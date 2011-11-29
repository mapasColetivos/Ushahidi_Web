CREATE TABLE IF NOT EXISTS `tags` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `value` varchar(50) NOT NULL,
    `incident_id` INT NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
);