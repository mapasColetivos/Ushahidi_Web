<?php defined('SYSPATH') or die('No direct script access.');


class Static_Controller extends Main_Controller {

	function is_ajax(){
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
	}
	
	function __construct()
	{
		parent::__construct();
		$this->user = Session::instance()->get('auth_user',FALSE);
	}

	public function about(){
		$this->template->content = new View('static/about');
		$this->template->header->header_block = $this->themes->header_block();		
        $this->template->header->this_page = 'about';		
	}
	
	public function narratives(){
		$this->template->content = new View('static/narratives');
		$this->template->header->header_block = $this->themes->header_block();		
        $this->template->header->this_page = 'narratives';				
	}
	
	public function visualizations(){
		$this->template->content = new View('static/visualizations');
		$this->template->header->header_block = $this->themes->header_block();		
        $this->template->header->this_page = 'visualizations';						
	}
	
	public function apps(){
		$this->template->content = new View('static/apps');
		$this->template->header->header_block = $this->themes->header_block();		
	}
	
	public function sms(){
		$this->template->content = new View('static/sms');
		$this->template->header->header_block = $this->themes->header_block();		
	}
	
	public function privacy(){
		$this->template->content = new View('static/privacy');
		$this->template->header->header_block = $this->themes->header_block();		
	}

	public function usage(){
		$this->template->content = new View('static/usage');
		$this->template->header->header_block = $this->themes->header_block();		
	}
	
	public function blogs(){
		$this->template->content = new View('static/blogs');
		$this->template->header->header_block = $this->themes->header_block();		
	}	
	
	public function kml(){
		$this->template->content = new View('static/kml');
		$this->template->header->header_block = $this->themes->header_block();		
	}
}