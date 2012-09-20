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

CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(40) NOT NULL DEFAULT '',
  `type` varchar(20) DEFAULT NULL,
  `data` text,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expire_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_tokens_un_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
