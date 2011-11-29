ALTER TABLE location ADD incident_id integer not null;
UPDATE location l,incident_location il SET l.incident_id = il.incident_id
WHERE il.location_id = l.id;

DROP TABLE incident_location;