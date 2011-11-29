<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Model for users for the Auth Module
 *
 * $Id: user.php 3352 2008-08-18 09:43:56BST atomless $
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     User Model  
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class User_Model extends Auth_User_Model {
	public function has_role($role){
		$has_role = FALSE;
		foreach ($this->roles as $user_role)
		{
			if ($user_role->name == $role)
			{
				$has_role = TRUE;
				break;
			}
		}
		return $has_role;
	}
	
	public function follows($user){
		$relation = ORM::factory('users_users')->where("follower_id",$this->id)->where("followee_id",$user->id)->find();
		return $relation->id != 0;	
	}
	
	public function follows_map($incident){
		$relation = ORM::factory('maps_users')->where("user_id",$this->id)->where("map_id",$incident->id)->find();
		return $relation->id != 0;	
	}
	
	public function following_maps(){
		$incident_ids = ORM::factory('maps_users')->where("user_id",$this->id)->find_all()->as_array();		
		return array_filter(array_map("map_get_incidents", $incident_ids));
	}
	
	public function available_maps(){
		$available = array();
		$incidents = ORM::factory('incident')->where("owner_id",$this->id)->find_all()->as_array();
		$available = array_merge($available,array_map("map_get_incident_ids",$incidents));
	
		$kmls = ORM::factory('incident_kml')->where("owner_id",$this->id)->find_all()->as_array();
		$available = array_merge($available,array_map("map_get_ids",$kmls));
		
		$locations = ORM::factory('location')->where("owner_id",$this->id)->find_all()->as_array();
		$available = array_merge($available,array_map("map_get_ids",$locations));
		
		$location_layers = ORM::factory('location_layer')->where("owner_id",$this->id)->find_all()->as_array();
		$available = array_merge($available,array_map("map_get_ids",$location_layers));

		$media = ORM::factory('media')->where("owner_id",$this->id)->find_all()->as_array();
		$available = array_merge($available,array_map("map_get_ids",$media));
		
		return array_filter(array_map("map_get_incident",array_unique($available)));
	}
	
	public function created_maps(){
		return ORM::factory('incident')->where("owner_id",$this->id)->find_all();
	}
	
	public function followees(){
		$followees = ORM::factory('users_users')->where("follower_id",$this->id)->find_all();
		return $followees;
	}
	
	public function photo($width){
		$email_hash = md5(strtolower(trim($this->email)));
		return 'http://www.gravatar.com/avatar/'.$email_hash.'?s='.$width.'&d='.url::base().'media/img/user_no_photo.png';
	}
	
	public function categories(){
    $categories = ORM::factory('category')
				->where('category_visible', '1')
				->where('parent_id', '0')
				->find_all();
    
    return $categories;
	}
	
} // End User_Model

function map_get_incidents ($item){
	$incident = ORM::factory('incident')->where("id",$item->map_id)->find();
	if ($incident->id > 0){
		return $incident;
	};
	return null;
}

function map_get_incident_ids($item){
	return $item->id;
}

function map_get_ids($item){
	return $item->incident_id;
}

function map_get_incident($item){
	$incident = ORM::factory('incident')->where("id",$item)->find();
	if ($incident->id > 0){
		return $incident;
	};
	return null;
}