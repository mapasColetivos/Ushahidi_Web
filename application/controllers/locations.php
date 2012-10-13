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
			->bind('incident_layers', $incident_layers)
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
			->set('locations', json_encode($incident->get_locations_array()))
			->bind('layers', $user_layers)
			->set('user', $this->user)
			->set('layers_api_url', url::site('locations/layers/'.$incident->id));

		$incident_layers = $incident->get_layers();
		$all_layers = array();
		foreach ($this->user->get_layers_array() as $layer)
		{
			$all_layers[$layer['id']] = $layer;
		}

		// Remove the layers for the current incident from the list
		// of all the user's layers
		foreach ($incident_layers as $layer)
		{
			if (array_key_exists($layer->id, $all_layers))
			{
				unset ($all_layers[$layer->id]);
			}
		}

		$user_layers = json_encode(array_values($all_layers));

		$this->themes->map_enabled = TRUE;
		$this->themes->colorpicker_enabled = TRUE;
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
		if ( ! Incident_Model::is_valid_incident($incident_id, FALSE))
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
			break;

			case "delete":
			break;

		}
	}

	/**
	 * REST endpoint for adding/editing location layers
	 */
	public function layers($incident_id, $layer_id = NULL)
	{
		$this->template = '';
		$this->auto_render = FALSE;

		switch (request::method())
		{
			case "post":
				Kohana::log("info", "Adding/editing KML");
				$post = array_merge($_FILES, $_POST);
				if (($layer_orm = location::save_layer($this->user, $layer_id, $post)) !== FALSE)
				{
					if (empty($layer_id))
					{
						// New layer added, echo response
						echo json_encode(array(
							'success' => TRUE,
							'layer' => $layer_orm->as_array()
						));
					}
					else
					{
						echo json_encode(array('success' => TRUE));
					}
				}
				else
				{
					echo json_encode(array(
						'success' => FALSE,
						'message' => "The layer could not be saved"
					));
				}
			break;

			case "put":
				Kohana::log("info", "Adding KML to incident");

				$layer_orm = ORM::factory('layer', $layer_id);
				ORM::factory('incident', $incident_id)->add_layer($this->user, $layer_orm);
			break;

			case "delete":
				$layer_orm = ORM::factory('layer', $layer_id);
				if ($layer_orm->loaded)
				{
					$layer_orm->delete();
				}
			break;
		}
	}

    public function export($incident_id)
    {
		$this->template = '';
		$this->auto_render = FALSE;

		// Load the incident
		$incident = ORM::factory('incident', $incident_id);

		// Titles
		$report_csv = "#,INCIDENT TITLE,INCIDENT DATE";
		$report_csv .= ",LOCATION";
		$report_csv .= ",DESCRIPTION";
		$report_csv .= ",CATEGORY";
		$report_csv .= ",LATITUDE";
		$report_csv .= ",LONGITUDE";
		$report_csv .= ",APPROVED,VERIFIED";
		$report_csv .= "\n";

		if ($incident->loaded)
		{
			foreach ($incident->location as $location)
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
	public function deleteAsset ($id)
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

	public function deleteAsset2 ( $id, $user_id)
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

	private function _csv_text($text)
	{
		$text = stripslashes(htmlspecialchars($text));
		return $text;
	}
}
