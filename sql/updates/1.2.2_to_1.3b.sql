CREATE TABLE plugins(
	pi_name varchar(30) DEFAULT '' NOT NULL,
	pi_version varchar(20) DEFAULT '' NOT NULL,
	pi_gl_version varchar(20) DEFAULT '' NOT NULL,
	pi_enabled tinyint(3) unsigned DEFAULT '1' NOT NULL,
	pi_homepage varchar(128) DEFAULT '' NOT NULL,
	PRIMARY KEY(pi_name)
);

ALTER TABLE blocks add phpblockfn varchar(64) DEFAULT '';
ALTER TABLE blocks add onleft tinyint(3) unsigned DEFAULT '0' NOT NULL;
ALTER TABLE stories add numemails mediumint(8) unsigned DEFAULT '0' NOT NULL;
ALTER TABLE users add regdate datetime DEFAULT '0000-00-00 00:00:00' NOT NULL;
UPDATE users SET regdate = NOW();

#Mandatory Data for blocks
INSERT INTO blocks (title,tid,seclev,blockorder,type,rdfurl,rdfupdated,content,onleft,phpblockfn) VALUES ('blockheader','all',255,0,'layout','','0000-00-00 00:00:00','<table border=0 cellpadding=1 cellspacing=0 width=\"100%\"><tr bgcolor=666666><td>\r\n<table width=\"100%\" border=0 cellspacing=0 cellpadding=2>\r\n<tr bgcolor=666666><td class=blocktitle>%title</td><td align=right>%help</td></tr>\r\n<tr><td bgcolor=FFFFFF colspan=2>',1,'');
INSERT INTO blocks (title,tid,seclev,blockorder,type,rdfurl,rdfupdated,content,onleft,phpblockfn) VALUES ('blockfooter','all',255,0,'layout','','0000-00-00 00:00:00','</td></tr></table>\r\n</td></tr></table><br>',1,'');
INSERT INTO blocks (title,tid,seclev,blockorder,type,rdfurl,rdfupdated,content,onleft,phpblockfn) VALUES ('Events Block','all',255,3,'gldefault','','0000-00-00 00:00:00','',1,'');
INSERT INTO blocks (title,tid,seclev,blockorder,type,rdfurl,rdfupdated,content,onleft,phpblockfn) VALUES ('Section Block','all',255,0,'gldefault','','0000-00-00 00:00:00','',1,'');
INSERT INTO blocks (title,tid,seclev,blockorder,type,rdfurl,rdfupdated,content,onleft,phpblockfn) VALUES ('Poll Block','all',255,2,'gldefault','','0000-00-00 00:00:00','',0,'');
INSERT INTO blocks (title,tid,seclev,blockorder,type,rdfurl,rdfupdated,content,onleft,phpblockfn) VALUES ('User Block','all',255,1,'gldefault','','0000-00-00 00:00:00','',1,'');
INSERT INTO blocks (title,tid,seclev,blockorder,type,rdfurl,rdfupdated,content,onleft,phpblockfn) VALUES ('Admin Block','all',255,2,'gldefault','','0000-00-00 00:00:00','',1,'');
INSERT INTO blocks (title,tid,seclev,blockorder,type,rdfurl,rdfupdated,content,onleft,phpblockfn) VALUES ('Whats New Block','all',255,4,'gldefault','','0000-00-00 00:00:00','',1,'');
