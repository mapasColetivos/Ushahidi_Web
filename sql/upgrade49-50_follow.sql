CREATE TABLE IF NOT EXISTS `users_users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `follower_id` INT NOT NULL DEFAULT '0',
  `followee_id` INT NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `maps_users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` INT NOT NULL DEFAULT '0',
  `map_id` INT NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
);