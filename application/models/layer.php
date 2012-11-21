<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for Layers
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://github.com/ushahidi/Ushahidi_Web
 * @subpackage Models
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Layer_Model extends ORM {

	/**
	 * belongs-to relationship definition
	 * @var array
	 */
	protected $belongs_to = array("user");

	/**
	 * One-to-many relationship definition
	 * @var array
	 */
	protected $has_many = array('incident_kml');

	/**
	 * Database table name
	 * @var string
	 */
	protected $table_name = 'layer';
	
	/** 
	 * Validates and optionally saves a new layer record from an array
	 * 
	 * @param array $array Values to check
	 * @param bool $save Saves the record when validation succeeds
	 * @return bool
	 */
	public function validate(array & $array, $save = FALSE)
	{
		// Set up validation
		$array = Validation::factory($array)
				->pre_filter('trim')
				->add_rules('layer_name','required', 'length[3,80]')
				->add_rules('layer_color','required', 'length[6,6]');
		
		// Add callbacks for the layer url and layer file
		$array->add_callbacks('layer_url', array($this, 'layer_url_file_check'));
		$array->add_callbacks('layer_file', array($this, 'layer_url_file_check'));
		
		// Pass validation to parent and return
		return parent::validate($array, $save);
	}
	
	/**
	 * Performs validation checks on the layer url and layer file - Checks that at least
	 * one of them has been specified using the applicable validation rules
	 *
	 * @param Validation $array Validation object containing the field names to be checked
	 */
	public function layer_url_file_check(Validation $array)
	{
		// Ensure at least a layer URL or layer file has been specified
		if (empty($array->layer_url) AND empty($array->layer_file) AND empty($array->layer_file_old))
		{
			$array->add_error('layer_url', 'atleast');
		}
		
		// Add validation rule for the layer URL if specified
		if ( ! empty($array->layer_url) AND (empty($array->layer_file) OR empty($array->layer_file_old)))
		{
			$array->add_rules('layer_url', 'url');
		}
		
		// Check if both the layer URL and the layer file have been specified
		if ( ! empty($array->layer_url) AND ( ! empty($array->layer_file_old) OR ! empty($array->layer_file)))
		{
			$array->add_error('layer_url', 'both');
		}
	}
	
	/**
	 * Checks if the specified layer id is a valid integer and exists in the database
	 *
	 * @param int $layer_id 
	 * @return bool
	 */
	public static function is_valid_layer($layer_id)
	{
		return ORM::factory('layer', intval($layer_id))->loaded;
	}

	/**
	 * Override the default delete behaviour
	 * If the entry has an upload, the file is purged from the file system
	 *
	 * @return  mixed ORM on success, FALSE otherwise
	 */
	public function delete()
	{
		if ( ! empty($this->layer_file))
		{
			// Generate the absolute file path for the layer file (KML, KMZ)
			$file_path = Kohana::config('upload.directory', TRUE).$this->layer_file;
			if (file_exists($file_path))
			{
				try
				{
					// Purge KML from uploads directory
					unlink($file_path);
				}
				catch (Kohana_Exception $e)
				{
					Kohana::log("error", sprintf("Error deleting file (%s) - %s", $file_path, $e->getMessage()));
					return FALSE;
				}
			}
		}

		return parent::delete();
	}
	
	/**
	 * Gets the list of visible layers
	 * 
	 * @return ORM_Iterator
	 */
	public static function get_visible_layers()
	{
		return ORM::factory('layer')->where('layer_visible', 1)->find_all();
	}
}
