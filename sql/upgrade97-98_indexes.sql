ALTER TABLE `location` ADD INDEX `idx_incident_legened_id` (`incident_legend_id`);
ALTER TABLE `location` ADD INDEX `idx_latitude` (`latitude`);
ALTER TABLE `location` ADD INDEX `idx_longitude` (`longitude`);
ALTER TABLE `location` ADD INDEX `idx_incident_id` (`incident_id`);
ALTER TABLE `location` ADD INDEX `idx_user_id` (`user_id`);

ALTER TABLE `location_layer` ADD INDEX `idx_incident_id` (`incident_id`);
ALTER TABLE `location_layer` ADD INDEX `idx_user_id` (`user_id`);

ALTER TABLE `layer` ADD INDEX `idx_user_id` (`user_id`);
ALTER TABLE `media` ADD INDEX `idx_user_id` (`user_id`);
