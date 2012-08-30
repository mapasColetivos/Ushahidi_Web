ALTER TABLE tags DROP incident_id;

CREATE TABLE IF NOT EXISTS `incidents_tags` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `incident_id` INT NOT NULL DEFAULT '0',
  `tag_id` INT NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
);