-- Drop unnecessary MHI tables
DROP TABLE IF EXISTS `mhi_category`;
DROP TABLE IF EXISTS `mhi_log`;
DROP TABLE IF EXISTS `mhi_log_actions`;
DROP TABLE IF EXISTS `mhi_site`;
DROP TABLE IF EXISTS `mhi_site_category`;
DROP TABLE IF EXISTS `mhi_site_database`;
DROP TABLE IF EXISTS `mhi_users`;

-- Change `owner_id` columns to `user_id` for consistency
UPDATE `incident` SET `user_id` = `owner_id`;
UPDATE `incident` SET `incident_zoom` = `incident_default_zoom`;
ALTER TABLE `incident` DROP COLUMN `owner_id`;

ALTER TABLE `incident_kml` CHANGE `owner_id` `user_id` INT(11);
ALTER TABLE `incident_kml` CHANGE `kml_id` `layer_id` INT(11) NOT NULL;

ALTER TABLE `layer` CHANGE `owner_id` `user_id` INT(11);

ALTER TABLE `location` CHANGE `owner_id` `user_id` INT(11);

ALTER TABLE `location_layer` CHANGE `owner_id` `user_id` INT(11);

ALTER TABLE `media` CHANGE `owner_id` `user_id` INT(11);

-- Rename the `users_users` table to `user_followers`
RENAME TABLE `users_users` TO `user_followers`;
ALTER TABLE `user_followers` CHANGE `followee_id` `user_id` INT(11) NOT NULL AFTER `id`;
ALTER TABLE `user_followers` ADD UNIQUE INDEX `user_followers_unique_idx` (`user_id`, `follower_id`);

-- Change the `map_id` column in TABLE `maps_users` to `incident_id`
ALTER TABLE `maps_users` CHANGE `map_id` `incident_id` INT(11) NOT NULL;

-- Rename the table `maps_users` to `incident_follows`
RENAME TABLE `maps_users` TO `incident_follows`;
ALTER TABLE `incident_follows` ADD UNIQUE INDEX `incident_subscribe_unique_idx` (`user_id`, `incident_id`);

RENAME TABLE `incidents_tags` TO `incident_tags`;

CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(40) NOT NULL DEFAULT '',
  `type` varchar(20) DEFAULT NULL,
  `data` text,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expire_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_tokens_un_token` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ------------------------------------------------
-- Table legend
-- ------------------------------------------------
CREATE TABLE IF NOT EXISTS `legend`(
	`id` INT(11) unsigned NOT NULL AUTO_INCREMENT,
	`legend_name` VARCHAR(50) NOT NULL COMMENT 'Name of the legend',
	PRIMARY KEY(`id`),
	UNIQUE KEY `un_legend_name` (`legend_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ------------------------------------------------
-- Table location_legend
-- ------------------------------------------------
CREATE TABLE IF NOT EXISTS `incident_legend` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`incident_id` int(11) unsigned NOT NULL,
	`legend_id` int(11) unsigned NOT NULL,
	`legend_color` varchar(6) NOT NULL DEFAULT 'FF0000',
	`user_id` int(11) unsigned,
	PRIMARY KEY (`id`),
	UNIQUE KEY `un_location_legend_id` (`incident_id`, `legend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Create the legend names
INSERT INTO `legend` (`legend_name`)
SELECT DISTINCT `layer_name` FROM `location_layer`;

-- Create entries for the location legends
INSERT INTO `incident_legend` (`incident_id`, `legend_id`, `legend_color`, `user_id`)
SELECT `location_layer`.`incident_id`, `legend`.`id`, `location_layer`.`layer_color`, `location_layer`.`user_id`
FROM `location_layer`
INNER JOIN `legend` ON (`location_layer`.`layer_name` = `legend`.`legend_name`)
INNER JOIN `incident` ON (`location_layer`.`incident_id` = `incident`.`id`);

-- Sync the layer_id with incident_legend table
UPDATE `location` AS a JOIN (
	SELECT location.id AS `location_id`, `incident_legend`.`id` AS `incident_legend_id`	
	FROM `incident_legend`
	INNER JOIN `legend` on (`incident_legend`.`legend_id` = `legend`.`id`)
	INNER JOIN `location_layer` on (`location_layer`.`layer_name` = `legend`.`legend_name`)
	INNER JOIN `location` on (location.layer_id = `location_layer`.`id`)
	WHERE `location_layer`.`incident_id` = `incident_legend`.`incident_id`) AS `b`
ON `b`.`location_id` = a.id
SET `a`.`layer_id` = `b`.`incident_legend_id`;

-- Rename the layer_id column to incident_legend_id
ALTER TABLE `location` CHANGE `layer_id` `incident_legend_id` int(11) unsigned;

-- Nullify invalid incident_legend_id values
UPDATE `location` SET `incident_legend_id` = NULL 
WHERE `incident_legend_id` NOT IN (SELECT `id` FROM `incident_legend`);

-- Drop the location_layer table
DROP TABLE IF EXISTS `location_layer`;

-- Set the default theme to mapascoletivos
UPDATE `settings` SET `value` = 'mapascoletivos' WHERE `key` = 'site_style';

-- Set Google Normal as the default map provider
UPDATE `settings` SET `value` = 'google_normal' WHERE `key` = 'default_map';

-- Set the site language to Brazilian Portuguese
UPDATE `settings` SET `value` = 'pt_BR' WHERE `key` = 'site_language';