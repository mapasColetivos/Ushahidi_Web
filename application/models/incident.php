<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for reported Incidents
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
class Incident_Model extends ORM {
	/**
	 * One-to-may relationship definition
	 * @var array
	 */
	protected $has_many = array(
		'category' => 'incident_category',
		'media',
		'verify',
		'comment',
		'rating',
		'alert' => 'alert_sent',
		'incident_lang',
		'form_response',
		'cluster' => 'cluster_incident',
		'geometry',
		'incident_kml',
		'incident_tags',
		'location',
		'incident_follows',
		'incident_legend'
	);

	/**
	 * One-to-one relationship definition
	 * @var array
	 */
	protected $has_one = array(
		'incident_person',
		'user',
		'message',
		'twitter',
		'form'
	);

	/**
	 * Database table name
	 * @var string
	 */
	protected $table_name = 'incident';

	/**
	 * Prevents cached items from being reloaded
	 * @var bool
	 */
	protected $reload_on_wakeup   = FALSE;

	/**
	 * Gets a list of all visible categories
	 * @todo Move this to the category model
	 * @return array
	 */
	public static function get_active_categories()
	{
		// Get all active categories
		$categories = array();
		foreach
		(
			ORM::factory('category')
			    ->where('category_visible', '1')
			    ->find_all() as $category)
		{
			// Create a list of all categories
			$categories[$category->id] = array(
				$category->category_title, 
				$category->category_color
			);
		}
		return $categories;
	}

	/**
	 * Get the total number of reports
	 *
	 * @param boolean $approved - Only count approved reports if true
	 * @return int
	 */
	public static function get_total_reports($approved = FALSE)
	{
		return ($approved)
			? ORM::factory('incident')->where('incident_active', '1')->where('incident_privacy', 0)->count_all()
			: ORM::factory('incident')->count_all();
	}

	/**
	 * Get the total number of verified or unverified reports
	 *
	 * @param boolean $verified - Only count verified reports if true, unverified if false
	 * @return int
	 */
	public static function get_total_reports_by_verified($verified = FALSE)
	{
		return ($verified)
			? ORM::factory('incident')->where('incident_verified', '1')->where('incident_active', '1')->where('incident_privacy', 0)->count_all()
			: ORM::factory('incident')->where('incident_verified', '0')->where('incident_active', '1')->where('incident_privacy', 0)->count_all();
	}

	/**
	 * Get the earliest report date
	 *
	 * @param boolean $approved - Oldest approved report timestamp if true (oldest overall if false)
	 * @return string
	 */
	public static function get_oldest_report_timestamp($approved = TRUE)
	{
		$result = ($approved)
			? ORM::factory('incident')->where('incident_active', '1')->orderby(array('incident_date'=>'ASC'))->find_all(1,0)
			: ORM::factory('incident')->where('incident_active', '0')->orderby(array('incident_date'=>'ASC'))->find_all(1,0);

		foreach($result as $report)
		{
			return strtotime($report->incident_date);
		}
	}

	/**
	 * Get the latest report date
	 * @return string
	 */
	public static function get_latest_report_timestamp($approved = TRUE)
	{
		$result = ($approved)
			? ORM::factory('incident')->where('incident_active', '1')->orderby(array('incident_date'=>'DESC'))->find_all(1,0)
			: ORM::factory('incident')->where('incident_active', '0')->orderby(array('incident_date'=>'DESC'))->find_all(1,0);

		foreach($result as $report)
		{
			return strtotime($report->incident_date);
		}
	}

	private static function category_graph_text($sql, $category)
	{
		$db = new Database();
		$query = $db->query($sql);
		$graph_data = array();
		$graph = ", \"".  $category[0] ."\": { label: '". str_replace("'","",$category[0]) ."', ";
		foreach ( $query as $month_count )
		{
			array_push($graph_data, "[" . $month_count->time * 1000 . ", " . $month_count->number . "]");
		}
		$graph .= "data: [". join($graph_data, ",") . "], ";
		$graph .= "color: '#". $category[1] ."' ";
		$graph .= " } ";
		return $graph;
	}

	public static function get_incidents_by_interval($interval='month',$start_date=NULL,$end_date=NULL,$active='true',$media_type=NULL)
	{
		// Table Prefix
		$table_prefix = Kohana::config('database.default.table_prefix');

		// get graph data
		// could not use DB query builder. It does not support parentheses yet
		$db = new Database();

		$select_date_text = "DATE_FORMAT(incident_date, '%Y-%m-01')";
		$groupby_date_text = "DATE_FORMAT(incident_date, '%Y%m')";
		if ($interval == 'day')
		{
			$select_date_text = "DATE_FORMAT(incident_date, '%Y-%m-%d')";
			$groupby_date_text = "DATE_FORMAT(incident_date, '%Y%m%d')";
		}
		elseif ($interval == 'hour')
		{
			$select_date_text = "DATE_FORMAT(incident_date, '%Y-%m-%d %H:%M')";
			$groupby_date_text = "DATE_FORMAT(incident_date, '%Y%m%d%H')";
		}
		elseif ($interval == 'week')
		{
			$select_date_text = "STR_TO_DATE(CONCAT(CAST(YEARWEEK(incident_date) AS CHAR), ' Sunday'), '%X%V %W')";
			$groupby_date_text = "YEARWEEK(incident_date)";
		}

		$date_filter = ($start_date) ? ' AND incident_date >= "' . $db->escape($start_date) . '"' : "";

		if ($end_date)
		{
			$date_filter .= ' AND incident_date <= "' . $db->escape($end_date) . '"';
		}

		$active_filter = ($active == 'all' || $active == 'false')? $active_filter = '0,1' : '1';

		$joins = '';
		$general_filter = '';
		if (isset($media_type) AND is_numeric($media_type))
		{
			$joins = 'INNER JOIN '.$table_prefix.'media AS m ON m.incident_id = i.id';
			$general_filter = ' AND m.media_type IN ('. $db->escape($media_type)  .')';
		}

		$graph_data = array();
		$all_graphs = array();

		$all_graphs['0'] = array();
		$all_graphs['0']['label'] = 'All Categories';
		$query_text = 'SELECT UNIX_TIMESTAMP(' . $select_date_text . ') AS time,
					   COUNT(*) AS number
					   FROM '.$table_prefix.'incident AS i ' . $joins . '
					   WHERE incident_active IN (' . $active_filter .')' .
		$general_filter .'
					   GROUP BY ' . $groupby_date_text;
		$query = $db->query($query_text);
		$all_graphs['0']['data'] = array();
		foreach ( $query as $month_count )
		{
			array_push($all_graphs['0']['data'],
				array($month_count->time * 1000, $month_count->number));
		}
		$all_graphs['0']['color'] = '#990000';

		$query_text = 'SELECT category_id, category_title, category_color, UNIX_TIMESTAMP(' . $select_date_text . ')
							AS time, COUNT(*) AS number
								FROM '.$table_prefix.'incident AS i
							INNER JOIN '.$table_prefix.'incident_category AS ic ON ic.incident_id = i.id
							INNER JOIN '.$table_prefix.'category AS c ON ic.category_id = c.id
							' . $joins . '
							WHERE incident_active IN (' . $active_filter . ')
								  ' . $general_filter . '
							GROUP BY ' . $groupby_date_text . ', category_id ';
		$query = $db->query($query_text);
		foreach ($query as $month_count)
		{
			$category_id = $month_count->category_id;
			if (!isset($all_graphs[$category_id]))
			{
				$all_graphs[$category_id] = array();
				$all_graphs[$category_id]['label'] = $month_count->category_title;
				$all_graphs[$category_id]['color'] = '#'. $month_count->category_color;
				$all_graphs[$category_id]['data'] = array();
			}
			array_push($all_graphs[$category_id]['data'],
				array($month_count->time * 1000, $month_count->number));
		}
		$graphs = json_encode($all_graphs);
		return $graphs;
	}

	/**
	 * Get the number of reports by date for dashboard chart
	 *
	 * @param int $range No. of days in the past
	 * @param int $user_id
	 * @return array
	 */
	public static function get_number_reports_by_date($range = NULL, $user_id = NULL)
	{
		// Table Prefix
		$table_prefix = Kohana::config('database.default.table_prefix');

		// Database instance
		$db = new Database();

		// Filter by User
		$user_id = (int) $user_id;
		$u_sql = ($user_id)? " AND user_id = ".$user_id." " : "";

		// Query to generate the report count
		$sql = 'SELECT COUNT(id) as count, DATE(incident_date) as date, MONTH(incident_date) as month, DAY(incident_date) as day, '
			. 'YEAR(incident_date) as year '
			. 'FROM '.$table_prefix.'incident ';

		// Check if the range has been specified and is non-zero then add predicates to the query
		if ($range != NULL AND intval($range) > 0)
		{
			$sql .= 'WHERE incident_date >= DATE_SUB(CURDATE(), INTERVAL '.$db->escape_str($range).' DAY) ';
		}
		else
		{
			$sql .= 'WHERE 1=1 ';
		}

		// Group and order the records
		$sql .= $u_sql.'GROUP BY date ORDER BY incident_date ASC';

		$query = $db->query($sql);
		$result = $query->result_array(FALSE);

		$array = array();
		foreach ($result AS $row)
		{
			$timestamp = mktime(0, 0, 0, $row['month'], $row['day'], $row['year']) * 1000;
			$array["$timestamp"] = $row['count'];
		}

		return $array;
	}

	/**
	 * Gets a list of dates of all approved incidents
	 *
	 * @return array
	 */
	public static function get_incident_dates()
	{
		//$incidents = ORM::factory('incident')->where('incident_active',1)->incident_date->find_all();
		$incidents = ORM::factory('incident')->where('incident_active',1)->select_list('id', 'incident_date');
		$array = array();
		foreach ($incidents as $id => $incident_date)
		{
			$array[] = $incident_date;
		}
		return $array;
	}

	/**
	 * Checks if a specified incident id is numeric and exists in the database
	 *
	 * @param int $incident_id ID of the incident to be looked up
	 * @param bool $approved Whether to include un-approved reports
	 * @return bool
	 */
	public static function is_valid_incident($incident_id, $approved = TRUE)
	{
		$where = ($approved == TRUE) ? array("incident_active" => "1") : array("id >" => 0);
		return (intval($incident_id) > 0)
			? ORM::factory('incident')->where($where)->find(intval($incident_id))->loaded
			: FALSE;
	}

	/**
	 * Gets the reports that match the conditions specified in the $where parameter
	 * The conditions must relate to columns in the incident, location, incident_category
	 * category and media tables
	 *
	 * @param array $where List of conditions to apply to the query
	 * @param mixed $limit No. of records to fetch or an instance of Pagination
	 * @param string $order_field Column by which to order the records
	 * @param string $sort How to order the records - only ASC or DESC are allowed
	 * @return Database_Result
	 */
	public static function get_incidents($where = array(), $limit = NULL, $order_field = NULL, $sort = NULL, $count = FALSE)
	{
		// Get the table prefix
		$table_prefix = Kohana::config('database.default.table_prefix');

		// To store radius parameters
		$radius = array();
		$having_clause = "";
		if (array_key_exists('radius', $where))
		{
			// Grab the radius parameter
			$radius = $where['radius'];

			// Delete radius parameter from the list of predicates
			unset ($where['radius']);
		}

		// Query
		// Normal query
		if (! $count)
		{
			$sql = 'SELECT DISTINCT i.id incident_id, i.incident_title, i.incident_description, '
			    . 'i.incident_date, i.incident_mode, i.incident_active, '
				. 'i.incident_verified, i.incident_default_lat latitude, i.incident_default_lon longitude, '
				. 'c.category_color ';
		}
		// Count query
		else
		{
			$sql = 'SELECT COUNT(DISTINCT i.id) as report_count ';
		}
		
		// Check if all the parameters exist
		if (count($radius) > 0 AND array_key_exists('latitude', $radius) AND array_key_exists('longitude', $radius)
			AND array_key_exists('distance', $radius))
		{
			// Calculate the distance of each point from the starting point
			$sql .= ", ((ACOS(SIN(%s * PI() / 180) * SIN(i.`incident_default_lat` * PI() / 180) + COS(%s * PI() / 180) * "
				. "	COS(l.`latitude` * PI() / 180) * COS((%s - i.`incident_default_lon`) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance ";

			$sql = sprintf($sql, $radius['latitude'], $radius['latitude'], $radius['longitude']);

			// Set the "HAVING" clause
			$having_clause = "HAVING distance <= ".intval($radius['distance'])." ";
		}

		$sql .=  'FROM '.$table_prefix.'incident i '
			. 'LEFT JOIN '.$table_prefix.'incident_category ic ON (ic.incident_id = i.id) '
			. 'LEFT JOIN '.$table_prefix.'category c ON (ic.category_id = c.id) ';
		
		// Check if the all reports flag has been specified
		if (array_key_exists('all_reports', $where) AND $where['all_reports'] == TRUE)
		{
			unset ($where['all_reports']);
			$sql .= 'WHERE 1=1 ';
		}
		else
		{
			$sql .= 'WHERE i.incident_active = 1 '
			    . "AND i.incident_privacy = 0 ";
		}

		// Check for the additional conditions for the query
		if ( ! empty($where) AND count($where) > 0)
		{
			foreach ($where as $predicate)
			{
				$sql .= 'AND '.$predicate.' ';
			}
		}

		// Might need "GROUP BY i.id" do avoid dupes
		
		// Add the having clause
		$sql .= $having_clause;

		// Check for the order field and sort parameters
		if ( ! empty($order_field) AND ! empty($sort) AND (strtoupper($sort) == 'ASC' OR strtoupper($sort) == 'DESC'))
		{
			$sql .= 'ORDER BY '.$order_field.' '.$sort.' ';
		}
		else
		{
			$sql .= 'ORDER BY i.incident_date DESC ';
		}

		// Check if the record limit has been specified
		if ( ! empty($limit) AND is_int($limit) AND intval($limit) > 0)
		{
			$sql .= 'LIMIT 0, '.$limit;
		}
		elseif ( ! empty($limit) AND $limit instanceof Pagination_Core)
		{
			$sql .= 'LIMIT '.$limit->sql_offset.', '.$limit->items_per_page;
		}

		// Kohana::log('debug', $sql);
		return Database::instance()->query($sql);
	}

	/**
	 * Gets the comments for an incident
	 * @param int $incident_id Database ID of the incident
	 * @return mixed FALSE if the incident id is non-existent, ORM_Iterator if it exists
	 */
	public static function get_comments($incident_id)
	{
		if (self::is_valid_incident($incident_id))
		{
			$where = array(
				'comment.incident_id' => $incident_id,
				'comment_active' => '1',
				'comment_spam' => '0'
			);

			// Fetch the comments
			return ORM::factory('comment')
					->where($where)
					->orderby('comment_date', 'asc')
					->find_all();
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Given an incident, gets the list of incidents within a specified radius
	 *
	 * @param int $incident_id Database ID of the incident to be used to fetch the neighbours
	 * @param int $distance Radius within which to fetch the neighbouring incidents
	 * @param int $num_neigbours Number of neigbouring incidents to fetch
	 * @return mixed FALSE is the parameters are invalid, Result otherwise
	 */
	public static function get_neighbouring_incidents($incident_id, $order_by_distance = FALSE, $distance = 0, $num_neighbours)
	{
		if (self::is_valid_incident($incident_id))
		{
			// Get the table prefix
			$table_prefix = Kohana::config('database.default.table_prefix');

			$incident_id = (intval($incident_id));

			// Get the location object and extract the latitude and longitude
			$location = self::factory('incident', $incident_id)->location;
			$latitude = $location->latitude;
			$longitude = $location->longitude;

			// Garbage collection
			unset ($location);

			// Query to fetch the neighbour
			$sql = "SELECT DISTINCT i.*, l.`latitude`, l.`longitude`, l.location_name, "
				. "((ACOS(SIN( ? * PI() / 180) * SIN(l.`latitude` * PI() / 180) + COS( ? * PI() / 180) * "
				. "	COS(l.`latitude` * PI() / 180) * COS(( ? - l.`longitude`) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance "
				. "FROM `".$table_prefix."incident` AS i "
				. "INNER JOIN `".$table_prefix."location` AS l ON (l.`id` = i.`location_id`) "
				. "WHERE i.incident_active = 1 "
				. "AND i.id <> ? ";

			// Check if the distance has been specified
			if (intval($distance) > 0)
			{
				$sql .= "HAVING distance <= ".intval($distance)." ";
			}

			// If the order by distance parameter is TRUE
			if ($order_by_distance)
			{
				$sql .= "ORDER BY distance ASC ";
			}
			else
			{
				$sql .= "ORDER BY i.`incident_date` DESC ";
			}

			// Has the no. of neigbours been specified
			if (intval($num_neighbours) > 0)
			{
				$sql .= "LIMIT ".intval($num_neighbours);
			}

			// Fetch records and return
			return Database::instance()->query($sql, $latitude, $latitude, $longitude, $incident_id);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Sets approval of an incident
	 * @param int $incident_id
	 * @param int $val Set to 1 or 0 for approved or not approved
	 * @return bool
	 */
	public static function set_approve($incident_id,$val)
	{
		$incident = ORM::factory('incident',$incident_id);
		$incident->incident_active = $val;
		return $incident->save();
	}

	/**
	 * Sets incident as verified or not
	 * @param int $incident_id
	 * @param int $val Set to 1 or 0 for verified or not verified
	 * @return bool
	 */
	public static function set_verification($incident_id,$val)
	{
		$incident = ORM::factory('incident',$incident_id);
		$incident->incident_verified = $val;
		return $incident->save();
	}

	/**
	 * Overrides the default delete method for the ORM.
	 * Deletes all other content related to the incident - performs
	 * an SQL destroy
	 */
	public function delete()
	{
		// Delete Location
		ORM::factory('location')
			->where('id', $this->location_id)
			->delete_all();

		// Delete Categories
		ORM::factory('incident_category')
		    ->where('incident_id', $this->id)
		    ->delete_all();

		// Delete Translations
		ORM::factory('incident_lang')
		    ->where('incident_id', $this->id)
		    ->delete_all();

		// Delete Photos From Directory
		$photos = ORM::factory('media')
				      ->where('incident_id', $this->id)
				      ->where('media_type', 1)
				      ->find_all();
		
		foreach ($photos as $photo)
		{
			Media_Model::delete_photo($photo->id);
		}

		// Delete Media
		ORM::factory('media')
		    ->where('incident_id', $this->id)
		    ->delete_all();

		// Delete Sender
		ORM::factory('incident_person')
		    ->where('incident_id', $this->id)
		    ->delete_all();

		// Delete relationship to SMS message
		$updatemessage = ORM::factory('message')
						     ->where('incident_id', $this->id)
						     ->find();

		if ($updatemessage->loaded)
		{
			$updatemessage->incident_id = 0;
			$updatemessage->save();
		}

		// Delete Comments
		ORM::factory('comment')
			->where('incident_id', $this->id)
			->delete_all();
			
		// Delete ratings
		ORM::factory('rating')
			->where('incident_id', $this->id)
			->delete_all();

		$incident_id = $this->id;

		// Action::report_delete - Deleted a Report
		Event::run('ushahidi_action.report_delete', $incident_id);

		parent::delete();
	}

	/**
	 * Get the no. of videos associated with this incident
	 * @return int
	 */
	public function count_videos()
	{
		return $this->count_asset_by_type(2);
	}
	
	/**
	 * Get the no. of images associated with this incident
	 * @return int
	 */
	public function count_images()
	{
		return $this->count_asset_by_type(1);
	}
	
	public function count_reports()
	{
		return $this->count_asset_by_type(4);
	}
	
	/**
	 * Gets the no. of media items associated with this incident
	 *
	 * @param  int  $type Type of media
	 * @return int
	 */
	private function count_asset_by_type($type)
	{
		return Database::instance()
		    ->where('media_type', $type)
		    ->where('incident_id', $this->id)
		    ->count_records('media');
	}

	public function share_url()
	{
		return url::site("reports/view".$this->id);
	}

	/**
	 * Gets the list of users collaborating on an incident
	 * This is the list of users that have:
	 *     - Created a location entry
	 *     - Uploaded a KML for the current incident
	 *     - Uploaded media (image, video etc) for the incident
	 *     - Added a legend to the incident/map
	 * @return array
	 */
	public function get_collaborators()
	{
		$collaborator_ids = array();

		// Locations
		foreach ($this->location as $location)
		{
			$collaborator_ids[] = $location->user_id;
		}

		// Media
		foreach ($this->media as $media)
		{
			$collaborator_ids[] = $media->user_id;
		}

		// KMLS
		foreach ($this->incident_kml as $kml)
		{
			$collaborator_ids[] = $kml->user_id;
		}
		
		// Legends
		foreach ($this->incident_legend as $legend)
		{
			$collaborators_ids[] = $legend->user_id;
		}

		// Sanity check
		if ( ! count($collaborator_ids)) return array();
		
		// Get the unique values
		$collaborator_ids = array_unique($collaborator_ids);
		
		$collaborators = array();

		// Fetch the entries
		$collaborators_iterator = ORM::factory('user')
			->in('id', $collaborator_ids)
			->find_all();

		foreach ($collaborators_iterator as $collaborator)
		{
			$collaborators[] = $collaborator;
		}

		return $collaborators;
	}

	/**
	 * Creates entries in the tags and incident_tags tables
	 * from the form response of the current incident
	 */
	public function generate_tags()
	{
		// TODO - write the code
	}

	/**
	 * Gets the layers associated with the incident via incident_kml
	 *
	 * @return array
	 */
	public function get_layers()
	{
		$layer_ids = array();
		foreach ($this->incident_kml as $kml)
		{
			$layer_ids[] = $kml->layer_id;
		}

		// Sanity check
		if ( ! count($layer_ids)) return array();

		$layers = array();
		foreach (ORM::factory('layer')->in('id', $layer_ids)->find_all() as $layer)
		{
			$layers[] = $layer;
		}
		return $layers;
	}

	/**
	 * Determines whether a given owner is the owner of the current
	 * incident. By default, the "admin" user is an owner of all incidents
	 *
	 * @param  User_Model ORM instance of the user
	 * @return bool
	 */
	public function is_owner($user)
	{
		return ($this->user_id == $user->id) OR $user->has(ORM::factory('role', 'superadmin'));
	}

	/**
	 * Gets the category IDs associated with the current incident
	 * @return array
	 */
	public function get_categories_array()
	{
		$categories = array();
		foreach ($this->incident_category as $category)
		{
			$categories[] = $category->category_id;
		}
		return $categories;
	}

	/**
	 * Gets the locations for this incident as an array
	 *
	 * @return array
	 */
	public function get_locations_array()
	{
		$locations = array();
		foreach ($this->location as $location)
		{
			$locations[$location->id] = $location->as_array();
		}

		// Map media types to their actual names
		$media_type_map = array(1 => 'photo', 2 => 'video', 4 => 'news');

		foreach ($this->media as $media)
		{
			$location_id = $media->location_id;
			if (array_key_exists($location_id, $locations))
			{
				$media_type = $media_type_map[$media->media_type];
				
				if ( ! array_key_exists($media_type, $locations[$location_id]))
				{
					$locations[$location_id][$media_type] = array();
				}
				
				// Media type entry
				$entry = array(
				    "id" => $media->id,
				    "location_id" => $location_id,
				    "media_type" => $media_type,
				    "media_link" => trim($media->media_link),
				    "media_thumb" => $media->media_thumb					
				);
				
				$locations[$location_id][$media_type][] = $entry;
			}
		}

		return  ( ! count($locations)) ? $locations : array_values($locations);
	}

	/**
	 * Associates an the incident with the layer by creating
	 * an entry in incident_kml
	 * @param  ORM $user
	 * @param  ORM $layer
	 */
	public function add_layer($user, $layer)
	{
		$entry = ORM::factory('incident_kml')
			->where('incident_id', $this->id)
			->where('layer_id', $layer->id)
			->find();

		if ( ! $entry->loaded)
		{
			$entry = new Incident_Kml_Model();
			$entry->incident_id = $this->id;
			$entry->layer_id = $layer->id;
			$entry->user_id = $user->id;
			$entry->save();

			return TRUE;
		}

		Kohana::log("error", "The layer has already been associated with this incident");
		return FALSE;
	}

	/**
	 * Checks if the specified user has access to the
	 * incident
	 *
	 * @param  ORM $user
	 * @return bool
	 */
	public function has_access($user)
	{
		// If the incident is public, return TRUE
		if ( ! $this->incident_privacy OR $user->loaded)
		{
			return TRUE;
		}

		// If the incident is private and no user has been specified
		// return FALSE
		if ($this->incident_privacy AND empty($user))
		{
			return FALSE;
		}

		// Default
		return FALSE;
	}
	
	/**
	 * Gets the legends for the current incident
	 *
	 * @return array
	 */
	public function get_legends_array()
	{
		$legends = array();
		
		// Get the legends
		$incident_legends = Database::instance()
			->select('incident_legend.id', 'legend.legend_name', 'incident_legend.legend_color')
			->from('incident_legend')
			->join('legend', 'legend.id', 'incident_legend.legend_id')
			->where('incident_legend.incident_id', $this->id)
			->get();
		
		foreach ($incident_legends as $legend)
		{
			$legends[] = array(
				'id' => $legend->id,
				'legend_name' => $legend->legend_name,
				'legend_color' => $legend->legend_color
			);
		}

		return $legends;
	}
	
	/**
	 * Adds a legend to the incident
	 * 
	 * @param int $incident_id ID of the incident
	 * @param array $post_data Name and color of the legend packed into an object
	 * @param int $user_id ID of the user adding the legend
	 * @return mixed array on success, FALSE otherwise
	 */
	public static function add_legend($incident_id, $post_data, $user_id)
	{
		// Add the legend
		$legend_orm = Legend_Model::add_legend($post_data['legend_name']);		
		
		// Use a try/catch block so that we fail gracefully should a DB
		// constraint be violated
		try
		{
			$incident_legend = new Incident_Legend_Model();
			$incident_legend->incident_id = $incident_id;
			$incident_legend->legend_id = $legend_orm->id;
			$incident_legend->legend_color = $post_data['legend_color'];
			$incident_legend->user_id = $user_id;
			$incident_legend->save();

			return array(
				'id' => $incident_legend->id,
				'legend_name' => $legend_orm->legend_name,
				'legend_color' => $incident_legend->legend_color
			);
		}
		catch (Kohana_Exception $e)
		{
			// Log the error
			Kohana::log("error", $e->getMessage());			
		}
		
		return FALSE;
	}
	
	/**
	 * Gets an array of the incident's tags
	 *
	 * @return array
	 */
	public function get_tags()
	{
		$tag_ids = array();
		foreach ($this->incident_tags as $tag)
		{
			$tag_ids[] = $tag->tag_id;
		}

		if ( ! count($tag_ids)) return array();

		$tags = array();
		foreach (ORM::factory('tag')->in('id', $tag_ids)->find_all() as $tag)
		{
			$tags[] = $tag;
		}
		
		return $tags;
	}

}
