<?php defined('SYSPATH') OR die('No direct script access');

/**
 * Hook for the mapascoletivos theme
 *
 * This hook performs registers custom JS extensions that are
 * necessary for delivery the customizations on mapascoletivos.com.br
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - https://github.com/ushahidi/Ushahidi_Web
 * @subpackage Hooks
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class mapascoletivos {
	
	public function __construct()
	{
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}

	/**
	 * Registers callback functions for the events to be run
	 * soon after hooking into routing
	 */
	public function add()
	{
		// Modfiy the header scripts
		Event::add('ushahidi_action.header_scripts', array($this, 'extend_ushahidi_js'));
	}

	/**
	 * Loads the extensions to ushahidi.js
	 */
	public function extend_ushahidi_js()
	{
		$js = View::factory('js/mapascoletivos');
		$js->render(TRUE);
	}
}

// Run the hook
new mapascoletivos;