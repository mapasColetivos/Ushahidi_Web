<?php defined('SYSPATH') or die('No direct script access.');

class Social_Controller extends Main_Controller {

	function is_ajax(){
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
	}
	
	function __construct()
	{
		parent::__construct();
		$this->user = Session::instance()->get('auth_user',FALSE);
	}
	
	function follow($user_id = false){
		$user = ORM::factory("user")->find($user_id);
		if (!$this->user->follows($user) and $user->id != $this->user->id){
			$relation = new Users_users_Model();
			$relation->followee_id = $user_id;
			$relation->follower_id = $this->user->id;
			$relation->save();
		}
		url::redirect(url::site().'users/index/'.$user_id);	
	}
	
	function unfollow($user_id = false){
		$user = ORM::factory("user")->find($user_id);
		if ($this->user->follows($user)){
			ORM::factory('users_users')->where("follower_id",$this->user->id)->where("followee_id",$user->id)->delete_all();
		}
		url::redirect(url::site().'users/index/'.$user_id);	
	}
	
	function follow_map($incident_id = false){
		$incident = ORM::factory("incident")->find($incident_id);
		if (!$this->user->follows_map($incident)){
			$relation = new Maps_users_Model();
			$relation->map_id = $incident_id;
			$relation->user_id = $this->user->id;
			$relation->save();
		}
		url::redirect(url::site().'reports/view/'.$incident_id);	
	}
	
	function unfollow_map($incident_id = false){
		$incident = ORM::factory("incident")->find($incident_id);
		if ($this->user->follows_map($incident)){
			ORM::factory('maps_users')->where("user_id",$this->user->id)->where("map_id",$incident->id)->delete_all();
		}
		url::redirect(url::site().'reports/view/'.$incident_id);
	}
}