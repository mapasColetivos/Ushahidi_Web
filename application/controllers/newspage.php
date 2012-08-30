<?php defined('SYSPATH') or die('No direct script access.');

class Newspage_Controller extends Main_Controller {

	function is_ajax(){
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
	}
	
	function __construct()
	{
		parent::__construct();
		$this->user = Session::instance()->get('auth_user',FALSE);
	}

	public function index(){
    $this->template->content = new View('newspage');
    $this->template->content->url = $_GET["target"];
		$this->template->header->header_block = $this->themes->header_block();	  
	}
}