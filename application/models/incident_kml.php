<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for the incident_kml table
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
class Incident_Kml_Model extends ORM {

	/**
	 * belongs-to relationship definition
	 * @var array
	 */
	protected $belongs_to = array(
		// Has one user
		'user',

		// Has one incident
		'incident',

		// Belongs to a layer
		'layer'
	);

	/**
	 * Table name
	 * @var string
	 */
	protected $table_name = 'incident_kml';
}
