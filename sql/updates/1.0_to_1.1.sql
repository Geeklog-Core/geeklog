ALTER TABLE userinfo MODIFY uid mediumint DEFAULT '-1' NOT NULL;
ALTER TABLE userinfo ADD userspace varchar(255) DEFAULT '' NOT NULL;
ALTER TABLE userinfo ADD tokens tinyint unsigned DEFAULT '0' NOT NULL;
ALTER TABLE userinfo ADD totalcomments mediumint DEFAULT '0' NOT NULL;
ALTER TABLE userinfo ADD lastgranted int unsigned DEFAULT '0' NOT NULL;
ALTER TABLE userprefs DROP emailstories;
ALTER TABLE userprefs MODIFY uid mediumint DEFAULT '-1' NOT NULL;
ALTER TABLE userprefs ADD emailstories tinyint DEFAULT '1' NOT NULL;
ALTER TABLE userprefs ADD noicons tinyint unsigned DEFAULT '0' NOT NULL;
ALTER TABLE userprefs ADD willing tinyint unsigned DEFAULT '1' NOT NULL;
ALTER TABLE userprefs ADD dfid tinyint unsigned DEFAULT '0' NOT NULL;
ALTER TABLE userprefs ADD tzid char(3) DEFAULT 'edt' NOT NULL;
ALTER TABLE users ADD sig varchar(160) DEFAULT '' NOT NULL;
ALTER TABLE users MODIFY passwd char(32) DEFAULT '' NOT NULL;
ALTER TABLE users MODIFY seclev tinyint DEFAULT 0 NOT NULL;
ALTER TABLE users MODIFY username varchar(16) DEFAULT '' NOT NULL;
ALTER TABLE users ADD INDEX LOGIN (uid,passwd,username);
ALTER TABLE stories ADD commentcode tinyint DEFAULT '0' NOT NULL;
ALTER TABLE stories ADD statuscode tinyint DEFAULT '0' NOT NULL;
ALTER TABLE stories ADD postmode char(10) DEFAULT 'html' NOT NULL;
ALTER TABLE storysubmission ADD postmode char(10) DEFAULT 'html' NOT NULL;
ALTER TABLE pollquestions ADD commentcode tinyint DEFAULT '0' NOT NULL;
ALTER TABLE pollquestions ADD statuscode tinyint DEFAULT '0' NOT NULL;

INSERT INTO vars VALUES ('totalhits','383');
INSERT INTO userprefs (uid) SELECT (uid) from users;
INSERT INTO userinfo (uid) SELECT (uid) from users;

CREATE TABLE usercomment (
  uid mediumint(8) DEFAULT '0' NOT NULL,
  commentmode varchar(10) DEFAULT 'threaded' NOT NULL,
  commentorder char(4) DEFAULT 'ASC' NOT NULL,
  commentlimit mediumint unsigned DEFAULT '100' NOT NULL,
  PRIMARY KEY (uid)
);

INSERT INTO usercomment (uid) SELECT (uid) from users;

CREATE TABLE userindex (
  uid mediumint(8) DEFAULT '0' NOT NULL,
  tids varchar(255) DEFAULT '' NOT NULL,
  aids varchar(255) DEFAULT '' NOT NULL,
  boxes varchar(255) DEFAULT '' NOT NULL,
  noboxes tinyint DEFAULT '0' NOT NULL,
  maxstories tinyint DEFAULT '10' NOT NULL,
  PRIMARY KEY (uid)
);

INSERT INTO userindex (uid) SELECT (uid) from users;

CREATE TABLE commentcodes (
  code tinyint DEFAULT '' NOT NULL,
  name varchar(32),
  PRIMARY KEY (code)
);

INSERT INTO commentcodes VALUES (0,'Comments Enabled');
INSERT INTO commentcodes VALUES (1,'Read-Only');
INSERT INTO commentcodes VALUES (-1,'Comments Disabled');

CREATE TABLE featurecodes (
  code tinyint DEFAULT '' NOT NULL,
  name varchar(32),
  PRIMARY KEY (code)
);

INSERT INTO featurecodes VALUES (0,'Not Featured');
INSERT INTO featurecodes VALUES (1,'Featured');

CREATE TABLE commentmodes (
  mode varchar(10) DEFAULT '' NOT NULL,
  name varchar(32),
  PRIMARY KEY (mode)
);

INSERT INTO commentmodes VALUES ('flat','Flat');
INSERT INTO commentmodes VALUES ('nested','Nested');
INSERT INTO commentmodes VALUES ('threaded','Threaded');
INSERT INTO commentmodes VALUES ('nocomment','No Comments');

CREATE TABLE dateformats (
  dfid tinyint DEFAULT '0' NOT NULL,
  format varchar(32),
  description varchar(64),
  PRIMARY KEY (dfid)
);

INSERT INTO dateformats VALUES (0,'','System Default');
INSERT INTO dateformats VALUES (1,'%A %B %d, %Y @%I:%M%p','Sunday March 21, 1999 @10:00PM');
INSERT INTO dateformats VALUES (2,'%A %b %d, %Y @%H:%M','Sunday March 21, 1999 @22:00');
INSERT INTO dateformats VALUES (3,'%A %B %d @%I:%M%p','Sunday March 21 @10:00PM');
INSERT INTO dateformats VALUES (4,'%A %b %d @%H:%M','Sunday March 21 @22:00');
INSERT INTO dateformats VALUES (5,'%H:%M %d %B %Y','22:00 21 March 1999');
INSERT INTO dateformats VALUES (6,'%H:%M %A %d %B %Y','22:00 Sunday 21 March 1999');
INSERT INTO dateformats VALUES (7,'%I:%M%p - %A %B %d %Y','10:00PM -- Sunday March 21 1999');
INSERT INTO dateformats VALUES (8,'%a %B %d, %I:%M%p','Sun March 21, 10:00PM');
INSERT INTO dateformats VALUES (9,'%a %B %d, %H:%M','Sun March 21, 22:00');
INSERT INTO dateformats VALUES (10,'%m-%d-%y %H:%M','3-21-99 22:00');
INSERT INTO dateformats VALUES (11,'%d-%m-%y %H:%M','21-3-99 22:00');
INSERT INTO dateformats VALUES (12,'%m-%d-%y %I:%M%p','3-21-99 10:00PM');
INSERT INTO dateformats VALUES (13,'%I:%M%p  %B %D, %Y','10:00PM  March 21st, 1999');
INSERT INTO dateformats VALUES (14,'%a %b %d, \'%y %I:%M%p','Sun Mar 21, \'99 10:00PM');
INSERT INTO dateformats VALUES (15,'Day %j, %I ish','Day 80, 10 ish');
INSERT INTO dateformats VALUES (16,'%y-%m-%d %I:%M','99-03-21 10:00');
INSERT INTO dateformats VALUES (17,'%d/%m/%y %H:%M','21/03/99 22:00');
INSERT INTO dateformats VALUES (18,'%a %d %b %I:%M%p','Sun 21 Mar 10:00PM');

CREATE TABLE maillist (
  code int(1) DEFAULT '0' NOT NULL,
  name char(32),
  PRIMARY KEY (code)
);

INSERT INTO maillist VALUES (0,'Don\'t Email');
INSERT INTO maillist VALUES (1,'Email Headlines Each Night');

CREATE TABLE postmodes (
  code char(10) DEFAULT '' NOT NULL,
  name char(32),
  PRIMARY KEY (code)
);

INSERT INTO postmodes VALUES ('html','HTML Formatted');
INSERT INTO postmodes VALUES ('plaintext','Plain Old Text');

CREATE TABLE sortcodes (
  code char(4) DEFAULT '0' NOT NULL,
  name char(32),
  PRIMARY KEY (code)
);

INSERT INTO sortcodes VALUES ('ASC','Oldest First');
INSERT INTO sortcodes VALUES ('DESC','Newest First');

CREATE TABLE statuscodes (
  code int(1) DEFAULT '0' NOT NULL,
  name char(32),
  PRIMARY KEY (code)
);

INSERT INTO statuscodes VALUES (1,'Refreshing');
INSERT INTO statuscodes VALUES (0,'Normal');
INSERT INTO statuscodes VALUES (10,'Archive');

CREATE TABLE tzcodes (
  tz char(3) DEFAULT '' NOT NULL,
  offset int(1),
  description varchar(64),
  PRIMARY KEY (tz)
);

INSERT INTO tzcodes VALUES ('ndt',-9000,'Newfoundland Daylight');
INSERT INTO tzcodes VALUES ('adt',-10800,'Atlantic Daylight');
INSERT INTO tzcodes VALUES ('edt',-14400,'Eastern Daylight');
INSERT INTO tzcodes VALUES ('cdt',-18000,'Central Daylight');
INSERT INTO tzcodes VALUES ('mdt',-21600,'Mountain Daylight');
INSERT INTO tzcodes VALUES ('pdt',-25200,'Pacific Daylight');
INSERT INTO tzcodes VALUES ('ydt',-28800,'Yukon Daylight');
INSERT INTO tzcodes VALUES ('hdt',-32400,'Hawaii Daylight');
INSERT INTO tzcodes VALUES ('bst',3600,'British Summer');
INSERT INTO tzcodes VALUES ('mes',7200,'Middle European Summer');
INSERT INTO tzcodes VALUES ('sst',7200,'Swedish Summer');
INSERT INTO tzcodes VALUES ('fst',7200,'French Summer');
INSERT INTO tzcodes VALUES ('wad',28800,'West Australian Daylight');
INSERT INTO tzcodes VALUES ('cad',37800,'Central Australian Daylight');
INSERT INTO tzcodes VALUES ('ead',39600,'Eastern Australian Daylight');
INSERT INTO tzcodes VALUES ('nzd',46800,'New Zealand Daylight');
INSERT INTO tzcodes VALUES ('gmt',0,'Greenwich Mean');
INSERT INTO tzcodes VALUES ('utc',0,'Universal (Coordinated)');
INSERT INTO tzcodes VALUES ('wet',0,'Western European');
INSERT INTO tzcodes VALUES ('wat',-3600,'West Africa');
INSERT INTO tzcodes VALUES ('at',-7200,'Azores');
INSERT INTO tzcodes VALUES ('gst',-10800,'Greenland Standard');
INSERT INTO tzcodes VALUES ('nft',-12600,'Newfoundland');
INSERT INTO tzcodes VALUES ('nst',-12600,'Newfoundland Standard');
INSERT INTO tzcodes VALUES ('ast',-14400,'Atlantic Standard');
INSERT INTO tzcodes VALUES ('est',-18000,'Eastern Standard');
INSERT INTO tzcodes VALUES ('cst',-21600,'Central Standard');
INSERT INTO tzcodes VALUES ('mst',-25200,'Mountain Standard');
INSERT INTO tzcodes VALUES ('pst',-28800,'Pacific Standard');
INSERT INTO tzcodes VALUES ('yst',-32400,'Yukon Standard');
INSERT INTO tzcodes VALUES ('hst',-36000,'Hawaii Standard');
INSERT INTO tzcodes VALUES ('cat',-36000,'Central Alaska');
INSERT INTO tzcodes VALUES ('ahs',-36000,'Alaska-Hawaii Standard');
INSERT INTO tzcodes VALUES ('nt',-39600,'Nome');
INSERT INTO tzcodes VALUES ('idl',-43200,'International Date Line West');
INSERT INTO tzcodes VALUES ('cet',3600,'Central European');
INSERT INTO tzcodes VALUES ('met',3600,'Middle European');
INSERT INTO tzcodes VALUES ('mew',3600,'Middle European Winter');
INSERT INTO tzcodes VALUES ('swt',3600,'Swedish Winter');
INSERT INTO tzcodes VALUES ('fwt',3600,'French Winter');
INSERT INTO tzcodes VALUES ('eet',7200,'Eastern Europe, USSR Zone 1');
INSERT INTO tzcodes VALUES ('bt',10800,'Baghdad, USSR Zone 2');
INSERT INTO tzcodes VALUES ('it',12600,'Iran');
INSERT INTO tzcodes VALUES ('zp4',14400,'USSR Zone 3');
INSERT INTO tzcodes VALUES ('zp5',18000,'USSR Zone 4');
INSERT INTO tzcodes VALUES ('ist',19800,'Indian Standard');
INSERT INTO tzcodes VALUES ('zp6',21600,'USSR Zone 5');
INSERT INTO tzcodes VALUES ('was',25200,'West Australian Standard');
INSERT INTO tzcodes VALUES ('jt',27000,'Java (3pm in Cronusland!)');
INSERT INTO tzcodes VALUES ('cct',28800,'China Coast, USSR Zone 7');
INSERT INTO tzcodes VALUES ('jst',32400,'Japan Standard, USSR Zone 8');
INSERT INTO tzcodes VALUES ('cas',34200,'Central Australian Standard');
INSERT INTO tzcodes VALUES ('eas',36000,'Eastern Australian Standard');
INSERT INTO tzcodes VALUES ('nzt',43200,'New Zealand');
INSERT INTO tzcodes VALUES ('nzs',43200,'New Zealand Standard');
INSERT INTO tzcodes VALUES ('id2',43200,'International Date Line East');
INSERT INTO tzcodes VALUES ('idt',10800,'Israel Daylight');
INSERT INTO tzcodes VALUES ('iss',7200,'Israel Standard');
