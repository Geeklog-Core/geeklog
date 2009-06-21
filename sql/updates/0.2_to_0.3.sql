CREATE TABLE calendar (
  eid varchar(20) DEFAULT '' NOT NULL,
  title varchar(128),
  description text,
  location text,
  datestart date,
  dateend date,
  url varchar(128),
  PRIMARY KEY (eid)
);

ALTER TABLE blocks ADD COLUMN rdfupdated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL;
UPDATE blocks SET rdfupdated = '0000-00-00 00:00:00';
