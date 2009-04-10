ALTER TABLE stories ADD COLUMN related text;
ALTER TABLE stories ADD COLUMN featured tinyint unsigned NOT NULL default 0;

ALTER TABLE users MODIFY passwd char(32);
UPDATE users SET passwd = '5f4dcc3b5aa765d61d8327deb882cf99'; 

ALTER TABLE comments CHANGE subject title varchar(128);
ALTER TABLE comments MODIFY pid int unsigned NOT NULL default 0;
