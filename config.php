<?php

###############################################################################
# config.php
# This is the main global configuration file.
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################
#
# See the INSTALL.HTML file for more information on configuration information
#
###############################################################################

##/ DATABASE SETTINGS /########################################################
#
#	These settings must suit your server environment.

$CONF["db_name"]		= "geeklog";
$CONF["db_host"]		= "localhost";
$CONF["db_user"]		= "username";
$CONF["db_pass"]		= "password";
$CONF["db_prefix"]		= ""; #e.g. "gl_"

##/ SERVER SETTINGS /##########################################################
#
#	All paths must have a trailing slash ('/').
#	The 'path' value signifies where the config.php file resides.

$CONF["path"] 			= "/path/to/geeklog/";
$CONF["path_log"]		= $CONF["path"]."/logs";
$CONF["path_html"]		= $CONF["path"]."public_html/";
$CONF["path_rdf"]		= $CONF["path_html"]."backend/geeklog.rdf";

##/ SITE SETTINGS /############################################################
#
#	These settings help define your Geeklog site.

$CONF["site_name"]		= "Geeklog Site";
$CONF["site_slogan"]	= "Another Nifty GeekLog Site";
$CONF["site_mail"]		= "admin@yourdomain.com";
$CONF["site_url"]		= "http://www.yourdomain.com";

$CONF["layout"]			= "classic";
$CONF["layout_url"]		= $CONF["site_url"].'/layout/'.$CONF["layout"];

##/ LOCALE SETTINGS /##########################################################

$CONF["languagefile"]	="english.php";
$CONF["locale"]			= "en-gb";
$CONF["date"]			= "%A, %B %d %Y @ %I:%M %p %Z";
$CONF["daytime"]		= "%m/%d %I:%M%p";
$CONF["shortdate"]		= "%x";

##/ SECURITY SETTINGS /########################################################
#
#	These settings assign the security levels for specific administration
#	duties/pages.  

$CONF["sec_mod"] 		= 100;
$CONF["sec_story"] 		= 150;
$CONF["sec_links"] 		= 150;
$CONF["sec_event"] 		= 150;
$CONF["sec_poll"] 		= 150;
$CONF["sec_topic"] 		= 200;
$CONF["sec_block"] 		= 200;
$CONF["sec_user"] 		= 200;
$CONF["sec_delstory"] 		= 200;	// deletion of comments
$CONF["sec_email"] 		= 200; 	// email other admins or all GL users

# The value below needs to be equal to the lowest seclevel found in the ones 
# above.  This is temporary until I find a better fix

$CONF["sec_lowest"]		= 150;

##/ SESSION SETTINGS /#########################################################
#
# 	cookie_timeout is the same for admin and non-admins (Note: 3600 = 1 hour)
# 	cookie_ip will store md5(remoteip + randomnum) as the session ID in the 
#	cookie. This is more secure but will more than likely require dialed up 
#	users to login each and every time.  If	ipbasedsessid is turned off 
#	(which it is by default) it will just store	a random number as the 
#	session ID in the cookie.

$CONF["cookie_ip"]		= 1;
$CONF["cookie_timeout"]		= "7200";
$CONF["cookie_session"]		= "gl_session";
$CONF["cookie_name"]		= "geeklog";
$CONF["cookie_path"]		= "/";


##/ PLUGIN SETTINGS /##########################################################
#
# 	You can have only one of the following two lines uncommented. The
# 	first one is for *nix users and assumes you are using tar.
# 	The second entry is for windows users and this is configured to work with
# 	FilZip.  You can get FilZip from http://www.filzip.com.  Make sure
# 	you add the FilZip directory to your path OR fully qualify the path
# 	here. Regardless of OS, make sure you leave a trailing space at the end.

$CONF["unzipcommand"] 		= '/bin/tar -C ' . $CONF['path'] . 'plugins/ -xzf ';
#$CONF["unzipcommand"] 		= 'filzip.exe -e -r ';

#	Command needed to remove a directory recursively and quietly
#	First one is typical for *nix boxes and the second is for 
#	windows machines.

$CONF["rmcommand"] 		= '/bin/rm -Rf ';
#$CONF["rmcommand"] 		= 'rmdir /S /Q ';

# This is really redundant but I am including this as a reminder that those
# people writing Geeklog Plug-ins that are OS dependent should check either the
# $CONF variable below or PHP_OS directly.  If you are writing an addon that is
# OS specific your addon should check the system is using the right OS.  If not,
# be sure to show a friendly message that says their GL distro isn't running the
# right OS. Do not modify this value
$CONF["ostype"] 		= PHP_OS;


# Submission Settings
$CONF["loginrequired"] 		= 0;
$CONF["speedlimit"] 		= "300"; #in seconds

# Topic Settings
//determines how topics are sorted in Section block
$CONF["sortmethod"] 		= "sortnum"; #can be sortnum or alpha

//show the number of stories in a topic in Section Block
$CONF["showstorycount"] 	= 1;

//show the number of story submissions for a topic in Section Block
$CONF["showsubmissioncount"] 	= 1;

//show any new articles, comments and links
$CONF["whatsnewbox"] 		= 1;

//Let users get stories emailed to them
//Requires cron and the use of php as a shell script
$CONF["emailstories"] 		= 1;

//following times are in seconds
$CONF["newstoriesinterval"] 	= 86400;
$CONF["newcommentsinterval"] 	= 172800;
$CONF["newlinksinterval"] 	= 1209600;
//$CONF["neweventsinterval"] 	= 2592000;

# Calendar Setting
$CONF["personalcalendars"] 	= 0;
$CONF["showupcomingevents"] 	= 1;
$CONF["headingbgcolor"] 	= '#DDDDDD';
$CONF["headingtextcolor"] 	= 'black';

# Story Settings

$CONF["pagetitle"] 		= "";
$CONF["backend"] 		= "1";
$CONF["limitnews"] 		= "10";
$CONF["minnews"] 		= "1"; # minimum number of stories per page
$CONF["olderstuff"]		= 1;
$CONF["olderstufforder"]	= 2;
$CONF["contributedbyline"] 	= 1; # if 1, show contributed by line

# Comment Settings

$CONF["speedlimit2"] 		= "60";
$CONF["loginrequired2"] 	= 0;

# Poll Settings

$CONF["maxanswers"] 		= "10";
$CONF["pollcookietime"] 	= "86400";
$CONF["polladdresstime"] 	= "604800";
$CONF["pollorder"] 		= 1;

# Parameters for checking words and HTML tags

$CONF["allowablehtml"] 		= "<p>,<b>,<i>,<a>,<em>,<br>,<tt>,<hr>,<li>,<ol>,<div>,<ul>";
$CONF["censormode"] 		= 0;
$CONF["censorreplace"] 		= "*censored*";
$CONF["censorlist"] 		= array("fuck","cunt","fucker","fucking","pussy","cock","c0ck","cum","twat","clit","bitch","fuk","fuking","motherfucker");

?>
