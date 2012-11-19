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
		'incident_legend',
		'incident_follows',
	);

	/**
	 * Creates a basic user and assigns to login and member roles
	 *
	 * @param   string  usename
	 * @param   string  name
	 * @param   string  email
	 * @param   string  password
	 * @return  object  ORM object from saving the user
	 */
	public static function create_user($username, $name, $email, $password)
	{
		$user = ORM::factory('user');

		$user->email = $email;
		$user->username = $username;
		$user->password = $password;
		$user->name = $name;
		$user->confirmed = 1;

		$user->add(ORM::factory('role', 'login'));

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

		$post->add_rules('username','required','length[3,100]');
		$post->add_rules('name','required','length[3,100]');
        $post->add_rules('email','required','email','length[4,64]');

		// If user id is not specified, check if the username already exists
		if (empty($post->user_id))
		{
			$post->add_callbacks('username', array('User_Model', 'unique_value_exists'));
			$post->add_callbacks('email', array('User_Model', 'unique_value_exists'));
		}

		// Only check for the password if the user id has been specified and we are passing a pw
		if (isset($post->user_id) AND ! empty($post->password))
		{
			$post->add_rules('password','required', 'length['.Kohana::config('auth.password_length').']');
			$post->add_callbacks('password' ,'User_Model::validate_password');
		}

		// If Password field is not blank and is being passed
		if
		(
			! isset($post->user_id) OR
			(isset($post->user_id) AND (! empty($post->password) OR ! empty($post->password_again))))
		{
			$post->add_rules('password','required','length['.Kohana::config('auth.password_length').']', 'matches[password_again]');
			$post->add_callbacks('password' ,'User_Model::validate_password');
		}

		//
		// Additional validation rules - for mapasColetivos
		//
		if ( ! empty($post->web))
		{
			$post->add_rules('web', 'url');
		}

		if ( ! empty($post->localization))
		{
			$post->add_rules('localizaton', 'standard_text');
		}

		if ( ! empty($post->bio))
		{
			$post->add_rules('bio', 'standard_text');
		}


		// $post->add_rules('role','required','length[3,30]', 'alpha_numeric');
		// $post->add_rules('notify','between[0,1]');

		// if ( ! $auth->logged_in('superadmin'))
		// {
		// 	$post->add_callbacks('role', array('User_Model', 'prevent_superadmin_modification'));
		// }

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
		return ORM::factory('user_follower')
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
	 *     5. Creating a legend on an incident
	 *
	 * @return array
	 */
	public function get_incidents_collaborated_on()
	{
		$incident_ids = array();

		// Get the incidents
		foreach ($this->incident as $incident)
		{
			$incident_ids[] = $incident->id;
		}

		// KMLs uploaded by the user (incident_kml)
		foreach ($this->incident_kml as $kml)
		{
			$incident_ids[] = $kml->incident_id;
		}

		// Locations created by the user (location)
		foreach ($this->location as $location)
		{
			$incident_ids[] = $location->incident_id;
		}

		// Media
		foreach ($this->media as $media)
		{
			$incident_ids[] = $media->incident_id;
		}
		
		// Legends created by this user
		foreach ($this->incident_legend as $legend)
		{
			$incident_ids[] = $legend->incident_id;
		}

		if ( ! count($incident_ids)) return array();

		$incidents = array();
		$incident_ids = array_unique($incident_ids);
		foreach (ORM::factory('incident')->in('id', $incident_ids)->find_all() as $incident)
		{
			$incidents[] = $incident;
		}
		
		return $incidents;
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

	/**
	 * Unfollows the user with the specified id
	 *
	 * @param  int  $user_id
	 */
	public function unfollow_user($user_id)
	{
		ORM::factory('user_follower')
		    ->where('user_id', $user_id)
		    ->where('follower_id', $this->id)
		    ->delete_all();
	}

	/**
	 * Follows the user with the specified id
	 *
	 * @param  int $user_id
	 */
	public function follow_user($user_id)
	{
		if (self::get_user_by_id($user_id))
		{
			$follow_orm = new User_Followers_Model();
			$follow_orm->user_id = $user_id;
			$follow_orm->follower_id = $this->id;
			$follow_orm->save();

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Adds an incident to the list of incidents followed
	 * by the current user
	 *
	 * @param int $incident_id Incident to follow
	 * @return bool
	 */
	public function follow_incident($incident_id)
	{
		if (Incident_Model::is_valid_incident($incident_id, FALSE))
		{
			$follow_orm = new Incident_Follow_Model();
			$follow_orm->user_id = $this->id;
			$follow_orm->incident_id = $incident_id;
			$follow_orm->save();

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Removes an incident (map) from the list of incidents that the
	 * current user is following
	 *
	 * @param  int $incident_id Incident to unfollow
	 * @return bool
	 */
	public function unfollow_incident($incident_id)
	{
		if (Incident_Model::is_valid_incident($incident_id, FALSE))
		{
			ORM::factory('incident_follow')
			    ->where('incident_id', $incident_id)
			    ->where('user_id', $this->id)
			    ->delete_all();

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Given an incident, gets the list of all layers created
	 * by the list
	 *
	 * @param  Incident_Model $incident ORM instance of the incident
	 * @return ORM_Iterator
	 */
	public function get_incident_layers($incident)
	{
		return ORM::factory('incident_kml')
		     ->where('incident_id', $incident->id)
		     ->where('user_id', $this->id)
		     ->find_all();
	}

	/**
	 * Gets the layers for the current user. If the user has
	 * the "superadmin" role, all the layers as returned
	 *
	 * @return array
	 */
	public function get_layers_array()
	{
		$layers = array();
		foreach ($this->get_layers as $layer)
		{
			$layers[] = $layer->as_array();
		}

		return $layers;
	}
	
	/**
	 * Gets the list of layers created by the current user. The
	 * entries in the return array are ORM objects
	 *
	 * @return array
	 */
	public function get_layers()
	{
		$layers = array();

		foreach ($this->layer as $layer)
		{
			$layers[] = $layer;
		}

		return $layers;
	}

	/**
	 * Gets the list of viewable incidents/maps for the current user.
	 * Where the $visitor parameter has been specified and they are an
	 * administrator on the deployment, all the user's incidents (maps)
	 * are returned. Otherwise, only the public ones (incident_privacy = 0)
	 * are returned.
	 *
	 * @param mixed $visitor
	 * @return array
	 */
	public function get_visible_incidents($visitor = NULL)
	{
		$fetch_all = ! empty ($visitor) AND
			($visitor->is_administrator() OR $visitor->id === $this->id);

		$visible_incidents = array();

		foreach ($this->incident as $incident)
		{
			if ($fetch_all)
			{
				$visible_incidents[] = $incident;
			}
			else
			{
				if ($incident->incident_privacy == 0)
				{
					$visible_incidents[] = $incident;
				}
			}
		}

		return $visible_incidents;
	}

	/**
	 * Whether the current user is an administrator i.e. either has
	 * the admin or superadmin role
	 *
	 * @return bool
	 */
	public function is_administrator()
	{
		return $this->has(ORM::factory('role', 'superadmin')) OR
			$this->has(ORM::factory('role', 'admin'));
	}
	
	/**
	 * Gets the incidents that the user is following
	 * 
	 * @return array
	 */
	public function get_incidents_following()
	{
		$incident_ids = array();
		
		foreach ($this->incident_follows as $follow)
		{
			$incident_ids[] = $follow->incident_id;
		}
		
		// Sanity check
		if ( ! count($incident_ids)) return array();
		
		// Fetch the followed incidents
		$incidents = array();
		foreach (ORM::factory('incident')->in('id', $incident_ids)->find_all() as $incident)
		{
			$incidents[] = $incident;
		}
			
		return $incidents;
	}

	/**
	 * Gets the legends created by the current user
	 * @return array
	 */
	public function get_legends_array()
	{
		$legends = array();
		
		// Get the legends
		$incident_legends = Database::instance()
			->select('DISTINCT incident_legend.id', 'legend.legend_name', 'incident_legend.legend_color')
			->from('incident_legend')
			->join('legend', 'legend.id', 'incident_legend.legend_id')
			->join('location', 'location.incident_legend_id', 'incident_legend.id')
			->where('incident_legend.user_id', $this->id)
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

} // End User_Model
