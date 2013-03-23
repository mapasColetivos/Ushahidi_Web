<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This controller handles login requests.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com>
 * @package	   Ushahidi - http://source.ushahididev.com
 * @subpackage Controllers
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class Login_Controller extends Template_Controller {

	public $auto_render = TRUE;

	// Session Object
	protected $session;

	// Main template
	public $template = 'login/main';

	/**
	 * Auth instance
	 * @var Auth
	 */
	protected $auth;

	public function __construct()
	{
		parent::__construct();

		$this->session = new Session();
		$this->auth = Auth::instance();
	}

	/**
	 * Landing page for this controller. Displays the login page
	 */
	public function index()
	{
		if ($this->auth->logged_in() OR $this->auth->auto_login())
		{
			if (($user = Session::instance('auth_user', FALSE)) != FALSE)
			{
				// Redirect the user to their dashboard
				url::redirect($user->get_dashboard_url());
			}
		}

		// Form fields
		$form = array(
			'username' => '',
			'password' => ''
		);

		// Copy the form as errors so that the errors are stored with
		// keys corresponding to the field names
		$errors = $form;
		$form_error = FALSE;

		if ($_POST)
		{
			// Set up validation rules
			$validation = Validation::factory($_POST)
			    ->pre_filter('trim')
			    ->add_rules('username', 'required')
			    ->add_rules('password', 'required');

			if ($validation->validate())
			{
				// Remember checkbox ticked?
				$remember = ! empty($_POST['remember']);

				// Attempt a login
				if ($this->auth->login($validation->username, $validation->password, $remember))
				{
					// Load the user
					$user = User_Model::get_user_by_username($validation->username);

					// Redirect to dashboard
					url::redirect($user->get_dashboard_url());
				}
				else
				{
					// TODO: Check if this is a new account and confirmation is pending
					
					// Log the authentication error
					Kohana::log('error', "Authentication failed for user ".$validation->username);
					
					$validation->add_error('password', 'login error');

					// Turn on the form error
					$form_error = TRUE;
				}
			}

			// Overwrite the form and errors arrays
			$errors = arr::overwrite($errors, $validation->errors('auth'));
			$form = arr::overwrite($form, $validation->as_array());
		}

		$this->template->errors = $errors;
		$this->template->form = $form;
		$this->template->form_error = $form_error;
	}

	/**
	 * Logs out a user
	 */
	public function logout()
	{
		$this->auth->logout(TRUE);
		url::redirect('login');
	}

	/**
	 * Confirms user registration
	 */
	public function verify()
	{
		$auth = Auth::instance();

		$code = (isset($_GET['c']) AND ! empty($_GET['c'])) ? $_GET['c'] : "";
		$email = (isset($_GET['e']) AND ! empty($_GET['e'])) ? $_GET['e'] : "";

		$user = ORM::factory("user")
			->where("code", $code)
			->where("email", $email)
			->where("confirmed != 1")
			->find();

		if ($user->loaded)
		{
			$user->confirmed = 1;

			// Give the user the appropriate roles if the admin doesn't need to verify accounts
			//   and if they don't already have role assigned.
			if (Kohana::config('settings.manually_approve_users') == 0
				AND ! $user->has(ORM::factory('role', 'login')))
			{
				$user->add(ORM::factory('role', 'login'));
				$user->add(ORM::factory('role', 'member'));
			}

			$user->save();

			// Log all other sessions out so they can log in nicely on the login page
			$auth->logout();

			// Redirect to login
			url::redirect("login?confirmation_success");
		}
		else
		{
			// Redirect to Login which will log themin if they are already logged in
			url::redirect("login");
		}


	}

	/**
	 * Facebook connect function
	 */
	public function facebook()
	{
		$auth = Auth::instance();

		$this->template = "";
		$this->auto_render = FALSE;

		$settings = ORM::factory("settings")->find(1);

		$appid = $settings->facebook_appid;
		$appsecret = $settings->facebook_appsecret;
		$next_url = url::site()."members/login/facebook";
		$cancel_url = url::site()."members/login";

		// Create our Application instance.
		$facebook = new Facebook(array(
			'appId'  => $appid,
			'secret' => $appsecret,
			'cookie' => true
		));

		// Get User ID
		$fb_user = $facebook->getUser();
		if ($fb_user)
		{
			try
			{
		    	// Proceed knowing you have a logged in user who's authenticated.
				$new_openid = $facebook->api('/me');

				// Does User Exist?
				$openid_user = ORM::factory("openid")
					->where("openid", "facebook_".$new_openid["id"])
					->find();

				if ($openid_user->loaded AND $openid_user->user)
				{
					// First log all other sessions out
					$auth->logout();

					// Initiate Ushahidi side login + AutoLogin
					$auth->force_login($openid_user->user->username);

					// Exists Redirect to Dashboard
					url::redirect($auth->get_user()->dashboard());
				}
				else
				{
					// Does this login have the required email??
					if ( ! isset($new_openid["email"]) OR empty($new_openid["email"]))
					{
						$openid_error = "User has not been logged in. No Email Address Found.";

						// Redirect back to login
						url::redirect("login");
					}
					else
					{
						// Create new User and save OpenID
						$user = ORM::factory("user");

						// But first... does this email address already exist
						// in the system?
						if ($user->email_exists($new_openid["email"]))
						{
							$openid_error = $new_openid["email"] . " is already registered in our system.";

							// Redirect back to login
							url::redirect("login");
						}
						else
						{
							$username = "user".time(); // Random User Name from TimeStamp - can be changed later
							$password = text::random("alnum", 16); // Create Random Strong Password

							// Name Available?
							$user->name = (isset($new_openid["name"]) AND ! empty($new_openid["name"]))
								? $new_openid["name"]
								: $username;
							$user->username = $username;
							$user->password = $password;
							$user->email = $new_openid["email"];

							// Add New Roles
							$user->add(ORM::factory('role', 'login'));
							$user->add(ORM::factory('role', 'member'));

							$user->save();

							// Save OpenID and Association
							$openid_user->user_id = $user->id;
							$openid_user->openid = "facebook_".$new_openid["id"];
							$openid_user->openid_email = $new_openid["email"];
							$openid_user->openid_server = "http://www.facebook.com";
							$openid_user->openid_date = date("Y-m-d H:i:s");
							$openid_user->save();

							// Initiate Ushahidi side login + AutoLogin
							$auth->login($username, $password, TRUE);

							// Redirect to Dashboard
							url::redirect($auth->get_user()->dashboard());
						}
					}
				}
			}
			catch (FacebookApiException $e)
			{
				error_log($e);
				$user = null;
			}
		}
		else
		{
			$login_url = $facebook->getLoginUrl(
				array(
					'canvas' => 1,
					'fbconnect' => 0,
					'scope' => "email,publish_stream",
					'next' => $next_url,
					'cancel' => $cancel_url
				)
			);

			url::redirect($login_url);
		}
	}

    /**
     * Create New password upon user request.
     */
    private function _new_password($user_id = 0, $password, $token)
    {
    	$auth = Auth::instance();
		$user = ORM::factory('user',$user_id);
		if ($user->loaded == true)
		{
			// Determine Method (RiverID or standard)

			if (kohana::config('riverid.enable') == TRUE AND ! empty($user->riverid))
			{
				// Use RiverID

				// We don't really have to save the password locally but if a deployer
				//   ever wants to switch back locally, it's nice to have the pw there
				$user->password = $password;
				$user->save();

				// Relay the password change back to the RiverID server
				$riverid = new RiverID;
				$riverid->email = $user->email;
				$riverid->token = $token;
				$riverid->new_password = $password;
				if ($riverid->setpassword() == FALSE)
				{
					// TODO: Something went wrong. Tell the user.
				}

			}
			else
			{
				// Use Standard

				if($auth->hash_password($user->email.$user->last_login, $auth->find_salt($token)) == $token)
				{
					$user->password = $password;
					$user->save();
				}
				else
				{
					// TODO: Something went wrong, tell the user.
				}
			}

			return TRUE;
		}

		// TODO: User doesn't exist, tell the user (meta, I know).

		return FALSE;
	}

	/**
	 * Sends an email confirmation
	 */
	private function _send_email_confirmation($user)
	{
		$settings = Kohana::config('settings');

		// Check if we require users to go through this process
		if ($settings['require_email_confirmation'] == 0)
		{
			return FALSE;
		}

		$email = $user->email;
		$code = text::random('alnum', 20);
		$user->code = $code;
		$user->save();

		$url = url::site()."login/verify/?c=$code&e=$email";

		$to = $email;
		$from = array($settings['site_email'], $settings['site_name']);
		$subject = $settings['site_name'].' '.Kohana::lang('ui_main.login_signup_confirmation_subject');
		$message = Kohana::lang('ui_main.login_signup_confirmation_message',
			array($settings['site_name'], $url));

		email::send($to, $from, $subject, $message, FALSE);

		return TRUE;
	}

}
