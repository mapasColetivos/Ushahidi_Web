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

		$this->template->content = new View('users/layout');
		$this->template->content->visited_user = $visited_user;	
		$this->template->content->visiting_user = $this->user;
        $this->template->content->users_following = $visited_user->get_following();
		
		// Javascript Header
		$this->themes->map_enabled = TRUE;

        $this->themes->js = new View('reports/view_js');
        $this->themes->js->markers_url = sprintf("json/user_locations/%d", $visited_user->id);
        $this->themes->js->layer_name = $visited_user->username;
        $this->themes->js->map_zoom = NULL;
        $this->themes->js->latitude = Kohana::config('settings.default_lat');
        $this->themes->js->longitude = Kohana::config('settings.default_lon');

        $this->template->header->header_block = $this->themes->header_block();

	}
	
    /**
     * Displays a page for editing a user's profile
     */
	public function profile()
    {
        $this->template->content = new View('users/profile');
        
        if ($user_id)
        {
            $user_exists = ORM::factory('user')->find($user_id);
            if ( ! $user_exists->loaded)
            {
                // Redirect
                url::redirect(url::site().'admin/users/');
            }
        }
        
        
        // setup and initialize form field names
        $form = array
        (
            'username'  => '',
            'password'  => '',
            'password_again'  => '',
            'name'      => '',
            'email'     => '',
            'localization' => '',
            'web' => '',
            'bio' => '',
        );
        
        //copy the form as errors, so the errors will be stored with keys corresponding to the form field names
        $errors = $form;
        $form_error = FALSE;
        $form_saved = FALSE;
        $form_action = "";
        $user = "";
        
        // check, has the form been submitted, if so, setup validation
        if ($_POST)
        {
            $post = Validation::factory($_POST);

            //  Add some filters
            $post->pre_filter('trim', TRUE);
    
            $post->add_rules('username','required');
        
            //only validate password as required when user_id has value.
            $user_id == '' ? $post->add_rules('password','required',
                'length[5,16]','alpha_numeric'):'';
            $post->add_rules('name','required','length[3,100]');
        
            $post->add_rules('email','required','email','length[4,64]');
        
            $user_id == '' ? $post->add_callbacks('username',
                array($this,'username_exists_chk')) : '';
        
            $user_id == '' ? $post->add_callbacks('email',
                array($this,'email_exists_chk')) : '';

            // If Password field is not blank
            if (!empty($post->password))
            {
                $post->add_rules('password','required','length[5,16]'
                    ,'alpha_numeric','matches[password_again]');
            }
            
            if ($post->validate())
            {
                $user = ORM::factory('user',$user_id);
                $user->name = $post->name;
                $user->email = $post->email;
                $user->notify = true;
                $user->web = $post->web;
                $user->bio = $post->bio;
                $user->localization = $post->localization;
                                
                // Existing User??
                if ($user->loaded==true)
                {
                    // Prevent modification of the main admin account username or role
                    if ($user->id != 1)
                    {
                        $user->username = $post->username;
                        
                        // Remove Old Roles
                        foreach($user->roles as $role)
                        {
                            $user->remove($role); 
                        }
                        
                        // Add New Roles
                        $user->add(ORM::factory('role', 'login'));
                    }
                    
                    $post->password !='' ? $user->password=$post->password : '';
                }
                // New User
                else 
                {
                    $user->username = $post->username;
                    $user->password = $post->password;
                    
                    // Add New Roles
                    $user->add(ORM::factory('role', 'login'));
                }
                $user->save();
                
                // Redirect
                url::redirect(url::site()."index.php/users/index/".$user->id);
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
        else
        {
            if ( $user_id )
            {
                // Retrieve Current Incident
                $user = ORM::factory('user', $user_id);
                if ($user->loaded == true)
                {
                    foreach ($user->roles as $user_role)
                    {
                         $role = $user_role->name;
                    }
                    
                    $form = array
                    (
                        'user_id'   => $user->id,
                        'username'  => $user->username,
                        'password'  => '',
                        'password_again'  => '',
                        'name'      => $user->name,
                        'email'     => $user->email,
                        'notify'    => $user->notify,
                        'role'      => $role,
			            'localization' => $user->web,
            			'web' => $user->localization,
			            'bio' => $user->bio, 
                    );
                }
            }
        }
		
		$this->template->content->user = $user;
        $this->template->content->form = $form;
        $this->template->content->errors = $errors;
        $this->template->content->form_error = $form_error;
        $this->template->content->form_saved = $form_saved;
        $this->template->header->header_block = $this->themes->header_block();	
	}
	

    /**
     * Displays the user signup form
     */	
    public function signup()
    {   
        $this->template->content = new View('users/signup');
        
        // setup and initialize form field names
        $form = array(
            'username'  => '',
            'password'  => '',
            'name'      => '',
            'email'     => '' 	
        );
        
        $errors = $form;
        $form_error = FALSE;
        $form_saved = FALSE;

        if ($_POST)
        {
            // Set up validation
            $validation = Validation::factory($_POST)
                ->pre_filter('trim')
                ->add_rules('username', 'required')
                ->add_rules('email', 'required', 'email')
                ->add_rules('password', 'required', 'length['.Kohana::config('auth.password_length').']')
                ->add_callbacks('email', 'User_Model::unique_value_exists');
        }
        
		
        $this->template->content->form = $form;
        $this->template->content->errors = $errors;
        $this->template->content->form_error = $form_error;
        $this->template->content->form_saved = $form_saved;
        $this->template->header->header_block = $this->themes->header_block();
    }

}