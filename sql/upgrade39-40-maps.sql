CREATE TABLE IF NOT EXISTS `incident_location` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `incident_id` INT NOT NULL DEFAULT '0',
    `location_id` INT NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
);

#INSERT INTO `incident_location` (`incident_id`,`location_id`)
#SELECT `id`, `location_id`
#FROM `incident`

ALTER TABLE `incident`
  DROP COLUMN location_id