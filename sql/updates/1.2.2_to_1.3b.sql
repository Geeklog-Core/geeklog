CREATE TABLE plugins(
	pi_name varchar(30) DEFAULT '' NOT NULL,
	pi_version varchar(20) DEFAULT '' NOT NULL,
	pi_gl_version varchar(20) DEFAULT '' NOT NULL,
	pi_enabled tinyint(3) unsigned DEFAULT '1' NOT NULL,
	pi_homepage varchar(128) DEFAULT '' NOT NULL,
	PRIMARY KEY(pi_name)
);
