<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for the user_followers table
 *
 * $Id: user.php 3352 2008-08-18 09:43:56BST atomless $
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     mapasColetivos Team <http://www.mapascoletivos.com.br>
 * @package    Ushahidi - http://github.com/mapasColetivos/Ushahidi_Web
 * @subpackage Models
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class User_Followers_Model extends ORM {

	/**
	 * Database table name
	 * @var string
	 */
	protected $table_name = 'user_followers';
}