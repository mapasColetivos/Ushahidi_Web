<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for the incident_tags table
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    mapascoletivos - http://github.com/mapasColetivos/Ushahidi_Web
 * @subpackage Models
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Incident_Tag_Model extends ORM {

	/**
	 * Belongs-to relationship definition
	 * @var array
	 */
	protected $belongs_to = array('incident', 'tag');

	/**
	 * Database table name
	 * @var string
	 */
	protected $table_name = 'incident_tags';
}
