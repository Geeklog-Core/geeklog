<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | usersettings.php                                                          |
// | Geeklog user settings page.                                               |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@users.sourceforge.net                |
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
// $Id: usersettings.php,v 1.50 2003/01/17 15:42:57 dhaun Exp $

include_once('lib-common.php');

// Set this to true to have this script generate various debug messages in
// error.log
$_US_VERBOSE = false;

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($HTTP_POST_VARS);

/**
* Shows the user's current settings
*
*/
function edituser() 
{
    global $_TABLES, $_CONF, $LANG04, $_USER;

    $retval = '';

    $result = DB_query("SELECT fullname,cookietimeout,email,homepage,sig,emailstories,about,pgpkey,photo FROM {$_TABLES['users']},{$_TABLES['userprefs']},{$_TABLES['userinfo']} WHERE {$_TABLES['users']}.uid = {$_USER['uid']} && {$_TABLES['userprefs']}.uid = {$_USER['uid']} && {$_TABLES['userinfo']}.uid = {$_USER['uid']}");

    $A = DB_fetchArray($result);

    $retval .= COM_startBlock($LANG04[1] . ' ' . $_USER['username']);
    if ($_CONF['allow_user_photo'] == 1) {
        $retval .= '<form action="' . $_CONF['site_url'] . '/usersettings.php" method="post" enctype="multipart/form-data">';
    } else {
        $retval .= '<form action="' . $_CONF['site_url'] . '/usersettings.php" method="post">';
    }
    $retval .= '<table border="0" cellspacing="0" cellpadding="3">' . LB
        . '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG04[3] . ':</b><br><small>' . $LANG04[34] . '</small></td>' . LB
        . '<td><input type="text" name="fullname" size="60" maxlength="80" value="' . $A['fullname'] . '"></td>' . LB
        . '</tr>' . LB
        . '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG04[4] . ':</b><br><small>' . $LANG04[35] . '</small></td>' . LB
        . '<td><input type="password" name="passwd" size="32" maxlength="32" value="' . $A["passwd"] . '"></td>' . LB
        . '</tr>' . LB
        . '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG04[68] . '</b><br><small>' . $LANG04[69] . ':</small></td>' . LB
        . '<td><select name="cooktime">'
        . COM_optionList($_TABLES['cookiecodes'],'cc_value,cc_descr',$A['cookietimeout'],0)
        . '</select></td>' . LB
        . '</tr>' . LB
        . '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG04[5] . ':</b><br><small>' . $LANG04[33] . '</small></td>' . LB
        . '<td><input type="text" name="email" size="60" maxlength="96" value="' . $A['email'] . '"></td>' . LB
        . '</tr>' . LB
        . '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG04[6] . ':</b><br><small>' . $LANG04[36] . '</small></td>' . LB
        . '<td><input type="text" name="homepage" size="60" maxlength="96" value="' . COM_killJS ($A['homepage']) . '"></td>' . LB
        . '</tr>' . LB
        . '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG04[32] . ':</b><br><small>' . $LANG04[37] . '</small></td>' . LB
        . '<td><textarea name="sig" cols="60" rows="4" wrap="virtual">' . $A['sig'] . '</textarea></td>' . LB
        . '</tr>' . LB;
    if ($_CONF['allow_user_photo'] == 1) {
        $retval .= '<tr valign="top">' . LB
            . '<td align="right"><b>' . $LANG04[77] . ':</b><br><small>' . $LANG04[78] . '</small></td>' . LB
            . '<td><input type="file" name="photo">' . LB;
        if (!empty($A['photo'])) {
            $retval .= '<br><img src="' . $_CONF['site_url'] . '/images/userphotos/' . $A['photo'] . '" alt="">' . LB
                . '<br>' . $LANG04[79] . '&nbsp;<input type="checkbox" name="delete_photo">' . LB;
        }
        $retval .= '</td>' . LB
            . '</tr>' . LB;
    }
        
/* Currently Not Enabled
        
    $retval .= '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG04[13] . ':</b><br><small>' . $LANG04[53] . '</small></td>' . LB
        . '<td><select name="emailstories">'
        . COM_optionList($_TABLES['maillist'],'code,name',$A['emailstories'])
        . '</select></td>' .LB
        . '</tr>' . LB;
*/

    $result = DB_query("SELECT about,pgpkey FROM {$_TABLES['userinfo']} WHERE uid = {$_USER['uid']}");
    $A = DB_fetchArray($result);

    $retval .= '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG04[7] . ':</b><br><small>' . $LANG04[38] . '</small></td>'
        . '<td><textarea name="about" cols="60" rows="6" wrap="virtual">' . $A['about'] . '</textarea></td>'
        . '</tr>' . LB
        . '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG04[8] . ':</b><br><small>' . $LANG04[39] . '</small></td>' . LB
        . '<td><textarea name="pgpkey" cols="60" rows="6" wrap="virtual">' . $A['pgpkey'] . '</textarea></td>' . LB
        . '</tr>' . LB
        . '<tr valign="top">' . LB
        . '<td align="center" colspan="2"><input type="hidden" name="uid" value="' . $user . '">'
        . '<input type="hidden" name="mode" value="saveuser">'
        . '<input type="hidden" name="username" value="' . $_USER['username'] . '">'
        . '<input type="submit" value="' . $LANG04[9] . '"></td>' . LB
        . '</tr>' . LB
        . '</table></form>'
        . COM_endBlock();
    
    return $retval;
}

/**
* Build a list of all topics the current user has access to
*
* @return   string   List of topic IDs, separated by spaces
*
*/
function buildTopicList ()
{
    global $_TABLES;

    $topics = '';

    $result = DB_query ("SELECT tid FROM {$_TABLES['topics']}");
    $numrows = DB_numRows ($result);
    for ($i = 1; $i <= $numrows; $i++) {
        $A = DB_fetchArray ($result);
        if (SEC_hasTopicAccess ($A['tid'])) {
            if ($i > 1) {
                $topics .= ' ';
            }
            $topics .= $A['tid'];
        }
    }

    return $topics;
}

/**
* Displays user preferences
*
*/
function editpreferences() 
{
    global $_TABLES, $_CONF, $LANG04, $_USER, $_GROUPS;

    $result = DB_query("SELECT noicons,willing,dfid,tzid,noboxes,maxstories,tids,aids,boxes FROM {$_TABLES['userprefs']},{$_TABLES['userindex']} WHERE {$_TABLES['userindex']}.uid = {$_USER['uid']} AND {$_TABLES['userprefs']}.uid = {$_USER['uid']}");

    $A = DB_fetchArray($result);

    // if 'maxstories' is empty (for a new user account) set it to the
    // default value from config.php
    if (empty($A['maxstories'])) {
        $A['maxstories'] = $_CONF['limitnews'];
    } else if ($A['maxstories'] < $_CONF['minnews']) {
        $A['maxstories'] = $_CONF['minnews'];
    }

    $preferences = new Template ($_CONF['path_layout'] . 'preferences');
    $preferences->set_file (array ('prefs' => 'displayprefs.thtml',
                                   'display' => 'displayblock.thtml',
                                   'exclude' => 'excludeblock.thtml',
                                   'digest' => 'digestblock.thtml',
                                   'boxes' => 'boxesblock.thtml',
                                   'language' => 'language.thtml',
                                   'theme' => 'theme.thtml'
                                  ));
    $preferences->set_var ('site_url', $_CONF['site_url']);
    $preferences->set_var ('layout_url', $_CONF['layout_url']);

    $preferences->set_var ('user_name', $_USER['username']);

    $preferences->set_var ('lang_language', $LANG04[73]);
    $preferences->set_var ('lang_theme', $LANG04[72]);
    $preferences->set_var ('lang_theme_text', $LANG04[74]);
    $preferences->set_var ('lang_noicons', $LANG04[40]);
    $preferences->set_var ('lang_noicons_text', $LANG04[49]);
    $preferences->set_var ('lang_noboxes', $LANG04[44]);
    $preferences->set_var ('lang_noboxes_text', $LANG04[51]);
    $preferences->set_var ('lang_maxstories', $LANG04[43]);
    if (strpos ($LANG04[52], '%d') === false) {
        $maxtext = $LANG04[52] . ' ' . $_CONF['limitnews'];
    } else {
        $maxtext = sprintf ($LANG04[52], $_CONF['limitnews']);
    }
    $preferences->set_var ('lang_maxstories_text', $maxtext);
    $preferences->set_var ('lang_dateformat', $LANG04[42]);
    $preferences->set_var ('lang_excludeditems', $LANG04[54]);
    $preferences->set_var ('lang_topics', $LANG04[48]);
    $preferences->set_var ('lang_authors', $LANG04[56]);
    $preferences->set_var ('lang_emailedtopics', $LANG04[76]);
    $preferences->set_var ('lang_boxes', $LANG04[55]);
    $preferences->set_var ('lang_submit', $LANG04[9]);

    $preferences->set_var ('start_block_display',
            COM_startBlock ($LANG04[45] . ' ' . $_USER['username']));
    $preferences->set_var ('start_block_exclude',
            COM_startBlock ($LANG04[46] . ' ' . $_USER['username']));
    $preferences->set_var ('start_block_digest',
            COM_startBlock ($LANG04[75] . ' ' . $_USER['username']));
    $preferences->set_var ('start_block_boxes',
            COM_startBlock ($LANG04[47] . ' ' . $_USER['username']));
    $preferences->set_var ('end_block', COM_endBlock ());

    if ($_CONF['allow_user_language'] == 1) {
        $selection = '<select name="language">' . LB;

        if (empty($_USER['language'])) {
            $userlang = $_CONF['language'];
        } else {
            $userlang = $_USER['language'];
        }

        // Get available languages
        $language_options = '';
        $fd = opendir ($_CONF['path_language']);
        while (($file = @readdir ($fd)) !== false) {
            if (is_file ($_CONF['path_language'] . $file)) {
                clearstatcache ();
                $file = str_replace ('.php', '', $file);
                $language_options .= '<option value="' . $file . '"';
                if ($userlang == $file) {
                    $language_options .= ' selected="SELECTED"';
                }
                $uscore = strpos ($file, '_');
                if ($uscore !== false) {
                    $lngname = substr ($file, 0, $uscore);
                    $lngadd = substr ($file, $uscore + 1);
                    $lngname = strtoupper ($lngname{0}) . substr ($lngname, 1);
                    $lngadd = strtoupper ($lngadd{0}) . substr ($lngadd, 1);
                    $file = $lngname . ' (' . $lngadd . ')';
                } else {
                    $file = strtoupper ($file{0}) . substr ($file, 1);
                }
                $language_options .= '>' . $file . '</option>' . LB;
            }
        }
        $selection .= $language_options;
        $selection .= '</select>';
        $preferences->set_var ('language_selector', $selection);
        $preferences->parse ('language_selection', 'language', true);
    } else {
        $preferences->set_var ('language_selection', '');
    }

    if ($_CONF['allow_user_themes'] == 1) {
        $selection = '<select name="theme">' . LB;

        if (empty ($_USER['theme'])) {
            $usertheme = $_CONF['theme'];
        } else {
            $usertheme = $_USER['theme'];
        }

        $themes = COM_getThemes ();
        for ($i = 1; $i <= count ($themes); $i++) {
            $selection .= '<option value="' . current ($themes) . '"';
            if ($usertheme == current ($themes)) {
                $selection .= ' selected="SELECTED"';
            }
            // some theme name beautifying ...
            $th = str_replace ('_', ' ', current ($themes));
            if ((strtolower ($th{0}) == $th{0}) &&
                (strtolower ($th{1}) == $th{1})) {
                $th = strtoupper ($th{0}) . substr ($th, 1);
            }
            $selection .= '>' . $th . '</option>' . LB;
            next ($themes);
        }
        $selection .= '</select>';
        $preferences->set_var ('theme_selector', $selection);
        $preferences->parse ('theme_selection', 'theme', true);
    } else {
        $preferences->set_var ('theme_selection', '');
    }

    if ($A['noicons'] == '1') {
        $preferences->set_var ('noicons_checked', 'checked="checked"');
    } else {
        $preferences->set_var ('noicons_checked', '');
    }

    if ($A['noboxes'] == 1) {
        $preferences->set_var ('noboxes_checked', 'checked="checked"');
    } else {
        $preferences->set_var ('noboxes_checked', '');
    }

    $preferences->set_var ('maxstories_value', $A['maxstories']);
    $selection = '<select name="dfid">' . LB
               . COM_optionList ($_TABLES['dateformats'], 'dfid,description',
                                 $A['dfid']) . '</select>';
    $preferences->set_var ('dateformat_selection', $selection);
    $preferences->parse ('display_block', 'display', true);

    $groupList = '';
    if (!empty ($_USER['uid'])) {
        foreach ($_GROUPS as $grp) {
            $groupList .= $grp . ',';
        }
        $groupList = substr ($groupList, 0, -1);
    }

    $permissions = '';
    if (!empty ($_USER['uid'])) {
        $permissions .= "(owner_id = {$_USER['uid']} AND perm_owner >= 2) OR ";
        $permissions .= "(group_id IN ($groupList) AND perm_group >= 2) OR ";
        $permissions .= "(perm_members >= 2) OR "; 
    }
    $permissions .= "(perm_anon >= 2)";

    $preferences->set_var ('exclude_topic_checklist',
        COM_checkList($_TABLES['topics'],'tid,topic',$permissions,$A['tids']));

    if ($_CONF['contributedbyline'] == 1) {
        $result = DB_query ("SELECT DISTINCT uid FROM {$_TABLES['stories']}");
        $nrows = DB_numRows ($result);
        unset ($where);
        for ($i = 0; $i < $nrows; $i++) {
            $W = DB_fetchArray ($result);
            $where .= "uid = '$W[0]' OR ";
        }
        $where .= "uid = '1'";
        $preferences->set_var ('exclude_author_checklist',
            COM_checkList($_TABLES['users'],'uid,username',$where,$A['aids']));
    } else {
        $preferences->set_var ('exclude_author_checklist', '');
    }
    $preferences->parse ('exclude_block', 'exclude', true);

    if ($_CONF['emailstories'] == 1) {
        $user_etids = DB_getItem ($_TABLES['userindex'], 'etids',
                                  "uid = {$_USER['uid']}");
        if (empty ($user_etids)) { // an empty string now means "all topics"
            $user_etids = buildTopicList ();
        } elseif ($user_etids == '-') { // this means "no topics"
            $user_etids = '';
        }
        $tmp = COM_checkList ($_TABLES['topics'], 'tid,topic', $permissions,
                              $user_etids);
        $preferences->set_var ('email_topic_checklist',
                str_replace ($_TABLES['topics'], 'etids', $tmp));
        $preferences->parse ('digest_block', 'digest', true);
    } else {
        $preferences->set_var ('digest_block', '');
    }

    $selectedblock = '';
    if (strlen($A['boxes']) > 0) {
        $blockresult = DB_query("SELECT bid FROM {$_TABLES['blocks']} WHERE bid NOT IN (" . str_replace(' ',',',$A['boxes']) . ")");
        for ($x = 1; $x <= DB_numRows($blockresult); $x++) {
            $row = DB_fetchArray($blockresult);
            $selectedblocks .= $row['bid'];
            if ($x <> DB_numRows($blockresult)) {
                $selectedblocks .= ' ';
            }
        }
    }
    $whereblock = "(" . $permissions . ") AND ((type != 'layout' AND type != 'gldefault' AND is_enabled = 1) OR (type = 'gldefault' AND is_enabled = 1 AND name IN ('whats_new_block','poll_block','events_block','older_stories'))) ORDER BY onleft desc,blockorder,title";
    $preferences->set_var ('boxes_checklist', COM_checkList ($_TABLES['blocks'],
            'bid,title,blockorder', $whereblock, $selectedblocks));
    $preferences->parse ('boxes_block', 'boxes', true);

    return $preferences->finish ($preferences->parse ('output', 'prefs'));
}

/**
* Shows comment preferences form
*
*/
function editcommentprefs() 
{
    global $_TABLES, $_CONF, $LANG04, $_USER;

    $retval = ''; 
    $result = DB_query("SELECT commentmode,commentorder,commentlimit FROM {$_TABLES['usercomment']} WHERE uid = {$_USER['uid']}");
    $A = DB_fetchArray($result);

    if (empty($A["commentmode"])) {
        $A["commentmode"] = $_CONF['comment_mode'];
    }       
    if (empty($A["commentorder"])) $A["commentorder"] = 0;
    if (empty($A["commentlimit"])) $A["commentlimit"] = 100;
    $retval .= COM_startBlock($LANG04[64] . ' ' . $_USER['username']);
    $retval .= '<form action="' . $_CONF['site_url'] . '/usersettings.php" method="post">' . LB;
    $retval .= '<table border="0" cellspacing="0" cellpadding=3>' . LB;
    $retval .= '<tr valign="top"><td align="right"><b>' . $LANG04[57] . ':</b><br><small>' . $LANG04[60] 
        . '</small></td><td><select name="commentmode">';
    $retval .= COM_optionList($_TABLES['commentmodes'],'mode,name',$A['commentmode']);
    $retval .= '</select></td></tr>';
    $retval .= '<tr valign="top"><td align="right"><b>' . $LANG04[58] . ':</b><br><small>' . $LANG04[61]
        . '</small></td><td><select name="commentorder">';
    $retval .= COM_optionList($_TABLES['sortcodes'],'code,name',$A['commentorder']);
    $retval .= '</select></td></tr>';
    $retval .= '<tr valign="top"><td align="right"><b>' . $LANG04[59] . ':</b><br><small>'
        . $LANG04[62] . '</small></td><td>';
    $retval .= '<input type="text" size="5" maxlength="5" name="commentlimit" value="' . $A['commentlimit']
        . '"></td></tr>' . LB;
    $retval .= '<tr><td align="right" colspan="2"><input type="hidden" name="mode" value="savecomments">';
    $retval .= '<input type="submit" value="' . $LANG04[9] . '"></td></tr>' . LB;
    $retval .= '</table></form>';
    $retval .= COM_endBlock();

    return $retval;
}

/**
* Saves the user's information back to the database
*
* @A        array       User's data
*
*/
function saveuser($A) 
{
    global $_TABLES, $_CONF, $_USER, $_US_VERBOSE, $HTTP_POST_FILES;

    if ($_US_VERBOSE) {
        COM_errorLog('**** Inside saveuser in usersettings.php ****', 1);
    } 

    if (!empty($A["passwd"])) {
        $passwd = md5($A["passwd"]);
        DB_change($_TABLES['users'],'passwd',"$passwd","uid",$_USER['uid']);
    }

    $A['fullname'] = strip_tags (COM_stripslashes ($A['fullname']));
    $A['email'] = strip_tags (COM_stripslashes ($A['email']));
    $A['homepage'] = COM_killJS(strip_tags (COM_stripslashes ($A['homepage'])));
    $A['sig'] = strip_tags (COM_stripslashes ($A['sig']));
    $A['about'] = strip_tags (COM_stripslashes ($A['about']));
    $A['pgpkey'] = strip_tags (COM_stripslashes ($A['pgpkey']));

    if (COM_isEmail($A['email'])) {
        if ($_US_VERBOSE) {
            COM_errorLog('cooktime = ' . $A['cooktime'],1);
        }

        if ($A['cooktime'] <= 0) {
            $A['cooktime'] = 'NULL';
            $cooktime = 1000;
            setcookie($_CONF['cookie_name'],$_USER['uid'],time() - $cooktime,$_CONF['cookie_path']);    
        } else {
            setcookie($_CONF['cookie_name'],$_USER['uid'],time() + $A['cooktime'],$_CONF['cookie_path']);   
        }

        if ($_CONF['allow_user_photo'] == 1) {
            include_once($_CONF['path_system'] . 'classes/upload.class.php');
            $upload = new upload();
            if (!empty($_CONF['image_lib'])) {
                if ($_CONF['image_lib'] == 'imagemagick') {
                    // Using imagemagick
                    $upload->setMogrifyPath ($_CONF['path_to_mogrify']);
                } else {
                    // must be using netPBM
                    $upload->_pathToNetPBM= $_CONF['path_to_netpbm'];
                }
                $upload->setAutomaticResize(true);
            }
            $upload->setAllowedMimeTypes(array('image/gif','image/jpeg','image/pjpeg','image/x-png','image/png'));
            if (!$upload->setPath($_CONF['path_html'] . 'images/userphotos')) {
                print 'File Upload Errors:<BR>' . $upload->printErrors();
                exit;
            }
            if ($upload->numFiles() == 1) {
                $curfile = current($HTTP_POST_FILES);
                if (strlen($curfile['name']) > 0) {
                    $pos = strrpos($curfile['name'],'.') + 1;
                    $fextension = substr($curfile['name'], $pos);
                    $filename = $_USER['username'] . '.' . $fextension;
                    $upload->setFileNames($filename);
                    $upload->setPerms('0644');
                    if (($_CONF['max_photo_width'] > 0) &&
                        ($_CONF['max_photo_height'] > 0)) {
                        $upload->setMaxDimensions ($_CONF['max_photo_width'],
                                                   $_CONF['max_photo_height']);
                    } else {
                        $upload->setMaxDimensions ($_CONF['max_image_width'],
                                                   $_CONF['max_image_height']);
                    }
                    if ($_CONF['max_photo_size'] > 0) {
                        $upload->setMaxFileSize($_CONF['max_photo_size']);
                    } else {
                        $upload->setMaxFileSize($_CONF['max_image_size']);
                    }
                    reset($HTTP_POST_FILES);
                    $upload->uploadFiles();
                    if ($upload->areErrors()) {
                       print "ERRORS<BR>";
                       $upload->printErrors();
                       exit; 
                    }
                } else {
                    $filename = '';
                }
            } else {
                $curphoto = DB_getItem($_TABLES['users'],'photo',"uid = {$_USER['uid']}");
                if (!empty($curphoto) AND $A['delete_photo'] == 'on') {
                    $filetodelete = $_CONF['path_html'] . 'images/userphotos/' . $curphoto;
                    if (!unlink($filetodelete)) {
                        echo COM_errorLog("Unable to remove file $filetodelete");
                        exit;
                    }
                    $curphoto = '';
                }
                $filename = $curphoto;
            }
        }

        if (!empty ($A['homepage'])) {
            $pos = strpos ($A['homepage'], ':');
            if ($pos === false) {
                $A['homepage'] = 'http://' . $A['homepage'];
            }
            else {
                $prot = substr ($A['homepage'], 0, $pos + 1);
                if (($prot != 'http:') && ($prot != 'https:')) {
                    $A['homepage'] = 'http:' . substr ($A['homepage'], $pos + 1);
                }
            }
            $A['homepage'] = addslashes ($A['homepage']); 
        }

        $A['fullname'] = addslashes ($A['fullname']);
        $A['email'] = addslashes ($A['email']);
        $A['sig'] = addslashes ($A['sig']);
        $A['about'] = addslashes ($A['about']);
        $A['pgpkey'] = addslashes ($A['pgpkey']);

        DB_query("UPDATE {$_TABLES['users']} SET fullname='{$A["fullname"]}',email='{$A["email"]}',homepage='{$A["homepage"]}',sig='{$A["sig"]}',cookietimeout={$A["cooktime"]},photo='$filename' WHERE uid={$_USER['uid']}");
        DB_query("UPDATE {$_TABLES['userprefs']} SET emailstories='{$A["emailstories"]}' WHERE uid={$_USER['uid']}");
        DB_query("UPDATE {$_TABLES['userinfo']} SET pgpkey='" . $A["pgpkey"] . "',about='{$A["about"]}' WHERE uid={$_USER['uid']}");

        if ($_US_VERBOSE) {
            COM_errorLog('**** Leaving saveuser in usersettings.php ****', 1);
        }

        return COM_refresh("{$_CONF['site_url']}/usersettings.php?mode=edit&msg=5");
    }
}

/**
* Saves user's perferences back to the database
*
* @A        array       User's data to save
*
*/
function savepreferences($A) 
{
    global $_TABLES, $_CONF, $_USER;

    if ($A['noicons'] == 'on') $A['noicons'] = 1;
    if ($A["willing"] == 'on') $A["willing"] = 1;
    if ($A['noboxes'] == 'on') $A['noboxes'] = 1;
    /*echo 'user max = ' . $A['maxstories'] . '<br>';
    echo 'conf min = ' . $_CONF['minnews'] . '<br>';
    exit;*/
    if ($A['maxstories'] < $_CONF['minnews']) {
        $A['maxstories'] = $_CONF['minnews'];
    }

    unset($tids);
    unset($aids);
    unset($boxes);
    unset($etids);

    $TIDS = @array_values($A[$_TABLES['topics']]);
    $AIDS = @array_values($A[$_TABLES['users']]);
    $BOXES = @array_values($A["{$_TABLES['blocks']}"]);
    $ETIDS = @array_values($A['etids']);
    
    if (sizeof($TIDS) > 0) {
        for ($i = 0; $i < sizeof($TIDS); $i++) {
            $tids .= $TIDS[$i] . ' ';
        }
    }
    if (sizeof($AIDS) > 0) {
        for ($i = 0; $i < sizeof($AIDS); $i++) {
            $aids .= $AIDS[$i] . ' ';
        }
    }
    if (count($BOXES) > 0) {
        for ($i = 1; $i <= count($BOXES); $i++) {
            $boxes .= current($BOXES); 
            if ($i <> count($BOXES)) {
                $boxes .= ',';
            }
            next($BOXES);
        }
        $blockresult = DB_query("SELECT bid,name FROM {$_TABLES['blocks']} WHERE bid NOT IN ($boxes)");
        $selectedblocks = '';
        for ($x = 1; $x <= DB_numRows($blockresult); $x++) {
            $row = DB_fetchArray($blockresult);
            if ($row['name'] <> 'user_block' AND $row['name'] <> 'admin_block' AND $row['name'] <> 'section_block') {
                $selectedblocks .= $row['bid'];
                if ($x <> DB_numRows($blockresult)) {
                    $selectedblocks .= ' ';
                }
            }
        }
    } 

    if (sizeof($ETIDS) > 0) {
        for ($i = 0; $i < sizeof($ETIDS); $i++) {
            $etids .= $ETIDS[$i] . " ";
        }
    }
    
    // Save theme, when doing so, put in cookie so we can set the user's theme even when they aren't logged in
    DB_query("UPDATE {$_TABLES['users']} SET theme='{$A["theme"]}',language='{$A["language"]}' WHERE uid = {$_USER['uid']}");
    setcookie($_CONF['cookie_theme'],$A['theme'],time() + 31536000,$_CONF['cookie_path']); 
    setcookie($_CONF['cookie_language'],$A['language'],time() + 31536000,$_CONF['cookie_path']);   
    
    DB_query("UPDATE {$_TABLES['userprefs']} SET noicons='{$A['noicons']}', willing='{$A["willing"]}', dfid='{$A["dfid"]}', tzid='{$A["tzid"]}' WHERE uid='{$_USER['uid']}'");

    if (empty ($etids)) {
        $etids = '-';
    }
    DB_save($_TABLES['userindex'],"uid,tids,aids,boxes,noboxes,maxstories,etids","'{$_USER['uid']}','$tids','$aids','$selectedblocks','{$A['noboxes']}',{$A['maxstories']},'$etids'",$_CONF['site_url'] . "/usersettings.php?mode=preferences&msg=6");

}

// MAIN
if (isset ($HTTP_POST_VARS['mode'])) {
    $mode = $HTTP_POST_VARS['mode'];
}
else if (isset ($HTTP_GET_VARS['mode'])) {
    $mode = $HTTP_GET_VARS['mode'];
}
$display = '';

if (!empty($_USER['username']) && !empty($mode)) {
    switch ($mode) {
    case 'preferences':
        $display .= COM_siteHeader('menu');
        $display .= COM_showMessage($HTTP_GET_VARS['msg']);
        $display .= editpreferences();
        $display .= COM_siteFooter();
        break;
    case 'comments':
        $display .= COM_siteHeader('menu');
        $display .= COM_showMessage($HTTP_GET_VARS['msg']);
        $display .= editcommentprefs();
        $display .= COM_siteFooter();
        break;
    case 'edit':
        $display .= COM_siteHeader('menu');
        $display .= COM_showMessage($HTTP_GET_VARS['msg']);
        $display .= edituser();
        $display .= COM_siteFooter();
        break;
    case 'saveuser':
        $display .= saveuser($HTTP_POST_VARS);
        break;
    case 'savepreferences':
        savepreferences($HTTP_POST_VARS);
        break;
    case 'savecomments':
        DB_save($_TABLES['usercomment'],'uid,commentmode,commentorder,commentlimit',"'{$_USER['uid']}','{$HTTP_POST_VARS['commentmode']}','{$HTTP_POST_VARS['commentorder']}','{$HTTP_POST_VARS['commentlimit']}'",$_CONF['site_url'] . "/usersettings.php?mode=comments&msg=7");
        break;
    }
} else {
    if ($mode == 'preferences') {
        $display .= COM_siteHeader('menu');
        $display .= COM_startBlock($LANG04[70] . '!');
        $display .= '<br>' . $LANG04[71] . '<br><br>';
        $display .= COM_endBlock();
    $display .= COM_siteFooter();
    } else {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    }
}

echo $display;

?>
