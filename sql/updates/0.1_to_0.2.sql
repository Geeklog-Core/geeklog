ALTER TABLE links MODIFY description text;
ALTER TABLE stories MODIFY sid varchar(20) DEFAULT '' NOT NULL;
ALTER TABLE comments MODIFY sid varchar(20) DEFAULT '' NOT NULL;
ALTER TABLE blocks ADD COLUMN blockorder tinyint unsigned DEFAULT 1 NOT NULL;
UPDATE blocks SET blockorder = 1;
