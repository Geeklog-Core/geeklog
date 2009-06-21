CREATE TABLE frontpagecodes (
  code tinyint(4) DEFAULT '0' NOT NULL,
  name varchar(32),
  PRIMARY KEY (code)
);

CREATE TABLE sessions (
  sess_id int(10) unsigned DEFAULT '0' NOT NULL,
  start_time int(10) unsigned DEFAULT '0' NOT NULL,
  remote_ip varchar(15) DEFAULT '' NOT NULL,
  uid mediumint(8) DEFAULT '1' NOT NULL,
  md5_sess_id varchar(128),
  PRIMARY KEY (sess_id),
  KEY sess_id (sess_id),
  KEY start_time (start_time),
  KEY remote_ip (remote_ip)
);

CREATE TABLE userevent (
  uid mediumint(8) DEFAULT '1' NOT NULL,
  eid varchar(20) DEFAULT '' NOT NULL,
  PRIMARY KEY (uid,eid)
);

ALTER TABLE userindex MODIFY maxstories tinyint(4);
ALTER TABLE stories ADD frontpage tinyint(3) unsigned DEFAULT '0';
ALTER TABLE topics ADD sortnum tinyint(3);
ALTER TABLE topics ADD limitnews tinyint(3);
INSERT INTO frontpagecodes VALUES (0,'Show Only in Topic');
INSERT INTO frontpagecodes VALUES (1,'Show on Front Page');
UPDATE stories SET frontpage = 1;
