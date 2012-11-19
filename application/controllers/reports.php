<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This controller is used to list/ view and edit reports
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com>
 * @package	   Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class Reports_Controller extends Main_Controller {

	/**
	 * Whether an admin console user is logged in
	 * @var bool
	 */
	var $logged_in;

	public function __construct()
	{
		parent::__construct();
		$this->themes->validator_enabled = TRUE;

		// Is the Admin Logged In?
		$this->logged_in = Auth::instance()->logged_in();
	}

	/**
	 * Displays all reports.
	 */
	public function index()
	{
		// Cacheable Controller
		$this->is_cachable = TRUE;

		$this->template->header->this_page = 'reports';
		$this->template->header->page_title .= Kohana::lang('ui_main.reports').Kohana::config('settings.title_delimiter');

		// Main view
		$this->template->content = View::factory('reports/main')
			->set('total_reports', Incident_Model::get_total_reports(TRUE))
			->set('category_tree_view', category::get_category_tree_view())
			->set('services', Service_Model::get_array())
			->bind('default_map_all', $default_map_all)
			->bind('default_map_all_icon', $default_map_all_icon)
			->bind('alert_radius_view', $alert_radius_view)
			->bind('report_listing_view', $report_listing_view)
			->bind('category_title', $category_title)
			->bind('oldest_timestamp', $oldest_timestamp)
			->bind('latest_timestamp', $latest_timestamp)
			->bind('custom_forms_filter', $custom_forms_filter);

		// JavaScript for this page
		$this->themes->js = View::factory('reports/reports_js')
			->set('url_params', json_encode($_GET))
			->set('latitude' ,Kohana::config('settings.default_lat'))
			->set('longitude', Kohana::config('settings.default_lon'))
			->set('default_map', Kohana::config('settings.default_map'))
			->set('default_zoom', Kohana::config('settings.default_zoom'))
			->bind('default_map_all', $default_map_all)
			->bind('default_map_all_icon', $default_map_all_icon);

		// Get Default Color
		$default_map_all = Kohana::config('settings.default_map_all');

		// Get default icon
		$default_map_all_icon = '';
		if (Kohana::config('settings.default_map_all_icon_id'))
		{
			$icon_object = ORM::factory('media')->find(Kohana::config('settings.default_map_all_icon_id'));
			$default_map_all_icon = Kohana::config('upload.relative_directory')."/".$icon_object->media_thumb;
		}

		// Load the alert radius view
		$alert_radius_view = View::factory('alerts/radius')
			->set('show_usage_info', FALSE)
			->set('enable_find_location', FALSE)
			->set('css_class', "rb_location-radius");

		// Get locale
		$l = Kohana::config('locale.language.0');

		// Get the report listing view
		$report_listing_view = $this->_get_report_listing_view($l);

		// Load the category
		$category_id = (isset($_GET['c']) AND intval($_GET['c']) > 0) ? intval($_GET['c']) : 0;
		$category = ORM::factory('category', $category_id);

		// Get the category title
		$category_title = ($category->loaded)
			? Category_Lang_Model::category_title($category_id, $l)
			: "";

		// Get the date of the oldest report
		if (isset($_GET['s']) AND ! empty($_GET['s']) AND intval($_GET['s']) > 0)
		{
			$oldest_timestamp =  intval($_GET['s']);
		}
		else
		{
			$oldest_timestamp = Incident_Model::get_oldest_report_timestamp();
		}

		// Get the date of the latest report
		if (isset($_GET['e']) AND !empty($_GET['e']) AND intval($_GET['e']) > 0)
		{
			$latest_timestamp = intval($_GET['e']);
		}
		else
		{
			$latest_timestamp = Incident_Model::get_latest_report_timestamp();
		}

		// Custom forms filter
		$custom_forms_filter = View::factory('reports/submit_custom_forms')
			->set('disp_custom_fields', customforms::get_custom_form_fields())
			->set('search_form', TRUE);

		// Enable the map
		$this->themes->map_enabled = TRUE;

		// Generate the header and footer blocks
		$this->template->header->header_block = $this->themes->header_block();
		$this->template->footer->footer_block = $this->themes->footer_block();
	}

	/**
	 * Helper method to load the report listing view
	 */
	private function _get_report_listing_view($locale = '')
	{
		// Check if the local is empty
		if (empty($locale))
		{
			$locale = Kohana::config('locale.language.0');
		}

		// Load the report listing view
		$report_listing = View::factory('reports/list')
			->set('incidents', reports::fetch_incidents(TRUE))
			->bind('localized_categories', $localized_categories)
			->bind('pagination', $pagination)
			->bind('stats_breadcrumb', $stats_breadcrumb);

		// For compatibility with older custom themes:
		// Generate array of category titles with their proper localizations using an array
		// DO NOT use this in new code, call Category_Lang_Model::category_title() directly
		foreach(Category_Model::categories() as $category)
		{
			$localized_categories[$category['category_title']] = Category_Lang_Model::category_title($category['category_id']);
		}

		// Pagination
		$pagination = reports::$pagination;

		// Pagination and Total Num of Report Stats
		$plural = ($pagination->total_items == 1)? "" : "s";

		// Set the next and previous page numbers
		$report_listing->next_page = $pagination->next_page;
		$report_listing->previous_page = $pagination->previous_page;

		if ($pagination->total_items > 0)
		{
			$current_page = ($pagination->sql_offset / $pagination->items_per_page) + 1;
			$total_pages = ceil($pagination->total_items / $pagination->items_per_page);

			if ($total_pages >= 1)
			{
				// Show the total of report
				$stats_breadcrumb = $pagination->current_first_item.'-'
				    . $pagination->current_last_item.' of '.$pagination->total_items.' '
				    . Kohana::lang('ui_main.reports');
			}
			else
			{
				// If we don't want to show pagination
				$stats_breadcrumb = $pagination->total_items.' '.Kohana::lang('ui_admin.reports');
			}
		}
		else
		{
			$pagination = '';
			$stats_breadcrumb = '('.$pagination->total_items.' report'.$plural.')';
		}

		// Return
		return $report_listing;
	}

	public function fetch_reports()
	{
		$this->template = "";
		$this->auto_render = FALSE;

		$report_listing_view = $this->_get_report_listing_view();
		print $report_listing_view;
	}

	/**
	 * Submits a new report.
	 * @param  int  $incident_id When specified, loads an incident to be edited
	 */
	public function submit($incident_id = FALSE)
	{
		// User must be logged in order to submit a report
		if ( ! $this->user OR ! Kohana::config('settings.allow_reports'))
		{
			url::redirect('login');
		}

		$this->template->header->this_page = 'reports_submit';
		$this->template->header->page_title .= Kohana::lang('ui_main.reports_submit_new')
		    .Kohana::config('settings.title_delimiter');

		$this->template->content = new View('reports/submit');

		//Retrieve API URL
		$this->template->api_url = Kohana::config('settings.api_url');

		// Setup and initialize form field names
		$form = array(
			'incident_id' => '',
			'incident_title' => '',
			'incident_description' => '',
			'incident_date' => date("m/d/Y",time()),
			'incident_hour' => date('g'),
			'incident_minute' => date('i'),
			'incident_ampm' => date('a'),
			'geometry' => array(),
			'country_id' => Kohana::config('settings.default_country'),
			'country_name' => '',
			'incident_category' => array(),
			'incident_zoom' => '',
			'form_id' => '',
			'tags' => '',
			'custom_field' => array(),
			'default_zoom' => Kohana::config('settings.default_zoom'),
			'default_lat' => Kohana::config('settings.default_lat'),
			'default_lon' => Kohana::config('settings.default_lon'),
			'incident_privacy' => FALSE
		);

		// Check if the incident
		$incident = NULL;
		if (Incident_Model::is_valid_incident($incident_id))
		{
			$incident = ORM::factory('incident', $incident_id);
			$this->_populate_form_fields($form, $incident);
		}

		// Copy the form as errors, so the errors will be stored with keys corresponding to the form field names
		$errors = $form;
		$form_error = FALSE;

		// Initialize Default Value for Hidden Field Country Name, just incase Reverse Geo coding yields no result
		$country_name = ORM::factory('country',$form['country_id']);
		$form['country_name'] = $country_name->country;

		// Initialize custom field array
		$form['form_id'] = 1;
		$form_id = $form['form_id'];
		$form['custom_field'] = customforms::get_custom_form_fields($incident_id, $form_id, TRUE);

		// GET custom forms
		$forms = array();
		foreach (customforms::get_custom_forms() as $custom_forms)
		{
			$forms[$custom_forms->id] = $custom_forms->form_title;
		}

		$this->template->content->forms = $forms;

		// Check, has the form been submitted, if so, setup validation
		if ($_POST)
		{
			// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
			$post = array_merge($_POST, $_FILES);

			// Test to see if things passed the rule checks
			if (reports::validate($post))
			{
				// STEP 1: SAVE INCIDENT
				if ( ! $incident instanceof Incident_Model)
				{
					$incident = new Incident_Model();
				}

				reports::save_report($post, $incident);

				// STEP 2: SAVE CATEGORIES
				reports::save_category($post, $incident);

				// STEP 3: SAVE CUSTOM FORM FIELDS
				reports::save_custom_fields($post, $incident);

				// Run events
				Event::run('ushahidi_action.report_submit', $post);
				Event::run('ushahidi_action.report_add', $incident);

				url::redirect('locations/create/'.$incident->id);
			}

			// No! We have validation errors, we need to show the form again, with the errors
			else
			{
				// Repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

				// Populate the error fields, if any
				$errors = arr::merge($errors, $post->errors('report'));
				$form_error = TRUE;
			}
		}

		$this->template->content->form_id = $form_id;
		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;

		$categories = $this->get_categories($form['incident_category']);
		$this->template->content->categories = $categories;

		// Pass timezone
		$this->template->content->site_timezone = Kohana::config('settings.site_timezone');

		// Pass the submit report message
		$this->template->content->site_submit_report_message = Kohana::config('settings.site_submit_report_message');

		// Retrieve Custom Form Fields Structure
		$this->template->content->custom_forms = new View('reports/submit_custom_forms');
		$disp_custom_fields = customforms::get_custom_form_fields($incident_id, $form_id, FALSE);
		$this->template->content->disp_custom_fields = $disp_custom_fields;
		$this->template->content->stroke_width_array = $this->_stroke_width_array();
		$this->template->content->custom_forms->disp_custom_fields = $disp_custom_fields;
		$this->template->content->custom_forms->form = $form;

		// Javascript Header
		$this->themes->map_enabled = TRUE;
		$this->themes->datepicker_enabled = TRUE;
		$this->themes->treeview_enabled = TRUE;
		$this->themes->colorpicker_enabled = TRUE;

		$this->themes->js = new View('reports/submit_edit_js');
		$this->themes->js->edit_mode = FALSE;
		$this->themes->js->incident_zoom = FALSE;
		$this->themes->js->default_map = Kohana::config('settings.default_map');
		$this->themes->js->default_zoom = Kohana::config('settings.default_zoom');
		if ( ! $form['default_lat'] OR ! $form['default_lon'])
		{
			$this->themes->js->latitude = Kohana::config('settings.default_lat');
			$this->themes->js->longitude = Kohana::config('settings.default_lon');
		}
		else
		{
			$this->themes->js->latitude = $form['default_lat'];
			$this->themes->js->longitude = $form['default_lon'];
		}
		$this->themes->js->geometries = $form['geometry'];


		// Rebuild Header Block
		$this->template->header->header_block = $this->themes->header_block();
		$this->template->footer->footer_block = $this->themes->footer_block();
	}

	 /**
	 * Displays a report.
	 * @param boolean $id If id is supplied, a report with that id will be
	 * retrieved.
	 */
	public function view($id = FALSE)
	{
		// Sanitize the report id before proceeding
		$id = intval($id);

		// Load the incident
		$incident = ORM::factory('incident', $id);
		if ( ! $incident->loaded)
		{
			// TODO: Show a 404 - Page not found
			url::redirect('reports');			
		}

		$this->template->header->this_page = 'reports';
		$this->template->content = View::factory('reports/detail')
			->set('user', $this->user)
			->set('incident', $incident)
			->set('incident_tags', $incident->get_tags())
			->bind('collaborators', $collaborators)
			->bind('map_filters', $map_filters);

		// Map filters view
		$map_filters = View::factory('map/filters')
			->set('incident_layers', $incident->get_layers())
			->set('incident_legends', $incident->get_legends_array());
		
		// Filters
		$incident_title = $incident->incident_title;
		$incident_description = $incident->incident_description;
		Event::run('ushahidi_filter.report_title', $incident_title);
		Event::run('ushahidi_filter.report_description', $incident_description);

		$this->template->header->page_title .= $incident_title.Kohana::config('settings.title_delimiter');

		$collaborators = $incident->get_collaborators();

		// Javascript Header
		$this->themes->map_enabled = TRUE;

		$this->themes->js = View::factory('reports/view_js')
			->set('markers_url', sprintf("json/locations/%d", $incident->id))
			->set('layer_name', $incident->incident_title)
			->set('latitude', $incident->incident_default_lat)
			->set('longitude', $incident->incident_default_lon)
			->set('map_zoom', $incident->incident_zoom);

		// Rebuild Header Block
		$this->template->header->header_block = $this->themes->header_block();
		$this->template->footer->footer_block = $this->themes->footer_block();
	}

	/**
	 * Report Thanks Page
	 */
	public function thanks()
	{
		$this->template->header->this_page = 'reports_submit';
		$this->template->content = new View('reports/submit_thanks');

		// Rebuild Header Block
		$this->template->header->header_block = $this->themes->header_block();
		$this->template->footer->footer_block = $this->themes->footer_block();
	}

	/**
	 * Report Rating.
	 * @param boolean $id If id is supplied, a rating will be applied to selected report
	 */
	public function rating($id = false)
	{
		$this->template = "";
		$this->auto_render = FALSE;

		if (!$id)
		{
			echo json_encode(array("status"=>"error", "message"=>"ERROR!"));
		}
		else
		{
			if ( ! empty($_POST['action']) AND !empty($_POST['type']))
			{
				$action = $_POST['action'];
				$type = $_POST['type'];

				// Is this an ADD(+1) or SUBTRACT(-1)?
				if ($action == 'add')
				{
					$action = 1;
				}
				elseif ($action == 'subtract')
				{
					$action = -1;
				}
				else
				{
					$action = 0;
				}

				if (!empty($action) AND ($type == 'original' OR $type == 'comment'))
				{
					// Has this User or IP Address rated this post before?
					if ($this->user)
					{
						$filter = "user_id = ".$this->user->id;
					}
					else
					{
						$filter = "rating_ip = '".$_SERVER['REMOTE_ADDR']."' ";
					}

					if ($type == 'original')
					{
						$previous = ORM::factory('rating')
							->where('incident_id',$id)
							->where($filter)
							->find();
					}
					elseif ($type == 'comment')
					{
						$previous = ORM::factory('rating')
							->where('comment_id',$id)
							->where($filter)
							->find();
					}

					// If previous exits... update previous vote
					$rating = new Rating_Model($previous->id);

					// Are we rating the original post or the comments?
					if ($type == 'original')
					{
						$rating->incident_id = $id;
					}
					elseif ($type == 'comment')
					{
						$rating->comment_id = $id;
					}

					// Is there a user?
					if ($this->user)
					{
						$rating->user_id = $this->user->id;

						// User can't rate their own stuff
						if ($type == 'original')
						{
							if ($rating->incident->user_id == $this->user->id)
							{
								echo json_encode(array("status"=>"error", "message"=>"Can't rate your own Reports!"));
								exit;
							}
						}
						elseif ($type == 'comment')
						{
							if ($rating->comment->user_id == $this->user->id)
							{
								echo json_encode(array("status"=>"error", "message"=>"Can't rate your own Comments!"));
								exit;
							}
						}
					}

					$rating->rating = $action;
					$rating->rating_ip = $_SERVER['REMOTE_ADDR'];
					$rating->rating_date = date("Y-m-d H:i:s",time());
					$rating->save();

					// Get total rating and send back to json
					$total_rating = $this->_get_rating($id, $type);

					echo json_encode(array("status"=>"saved", "message"=>"SAVED!", "rating"=>$total_rating));
				}
				else
				{
					echo json_encode(array("status"=>"error", "message"=>"Nothing To Do!"));
				}
			}
			else
			{
				echo json_encode(array("status"=>"error", "message"=>"Nothing To Do!"));
			}
		}
	}

	public function geocode()
	{
		$this->template = "";
		$this->auto_render = FALSE;

		if (isset($_POST['address']) AND ! empty($_POST['address']))
		{
			$geocode_result = map::geocode($_POST['address']);
			if ($geocode_result)
			{
				echo json_encode(array_merge(
					$geocode_result,
					array('status' => 'success')
				));
			}
			else
			{
				echo json_encode(array(
					'status' => 'error',
					'message' =>'ERROR!'
				));
			}
		}
		else
		{
			echo json_encode(array(
				'status' => 'error',
				'message' => 'ERROR!'
			));
		}
	}

	/**
	 * Retrieves Cities
	 * @param int $country_id Id of the country whose cities are to be fetched
	 * @return array
	 */
	private function _get_cities($country_id)
	{
		// Get the cities
		$cities = (Kohana::config('settings.multi_country'))
		    ? City_Model::get_all()
		    : ORM::factory('country', $country_id)->get_cities();

		$city_select = array('' => Kohana::lang('ui_main.reports_select_city'));

		foreach ($cities as $city)
		{
			$city_select[$city->city_lon.",".$city->city_lat] = $city->city;
		}

		return $city_select;
	}

	/**
	 * Retrieves Total Rating For Specific Post
	 * Also Updates The Incident & Comment Tables (Ratings Column)
	 */
	private function _get_rating($id = FALSE, $type = NULL)
	{
		if (!empty($id) AND ($type == 'original' OR $type == 'comment'))
		{
			if ($type == 'original')
			{
				$which_count = 'incident_id';
			}
			elseif ($type == 'comment')
			{
				$which_count = 'comment_id';
			}
			else
			{
				return 0;
			}

			$total_rating = 0;

			// Get All Ratings and Sum them up
			foreach (ORM::factory('rating')
							->where($which_count,$id)
							->find_all() as $rating)
			{
				$total_rating += $rating->rating;
			}

			return $total_rating;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Validates a numeric array. All items contained in the array must be numbers or numeric strings
	 *
	 * @param array $nuemric_array Array to be verified
	 */
	private function _is_numeric_array($numeric_array=array())
	{
		if (count($numeric_array) == 0)
			return FALSE;
		else
		{
			foreach ($numeric_array as $item)
			{
				if (! is_numeric($item))
					return FALSE;
			}

			return TRUE;
		}
	}

	/**
	 * Array with Geometry Stroke Widths
    */
	private function _stroke_width_array()
	{
		for ($i = 0.5; $i <= 8 ; $i += 0.5)
		{
			$stroke_width_array["$i"] = $i;
		}

		return $stroke_width_array;
	}

	/**
	 * Populates the form fields with the values of the specified
	 * incident
	 *
	 * @param  array  $form  Memory reference for the form fields
	 * @param  Model_Incident $incident ORM reference for the incident
	 */
	private function _populate_form_fields(array & $form, $incident)
	{
		$form['incident_id'] = $incident->id;
		$form['incident_title'] = $incident->incident_title;
		$form['incident_description'] = $incident->incident_description;
		$form['incident_privacy'] = $incident->incident_privacy;
		$form['default_lon'] = $incident->incident_default_lon;
		$form['default_lat'] = $incident->incident_default_lat;
		$form['default_zoom'] = $incident->incident_default_zoom;
		$form['incident_category'] = $incident->get_categories_array();
	}

	/**
	 * Ajax call to update Incident Reporting Form
    */
    public function switch_form()
    {
        $this->template = "";
        $this->auto_render = FALSE;
        isset($_POST['form_id']) ? $form_id = $_POST['form_id'] : $form_id = "1";
        isset($_POST['incident_id']) ? $incident_id = $_POST['incident_id'] : $incident_id = "";

		$form_fields = customforms::switcheroo($incident_id,$form_id);
        echo json_encode(array("status"=>"success", "response"=>$form_fields));
    }

    /**
     * REST endpoint for report (incident) follow/unfollow
     */
    public function social()
    {
    	$this->template = "";
    	$this->auto_render = FALSE;

    	if ($_POST AND $this->user)
    	{
    		// Set up validation
    		$validation = Validation::factory($_POST)
    		    ->add_rules('incident_id', 'required')
    		    ->add_rules('user_id', 'required')
    		    ->add_rules('action', 'required');

    		// Validate
    		if ($validation->validate())
    		{
    			if ($validation->action == 'follow')
    			{
    				$this->user->follow_incident($validation->incident_id);
    			}
    			elseif ($validation->action == 'unfollow')
    			{
    				$this->user->unfollow_incident($validation->incident_id);
    			}
    		}
    	}
    }

    /**
     * Displays the incident submit page in edit mode
     * This is an alias for the submit() method
     */
    public function edit($incident_id)
    {
    	$redirect_uri = sprintf("reports/submit/%s", $incident_id);
    	url::redirect($redirect_uri);
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
	
	/**
	 * REST endpoint for managing the legends for the incident
	 *
	 * @param int $incident_id ID of the incident
	 * @param int $legend_id When specified, id of the legend. This parameter must
	 *                       be specified when updating/deleting legends
	 */
	public function legends($incident_id, $legend_id = NULL)
	{
		$this->template = '';
		$this->auto_render = FALSE;
		
		// Verify that the incident exsits
		$incident_orm = ORM::factory('incident', $incident_id);
		if ( ! $incident_orm->loaded)
		{
			header("HTTP/1.1 404 The requested incident does not exist", TRUE, 404);
			exit;
		}

		$request_data = json_decode(file_get_contents('php://input'), TRUE);
		switch (request::method())
		{
			// Create new legend
			case "post":				
				if (($legend = Incident_Model::add_legend($incident_id, $request_data, $this->user->id)) !== FALSE)
				{
					echo json_encode($legend);
				}
				else
				{
					header("HTTP/1.1 400 The legend could not be saved", TRUE, 400);
				}			
			break;

			// Modify legend in $legend_id
			case "put":
				// Get the legend
				$legend_orm = ORM::factory('incident_legend', $legend_id);
				if ($legend_orm->loaded)
				{
					// Update the legend name
					$legend_label = $legend_orm->legend;
					$legend_label->legend_name = $request_data['legend_name'];
					$legend_label->save();
				
					// Update the legend color
					$legend_orm->legend_color = $request_data['legend_color'];
					$legend_orm->save();
				
					echo json_encode(array(
						'id' => $legend_orm->id,
						'legend_name' => $legend_label->legend_name,
						'legend_color' => $legend_orm->legend_color
					));
				}
				else
				{
					// 404 - Legend does not exist
					header("HTTP/1.1 404 The legend does not exist", TRUE, 404);
				}
				break;
			
			// Delete legend in $legend_id
			case "delete":
				$legend_orm = ORM::factory('incident_legend', $legend_id);
				if ($legend_orm->loaded)
				{
					$legend_orm->delete();
				}
				else
				{
					// 404 - Legend does not exist
					header("HTTP/1.1 404 The legend does not exist", TRUE, 404);
				}
			break;
		}
	}
	
}
