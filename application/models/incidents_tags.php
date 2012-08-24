<?php defined('SYSPATH') or die('No direct script access.');

class Incidents_Tags_Model extends ORM
{
	/**
	 * Belongs-to relationship definition
	 * @var array
	 */
	protected $belongs_to = array('incident');

	protected $table_name = 'incidents_tags';
}
