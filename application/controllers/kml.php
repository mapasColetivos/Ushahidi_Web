<?php defined('SYSPATH') or die('No direct script access.');

class Kml_Controller extends Admin_Controller {

	public $template = 'layout_clean';
	public $bypass_admin = TRUE;

	public function index($map_id= false){
		$this->template->this_page = 'manage';
		$this->template->content = new View('layers_kml');
		$this->template->content->title = Kohana::lang('ui_admin.layers');
		$this->template->content->map_id = $map_id;

		// setup and initialize form field names
		$form = array
		(
			'action' => '',
			'layer_id'		=> '',
			'layer_name'	  => '',
			'layer_url'	   => '',
			'layer_file'  => '',
			'layer_color'  => ''
		);

		// copy the form as errors, so the errors will be stored with keys corresponding to the form field names
		$errors = $form;
		$form_error = FALSE;
		$form_saved = FALSE;
		$form_action = "";
		$parents_array = array();

		// check, has the form been submitted, if so, setup validation
		if ($_POST)
		{
			// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
			$post = Validation::factory(array_merge($_POST,$_FILES));

			 //	 Add some filters
			$post->pre_filter('trim', TRUE);

			if ($post->action == 'a')		// Add Action
			{
				// Add some rules, the input field, followed by a list of checks, carried out in order
				$post->add_rules('layer_name','required', 'length[3,80]');
				$post->add_rules('layer_color','required', 'length[6,6]');
				$post->add_rules('layer_url','url');
				$post->add_rules('layer_file', 'upload::valid','upload::type[kml,kmz]');
				if ( empty($_POST['layer_url']) AND empty($_FILES['layer_file']['name'])
					AND empty($_POST['layer_file_old']) )
				{
					$post->add_error('layer_url', 'atleast');
				}
				if ( ! empty($_POST['layer_url']) AND
					( ! empty($_FILES['layer_file']['name']) OR !empty($_POST['layer_file_old'])) )
				{
					$post->add_error('layer_url', 'both');
				}
			}

			// Test to see if things passed the rule checks
			if ($post->validate())
			{
				$layer_id = $post->layer_id;
				$layer = new Layer_Model($layer_id);

				if( $post->action == 'd' )
				{ // Delete Action

					// Delete KMZ file if any
					$layer_file = $layer->layer_file;
					if ( ! empty($layer_file)
					AND file_exists(Kohana::config('upload.directory', TRUE).$layer_file))
						unlink(Kohana::config('upload.directory', TRUE) . $layer_file);

					$layer->delete( $layer_id );
					$form_saved = TRUE;
					$form_action = strtoupper(Kohana::lang('ui_admin.deleted'));

				}
				elseif( $post->action == 'v' )
				{ // Show/Hide Action
					if ($layer->loaded==true)
					{
						if ($layer->layer_visible == 1) {
							$layer->layer_visible = 0;
						}
						else {
							$layer->layer_visible = 1;
						}
						$layer->save();
						$form_saved = TRUE;
						$form_action = strtoupper(Kohana::lang('ui_admin.modified'));
					}
				}
				elseif( $post->action == 'i' )
				{ // Delete KMZ/KML Action
					if ($layer->loaded==true)
					{
						$layer_file = $layer->layer_file;
						if ( ! empty($layer_file)
							AND file_exists(Kohana::config('upload.directory', TRUE).$layer_file))
						{
							unlink(Kohana::config('upload.directory', TRUE) . $layer_file);
						}

						$layer->layer_file = null;
						$layer->save();
						$form_saved = TRUE;
						$form_action = strtoupper(Kohana::lang('ui_admin.modified'));
					}
				}
				elseif( $post->action == 'a' )
				{ // Save Action
					$layer->layer_name = $post->layer_name;
					$layer->layer_url = $post->layer_url;
					$layer->layer_color = $post->layer_color;
					$layer->owner_id = Session::instance()->get('auth_user',FALSE)->id;
					$layer->save();

					// Upload KMZ/KML
					$path_info = upload::save("layer_file");
					if ($path_info)
					{
						$path_parts = pathinfo($path_info);
						$file_name = $path_parts['filename'];
						$file_ext = $path_parts['extension'];

						if (strtolower($file_ext) == "kmz")
						{ // This is a KMZ Zip Archive, so extract
							$archive = new Pclzip($path_info);
							if ( TRUE == ($archive_files = $archive->extract(PCLZIP_OPT_EXTRACT_AS_STRING)) )
							{
								foreach ($archive_files as $file)
								{
									$ext_file_name = $file['filename'];
								}
							}

							if ( $ext_file_name AND
									$archive->extract(PCLZIP_OPT_PATH, Kohana::config('upload.directory')) == TRUE )
							{ // Okay, so we have an extracted KML - Rename it and delete KMZ file
								rename($path_parts['dirname']."/".$ext_file_name,
									$path_parts['dirname']."/".$file_name.".kml");

								$file_ext = "kml";
								unlink($path_info);
							}
						}

						$layer->layer_file = $file_name.".".$file_ext;
						$layer->save();
					}

					$form_saved = TRUE;
					$form_action = strtoupper(Kohana::lang('ui_admin.added_edited'));
				}
				
				url::redirect('locations/submit/'.$map_id);
			}
			// No! We have validation errors, we need to show the form again, with the errors
			else
			{
				url::redirect('locations/submit/'.$map_id);
				
				/*
				// repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

			   // populate the error fields, if any
				$errors = arr::overwrite($errors, $post->errors('layer'));
				$form_error = TRUE;
				*/
			}
		}

		// Pagination
		$pagination = new Pagination(array(
							'query_string' => 'page',
							'items_per_page' => (int) Kohana::config('settings.items_per_page_admin'),
							'total_items'	 => ORM::factory('layer')
													->count_all()
						));

		$layers = ORM::factory('layer')
						->orderby('layer_name', 'asc')
						->find_all((int) Kohana::config('settings.items_per_page_admin'),
							$pagination->sql_offset);

		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
		$this->template->content->form_action = $form_action;
		$this->template->content->pagination = $pagination;
		$this->template->content->total_items = $pagination->total_items;
		$this->template->content->layers = $layers;
		$this->template->content->user = Session::instance()->get('auth_user',FALSE);		

		// Javascript Header
		$this->template->colorpicker_enabled = TRUE;
		$this->template->js = new View('layers_kml_js');
	}	
}