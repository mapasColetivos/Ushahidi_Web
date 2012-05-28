<?php defined('SYSPATH') or die('No direct script access.');


class Locations_Controller extends Main_Controller {

	function is_ajax(){
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
	}
	
	function __construct()
	{
		parent::__construct();
		$this->user = Session::instance()->get('auth_user',FALSE);
	}

	
	public function index()
	{

	}
	
	public function popup($id = FALSE)
	{
		$this->template->header = new View('header_clean');
		$this->template->footer = NULL;	
		$this->template->content = new View("location_popup");	
		
		$location = ORM::factory("location")->where("id",$id)->find();
		$incident = ORM::factory("incident")->join('location','location.incident_id','incident.id')->where("incident_id",$location->incident_id)->find();

		$this->template->content->location = $location;
		$this->template->content->incident = $incident;		
		$this->template->content->user = $this->user;		
		$this->template->header->header_block = $this->themes->header_block();
	}

	public function popupkml()
	{
		$this->template->header = new View('header_clean');
		$this->template->footer = NULL;	
		$this->template->content = new View("location_popupkml");	

//		$this->template->content->render(TRUE);

		
// 		$location = ORM::factory("location")->where("id",$id)->find();
// 		$incident = ORM::factory("incident")->join('location','location.incident_id','incident.id')->where("incident_id",$location->incident_id)->find();

// 		$this->template->content->location = $location;
// 		$this->template->content->incident = $incident;		
		$this->template->content->user = $this->user;		
		$this->template->header->header_block = $this->themes->header_block();
	}
   
	public function destroy($id = FALSE)
	{
		$this->template->header = NULL;
		$this->template->footer = NULL;	
		$this->template->content = NULL;
		ORM::factory('location')->where('id',$id)->find()->delete();
	}
	
	public function edit($id = FALSE, $incident_id = FALSE)
	{
		$this->template->header = '';
		$this->template->footer = '';	
		$this->template->content = '';
		
		if ($_POST)
		{
			$layer_id = null;
			if (isset($_POST["layer_id"]))
			{
				$layer_id = $_POST["layer_id"];
			}
		
			if ($id == 0)
			{
				if ( ! $layer_id)
				{
					$layer_id = ORM::factory("location_layer")
								->where("incident_id",$incident_id)
								->find()->id;
				}
				$new_location = $this->_save_new_location(
					$_POST["location_name"],
					$_POST["location_lat"],
					$_POST["location_lon"],
					$layer_id,
					$incident_id);
				$id = $new_location->id;
			}
		
			$location = ORM::factory("location")->where("id",$id)->find();
			$incident = ORM::factory("incident")
			    ->join('location','location.incident_id','incident.id')
			    ->where("incident_id", $location->incident_id)
			    ->find();
		
			$location->location_name = $_POST['location_name'];
			$location->location_description = $_POST['location_description'];
			$location->layer_id = $layer_id;
			$location->owner_id = $this->user->id;		

			// a. News
			foreach ($_POST['incident_news'] as $item)
			{
				if (!empty($item))
				{
					$news = new Media_Model();
					$news->location_id = $location->id;
					$news->incident_id = $incident->id;
					$news->media_type = 4;		// News
					$news->media_link = $item;
					$news->media_date = date("Y-m-d H:i:s",time());
					$news->owner_id = $this->user->id;
					$news->save();
				}
			}

			// b. Video
			foreach ($_POST['incident_video'] as $item)
			{
				if (!empty($item))
				{
					$video = new Media_Model();
					$video->location_id = $location->id;
					$video->incident_id = $incident->id;
					$video->media_type = 2;		// Video
					$video->media_link = $item;
					$video->media_date = date("Y-m-d H:i:s",time());
					$video->owner_id = $this->user->id;				
					$video->save();
				}
			}

			// c. Photos
			$filenames = upload::save('incident_photo');
			$i = 1;

			foreach ($filenames as $filename)
			{
				$new_filename = $incident->id."_".$i."_".time();
			
				$file_type = strrev(substr(strrev($filename),0,4));
			
				// IMAGE SIZES: 800X600, 400X300, 89X59
			
				// Large size
				Image::factory($filename)->resize(800,600,Image::AUTO)
					->save(Kohana::config('upload.directory', TRUE).$new_filename.$file_type);

				// Medium size
				Image::factory($filename)->resize(400,300,Image::HEIGHT)
					->save(Kohana::config('upload.directory', TRUE).$new_filename."_m".$file_type);
			
				// Thumbnail
				Image::factory($filename)->resize(178,118,Image::HEIGHT)
					->save(Kohana::config('upload.directory', TRUE).$new_filename."_t".$file_type);	
			
				// PopUpThumbnail
				Image::factory($filename)->resize(251,208,Image::HEIGHT)
					->save(Kohana::config('upload.directory', TRUE).$new_filename."_p".$file_type);	


				// Remove the temporary file
				unlink($filename);

				// Save to DB
				$photo = new Media_Model();
				$photo->location_id = $location->id;
				$photo->incident_id = $incident->id;
				$photo->media_type = 1; // Images
				$photo->media_link = $new_filename.$file_type;
				$photo->media_medium = $new_filename."_m".$file_type;
				$photo->media_thumb = $new_filename."_t".$file_type;
				$photo->media_date = date("Y-m-d H:i:s",time());
				$photo->owner_id = $this->user->id;			
				$photo->save();
				$i++;
			}

			$location->save();
			url::redirect(url::site().'locations/submit/'.$incident->id);
		}
		else
		{
			url::redirect(url::site());
		}
	}
	
	public function kml($layer_id = FALSE, $incident_id = FALSE)
	{
		$incident = ORM::factory('incident')->where('id',$incident_id)->find();
		$incident->add_kml_layer($layer_id,$this->user->id);
		
		url::redirect(url::site().'locations/submit/'.$incident->id);	
	}
	
	public function kml_delete($layer_id = FALSE, $incident_id = FALSE)
	{
		ORM::factory('incident_kml')
		    ->where('incident_id', $incident_id)
		    ->where('kml_id', $layer_id)
		    ->delete_all();
		
		url::redirect(url::site().'locations/submit/'.$incident_id);	
	}

	
	public function show($id = false, $incident_id = FALSE)
	{
		if ( ! Kohana::config('settings.allow_reports'))
		{
			url::redirect(url::site().'main');
		}
		$this->template->header = new View('header_clean');
		$this->template->footer = NULL;
		$this->template->content = new View('location_edit');

		// setup and initialize form field names
		$this->template->header->header_block = $this->themes->header_block();

		$location = ORM::factory('location')->where('id',$id)->find();


		$this->template->content->location = $location;
		$form = array(
			'latitude' => $location->latitude,
			'longitude' => $location->longitude,
			'location_name' => $location->location_name,
			'location_description'=> $location->location_description,
			'country_id' => '',
			'incident_category' => array(),
			'incident_news' => array(),
			'incident_video' => $location->incident_video,
			'incident_photo' => $location->incident_photo,
			'form_id'	  => '',
			'custom_field' => array(),
			'points' => array()
		);
		
		$this->template->content->form = $form;
		$this->template->content->incident_id = $incident_id;		
		$this->template->content->layers = ORM::factory('location_layer')->where('incident_id',$incident_id)->find_all();
		$this->template->content->layer = $location->layer();
		$this->template->content->photos = $location->incident_photo;
		$this->template->content->videos = $location->incident_videos;
		$this->template->content->user = $this->user;		
	}
	
	public function add_location()
	{
		$this->template->header = NULL;
		$this->template->footer = NULL;
		$this->template->content = new View('location_ajax_js');
		
		$location = $this->_save_new_location($_POST["name"], $_POST['latitude'], 
		    $_POST['longitude'], $_POST['layer_id'], $_POST['incident_id']);
		
		$this->template->content->post = $location->id;
	}
	
	public function update_location()
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
	
	public function submit($id = FALSE, $umessage = FALSE){
		// First, are we allowed to submit new reports?
		if ( ! Kohana::config('settings.allow_reports') or ! $this->user)
		{
			url::redirect('login');
		}

		$this->template->header->this_page = 'reports_submit';
		$this->template->header->explode_content = TRUE;
		$this->template->content = new View('locations_submit');
		$this->template->content->ajax_request = "NO";

		if ($umessage)
		{
			$this->template->content->umessage = $umessage;
		}
		else
		{
			$this->template->content->umessage = false;
		}

	    $this->template->content->layers = ORM::factory('location_layer')->where('incident_id',$id)->find_all();
	    $this->template->content->user = $this->user;
	    $incident = ORM::factory('location_layer')->where('incident_id',$id)->find();
		
		// setup and initialize form field names
		$form = array(
			'latitude' => '',
			'longitude' => '',
			'zoom' => '',
			'location_name' => '',
			'country_id' => '',
			'incident_category' => array(),
			'incident_news' => array(),
			'incident_video' => array(),
			'incident_photo' => array(),
			'form_id'	  => '',
			'custom_field' => array(),
			'points' => array()
		);
		
		//	copy the form as errors, so the errors will be stored with keys corresponding to the form field names
		$errors = $form;
		$form_error = FALSE;
		$form_saved = FALSE;
		// check, has the form been submitted, if so, setup validation	
		$this->template->content->form = $form;

		$incident = ORM::factory('incident')->where('id',$id)->find();
		$this->template->content->incident = $incident;

		// Javascript Header
		$this->themes->map_enabled = TRUE;
		$this->themes->datepicker_enabled = TRUE;
		$this->themes->treeview_enabled = TRUE;
		$this->themes->js = new View('locations_submit_js');
		$this->themes->js->incident = $incident;
		$this->themes->js->default_map = Kohana::config('settings.default_map');
		
		$this->themes->js->latitude = $incident->incident_default_lat;
		$this->themes->js->longitude = $incident->incident_default_lon;
		$this->themes->js->zoom = $incident->incident_default_zoom;
		
		$this->themes->js->markers = $incident->locations;
		$this->themes->js->user_id = $this->user->id;		

		// Rebuild Header Block
		$this->template->header->header_block = $this->themes->header_block();
		$this->template->content->can_edit = ($this->user->id == $incident->owner_id);
	}


    function export($id = false)
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
