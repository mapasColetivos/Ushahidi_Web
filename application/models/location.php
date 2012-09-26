<?php defined('SYSPATH') or die('No direct script access.');

/**
* Model for Locations
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @subpackage Models
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Location_Model extends ORM {
	/**
	 * One-to-many relationship definition
	 * @var array
	 */
	protected $has_many = array(
		'media',
		'incident_person',
		'feed_item',
		'reporter',
		'checkin',
	);
	
	/**
	 * Belongs-to relatioship definition
	 * @var array
	 */
	protected $belongs_to = array('incident', 'user');

	/**
	 * Many-to-one relationship definition
	 * @var array
	 */
	protected $has_one = array('country');
	
	/**
	 * Database table name
	 * @var string
	 */
	protected $table_name = 'location';
	
	/**
	 * Checks if a location id exists in the database
	 * @param int $location_id Database ID of the the location
	 * @return bool
	 */
	public static function is_valid_location($location_id)
	{
		return (intval($location_id) > 0)
			? ORM::factory('location', intval($location_id))->loaded
			: FALSE;
	}

	/**
	 * Gets an array of all the media for the current location
	 * @return array
	 */
	public function get_media_array()
	{
		// Main media types
		$media = array(
		    'photo' => array(),
		    'video' => array(),
		    'news' => array()
		);

		// Mapping of the media type values to the indices of the return structure
		$map = array(
		    1 => 'photo',
		    2 => 'video',
		    4 => 'news'
		);

		// Get the media
		foreach ($this->media as $entry)
		{
			if ($entry->loaded)
			{
				$media_type = $map[$entry->media_type];
				$media[$media_type][] = array(
				    "id" => $entry->id,
				    "location_id" => $entry->location_id,
				    "media_type" => $media_type,
				    "media_link" => trim($entry->media_link),
				    "media_thumb" => $entry->media_thumb
				);
			}
		}

		return $media;
	}

	/**
	 * Returns the location as a GeoJSON feature
	 * @return array
	 */
	public function as_geojson_feature()
	{
		$image_thumb = $this->incident->category[0]->category_image_thumb;
		$thumb = ( ! empty($image_thumb)) ? url::file_loc("img").'media/uploads/'.$image_thumb : "";

		$image_icon = $this->incident->category[0]->category_image;
		$icon = ( ! empty($image_icon)) ? url::file_loc("img").'media/uploads/'.$image_icon : "";

		return array(
		    "type" => "Feature",
		    "properties" => array(
		        "id" => $this->id,
		        "name" => $this->location_name,
		        "link" => url::site("location/show/".$this->id),
		        "color" => "",
		        "thumb" => $thumb,
		        "icon" => $icon,
		    ),
		    "geometry" => array(
		        "type" => "Point",
		        "coordinates" => array($this->longitude, $this->latitude)
		    )
		);
	}
}
