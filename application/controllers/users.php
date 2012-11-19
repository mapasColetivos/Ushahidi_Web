<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Users Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     mapasColetivos Team <http://www.mapascoletivos.com.br>
 * @package    Ushahidi - http://github.com/mapasColetivos/Ushahidi_Web
 * @subpackage Controllers
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
class Users_Controller extends Main_Controller {

	/**
	 * Loads the user's profile page
	 */
	public function index($user_id = FALSE)
	{
		// Load the user and validate
		$visited_user = User_Model::get_user_by_id($user_id);
		if ( ! $visited_user)
		{
			url::redirect('main');
		}

		$this->template->content = View::factory('users/layout')
			->set('visited_user', $visited_user)
			->set('visiting_user', $this->user)
			->set('users_following', $visited_user->get_following())
			->set('incidents', $visited_user->get_visible_incidents($this->user))
			->set('incidents_following', $visited_user->get_incidents_following())
			->set('incidents_collaborated_on', $visited_user->get_incidents_collaborated_on())
			->bind('map_filters', $map_filters);

		// Map filters view
		$map_filters = View::factory('map/filters')
			->set('incident_layers', $visited_user->get_layers())
			->set('incident_legends', $visited_user->get_legends_array());

		// Javascript Header
		$this->themes->map_enabled = TRUE;

		$this->themes->js = View::factory('reports/view_js')
			->set('markers_url', sprintf("json/locations?uid=%d", $visited_user->id))
			->set('layer_name', $visited_user->username."'s Pontos")
			->set('map_zoom', NULL)
			->set('latitude', Kohana::config('settings.default_lat'))
			->set('longitude', Kohana::config('settings.default_lon'));

		$this->template->header->header_block = $this->themes->header_block();
	}

	/**
	 * Displays a page for editing a user's profile
	 */
	public function profile()
	{
		// Check if a user currently logged in
		if (empty($this->user))
		{
			url::redirect('main');
		}

		$this->template->content = View::factory('users/profile')
			->set('user', $this->user)
			->bind('errors', $errors)
			->bind('form', $form)
			->bind('form_error', $form_error)
			->bind('form_saved', $form_saved);

		// setup and initialize form field names
		$form = array(
		    'username' => $this->user->username,
		    'password' => '',
		    'password_again'  => '',
		    'name' => $this->user->name,
		    'email' => $this->user->email,
		    'localization' => $this->user->localization,
		    'web' => $this->user->web,
		    'bio' => $this->user->bio,
		);

		// Copy the form as errors, so the errors will be stored with keys
		// corresponding to the form field names
		$errors = $form;
		$form_error = FALSE;
		$form_saved = FALSE;
		$form_action = "";
		$user = "";

		// Forn submission
		if ($_POST)
		{
			// Get the submitted data
			$post = array(
			    'user_id' => $this->user->id,
			    'username' => $this->input->post('username'),
			    'email' => $this->input->post('email'),
			    'name' => $this->input->post('name'),
			    'password' => $this->input->post('password'),
			    'password_again' => $this->input->post('password_again'),
			    'localaization' => $this->input->post('localaization'),
			    'web' => $this->input->post('web'),
			    'bio' => $this->input->post('bio')
			);

			// Validate
			if (User_Model::custom_validate($post))
			{
				// Set the user properties
				foreach ($post->safe_array() as $field => $value)
				{
					if ($field != 'user_id')
					{
						$this->user->$field = $value;
					}
				}

				$this->user->save();

				// Redirect
				url::redirect("users/index/".$this->user->id);
			}
			else
			{
				// repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

				// populate the error fields, if any
				$errors = arr::overwrite($errors, $post->errors('auth'));
				$form_error = TRUE;
			}
		}

		$this->template->header->header_block = $this->themes->header_block();
	}

	/**
	 * Displays the user signup form
	 */
	public function signup()
	{
		$this->template->content = new View('users/signup');

		// Setup and initialize form field names
		$form = array(
		    'email' => '',
		    'security_code' => ''
		);

		$errors = $form;
		$form_error = FALSE;
		$form_saved = FALSE;

		if ($_POST)
		{
			// Set up validation
			$validation = Validation::factory($_POST)
			    ->pre_filter('trim')
			    ->add_rules('email', 'required', 'email')
			    ->add_rules('security_code', 'required', 'Captcha::valid')
			    ->add_callbacks('email', array('User_Model', 'unique_value_exists'));

			if ($validation->validate())
			{
				// Create the entry and user token
				if (($token_orm = Auth_Tokens_Model::create_token('new_registration', $validation->email)) != FALSE)
				{
					// Generate the confirmation url
					$confirm_url = url::site().'users/confirm_signup?email=%s&token=%s';
					$confirm_url = sprintf($confirm_url, urlencode($validation->email), $token_orm->token);

					// Email message to be sent
					$message = array();
					$message[] ='Thank you joining %s!';
					$message[] = 'Click on the link below to complete the registration and activate your account.';
					$message[] = '%s';
					$message = implode("\r\n", $message);

					$message = sprintf($message, Kohana::config('settings.site_name'), $confirm_url);

					// Sender and subject
					$sender = array(Kohana::config('settings.site_email'), Kohana::config('settings.site_name'));
					$subject = Kohana::config('settings.site_name').' '.Kohana::lang('ui_main.login_signup_confirmation_subject');

					// Send the email
					email::send($validation->email, $sender, $subject, $message, FALSE);

					$this->template->content = View::factory('users/register_success');
				}
				else
				{
					// Turn on the form error
					$form_error = TRUE;
				}
			}
			else
			{
				$form_error = TRUE;
				$form = arr::overwrite($form, $validation->as_array());
				$errors = arr::overwrite($errors, $validation->errors('auth'));
			}
		}

		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
		$this->template->content->captcha = Captcha::factory();
		$this->template->header->header_block = $this->themes->header_block();
	}

	/**
	 * REST endpoint for user follow/unfollow requests
	 */
	public function social()
	{
		$this->template = "";
		$this->auto_render = FALSE;

		if ($_POST)
		{
			// Set up validation
			$validation = Validation::factory($_POST)
			    ->add_rules('user_id', 'required')
			    ->add_rules('action', 'required');

			if ($validation->validate())
			{
				if ($validation->action == 'follow')
				{
					$this->user->follow_user($validation->user_id);
				}
				elseif ($validation->action == 'unfollow')
				{
					$this->user->unfollow_user($validation->user_id);
				}
			}
		}
	}

	/**
	 * Signup confirmation page
	 */
	public function confirm_signup()
	{
		$this->template->content = View::factory('users/create_user');

		// Fetch the query parameters from the $_GET request
		$email = $this->input->get('email', NULL);
		$token = $this->input->get('token', NULL);

		// Check if the email exists
		if ( ! empty($email) AND User_Model::get_user_by_email('email', $email)->loaded)
		{
			// Specified email address has already been registered to another user
			$this->template->content =  View::factory('users/messages');
			$this->template->content->message = "The email address you have specified is unavailable for use.";
			return;
		}

		$token_orm = FALSE;
		// Verify the token
		if ( ! empty($email) AND ! empty($token))
		{
			if (($token_orm = Auth_Tokens_Model::get_token('new_registration', $token)) == FALSE)
			{
				// Token has expired or is invalid
				$this->template->content = View::factory('users/messages');
				$this->template->content->message = "Your account creation token is invalid or has expired.";
				return;
			}
		}

		// Form fields
		$form = array(
		    'username' => '',
		    'email' => $email,
		    'name' => '',
		    'password' => '',
		    'password_again' => ''
		);

		$errors = $form;
		$form_error = FALSE;
		$form_saved = FALSE;

		// Form submission
		if ($_POST)
		{
			$validation = Validation::factory($_POST)
			    ->pre_filter('trim')
			    ->add_rules('name', 'required', 'length[3,200]')
			    ->add_rules('username', 'required')
			    ->add_rules('password', 'required', 'length['.Kohana::config('auth.password_length').']', 'matches[password_again]')
			    ->add_callbacks('username', array('User_Model', 'unique_value_exists'));

			if ($validation->validate())
			{
				// Create the user account
				User_Model::create_user($validation->username, $validation->name, $validation->email, $validation->password);

				// Delete the token
				$token_orm->delete();

				$form_saved = TRUE;
			}
			else
			{
				$form = arr::overwrite($form, $validation->as_array());
				$errors = arr::overwrite($errors, $validation->errors('auth'));
				$form_error = TRUE;
			}
		}

		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
		$this->template->content->form = $form;
		$this->template->header->header_block = $this->themes->header_block();
	}

}