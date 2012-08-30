<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Front-End Nav helper class.
 *
 * @package    Nav
 * @author     Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */
class nav_Core {
	
	/**
	 * Generate Main Tabs
     * @param string $this_page
     * @param array $dontshow
	 * @return string $menu
     */
	public static function main_tabs($this_page = FALSE, $dontshow = FALSE)
	{
		$user = Session::instance()->get('auth_user', FALSE);

		// Reports List
		$menu = "<ul id='home_link'><li><a href=\"".url::site()."static/about\"";
		$menu .= ($this_page == "about") ? " id=\"active\"" : "";
		$menu .= ">".Kohana::lang('ui_main.about')."</a></li>";

		$menu .= "<li><a href=\"".url::site()."help\" ";
		$menu .= ($this_page == "help") ? " id=\"active\"" : "";
		// $menu .= ">".Kohana::lang('ui_main.help')."</a></li></ul>";
		$menu .= ">como colaborar</a></li></ul>"; 

		$menu .= "<ul id='galery'><li><a class='first' href=\"".url::site()."reports\" ";
		$menu .= ($this_page == 'reports') ? " id=\"active\"" : "";
		$menu .= ">".Kohana::lang('ui_main.reports')."</a></li>";	

		$menu .= "<li >|</li><li><a href='".url::site()."static/narratives' ";
		$menu .= ($this_page == 'narratives') ? " id=\"active\"" : "";
		$menu .= ">narrativas</a></li>";	

		$menu .= "<li>|</li><li><a href='".url::site()."static/visualizations' ";
		$menu .= ($this_page == 'visualizations') ? " id=\"active\"" : "";
		$menu .= ">visualizações</a></li></ul>";	

		$menu .= "<ul id='login'>";
		$menu .= "<li><a href=\"".url::site()."reports/submit\">Criar Novo Mapa</a></li>";

		// Login
		if ( ! $user)
		{
			$menu .= "<li><a class='first' href=\"".url::site()."users/signup\" ";
			$menu .= ">".Kohana::lang('ui_main.signup')."</a></li>";

			$menu .= "<li>|</li><li><a href=\"".url::site()."login\" ";
			$menu .= ">".Kohana::lang('ui_main.login')."</a></li></ul>";
		}
		else 
		{	 		
			$menu .= "<li><a href='".url::site()."users/index/".$user->id."' class='active_user first'>".$user->username."</a></li>";
			$menu .= "<li><a class='first' href=\"".url::site()."logout\" ";
			$menu .= ">".Kohana::lang('ui_main.logout')."</a></li></ul>";	 		
		}

		echo $menu;
		Event::run('ushahidi_action.nav_main_top', $this_page);
	}
	
	
}
