<?php

/**
* Model for the tags table
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     mapasColetivos Team <http://www.mapacoletivos.com.br> 
 * @package    mapascoletivos - http://github.com/mapasColetivos/Ushahidi_Web
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 * $Id: $
 */
class Tag_Model extends ORM {

	/**
	 * One-to-many relationship definition
	 * @var array
	 */
	protected $has_many = array('incident_tags');

	/**
	 * Table name
	 * @var string
	 */
	protected $table_name = 'tags';
	
	public function add_tags_at_incident($tags,$incident_id)
	{
		ORM::factory("incidents_tags")->where("incident_id",$incident_id)->delete_all();
		foreach ($tags as $tag)
		{
			$tag_id = $this->add_tag($tag);
			$this->bind_tag_incident($tag_id,$incident_id);
		}
	}
	
	private function add_tag($tag)
	{
		$tag_model = ORM::factory("tag")->where("value",$tag)->find();
		if ($tag_model->id <= 0)
		{
			$tag_model->value = $tag;
			$tag_model->save();
		}
		return $tag_model->id;
	}
	
	private function bind_tag_incident($tag_id,$incident_id)
	{
		$it_model = ORM::factory("incidents_tags")->where("tag_id",$tag_id)->where("incident_id",$incident_id)->find();
		if ($it_model->id <= 0)
		{
			$it_model->incident_id = $incident_id;
			$it_model->tag_id = $tag_id;			
			$it_model->save();
		}
	}
}
