<?php
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
 * @package    Ushahidi - http://github.com/ushahidi/Ushahidi_Web
 * @subpackage Models
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class User_Model extends Auth_User_Model {

	/**
	 * One-to-many relationship definition
	 * @var array
	 */
	protected $has_many = array(
		'alert',
		'comment', 
		'openid', 
		'private_message',
		'rating',
		'media',
		'incident',
		'location',
		'incident_kml',
		'user_followers',
		'layer',
		'location_layer',
		'incident_follows',
	);
	
	/**
	 * Creates a basic user and assigns to login and member roles
	 * 
	 * @param   string  email
	 * @param   string  password
	 * @param   string  riverid user id
	 * @return  object  ORM object from saving the user
	 */
	public static function create_user($email, $password, $riverid=false, $name=false)
	{
		$user = ORM::factory('user');

		$user->email = $email;
		$user->username = User_Model::random_username();
		$user->password = $password;

		if ($name != false)
		{
			$user->name = $name;
		}

		if ($riverid != false)
		{
			$user->riverid = $riverid;
		}

		// Add New Roles if:
		//    1. We don't require admin to approve users (will be added when admin approves)
		//    2. We don't require users to first confirm their email address (will be added
		//       when user confirms if the admin doesn't have to first approve the user)
		if (Kohana::config('settings.manually_approve_users') == 0
			AND Kohana::config('settings.require_email_confirmation') == 0)
		{
			$user->add(ORM::factory('role', 'login'));
			$user->add(ORM::factory('role', 'member'));
		}

		return $user->save();
	}

	/**
	 * Gets the email address of a user
	 * @return string
	 */
	public static function get_email($user_id)
	{
		$user = ORM::factory('user')->find($user_id);
		return $user->email;
	}

	/**
	 * Returns data for a user based on username
	 * @return object
	 */
	public static function get_user_by_username($username)
	{
		$user = ORM::factory('user')->where(array('username'=>$username))->find();
		return $user;
	}

	/**
	 * Returns data for a user based on email
	 * @return object
	 */
	public static function get_user_by_email($email)
	{
		$user = ORM::factory('user')->where(array('email'=>$email))->find();
		return $user;
	}

	/**
	 * Returns data for a user based on user id
	 *
	 * @return mixed User_Model if the user exists, FALSE otherwise
	 */
	public static function get_user_by_id($user_id)
	{
		$user = ORM::factory('user', $user_id);
		
		return $user->loaded ? $user : FALSE;
	}

	/**
	 * Returns data for a user based on river id
	 * @return object
	 */
	public static function get_user_by_river_id($river_id)
	{
		$user = ORM::factory('user')->where(array('riverid'=>$river_id))->find();
		return $user;
	}

	/**
	 * Returns all users with public profiles
	 * @return object
	 */
	public static function get_public_users()
	{
		$users = ORM::factory('user')
			->where(array('public_profile'=>1)) // Only show public profiles
			->notlike(array('username'=>'@')) // We only want to show profiles that don't have email addresses as usernames
			->find_all();
		return $users;
	}

	/**
	 * Custom validation for this model - complements the default validate()
	 *
	 * @param   array  array to validate
	 * @param   Auth   instance of Auth class; used for testing purposes
	 * @return bool TRUE if validation succeeds, FALSE otherwise
	 */
	public static function custom_validate(array & $post, Auth $auth = NULL)
	{
		// Initalize validation
		$post = Validation::factory($post)
				->pre_filter('trim', TRUE);
		
		if ($auth === NULL)
		{
			$auth = new Auth;
		}

		$post->add_rules('username','required','length[3,100]', 'alpha_numeric');
		$post->add_rules('name','required','length[3,100]');
        $post->add_rules('email','required','email','length[4,64]');

		// If user id is not specified, check if the username already exists
		if (empty($post->user_id))
		{
			$post->add_callbacks('username', array('User_Model', 'unique_value_exists'));
			$post->add_callbacks('email', array('User_Model', 'unique_value_exists'));
		}

		// Only check for the password if the user id has been specified and we are passing a pw
		if (isset($post->user_id) AND isset($post->password))
		{
			$post->add_rules('password','required', 'length['.Kohana::config('auth.password_length').']');
			$post->add_callbacks('password' ,'User_Model::validate_password');
		}

		// If Password field is not blank and is being passed
		if ( isset($post->password) AND
			(! empty($post->password) OR (empty($post->password) AND ! empty($post->password_again))))
		{
			$post->add_rules('password','required','length['.Kohana::config('auth.password_length').']', 'matches[password_again]');
			$post->add_callbacks('password' ,'User_Model::validate_password');
		}

		$post->add_rules('role','required','length[3,30]', 'alpha_numeric');
		$post->add_rules('notify','between[0,1]');

		if ( ! $auth->logged_in('superadmin'))
		{
			$post->add_callbacks('role', array('User_Model', 'prevent_superadmin_modification'));
		}

		// Additional validation checks
		Event::run('ushahidi_action.user_submit_admin', $post);

		// Return
		return $post->validate();
	}

	/**
	 * Checks if a password is correct
	 *
	 * @param   int  user id
	 * @param   string   password to check
	 * @return bool TRUE if the password matches, FALSE otherwise
	 */
	public static function check_password($user_id,$password,$force_standard_method=FALSE)
	{
		$user = ORM::factory('user',$user_id);

		// RiverID or Standard method?
		if (kohana::config('riverid.enable') == TRUE
        	AND ! empty($user->riverid)
        	AND ! $force_standard_method)
		{
			// RiverID
			$riverid = new RiverID;
			$riverid->email = $user->email;
			$riverid->password = $password;
			if ($riverid->checkpassword() != FALSE)
			{
				return TRUE;
			}
			else
			{
				// TODO: Maybe return the error message?
				return FALSE;
			}
		}
		else
		{
			// Standard Local
			$auth = Auth::instance();
			return $auth->check_password($user_id,$password);
		}
	}

	/**
	 * Checks if the value in the specified field exists in database
	 */
	public static function unique_value_exists(Validation $post, $field)
	{
		$exists = (bool) ORM::factory('user')->where($field, $post[$field])->count_all();
		if ($exists)
		{
			$post->add_error($field, 'exists');
		}
	}

	/**
	 * Ensures that only a superadmin can modify superadmin users, or upgrade a user to superadmin
	 * @note this assumes the currently logged-in user isn't a superadmin
	 */
	public static function prevent_superadmin_modification(Validation $post, $field)
	{
		if ($post[$field] == 'superadmin')
		{
			$post->add_error($field, 'superadmin_modify');
		}
	}

	public static function validate_password(Validation $post, $field)
	{
		$_is_valid = User_Model::password_rule($post[$field]);
		if (! $_is_valid)
		{
			$post->add_error($field,'alpha_dash');
		}
	}

	public static function password_rule($password, $utf8 = FALSE)
	{
		return ($utf8 === TRUE)
			? (bool) preg_match('/^[-\pL\pN#@_]++$/uD', (string) $password)
			: (bool) preg_match('/^[-a-z0-9#@_]++$/iD', (string) $password);
	}

	/*
	* Creates a random int value for a username that isn't already represented in the database
	*/
	public function random_username()
	{
		while ($random = mt_rand(1000,mt_getrandmax()))
		{
			$find_username = ORM::factory('user')->where('username',$random)->count_all();
			if ($find_username == 0)
			{
				return $random;
			}
		}

		return FALSE;
	}


	/**
	 * Overrides the default delete method for the ORM.
	 * Deletes roles associated with the user before user is removed from DB.
	 */
	public function delete()
	{
		// Remove assigned roles
		// Have to use db->query() since we don't have an ORM model for roles_users
		$this->db->query('DELETE FROM roles_users WHERE user_id = ?',$this->id);
		
		// Remove assigned badges
		$this->db->query('DELETE FROM badge_users WHERE user_id = ?',$this->id);

		// Delete alerts
		ORM::factory('alert')
		    ->where('user_id', $this->id)
		    ->delete_all();
		
		// Delete user_token
		ORM::factory('user_token')
		    ->where('user_id', $this->id)
		    ->delete_all();
		
		// Delete openid
		ORM::factory('openid')
		    ->where('user_id', $this->id)
		    ->delete_all();

		// Delete user_devices
		ORM::factory('user_devices')
		    ->where('user_id', $this->id)
		    ->delete_all();
		
		parent::delete();
	}
	
	/**
	 * Check if user has specified permission
	 * @param $permission String permission name
	 **/
	public function has_permission($permission)
	{
		// Special case - superadmin ALWAYS has all permissions
		if ($this->has(ORM::factory('role','superadmin')))
		{
			return TRUE;
		}
		
		foreach ($this->roles as $user_role)
		{
			if ($user_role->has(ORM::factory('permission',$permission)))
			{
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	/**
	 * Get user's dashboard
	 */
	public function dashboard()
	{
		if ($this->has_permission('admin_ui'))
			return 'admin';
		
		if ($this->has_permission('member_ui'))
			return 'members';
		
		// Just in case someone has a login only role
		if ($this->has(ORM::factory('role','login')))
			return '';
		
		// Send anyone else to login
		return 'login';
	}

	/**
	 * Get the url for the current user's dashboard
	 * @return string
	 */
	public function get_dashboard_url()
	{
		return ($this->username == "admin")
		    ? url::site()."admin/dashboard"
		    : url::site()."users/index/".$this->id;
	}

	/**
	 * Get's the current user's avatar from Gravatar
	 *
	 * @param  int $size Size of the gravatar image. The default size is 30px
	 * @return string
	 */
	public function gravatar($size = 30)
	{
		$email_hash = md5(strtolower(trim($this->email)));
		return 'https://secure.gravatar.com/avatar/'.$email_hash.'?s='.$size.'&d='.url::base().'media/img/user_no_photo.png';
	}

	/**
	 * Verifies whether the current user is following the specified user
	 *
	 * @param  Model_User $user
	 * @return bool
	 */
	public function is_following($user)
	{
		return ORM::factory('user_followers')
		    ->where('user_id', $user->id)
		    ->where('follower_id', $this->id)
		    ->find()
		    ->loaded;
	}

	/**
	 * Gets the list of all users that the current user is following
	 *
	 * @return ORM_Iterator
	 */
	public function get_following()
	{
		return ORM::factory('user')
		    ->join('user_followers', 'user_followers.user_id', 'users.id')
		    ->where('user_followers.follower_id', $this->id)
		    ->find_all();
	}

	/**
	 * Gets the list of all users that are following the current user
	 *
	 * @return ORM_Iterator
	 */
	public function get_followers()
	{
		return ORM::factory('user')
		    ->join('user_followers', 'user_followers.follower_id', 'users.id')
		    ->where('users.id', $this->id)
		    ->find_all();
	}

	/**
	 * Gets all incidents in which the current user has collaborated on by
	 *     1. Creating an incident
	 *     2. Uploading a KML for that incident
	 *     3. Submitting a location for the incident
	 *     4. Uploading media (news source link, images, video) for the incident
	 *
	 * @return array
	 */
	public function get_incidents_collaborated_on()
	{
		$incidents = array();

		// Get the incidents
		foreach ($this->incident as $incident)
		{
			$this->_add_incident_to_array($incidents, $incident);
		}

		// KMLs uploaded by the user (incident_kml)
		foreach ($this->incident_kml as $kml)
		{
			$this->_add_incident_to_array($incidents, $kml->incident);
		}

		// Locations created by the user (location)
		foreach ($this->location as $location)
		{
			$this->_add_incident_to_array($incidents, $location->incident);
		}

		// Location layers (location_layer)
		foreach ($this->location_layer as $location_layer)
		{
			$this->_add_incident_to_array($incidents, $location_layer->incident);
		}

		// Media
		foreach ($this->media as $media)
		{
			$this->_add_incident_to_array($incidents, $media->incident);
		}

		return array_values($incidents);
	}

	/**
	 * Given an incident checks whether it exists in the provided buffer
	 * and adds it (if it doesn't exist)
	 *
	 * @param   array          $incidents List of incidents
	 * @param   Incident_Model $incident Incident to be added
	 */
	private function _add_incident_to_array(array & $incidents, $incident)
	{
		if ( ! array_key_exists($incident->id, $incidents))
		{
			$incidents[$incident->id] = $incident;
		}
	}

	/**
	 * Given an incident (map), checks whether the current user follows it
	 * @param  Model_Incident $incident
	 */
	public function is_incident_follower($incident)
	{
		$where_array = array(
			'user_id' => $this->id,
			'incident_id' => $incident->id
		);
		return ORM::factory('incident_follow')->where($where_array)->count_all() > 0;
	}

} // End User_Model
