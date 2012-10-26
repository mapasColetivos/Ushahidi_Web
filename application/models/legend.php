<?php defined('SYSPATH') or die('No direct script access');

/**
 * Model for the legend table
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - https://github.com/ushahidi/Ushahidi_Web
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
class Legend_Model extends ORM {

	/**
	 * Database table name 
	 * @var string
	 */
	protected $table_name = 'legend';
	
	/**
	 * One-to-many relationship definition
	 * @var array
	 */
	protected $has_many = array(
		'incident_legend'
	);
	
	/**
	 * Retrieves a legend using its name
	 * 
	 * @param  string $name Name of the legend
	 * @return mixed ORM if exists, FALSE otherwise
	 */
	public static function get_legend($name)
	{
		$legend_orm = ORM::factory('legend')
			->where('legend_name', $name)
				->find();
		
		return $legend_orm->loaded ? $legend_orm : FALSE;
	}
	
}