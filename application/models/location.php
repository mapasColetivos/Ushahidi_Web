<?php defined('SYSPATH') or die('No direct script access.');

/**
* Model for Locations
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Location Model  
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Location_Model extends ORM
{
	protected $has_many = array('media', 'incident_person', 'feed_item', 'reporter');
	protected $has_one = array('country','incident');
	
	// Database table name
	protected $table_name = 'location';
	
	public function layer_color(){
		return $this->layer()->layer_color;
	}
	
	public function layer(){
		$id = $this->layer_id;
		return ORM::factory('location_layer')->where('id',$id)->find();
	}
	
	public function category_color(){
		return $this->category()->category_color;
	}
	
	public function category_id(){
		return $this->category()->id;
	}
	
	public function category(){
		$category_id = ORM::factory('incident_category')->where('incident_id',$this->incident_id)->find()->category_id;
		$category = ORM::factory("category")->where("id",$category_id)->find();
		return $category;
	}
	
	public function filters($filter){
		if ($filter == 0){
			//Recents
			return "false";			
		} else if ($filter == 1){
			//Starred
			return "false";	
		} else if ($filter == 2){
			//Reports Media type 4
			$reports = ORM::factory('media')->where("location_id",$this->id)->where("media_type",4)->find_all()->count();
			return $reports > 0 ? "true" : "false";			
		} else if ($filter == 3){
			//Photos Media type 1
			$photos = ORM::factory('media')->where("location_id",$this->id)->where("media_type",1)->find_all()->count();
			return $photos > 0 ? "true" : "false";			
		} else if ($filter == 4){
			//Videos Media type 2
			$videos = ORM::factory('media')->where("location_id",$this->id)->where("media_type",2)->find_all()->count();
			return $videos > 0 ? "true" : "false";
		}
		return "true";	
	}	
}
