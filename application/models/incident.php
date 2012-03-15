<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for reported Incidents
 *
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Incident Model
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class Incident_Model extends ORM
{
	protected $has_many = array('category' => 'incident_category', 'media', 'verify', 'comment',
		'rating', 'alert' => 'alert_sent', 'incident_lang', 'form_response','cluster' => 'cluster_incident', 'locations');
	protected $has_one = array('incident_person','user','message','twitter','form');
	protected $belongs_to = array('sharing');

	// Database table name
	protected $table_name = 'incident';

	// Prevents cached items from being reloaded
	protected $reload_on_wakeup   = FALSE;

	static function get_active_categories()
	{
		// Get all active categories
		$categories = array();
		foreach (ORM::factory('category')
			->where('category_visible', '1')
			->find_all() as $category)
		{
			// Create a list of all categories
			$categories[$category->id] = array($category->category_title, $category->category_color);
		}
		return $categories;
	}
	

	/*
	* get the total number of reports
	* @param approved - Only count approved reports if true
	*/
	public static function get_total_reports($approved=false)
	{
		if($approved)
		{
			$count = ORM::factory('incident')->where('incident_active', '1')->count_all();
		}else{
			$count = ORM::factory('incident')->count_all();
		}

		return $count;
	}

	/*
	* get the total number of verified or unverified reports
	* @param verified - Only count verified reports if true, unverified if false
	*/
	public static function get_total_reports_by_verified($verified=false)
	{
		if($verified)
		{
			$count = ORM::factory('incident')->where('incident_verified', '1')->where('incident_active', '1')->count_all();
		}else{
			$count = ORM::factory('incident')->where('incident_verified', '0')->where('incident_active', '1')->count_all();
		}

		return $count;
	}

	/*
	* get the total number of verified or unverified reports
	* @param approved - Oldest approved report timestamp if true (oldest overall if false)
	*/
	public static function get_oldest_report_timestamp($approved=true)
	{
		if($approved)
		{
			$result = ORM::factory('incident')->where('incident_active', '1')->orderby(array('incident_date'=>'ASC'))->find_all(1,0);
		}else{
			$result = ORM::factory('incident')->where('incident_active', '0')->orderby(array('incident_date'=>'ASC'))->find_all(1,0);
		}

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

	static function get_incidents_by_interval($interval='month',$start_date=NULL,$end_date=NULL,$active='true',$media_type=NULL)
	{
		// Table Prefix
		$table_prefix = Kohana::config('database.default.table_prefix');

		// get graph data
		// could not use DB query builder. It does not support parentheses yet
		$db = new Database();

		$select_date_text = "DATE_FORMAT(incident_date, '%Y-%m-01')";
		$groupby_date_text = "DATE_FORMAT(incident_date, '%Y%m')";
		if ($interval == 'day') {
			$select_date_text = "DATE_FORMAT(incident_date, '%Y-%m-%d')";
			$groupby_date_text = "DATE_FORMAT(incident_date, '%Y%m%d')";
		} elseif ($interval == 'hour') {
			$select_date_text = "DATE_FORMAT(incident_date, '%Y-%m-%d %H:%M')";
			$groupby_date_text = "DATE_FORMAT(incident_date, '%Y%m%d%H')";
		} elseif ($interval == 'week') {
			$select_date_text = "STR_TO_DATE(CONCAT(CAST(YEARWEEK(incident_date) AS CHAR), ' Sunday'), '%X%V %W')";
			$groupby_date_text = "YEARWEEK(incident_date)";
		}

		$date_filter = "";
		if ($start_date) {
			$date_filter .= ' AND incident_date >= "' . $start_date . '"';
		}
		if ($end_date) {
			$date_filter .= ' AND incident_date <= "' . $end_date . '"';
		}

		$active_filter = '1';
		if ($active == 'all' || $active == 'false') {
			$active_filter = '0,1';
		}

		$joins = '';
		$general_filter = '';
		if (isset($media_type) && is_numeric($media_type)) {
			$joins = 'INNER JOIN '.$table_prefix.'media AS m ON m.incident_id = i.id';
			$general_filter = ' AND m.media_type IN ('. $media_type  .')';
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
		foreach ( $query as $month_count )
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

	/*
	* get the number of reports by date for dashboard chart
	*/
	public static function get_number_reports_by_date($range=NULL)
	{
		// Table Prefix
		$table_prefix = Kohana::config('database.default.table_prefix');
		
		$db = new Database();
		
		if ($range == NULL)
		{
			$sql = 'SELECT COUNT(id) as count, DATE(incident_date) as date, MONTH(incident_date) as month, DAY(incident_date) as day, YEAR(incident_date) as year FROM '.$table_prefix.'incident GROUP BY date ORDER BY incident_date ASC';
		}else{
			$sql = 'SELECT COUNT(id) as count, DATE(incident_date) as date, MONTH(incident_date) as month, DAY(incident_date) as day, YEAR(incident_date) as year FROM '.$table_prefix.'incident WHERE incident_date >= DATE_SUB(CURDATE(), INTERVAL '.mysql_escape_string($range).' DAY) GROUP BY date ORDER BY incident_date ASC';
		}
		
		$query = $db->query($sql);
		$result = $query->result_array(FALSE);
		
		$array = array();
		foreach ($result AS $row)
		{
			$timestamp = mktime(0,0,0,$row['month'],$row['day'],$row['year'])*1000;
			$array["$timestamp"] = $row['count'];
		}

		return $array;
	}

	/*
	* return an array of the dates of all approved incidents
	*/
	static function get_incident_dates()
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
	
	public function generate_tags(){
		$tags = ORM::factory('form_response')->where('form_field_id',1)->where('incident_id',$this->id)->find()->form_response;
		$tags_list = preg_split("/,/", $tags);
		ORM::factory("tag")->add_tags_at_incident($tags_list,$this->id);
	}
	
	public function tags(){
		$html = '';
		$tags = ORM::factory("incidents_tags")->where('incident_id',$this->id)->find_all();
		foreach($tags as $tag_relation){
			$tag = ORM::factory("tag")->where("id",$tag_relation->tag_id)->find();
			$html .= "<a href='".url::base()."reports/?t=".$tag->id."'>".$tag->value."</a> ";
		}
		return $html; 
	}
	
	public function add_kml_layer($layer_id,$user_id){
		if (ORM::factory('incident_kml')->where('incident_id',$this->id)->where('kml_id',$layer_id)->find()->id > 0){
			return;
		}
		$relation = ORM::factory('incident_kml');
		$relation->kml_id = $layer_id;
		$relation->incident_id = $this->id;
		$relation->owner_id = $user_id;
		$relation->save();
	}
	
	public function layers(){
		$kmls = array();
		$ids = ORM::factory('incident_kml')->select("DISTINCT kml_id")->where('incident_id',$this->id)->orderby('incident_id')->find_all();
		foreach ($ids as $id){
			$kml = ORM::factory('layer')->where("id",$id->kml_id)->find();
			if ($kml->id > 0){
				array_push($kmls, $kml);
			}
		}

		return $kmls;
	}
	
	public function categories(){
		return ORM::factory('location_layer')->where('incident_id',$this->id)->find_all();
	}
	
	public function count_videos(){
		return $this->count_asset_by_type(2);
	}
	
	public function count_images(){
		return $this->count_asset_by_type(1);
	}
	
	public function count_reports(){
		return $this->count_asset_by_type(4);
	}
	
	private function count_asset_by_type($type){
		$counter = 0;
		foreach($this->media as $media) {			
			if ($media->media_type == $type){
			      $foo=ORM::factory('location')->where('id',$media->location_id)->find();
			      if($foo->location_name){
				    $counter += 1;
			      }
			}
		}
		return $counter;
	}
	
	public function share_url(){
		return "http://www.mapascoletivos.com.br/reports/view/".$this->id;
	}
	
	public function share_mail_to(){
		$title = "Convite para colaborar com o mapa coletivo ".$this->incident_title;
		$body = "Compartilhei com você um mapa coletivo chamado: ".$this->incident_title."%0A%0A";
		$body .= "Você pode visualizar, colaborar e convidar outras pessoas para colaborar com este mapa em%0A%0A";
		$body .= $this->share_url()."%0A%0A%0A";
		return "?subject=".$title."&body=".$body;
		
		//$body .= "obs: para poder colaborar ou criar novos mapas coletivos, você precisa juntar-se à rede mapasColetivos em "+url::base()+"/login";
		
	}
	
	
	public function collaborators(){
		$collaborators = array();

		$kmls = ORM::factory('incident_kml')->where("incident_id",$this->id)->find_all()->as_array();
		$collaborators = array_merge($collaborators,array_map("get_owner_id",$kmls));
		
		$locations_ids = $this->locations->as_array();
		$collaborators = array_merge($collaborators,array_map("get_owner_id",$locations_ids));
		
		$location_layers = ORM::factory('location_layer')->where("incident_id",$this->id)->find_all()->as_array();
		$collaborators = array_merge($collaborators,array_map("get_owner_id",$location_layers));

		$media = ORM::factory('media')->where("incident_id",$this->id)->find_all()->as_array();
		$collaborators = array_merge($collaborators,array_map("get_owner_id",$media));

		return array_filter(array_map("get_user",array_unique($collaborators)));
	}
}

function get_user ($item){
	$user = ORM::factory('user')->where("id",$item)->find();
	if ($user->id > 0){
		return $user;
	};
	return null;
}
function get_owner_id($item){
	return $item->owner_id;
}
