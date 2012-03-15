<?php defined('SYSPATH') or die('No direct script access.');

class Users_Controller extends Main_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index($user_id = false){
		$user = ORM::factory('user')->find($user_id);
		$this->template->content = new View('users_dashboard');
		$this->template->content->user = $user;		
		$this->template->content->myself = $this->user;
		
		// Javascript Header
		$this->themes->map_enabled = TRUE;
		$this->themes->js = new View('dashboard_js');
		$this->themes->js->map_div_name = "user_map";		
		$this->themes->js->default_map = Kohana::config('settings.default_map');
		
		$this->themes->js->latitude = Kohana::config('settings.default_lat');
		$this->themes->js->longitude = Kohana::config('settings.default_lon');
		$this->themes->js->zoom = 9;
		$this->themes->js->color_with_category = true;
		$this->themes->js->hide_layers = true;		
		
// 		$this->themes->js->markers = ORM::factory('location')->where("owner_id",$user_id)->find_all();
		$m=array();
		$pontos = ORM::factory('location')->where("owner_id",$user_id)->find_all();
		$ii=0;
		foreach($pontos as $ponto) {
		    $mapas = ORM::factory('incident')->where('id',$ponto->incident_id)->find();
		    if ($mapas->incident_title){
			$m[$ii] =  $ponto;
			$ii+=1;
		     }	
		}
		$this->themes->js->markers = $m;

		$this->template->header->fb_title = $user->name;
		$this->template->header->fb_description = $user->bio;
		$this->template->header->fb_image =  url::base().'media/img/user_no_photo.png';
		
		$this->template->content->layers = ORM::factory('layer')->where("owner_id",$user->id)->find_all();
		$this->template->content->user_categories = $user->categories();		
		$this->themes->js->layers = $this->template->content->layers;

		$this->template->header->header_block = $this->themes->header_block();
		
		$parent_categories = array();
		foreach (ORM::factory('category')
				->where('category_visible', '1')
				->where('parent_id', '0')
				->find_all() as $category)
		{
			$children = array();
			$display_title = $category->category_title;

			// Put it all together
			$parent_categories[$category->id] = array(
				$display_title,
				$category->category_color,
				$category->category_image,
				$children
			);
		}
		$this->template->content->categories = $parent_categories;
	}
	
	function profile($user_id = false, $saved = false){
        $this->template->content = new View('users_profile');
        
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
	
	
    function signup( $user_id = false, $saved = false )
    {   
        $this->template->content = new View('users_edit');
        
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
            'email'     => '' 	
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
    
            $post->add_rules('username','required','length[3,16]', 'alpha');
        
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
                url::redirect(url::site());
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
                        'role'      => $role
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

    public function username_exists_chk(Validation $post)
    {
        $users = ORM::factory('user');
        // If add->rules validation found any errors, get me out of here!
        if (array_key_exists('username', $post->errors()))
            return;
                
        if ($users->username_exists($post->username))
            $post->add_error( 'username', 'exists');
    }
    
    public function email_exists_chk( Validation $post )
    {
        $users = ORM::factory('user');
        if (array_key_exists('email',$post->errors()))
            return;
            
        if ($users->email_exists( $post->email ) )
            $post->add_error('email','exists');
    }        	
}