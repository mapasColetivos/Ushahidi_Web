<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for the location_legend table
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
class Incident_Legend_Model extends ORM {
	
	/**
	 * Database table name 
	 * @var string
	 */
	protected $table_name = 'incident_legend';
	
	/**
	 * Belongs-to relationship definition
	 * @var array
	 */
	protected $belongs_to = array(
		'legend',
		'user',
		'incident'
	);
	
	/**
	 * Overrides the default delete behaviour
	 */
	public function delete()
	{
		// Check the legend for this entry
		$legend = $this->legend;
		
		parent::delete();
		
		// Delete the legend associated with this record if
		// it doesn't have any more children
		if ($legend->incident_legend->count() == 0)
		{			
			$legend->delete();
		}
	}
	
	/**
	 * Helper method to checks if the entry with the specified ID exists
	 *
	 * @param  int $id ID of the incident_legend record in the database
	 * @return bool
	 */
	public static function exists($id)
	{
		return ORM::factory('incident_legend', $id)->loaded;
	}
}