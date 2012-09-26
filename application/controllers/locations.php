<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This controller is used to create/edit/delete/export locations
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://github.com/ushahidi/Ushahidi_Web
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
class Locations_Controller extends Main_Controller {

	/**
	 * Loads the create location page
	 */ 
	public function create($incident_id = FALSE)
	{
    	// Validate the specified incident ID and ensure the
    	// user is logged in before proceeding
    	if ( ! Incident_Model::is_valid_incident($incident_id, FALSE) OR ! $this->user)
    	{
    		url::redirect('main');
    	}

    	// Load the incident
    	$incident = ORM::factory('incident', $incident_id);

    	// Set the view properties
    	$this->template->content = View::factory('locations/create')
    	    ->set('user', $this->user)
    	    ->set('incident', $incident)
    	    ->set('incident_layers', $incident->get_layers())
    	    ->bind('javascript', $javascript);

    	// Set the properties for the JavaScript
    	$javascript = View::factory('locations/js/location')
    	    ->set('latitude', $incident->incident_default_lat)
    	    ->set('longitude', $incident->incident_default_lon)
    	    ->set('map_zoom', $incident->incident_zoom)
    	    ->set('layer_name', $incident->incident_title)
    	    ->set('incident_id',  $incident->id)
    	    ->set('markers_url', "json/locations/".$incident->id)
    	    ->set('action_url', url::site('locations/manage/'.$incident->id))
    	    ->set('locations', json_encode($incident->get_locations_array()));

		$this->themes->map_enabled = TRUE;
		$this->template->header->header_block = $this->themes->header_block();
		$this->template->footer->footer_block = $this->themes->footer_block();
	}

	/**
	 * REST endpoint for managing locations and their metadata
	 */
	public function manage($incident_id)
	{
		$this->template = "";
		$this->auto_render = FALSE;

		// Check if the incident is valid
		if (! Incident_Model::is_valid_incident($incident_id, FALSE))
		{
			header("Status: 404 The specified incident does not exist");
			return;
		}

		// Check the request type
		switch (request::method())
		{
			case "post":
			$post = array_merge($_POST, $_FILES);
			// Save the basic location
			if (location::validate($post))
			{
				// Save the location
				$location_orm = location::save_location($post, $incident_id, $this->user->id);

				// Save the media
				location::save_media($post, $location_orm->id, $incident_id, $this->user->id);

				// Echo the newly added location
				echo json_encode(array(
					"status" => "OK",
					"location" => $location_orm->as_geojson_feature()
				));
			}
			else
			{
				echo json_encode(array(
				    "status" => "error",
				    "message" => $post->errors()
				));
			}

		}
	}

	public function remove_location($id = FALSE)
	{
		$this->template->header = NULL;
		$this->template->footer = NULL;
		$this->template->content = new View('location_ajax_js');
		
		if ($this->is_ajax())
		{
			$this->template->content->post = 1;
		}
		else
		{
			$this->template->content->post = 0;			
		}
	}

    public function export($id = FALSE)
    {
    	$this->template->header = NULL;
		$this->template->content = NULL;
		$this->template->footer = NULL;

        $locations = ORM::factory('location')
        	->where('incident_id',$id)
        	->find_all();
            
        $report_csv = "#,INCIDENT TITLE,INCIDENT DATE";
		$report_csv .= ",LOCATION";
		$report_csv .= ",DESCRIPTION";
		$report_csv .= ",CATEGORY";
		$report_csv .= ",LATITUDE";
		$report_csv .= ",LONGITUDE";
        $report_csv .= ",APPROVED,VERIFIED";
        $report_csv .= "\n";
        foreach ($locations as $location)
        {
            $report_csv .= '"'.$location->id.'",';
            $report_csv .= '"'.$this->_csv_text($location->incident->incident_title).'",';
            $report_csv .= '"'.$location->location_date.'"';
			$report_csv .= ',"'.$this->_csv_text($location->location_name).'"';
			$report_csv .= ',"'.$this->_csv_text($location->location_description).'"';
			$report_csv .= ',"';           
			         
            foreach($location->incident->incident_category as $category)
            {
                if ($category->category->category_title)
                {
                    $report_csv .= $this->_csv_text($category->category->category_title) . ", ";
                }
            }
			$report_csv .= '"';
			$report_csv .= ',"'.$this->_csv_text($location->latitude).'"';
			$report_csv .= ',"'.$this->_csv_text($location->longitude).'"';
            
            if ($location->incident->incident_active)
            {
                $report_csv .= ",YES";
            }
            else
            {
                $report_csv .= ",NO";
            }
            
            if ($location->incident->incident_verified)
            {
                $report_csv .= ",YES";
            }
            else
            {
                $report_csv .= ",NO";
            }
            
            $report_csv .= "\n";
        }
        // Output to browser
        header("Content-type: text/x-csv");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Disposition: attachment; filename=" . time() . ".csv");
        header("Content-Length: " . strlen($report_csv));
        echo $report_csv;
    }

	/**
	 * Delete Photo
	 * @param int $id The unique id of the photo to be deleted
	 */
    function deleteAsset ($id)
    {
    	$media = ORM::factory('media')->where('id',$id)->find();
    	$incident_id = $media->incident_id;
    	
    	//Special for photos that have physical assets on the system
        if ($media->media_type == 1 )
        {
            $photo = $media;
            $photo_large = $photo->media_link;
            $photo_thumb = $photo->media_thumb;

            // Delete Files from Directory
            if ( ! empty($photo_large))
            {
                unlink(Kohana::config('upload.directory', TRUE) . $photo_large);
            }
            
            if ( ! empty($photo_thumb))
            {
                unlink(Kohana::config('upload.directory', TRUE) . $photo_thumb);
            }
        }
        
        $media->delete();
		url::redirect(url::site().'locations/submit/'.$incident_id);
    }

	function deleteAsset2 ( $id, $user_id)
	{
    	$media = ORM::factory('media')->where('id',$id)->find();
    	$incident_id = $media->incident_id;
		if ($media->owner_id != $user_id)
		{
		    // popup para avisar que nao sao os mesmos caras, volta
			echo "<script language=javascript>alert('Please enter a valid username.')</script>";
			url::redirect(url::site().'locations/submit/'.$incident_id . '/Somente quem postou a midia pode removê-la. Entre em contato.');
		}
		else
		{
			//Special for photos that have physical assets on the system
			if ($media->media_type == 1 )
			{
				$photo = $media;
				$photo_large = $photo->media_link;
				$photo_thumb = $photo->media_thumb;

				// Delete Files from Directory
				if ( ! empty($photo_large))
				{
				    unlink(Kohana::config('upload.directory', TRUE) . $photo_large);
				}

				if ( ! empty($photo_thumb))
				{
				    unlink(Kohana::config('upload.directory', TRUE) . $photo_thumb);
				}
			}
		
			$media->delete();
		}
		
		url::redirect(url::site().'locations/submit/'.$incident_id);
	}

	private function _save_new_location($name,$lat,$lon,$layer_id,$incident_id)
	{
		$location = new Location_Model();
		$location->location_name = $name;
		$location->latitude = $lat;
		$location->longitude = $lon;
		$location->location_date = date("Y-m-d H:i:s",time());
		$location->layer_id = $layer_id;
		$location->incident_id = $incident_id;
		$location->save();
		return $location;
    }
    
    private function _csv_text($text)
    {
        $text = stripslashes(htmlspecialchars($text));
        return $text;
    }
}
