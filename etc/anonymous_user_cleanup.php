<?php

###############################################################################
# anonymous_user_cleanup.php  
#
# This script will make your pre1.2 Geeklog distribution compatible with 
# MySQL 3.23.X.  You MUST make sure you have already upgraded your database to
# GL 1.2 first (i.e. no gaurantees are made if this scripts is ran against any
# geeklog install other than 1.2).  New users installing Geeklog for the first 
# time do not need to run this script.
#
# PLEASE be sure to BACK UP YOUR DATABASE before running this script.  You can
# do this by issuing the following command:
# >mysqldump -u[username] -p[password] [database name] > geeklog_backup.sql
#
# This will save your table structure and data to a file called geeklog_backup.sql
# If you have problems with this script you should drop your geeklog database
# and restore it from that file.
#
# PLEASE take the time to view the code in this script so you understand what is
# going on.  You've been warned.
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

include("common.php");

###############################################################################
# MAIN
# The flow for this is fairly simple.  First, check to see which user is 
# assigned the user id of 1.  If it is someone other than anonymous, change that
# users ID to the next available user id (for our example let's say it is 4).  Then
# we need to update all comments, articles, etc tied to that users old id to the 
# new ID of 4.  Then we need to figure out what user id anonymous is now (we won't
# assume it is -1 but it should be).  We then update the anonymous users old ID of
# -1 (or whatever it is) to be 1.  Then we update the anonymous users article,
# comments, etc to use the new id of 1. 
		
#get username of current user that has uid of 1
$result = dbquery("SELECT username FROM {$CONF["db_prefix"]}users WHERE uid = 1");
$nrows = mysql_num_rows($result);

#we should get exactly one row back
if ($nrows == 1) {
	$A = mysql_fetch_array($result); 
	if ($A["username"] <> "Anonymous") {
		$user_to_mod = $A["username"];

		#insert a new record with the same data
  		$sql = "CREATE TABLE tmp (uid mediumint(8) DEFAULT '0' NOT NULL auto_increment, 
			username varchar(16) DEFAULT '' NOT NULL,
  			fullname varchar(80),
  			passwd varchar(32) DEFAULT '' NOT NULL,
  			seclev tinyint(3) unsigned DEFAULT '0' NOT NULL,
  			email varchar(96),
  			homepage varchar(96),
  			sig varchar(160) DEFAULT '' NOT NULL,
  			PRIMARY KEY (uid))";
		
		dbquery($sql);

		$result = dbquery("SELECT MAX(uid) as max_id FROM {$CONF["db_prefix"]}users");
		$ID = mysql_fetch_array($result);
		$newid = $ID["max_id"] + 1;
		$sql = "UPDATE users SET uid = $newid WHERE uid = 1";

		if (dbquery($sql)) {
			if (!dbquery("UPDATE comments SET uid = $newid WHERE uid = 1")) {
				#query didn't work, exit 
				errorlog("Couldn't update table comments in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("UPDATE stories SET uid = $newid WHERE uid = 1")) {
				#query didn't work, exit
				errorlog("Couldn't update table stories in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("UPDATE storysubmission SET uid = $newid WHERE uid = 1")) {
				#query didn't work, exit
				errorlog("Couldn't update table storysubmission in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("UPDATE usercomment SET uid = $newid WHERE uid = 1")) {
				#query didn't work, exit
				errorlog("Couldn't update table usercomment in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("UPDATE userindex SET uid = $newid WHERE uid = 1")) {
				#query didn't work, exit
				errorlog("Couldn't update table userindex in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("UPDATE userinfo SET uid = $newid WHERE uid = 1")) {
				#query didn't work, exit
				errorlog("Couldn't update table userinfo in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("UPDATE userprefs SET uid = $newid WHERE uid = 1")) {
				#query didn't work, exit
				errorlog("Couldn't update table userprefs in anonymous_user_cleanup.php");
				exit;
			}

			#Now get the current id for anonymous user
			$result = dbquery("SELECT uid FROM {$CONF["db_prefix"]}users WHERE username = 'Anonymous'");
			$A = mysql_fetch_array($result);
			$old_anon_uid = $A["uid"];
			
			#update anonymous record with new ID of 1
			if (!dbquery("UPDATE users SET uid = 1 WHERE uid = $old_anon_uid")) {
				#query didn't work, exit
				errorlog("Couldn't update anonymous uid to 1 in anonymous_user_cleanup.php");
				exit;
			}

			#Now update all of anonymous users children to reflect uid change
			if (!dbquery("UPDATE comments SET uid = 1 WHERE uid = $old_anon_uid")) {
                        	#query didn't work, exit
                 	       	errorlog("Couldn't update table comments with new anonymous user id in anonymous_user_cleanup.php");
                                exit;
                        }
			if (!dbquery("UPDATE stories SET uid = 1 WHERE uid = $old_anon_uid")) {
                                #query didn't work, exit
                                errorlog("Couldn't update table stories with new anonymous user id in anonymous_user_cleanup.php");
                                exit;
                        }
			if (!dbquery("UPDATE storysubmission SET uid = 1 WHERE uid = $old_anon_uid")) {
                                #query didn't work, exit
                                errorlog("Couldn't update table storysubmission with new anonymous user id in anonymous_user_cleanup.php");
                                exit;
                        }
			if (!dbquery("UPDATE usercomment SET uid = 1 WHERE uid = $old_anon_uid")) {
                                #query didn't work, exit
                                errorlog("Couldn't update table usercomment with new anonymous user id in anonymous_user_cleanup.php");
                                exit;
                        }
			if (!dbquery("UPDATE userindex SET uid = 1 WHERE uid = $old_anon_uid")) {
                                #query didn't work, exit
                                errorlog("Couldn't update table userindex with new anonymous user id in anonymous_user_cleanup.php");
                                exit;
                        }
			if (!dbquery("UPDATE userinfo SET uid = 1 WHERE uid = $old_anon_uid")) {
                                #query didn't work, exit
                                errorlog("Couldn't update table userinfo with new anonymous user id in anonymous_user_cleanup.php");
                                exit;
                        }
			if (!dbquery("UPDATE userprefs SET uid = 1 WHERE uid = $old_anon_uid")) {
                                #query didn't work, exit
                                errorlog("Couldn't update table userprefs with new anonymous user id in anonymous_user_cleanup.php");
                                exit;
                        }
		
			#almost done now!  now we need to update any table that default to uid of -1
			#to default to uid of 1
			if (!dbquery("ALTER TABLE comments MODIFY uid mediumint(8) DEFAULT '1' NOT NULL")) {
				#query didn't work, exit
				errorlog("Couldn't alter table comments in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("ALTER TABLE stories MODIFY uid mediumint(8) DEFAULT '1' NOT NULL")) {
				#query didn't work, exit
				errorlog("Couldn't alter table stories in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("ALTER TABLE storysubmission MODIFY uid mediumint(8) DEFAULT '1' NOT NULL")) {
				#query didn't work, exit
				errorlog("Couldn't alter table storysubmission in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("ALTER TABLE usercomment MODIFY uid mediumint(8) DEFAULT '1' NOT NULL")) {
				#query didn't work, exit
				errorlog("Couldn't alter table usercomment in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("ALTER TABLE userindex MODIFY uid mediumint(8) DEFAULT '1' NOT NULL")) {
				#query didn't work, exit
				errorlog("Couldn't alter table userindex in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("ALTER TABLE userinfo MODIFY uid mediumint(8) DEFAULT '1' NOT NULL")) {
				#query didn't work, exit
				errorlog("Couldn't alter table userinfo in anonymous_user_cleanup.php");
				exit;
			}
			if (!dbquery("ALTER TABLE userprefs MODIFY uid mediumint(8) DEFAULT '1' NOT NULL")) {
				#query didn't work, exit
				errorlog("Couldn't alter table userprefs in anonymous_user_cleanup.php");
				exit;
			}
					
		} else {
			dbquery ("drop table tmp");
			errorlog("query had an error");
			exit;
		}#end if dbquery($sql)
	} else {
		errorlog("Anonymous already has id of 1");
		exit;
	} #end if ($A["username"] <> "Anonymous")
} else {
	errorlog("query returned more than one row in anonymous_user_cleanup.php");
	errorlog("nrows = " . $nrows);
	exit;
} #end if ($nrows)

dbquery("drop table tmp");
errorlog("script ran successfully");

?>

