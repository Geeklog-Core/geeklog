<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-user.php                                                              |
// | Geeklog user administration page.                                         |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
// $Id: user.php,v 1.33 2002/05/05 12:26:21 dhaun Exp $

// Set this to true to get various debug messages from this script
$_USER_VERBOSE = false;

include('../lib-common.php');
include('auth.inc.php');

$display = '';

// Make sure user has access to this page  
if (!SEC_hasRights('user.edit')) {
    $retval .= COM_siteHeader('menu');
    $retval .= COM_startBlock($MESSAGE[30]);
    $retval .= $MESSAGE[37];
    $retval .= COM_endBlock();
    $retval .= COM_siteFooter();
    COM_errorLog("User {$_USER['username']} tried to illegally access the user administration screen",1);
    echo $retval;
    exit;
}

/**
* Shows the user edit form
*
* @uid          int         User to edit
*
*/
function edituser($uid = '', $msg = '') 
{
	global $_TABLES, $LANG28, $_CONF, $LANG_ACCESS, $_USER;

    $retval = '';

    if (!empty($msg)) {
        $retval .= COM_startBlock($LANG28[22]) . $LANG28[$msg] . COM_endBlock();
    }

	$retval .= COM_startBlock($LANG28[1]);

	if (!empty($uid)) {
		$result = DB_query("SELECT * FROM {$_TABLES['users']} WHERE uid ='$uid'");
		$A = DB_fetchArray($result);
	
        $curtime = COM_getUserDateTimeFormat($A['regdate']);
	
		if (SEC_inGroup('Root',$uid) AND !SEC_inGroup('Root')) {
			// the current admin user isn't Root but is trying to change
			// a root account.  Deny them and log it.
			$retval .= $LANG_ACCESS[editrootmsg];
			COM_errorLog("User {$_USER['username']} tried to edit a root account with insufficient privileges",1);
			$retval .= COM_endBlock();
			return $retval;
		}
		$curtime = COM_getUserDateTimeFormat($A['regdate']);
	} else {
        $tmp = DB_query("SELECT MAX(uid) AS max FROM {$_TABLES['users']}");
        $T = DB_fetchArray($tmp);
        $A['uid'] = $T['max'] + 1;
		$curtime =  COM_getUserDateTimeFormat();
    }

    $user_templates = new Template($_CONF['path_layout'] . 'admin/user');
    $user_templates->set_file(array('form'=>'edituser.thtml','groupedit'=>'groupedit.thtml'));
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $user_templates->set_var('layout_url', $_CONF['layout_url']);
    $user_templates->set_var('lang_save', $LANG28[20]);
	if ($A['uid'] > 1) { 
        $user_templates->set_var('change_password_option', '<input type="submit" value="' . $LANG28[17] . '" name="mode">');
    }
	if (!empty($uid) && SEC_hasRights('user.delete')) {
        $user_templates->set_var('delete_option', '<input type="submit" value="' . $LANG28[19] . '" name="mode">');
	}
    $user_templates->set_var('lang_cancel', $LANG28[18]);

    $user_templates->set_var('lang_userid', $LANG28[2]);
    $user_templates->set_var('user_id', $A['uid']);
    $user_templates->set_var('lang_regdate', $LANG28[14]);
    $user_templates->set_var('regdate_timestamp', $curtime[1]);
    $user_templates->set_var('user_regdate', $curtime[0]);
    $user_templates->set_var('lang_username', $LANG28[3]);
    $user_templates->set_var('username', $A['username']);
    if ($_CONF['allow_user_photo'] == 1 AND !empty($A['photo'])) {
        $user_templates->set_var('user_photo', '<img src="' . $_CONF['site_url'] . '/images/userphotos/' . $A['photo'] . '" alt="">');
        $user_templates->set_var('lang_delete_photo', $LANG28[28]);
        $user_templates->set_var('delete_photo_option', '<input type="checkbox" name="delete_photo">');
    } else {
        $user_templates->set_var('user_photo', '');
        $user_templates->set_var('lang_delete_photo','');
        $user_templates->set_var('delete_photo_option','');
    }
    $user_templates->set_var('lang_fullname', $LANG28[4]);
    $user_templates->set_var('user_fullname', $A['fullname']);
    $user_templates->set_var('lang_password', $LANG28[5]); 
    $user_templates->set_var('lang_emailaddress', $LANG28[7]);
    $user_templates->set_var('user_email', $A['email']);
    $user_templates->set_var('lang_homepage', $LANG28[8]);
    $user_templates->set_var('user_homepage', $A['homepage']);
    $user_templates->set_var('do_not_use_spaces', $LANG28[9]);

	if (SEC_inGroup('Group Admin')) {
        $user_templates->set_var('lang_securitygroups', $LANG_ACCESS[securitygroups]);
        $user_templates->set_var('lang_groupinstructions', $LANG_ACCESS[securitygroupsmsg]);
        
        if (!empty($uid)) { 
		    $usergroups = SEC_getUserGroups($uid);
		    if (is_array($usergroups) && !empty($uid)) {
			    $selected = implode(' ',$usergroups);
		    } else {
			    $selected = '';
		    }
        } else {
            $selected = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='All Users'") . ' ';
            $selected .= DB_getItem($_TABLES['groups'],'grp_id',"grp_name='Logged-in Users'");
        }
		$user_templates->set_var('group_options', COM_checkList($_TABLES['groups'],'grp_id,grp_name','',$selected));
        $user_templates->parse('group_edit', 'groupedit', true);
	} else {
		// user doesn't have the rights to edit a user's groups so set to -1 so we know not to
		// handle the groups array when we save
		$user_templates->set_var('group_edit', '<input type="hidden" name="groups" value="-1">');
	}
    $user_templates->parse('output', 'form');
    $retval .= $user_templates->finish($user_templates->get_var('output')); 
	$retval .= COM_endBlock();

    return $retval;
}

/**
* Changes a user's password
*
* @uid      int     ID of user to change password for
* @passwd   int     New password
*
*/
function changepw($uid,$passwd) 
{
	global $_TABLES; 

    $retval = '';

	if (!empty($passwd) && !empty($uid)) {
		$passwd = md5($passwd);
		$result = DB_change($_TABLES['users'],'passwd',"$passwd",'uid',$uid,'admin/user.php?mode=none');	
	} else {
		$retval .= COM_siteHeader('menu');
		COM_errorLog("CHANGEPW ERROR: There was nothing to do!",3);
		$retval .= COM_siteFooter();
	}
}

/**
* Saves $uid to the database
*
*/
function saveusers($uid,$username,$fullname,$passwd,$email,$regdate,$homepage,$groups,$delete_photo = '') 
{
	global $_TABLES, $_CONF, $LANG28, $_USER_VERBOSE, $_USER;

	if ($_USER_VERBOSE) COM_errorLog("**** entering saveusers****",1);	
	if ($_USER_VERBOSE) COM_errorLog("group size at beginning = " . sizeof($groups),1);	

    $ucount = DB_getItem($_TABLES['users'],'count(*)',"username = '$username' AND uid <> $uid");
    if ($ucount > 0) {
        // Admin just changes a user's username to one that already exists...bail
        return edituser($uid, 21);
    }

	if (!empty($username) && !empty($email)) {
        $regdate = strftime('%Y-%m-%d %H:%M:$S',$regdate);
		if (($uid == 1) or !empty($passwd)) { 
			$passwd = md5($passwd);
		} else {
            $passwd = DB_getItem($_TABLES['users'],'passwd',"uid = $uid");
		}
        
        if (DB_count($_TABLES['users'],'uid',$uid) == 0) {
            DB_query("INSERT INTO {$_TABLES['users']} (uid,username,fullname,passwd,email,regdate,homepage) VALUES($uid,'$username','$fullname','$passwd', '$email','$regdate','$homepage')");
			DB_query("INSERT INTO {$_TABLES['userprefs']} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES['userindex']} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES['usercomment']} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES['userinfo']} (uid) VALUES ($uid)");
        } else {
            $curphoto = DB_getItem($_TABLES['users'],'photo',"uid = {$_USER['uid']}");
            if (!empty($curphoto) AND $delete_photo == 'on') {
                if (!unlink($_CONF['path_html'] . 'images/userphotos/' . $curphoto)) {
                    echo COM_errorLog('Unable to delete photo ' . $curphoto);
                    exit;
                }
                $curphoto = '';
            }
            DB_query("UPDATE {$_TABLES['users']} SET username = '$username', fullname = '$fullname', passwd = '$passwd', email = '$email', homepage = '$homepage', photo = '$curphoto' WHERE uid = $uid");
        }
		
		// if groups is -1 then this user isn't allowed to change any groups so ignore
		if (is_array($groups)) {
			if ($_USER_VERBOSE) COM_errorLog("deleting all group_assignments for user $uid/$username",1);
			DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_uid = $uid");
			if (!empty($groups)) {
				for ($i = 1; $i <= sizeof($groups); $i++) {
					if ($_USER_VERBOSE) COM_errorLog("adding group_assignment " . current($groups) . " for $username",1);
					$sql = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES (" . current($groups) . ",$uid)";
					DB_query($sql);
					next($groups);		
				}
			}
		}
        $errors = DB_error();
		if (empty($errors)) { 
			echo COM_refresh($_CONF['site_admin_url'] . '/user.php?msg=21');
		} else {
			$retval .= COM_siteHeader('menu');
            $retval .= COM_errorLog('Error in saveusers in admin/users.php');
			$retval .= COM_siteFooter();
            echo $retval;
            exit;
		}
	} else {
		$retval = COM_siteHeader('menu');
		$retval .= COM_errorLog($LANG28[10]);
        if (DB_count($_TABLES['users'],'uid',$uid) > 0) {
            $retval .= edituser($uid);
        } else {
            $retval .= edituser();
        }
		$retval .= COM_siteFooter();
        echo $retval;
        exit;
	}

	if ($_USER_VERBOSE) COM_errorLog("***************leaving saveusers*****************",1);	

    return $retval;
}

/**
* Lists all users in the system
*
*/
function listusers($offset, $curpage, $query = '', $query_limit = 50) 
{
	global $_TABLES, $LANG28, $_CONF;
        
    $retval = '';

	$retval .= COM_startBlock($LANG28[11]);

    $user_templates = new Template($_CONF['path_layout'] . 'admin/user');
    $user_templates->set_file(array('list'=>'userslist.thtml','row'=>'listitem.thtml'));
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $user_templates->set_var('layout_url', $_CONF['layout_url']);
    $user_templates->set_var('lang_newuser', $LANG28[15]);
    $user_templates->set_var('lang_batchadd',$LANG28[23]);
    $user_templates->set_var('lang_adminhome', $LANG28[16]);
    $user_templates->set_var('lang_instructions', $LANG28[12]);
    $user_templates->set_var('lang_search', $LANG28[26]);
    $user_templates->set_var('lang_submit', $LANG28[33]);
    $user_templates->set_var('last_query', $query);
    $user_templates->set_var('lang_limit_results', $LANG28[27]);
    $user_templates->set_var('lang_username', $LANG28[3]);
    $user_templates->set_var('lang_fullname', $LANG28[4]);
    $user_templates->set_var('lang_emailaddress', $LANG28[7]);

    if (empty($query_limit)) {
        $limit = 50;
    } else {
        $limit = $query_limit;
    }
    $user_templates->set_var($limit . '_selected', 'selected="SELECTED"');
    
    if (!empty($query)) {
        $query = str_replace('*','%',$query);
        $num_pages = ceil(DB_getItem($_TABLES['users'],'count(*)',"uid > 1 AND username LIKE '$query'") / $limit);
        if ($num_pages < $curpage) {
            $curpage = 1;
        }
    } else {
        $num_pages = ceil(DB_getItem($_TABLES['users'],'count(*)','uid > 1') / $limit);
    }

    $offset = ($curpage - 1) * $limit;

    if (!empty($query)) {
        $sql = "SELECT uid,username,fullname,email FROM {$_TABLES['users']} WHERE uid > 1 AND (username LIKE '$query' OR email LIKE '$query' OR fullname LIKE '$query') LIMIT $offset,$limit";
    } else {
        $sql = "SELECT uid,username,fullname,email FROM {$_TABLES['users']} WHERE uid > 1 LIMIT $offset,$limit";
    }
	$result = DB_query($sql);
	$nrows = DB_numRows($result);

	for ($i = 0; $i < $nrows; $i++) {
		$A = DB_fetchArray($result);
        $user_templates->set_var('user_id', $A['uid']);
        $user_templates->set_var('username', $A['username']);
        $user_templates->set_var('user_fullname', $A['fullname']);
        $user_templates->set_var('user_email', $A['email']);
        $user_templates->parse('user_row', 'row', true);
	}
    if (!empty($query)) {
        $query = str_replace('%','*',$query);
        $base_url = $_CONF['site_admin_url'] . '/user.php?q=' . urlencode($query) . '&amp;query_limit=' . $query_limit;
    } else {
        $base_url = $_CONF['site_admin_url'] . '/user.php?query_limit=' . $query_limit;
    }

    $user_templates->set_var('google_paging',COM_printPageNavigation($base_url,$curpage,$num_pages));
    $user_templates->parse('output', 'list');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

	$retval .= COM_endBlock();

    return $retval;

}

/**
* This function allows the administrator to import batches of users
*
* $file     string      file to import
*
*/
function importusers($file)
{
    global $_TABLES, $LANG04, $LANG28, $_CONF, $HTTP_POST_FILES;

    // Setting this to true will cause import to print processing status to webpage.
    // and to the error.log file
    $verbose_import = false;    

    // First, upload the file
    require_once($_CONF['path_system'] . "classes/upload.class.php");

    $upload = new upload();
    $upload->setPath($_CONF['path']);
    $upload->setAllowedMimeTypes(array('text/plain'));
    $upload->setFileNames('user_import_file.txt');
    if ($upload->uploadFiles()) {
        // Good, file got uploaded, now install everything
        $thefile =  current($HTTP_POST_FILES);
        $filename = $_CONF['path'] . 'user_import_file.txt';
    } else {
        // A problem occurred, print debug information
        print 'ERRORS<br>';
        $upload->printErrors();
        exit;
    }

    $retval = '';

    $handle = @fopen($filename,'r');
    if (empty ($handle)) {
        return $LANG28[34];
    }
    
    // Following variables track import processing statistics
    $successes = 0;
    $failures = 0;
    while ($user1 = fgets($handle,4096)) {
        $user = rtrim($user1);
        list($full_name,$u_name,$email) = split("\t",$user);

        $ucount = DB_count($_TABLES['users'],'username',$u_name);
        $ecount = DB_count($_TABLES['users'],'email',$email);
        
        if ($verbose_import) {
            $retval .="<BR><B>Working on username=$u_name, fullname=$full_name, and email=$email</B><BR>\n";
            COM_errorLog("Working on username=$u_name, fullname=$full_name, and email=$email",1);
        }
        
        if ($ucount == 0 && ecount == 0) {
            // user doesn't already exist
            if (COM_isEmail($email)) {
                // email is valid form
                $regdate = strftime('%Y-%m-%d %H:%M:%S',time());
                
                // Create user record
                DB_query("INSERT INTO {$_TABLES['users']} (username,fullname,email,regdate) VALUES ('$u_name','$full_name','$email','$regdate')");
                $uid = DB_getItem($_TABLES['users'],'uid',"username = '$u_name'");

                // Add user to Logged-in group (i.e. members) and the All Users group (which includes
                // anonymous users
                $normal_grp = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='Logged-in Users'");
                $all_grp = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='All Users'");
                DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id,ug_uid) values ($normal_grp, $uid)");
                DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id,ug_uid) values ($all_grp, $uid)");
                DB_query("INSERT INTO {$_TABLES['userprefs']} (uid) VALUES ($uid)");
                DB_query("INSERT INTO {$_TABLES['userindex']} (uid) VALUES ($uid)");
                DB_query("INSERT INTO {$_TABLES['usercomment']} (uid) VALUES ($uid)");
                DB_query("INSERT INTO {$_TABLES['userinfo']} (uid) VALUES ($uid)");
                $retval .= emailpassword($u_name, 1);
                
                if ($verbose_import) {
                    $retval .= "<BR> Account for <B>$u_name</B> created successfully.<BR>\n";
                    COM_errorLog("Account for $u_name created successfully",1);
                }
                $successes++;
            } else {
                if ($verbose_import) {
                    $retval .= "<BR><B>$email</B> is not a valid email address, account not created<BR>\n"; // malformed email
                    COM_errorLog("$email is not a valid email address, account not created",1);
                }
                $failures++;
            } // end if COM_isEmail($email)
        } else {
            if ($verbose_import) {
                $retval .= "<BR><B>$u_name</B> already exists, account not created.<BR>\n"; // users already exists
                COM_errorLog("$u_name,$email: username or email already exists, account not created",1);
            }
            $failures++;
        } // end if $ucount == 0 && ecount == 0
    } // end while
        
    fclose($handle);
    unlink($filename);

    $report = $LANG28[32];
    eval ("\$report = \"$report\";");

    $retval .= '<p>' . $report;
    
    return $retval;

} // end importusers

function emailpassword($username)
{
    global $_TABLES, $_CONF, $LANG04, $LANG_CHARSET;

    $result = DB_query("SELECT email FROM {$_TABLES['users']} WHERE username = '$username'");
    $nrows = DB_numRows($result);
    if ($nrows == 1) {
        srand((double)microtime()*1000000);
        $passwd = rand();
        $passwd = md5($passwd);
        $passwd = substr($passwd,1,8);
        $passwd2 = md5($passwd);
        DB_change($_TABLES['users'],'passwd',"$passwd2",'username',$username);
        $A = DB_fetchArray($result);
        $mailtext = "{$LANG04[15]}\n\n";
        $mailtext .= "{$LANG04[2]}: $username\n";
        $mailtext .= "{$LANG04[4]}: $passwd\n\n";
        $mailtext .= "{$LANG04[14]}\n\n";
        $mailtext .= "{$_CONF["site_name"]}\n";
        $mailtext .= "{$_CONF['site_url']}\n";
        if (empty ($LANG_CHARSET)) {
            $charset = $_CONF['default_charset'];
            if (empty ($charset)) {
                $charset = "iso-8859-1";
            }
        }
        else {
            $charset = $LANG_CHARSET;
        }
        mail($A["email"]
            ,"{$_CONF["site_name"]}: {$LANG04[16]}"
            ,$mailtext
            ,"From: {$_CONF["site_name"]} <{$_CONF["site_mail"]}>\nReturn-Path: <{$_CONF["site_mail"]}>\nContent-Type: text/plain; charset={$charset}\nX-Mailer: GeekLog $VERSION"
            );
    }
    return $retval;
}


function display_form()
{
    global $_CONF, $LANG28;

    $retval .= '<form action="' . $_CONF['site_admin_url'] . '/user.php" method="post" enctype="multipart/form-data">'
            . $LANG28[29] . ': <input type="file" name="importfile" size="40">'
            . '<input type="hidden" name="mode" value="import">'
            . '<input type="submit" name="submit" value="' . $LANG28[30] . '"></form>';
    return $retval;
}

// MAIN
switch ($mode) {
case $LANG28[19]:
    // Ok, delete everything related to this user
		
    #first, remove from all security groups
    DB_delete($_TABLES['group_assignments'],'ug_uid',$uid);
    DB_delete($_TABLES['userprefs'],'uid',$uid);
    DB_delete($_TABLES['userindex'],'uid',$uid);
    DB_delete($_TABLES['usercomment'],'uid',$uid);
    DB_delete($_TABLES['userinfo'],'uid',$uid);
	
    // what to do with orphan stories/comments?
	
    // now move delete the user itself
    DB_delete($_TABLES['users'],'uid',$uid,'admin/user.php?msg=22');
    break;
case $LANG28[20]:
    $display = saveusers($uid,$username,$fullname,$passwd,$email,$regdate,$homepage,$HTTP_POST_VARS[$_TABLES['groups']],$delete_photo);
    if (!empty($display)) {
        $tmp = COM_siteHeader('menu');
        $tmp .= $display;
        $tmp .= COM_siteFooter('menu');
        $display = $tmp;
    }
    break;
case $LANG28[17]:
    changepw($uid,$passwd);
    break;
case 'edit':
    $display .= COM_siteHeader('menu');
    $display .= edituser($uid);
    $display .= COM_siteFooter();
    break;
case 'import':
    $display .= COM_siteHeader('menu');
	$display .= COM_startBlock($LANG28[31]);
	$display .= importusers($file);
	$display .= COM_endBlock();
	$display .= COM_siteFooter();  
	break;
case 'importform':
	$display .= COM_siteHeader('menu');
	$display .= COM_startBlock($LANG28[24]);
	$display .= $LANG28[25] . '<br><br>';
	$display .= display_form();
	$display .= COM_endBlock();
	$display .= COM_siteFooter();  
	break;
case $LANG28[18]:
default:
    $display .= COM_siteHeader('menu');
    $display .= COM_showMessage($msg);
    if (empty($offset)) {
        $offset = 0;
    }
    if (empty($page)) {
        $page = 1;
    }
    $display .= listusers($offset,$page,$q,$query_limit);
    $display .= COM_siteFooter();
    break;
}

echo $display;

?>
