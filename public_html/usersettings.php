<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | usersettings.php                                                          |
// | Geeklog user settings page.                                               |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@users.sourceforge.net                |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
// |          Dirk Haun        - dirk@haun-online.de                           |
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
// $Id: usersettings.php,v 1.70 2003/08/04 12:11:52 dhaun Exp $

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

	// Call custom account form and edit function if enabled and exists
	if ($_CONF['custom_registration'] AND (function_exists(custom_userform))) {
        return custom_userform('edit',$_USER['uid']);
	} 
    $result = DB_query("SELECT fullname,cookietimeout,email,homepage,sig,emailstories,about,pgpkey,photo FROM {$_TABLES['users']},{$_TABLES['userprefs']},{$_TABLES['userinfo']} WHERE {$_TABLES['users']}.uid = {$_USER['uid']} && {$_TABLES['userprefs']}.uid = {$_USER['uid']} && {$_TABLES['userinfo']}.uid = {$_USER['uid']}");
    $A = DB_fetchArray($result);
    if ($A['cookietimeout'] == 0) {
        $A['cookietimeout'] = $_CONF['default_perm_cookie_timeout'];
    }

    $preferences = new Template ($_CONF['path_layout'] . 'preferences');
    $preferences->set_file (array ('profile' => 'profile.thtml',
                                   'photo' => 'userphoto.thtml',
                                   'username' => 'username.thtml',
                                   'deleteaccount' => 'deleteaccount.thtml'));
    $preferences->set_var ('site_url', $_CONF['site_url']);
    $preferences->set_var ('layout_url', $_CONF['layout_url']);

    $preferences->set_var ('lang_fullname', $LANG04[3]);
    $preferences->set_var ('lang_fullname_text', $LANG04[34]);
    $preferences->set_var ('lang_username', $LANG04[2]);
    $preferences->set_var ('lang_username_text', $LANG04[87]);
    $preferences->set_var ('lang_password', $LANG04[4]);
    $preferences->set_var ('lang_password_text', $LANG04[35]);
    $preferences->set_var ('lang_cooktime', $LANG04[68]);
    $preferences->set_var ('lang_cooktime_text', $LANG04[69]);
    $preferences->set_var ('lang_email', $LANG04[5]);
    $preferences->set_var ('lang_email_text', $LANG04[33]);
    $preferences->set_var ('lang_homepage', $LANG04[6]);
    $preferences->set_var ('lang_homepage_text', $LANG04[36]);
    $preferences->set_var ('lang_signature', $LANG04[32]);
    $preferences->set_var ('lang_signature_text', $LANG04[37]);
    $preferences->set_var ('lang_userphoto', $LANG04[77]);
    $preferences->set_var ('lang_userphoto_text', $LANG04[78]);
    $preferences->set_var ('lang_about', $LANG04[7]);
    $preferences->set_var ('lang_about_text', $LANG04[38]);
    $preferences->set_var ('lang_pgpkey', $LANG04[8]);
    $preferences->set_var ('lang_pgpkey_text', $LANG04[39]);
    $preferences->set_var ('lang_submit', $LANG04[9]);

    $preferences->set_var ('start_block_profile',
            COM_startBlock ($LANG04[1] . ' ' . $_USER['username']));
    $preferences->set_var ('end_block', COM_endBlock ());

    $preferences->set_var ('profile_headline',
                           $LANG04[1] . ' ' . $_USER['username']);

    if ($_CONF['allow_user_photo'] == 1) {
        $preferences->set_var ('enctype', 'enctype="multipart/form-data"');
    } else {
        $preferences->set_var ('enctype', '');
    }
    $preferences->set_var ('fullname_value', $A['fullname']);
    $preferences->set_var ('new_username_value', $_USER['username']);
    $preferences->set_var ('password_value', $A['passwd']);
    if ($_CONF['allow_username_change'] == 1) {
        $preferences->parse ('username_option', 'username', true);
    } else {
        $preferences->set_var ('username_option', '');
    }

    $selection = '<select name="cooktime">' . LB;
    $selection .= COM_optionList ($_TABLES['cookiecodes'], 'cc_value,cc_descr',
                                  $A['cookietimeout'], 0);
    $selection .= '</select>';
    $preferences->set_var ('cooktime_selector', $selection);

    $preferences->set_var ('email_value', $A['email']);
    $preferences->set_var ('homepage_value', COM_killJS ($A['homepage']));
    $preferences->set_var ('signature_value', $A['sig']);

    if ($_CONF['allow_user_photo'] == 1) {
        if (!empty ($A['photo'])) {
            if (!empty ($A['fullname'])) {
                $alt = '[' . $A['fullname'] . ']';
            } else {
                $alt = '[' . $A['username'] . ']';
            }
            $photo .= '<br><img src="' . $_CONF['site_url']
                   . '/images/userphotos/' . $A['photo'] . '" alt="' . $alt
                   . '">' . LB . '<br>' . $LANG04[79]
                   . '&nbsp;<input type="checkbox" name="delete_photo">' . LB;
            $preferences->set_var ('display_photo', $photo);
        }
        $preferences->parse ('userphoto_option', 'photo', true);
    } else {
        $preferences->set_var ('userphoto_option', '');
    }

    $result = DB_query("SELECT about,pgpkey FROM {$_TABLES['userinfo']} WHERE uid = {$_USER['uid']}");
    $A = DB_fetchArray($result);

    $preferences->set_var ('about_value', $A['about']);
    $preferences->set_var ('pgpkey_value', $A['pgpkey']);
    $preferences->set_var ('uid_value', $_USER['uid']);
    $preferences->set_var ('username_value', $_USER['username']);

    if ($_CONF['allow_account_delete'] == 1) {
        $preferences->set_var ('start_block_delete_account',
                COM_startBlock (sprintf ($LANG04[94], $_USER['username'])));
        $preferences->set_var ('end_block_delete_account', COM_endBlock ());
        $preferences->set_var ('delete_text', $LANG04[95]);
        $preferences->set_var ('lang_button_delete', $LANG04[96]);
        $preferences->set_var ('delete_mode', 'confirmdelete');
        $preferences->set_var ('account_id', $_USER['uid']);
        $preferences->parse ('delete_account_option', 'deleteaccount', false);
    } else {
        $preferences->set_var ('delete_account_option', '');
    }

    PLG_profileVariablesEdit ($_USER['uid'], $preferences);

    $retval = $preferences->finish ($preferences->parse ('output', 'profile'));
    $retval .= PLG_profileBlocksEdit ($_USER['uid']);

    return $retval;
}

/**
* Ask user for confirmation to delete his/her account.
*
* @param    int      account_id   uid of account to delete (must match current user's uid)
* @return   string   confirmation form
*
*/
function confirmAccountDelete ($account_id)
{
    global $_CONF, $_USER, $LANG04;

    if ($account_id != $_USER['uid']) {
        // now that doesn't look right - abort ...
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    $retval = '';

    $confirm = new Template ($_CONF['path_layout'] . 'preferences');
    $confirm->set_file (array ('deleteaccount' => 'deleteaccount.thtml'));
    $confirm->set_var ('site_url', $_CONF['site_url']);
    $confirm->set_var ('layout_url', $_CONF['layout_url']);

    $confirm->set_var ('start_block_delete_account',
            COM_startBlock (sprintf ($LANG04[94], $_USER['username'])));
    $confirm->set_var ('end_block_delete_account', COM_endBlock ());
    $confirm->set_var ('delete_text', $LANG04[95]);
    $confirm->set_var ('lang_button_delete', $LANG04[96]);
    $confirm->set_var ('delete_mode', 'deleteconfirmed');
    $confirm->set_var ('account_id', $_USER['uid']);

    $retval .= COM_siteHeader ('menu');
    $retval .= COM_startBlock ($LANG04[97], '',
                               COM_getBlockTemplate ('_msg_block', 'header'));
    $retval .= $LANG04[98];
    $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $retval .= $confirm->finish ($confirm->parse ('output', 'deleteaccount'));
    $retval .= COM_siteFooter ();

    return $retval;
}

/**
* Delete an account (keep in sync with delete_user() in admin/user.php).
*
* @param    uid      int   uid of account to delete
* @return   string   redirection to main page (+ success msg)
*
*/
function deleteUserAccount ($uid)
{
    global $_CONF, $_TABLES, $_USER;

    if ($uid != $_USER['uid']) {
        // now that doesn't look right - abort ...
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    // log the user out
    SESS_endUserSession ($_USER['uid']);

    // Ok, delete everything related to this user

    // first, remove from all security groups
    DB_delete ($_TABLES['group_assignments'], 'ug_uid', $uid);

    // remove user information and preferences
    DB_delete ($_TABLES['userprefs'], 'uid', $uid);
    DB_delete ($_TABLES['userindex'], 'uid', $uid);
    DB_delete ($_TABLES['usercomment'], 'uid', $uid);
    DB_delete ($_TABLES['userinfo'], 'uid', $uid);

    // Call custom account profile delete function if enabled and exists
    if ($_CONF['custom_registration'] AND function_exists (custom_userdelete)) {
        custom_userdelete ($uid);
    }

    // let plugins update their data for this user
    PLG_deleteUser ($uid);

    // avoid having orphand stories/comments by making them anonymous posts
    DB_query ("UPDATE {$_TABLES['comments']} SET uid = 1 WHERE uid = $uid");
    DB_query ("UPDATE {$_TABLES['stories']} SET uid = 1 WHERE uid = $uid");

    // now delete the user itself
    DB_delete ($_TABLES['users'], 'uid', $uid);

    return COM_refresh ($_CONF['site_url'] . '/index.php?msg=57');
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

    $result = DB_query("SELECT noicons,willing,dfid,tzid,noboxes,maxstories,tids,aids,boxes,emailfromadmin,emailfromuser,showonline FROM {$_TABLES['userprefs']},{$_TABLES['userindex']} WHERE {$_TABLES['userindex']}.uid = {$_USER['uid']} AND {$_TABLES['userprefs']}.uid = {$_USER['uid']}");

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
                                   'comment' => 'commentblock.thtml',
                                   'language' => 'language.thtml',
                                   'theme' => 'theme.thtml',
                                   'privacy' => 'privacyblock.thtml'
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
    $preferences->set_var ('lang_emailedtopics', $LANG04[76]);
    $preferences->set_var ('lang_boxes', $LANG04[55]);
    $preferences->set_var ('lang_displaymode', $LANG04[57]);
    $preferences->set_var ('lang_displaymode_text', $LANG04[60]);
    $preferences->set_var ('lang_sortorder', $LANG04[58]);
    $preferences->set_var ('lang_sortorder_text', $LANG04[61]);
    $preferences->set_var ('lang_commentlimit', $LANG04[59]);
    $preferences->set_var ('lang_commentlimit_text', $LANG04[62]);
    $preferences->set_var ('lang_emailfromadmin', $LANG04[100]);
    $preferences->set_var ('lang_emailfromadmin_text', $LANG04[101]);
    $preferences->set_var ('lang_emailfromuser', $LANG04[102]);
    $preferences->set_var ('lang_emailfromuser_text', $LANG04[103]);
    $preferences->set_var ('lang_showonline', $LANG04[104]);
    $preferences->set_var ('lang_showonline_text', $LANG04[105]);
    $preferences->set_var ('lang_submit', $LANG04[9]);

    $preferences->set_var ('start_block_display',
            COM_startBlock ($LANG04[45] . ' ' . $_USER['username']));
    $preferences->set_var ('start_block_exclude',
            COM_startBlock ($LANG04[46] . ' ' . $_USER['username']));
    $preferences->set_var ('start_block_digest',
            COM_startBlock ($LANG04[75] . ' ' . $_USER['username']));
    $preferences->set_var ('start_block_boxes',
            COM_startBlock ($LANG04[47] . ' ' . $_USER['username']));
    $preferences->set_var ('start_block_comment',
            COM_startBlock ($LANG04[64] . ' ' . $_USER['username']));
    $preferences->set_var ('start_block_privacy',
            COM_startBlock ($LANG04[99] . ' ' . $_USER['username']));
    $preferences->set_var ('end_block', COM_endBlock ());

    $preferences->set_var ('display_headline',
                           $LANG04[45] . ' ' . $_USER['username']);
    $preferences->set_var ('exclude_headline',
                           $LANG04[46] . ' ' . $_USER['username']);
    $preferences->set_var ('digest_headline',
                           $LANG04[75] . ' ' . $_USER['username']);
    $preferences->set_var ('boxes_headline',
                           $LANG04[47] . ' ' . $_USER['username']);
    $preferences->set_var ('comment_headline',
                           $LANG04[64] . ' ' . $_USER['username']);
    $preferences->set_var ('privacy_headline',
                           $LANG04[99] . ' ' . $_USER['username']);

    // display preferences block
    if ($_CONF['allow_user_language'] == 1) {

        if (empty($_USER['language'])) {
            $userlang = $_CONF['language'];
        } else {
            $userlang = $_USER['language'];
        }

        // Get available languages
        $language = array ();
        $fd = opendir ($_CONF['path_language']);
        while (($file = @readdir ($fd)) !== false) {
            if ((substr ($file, 0, 1) != '.') && preg_match ('/\.php$/i', $file)
                    && is_file ($_CONF['path_language'] . $file)) {
                clearstatcache ();
                $file = str_replace ('.php', '', $file);
                $uscore = strpos ($file, '_');
                if ($uscore === false) {
                    $lngname = ucfirst ($file);
                } else {
                    $lngname = ucfirst (substr ($file, 0, $uscore));
                    $lngadd = ucfirst (substr ($file, $uscore + 1));
                    $lngname .= ' (' . $lngadd . ')';
                }
                $language[$file] = $lngname;
            }
        }
        asort ($language);
        $selection = '<select name="language">' . LB;
        foreach ($language as $langFile => $langName) {
            $selection .= '<option value="' . $langFile . '"';
            if ($userlang == $langFile) {
                $selection .= ' selected="selected"';
            }
            $selection .= '>' . $langName . '</option>' . LB;
        }
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

        $themeFiles = COM_getThemes ();
        // first, some theme name beautifying ...
        $themes = array ();
        foreach ($themeFiles as $themeFile) {
            $themeName = str_replace ('_', ' ', $themeFile);
            $themes[$themeFile] = ucwords ($themeName);
        }
        asort ($themes);
        foreach ($themes as $themeFile => $themeName) {
            $selection .= '<option value="' . $themeFile . '"';
            if ($usertheme == $themeFile) {
                $selection .= ' selected="selected"';
            }
            $selection .= '>' . $themeName . '</option>' . LB;
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
    $preferences->set_var ('dateformat_selector', $selection);
    $preferences->parse ('display_block', 'display', true);

    // privacy options block
    if ($A['emailfromadmin'] == 1) {
        $preferences->set_var ('emailfromadmin_checked', 'checked="checked"');
    } else {
        $preferences->set_var ('emailfromadmin_checked', '');
    }
    if ($A['emailfromuser'] == 1) {
        $preferences->set_var ('emailfromuser_checked', 'checked="checked"');
    } else {
        $preferences->set_var ('emailfromuser_checked', '');
    }
    if ($A['showonline'] == 1) {
        $preferences->set_var ('showonline_checked', 'checked="checked"');
    } else {
        $preferences->set_var ('showonline_checked', '');
    }
    $preferences->parse ('privacy_block', 'privacy', true);

    // excluded items block
    $permissions = COM_getPermSQL ('');
    $preferences->set_var ('exclude_topic_checklist',
        COM_checkList($_TABLES['topics'],'tid,topic',$permissions,$A['tids']));

    if (($_CONF['contributedbyline'] == 1) &&
        ($_CONF['hide_author_exclusion'] == 0)) {
        $result = DB_query ("SELECT DISTINCT uid FROM {$_TABLES['stories']}");
        $nrows = DB_numRows ($result);
        unset ($where);
        for ($i = 0; $i < $nrows; $i++) {
            $W = DB_fetchArray ($result);
            $where .= "uid = '$W[0]' OR ";
        }
        $where .= "uid = '1'";
        $preferences->set_var ('lang_authors', $LANG04[56]);
        $preferences->set_var ('exclude_author_checklist',
            COM_checkList($_TABLES['users'],'uid,username',$where,$A['aids']));
    } else {
        $preferences->set_var ('lang_authors', '');
        $preferences->set_var ('exclude_author_checklist', '');
    }
    $preferences->parse ('exclude_block', 'exclude', true);

    // daily digest block
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

    // boxes block
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
    $whereblock = '';
    if (!empty ($permissions)) {
        $whereblock .= $permissions . ' AND ';
    }
    $whereblock = "((type != 'layout' AND type != 'gldefault' AND is_enabled = 1) OR (type = 'gldefault' AND is_enabled = 1 AND name IN ('whats_new_block','poll_block','events_block','older_stories'))) ORDER BY onleft desc,blockorder,title";
    $preferences->set_var ('boxes_checklist', COM_checkList ($_TABLES['blocks'],
            'bid,title,blockorder', $whereblock, $selectedblocks));
    $preferences->parse ('boxes_block', 'boxes', true);

    // comment preferences block
    $result = DB_query("SELECT commentmode,commentorder,commentlimit FROM {$_TABLES['usercomment']} WHERE uid = {$_USER['uid']}");
    $A = DB_fetchArray ($result);

    if (empty ($A['commentmode'])) {
        $A['commentmode'] = $_CONF['comment_mode'];
    }
    if (empty ($A['commentorder'])) $A['commentorder'] = 0;
    if (empty ($A['commentlimit'])) $A['commentlimit'] = 100;

    $selection = '<select name="commentmode">';
    $selection .= COM_optionList ($_TABLES['commentmodes'], 'mode,name',
                                  $A['commentmode']);
    $preferences->set_var ('displaymode_selector', $selection);

    $selection = '<select name="commentorder">';
    $selection .= COM_optionList ($_TABLES['sortcodes'], 'code,name',
                                  $A['commentorder']);
    $preferences->set_var ('sortorder_selector', $selection);
    $preferences->set_var ('commentlimit_value', $A['commentlimit']);
    $preferences->parse ('comment_block', 'comment', true);

    return $preferences->finish ($preferences->parse ('output', 'prefs'));
}

/**
* Check if an email address already exists in the database
*
* @param   email   string   email address to check
* @param   uid     int      user id of current user
* @return          bool     true = exists, false = does not exist
*
*/
function emailAddressExists ($email, $uid)
{
    global $_TABLES;

    $result = DB_query ("SELECT uid FROM {$_TABLES['users']} WHERE email = '{$email}'");
    $numrows = DB_numRows ($result);
    for ($i = 0; $i < $numrows; $i++) {
        $A = DB_fetchArray ($result);
        if ($A['uid'] != $uid) {
            // email address is already in use for another account
            return true;
        }
    }

    return false;
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

    if ($_CONF['allow_username_change'] == 1) {
        $A['new_username'] = strip_tags (COM_stripslashes ($A['new_username']));
        if (!empty ($A['new_username']) &&
                ($A['new_username'] != $_USER['username'])) {
            $A['new_username'] = addslashes ($A['new_username']);
            if (DB_count ($_TABLES['users'], 'username', $A['new_username']) == 0) {
                DB_change ($_TABLES['users'], 'username', $A['new_username'],
                           "uid", $_USER['uid']);
            } else {
                return COM_refresh ($_CONF['site_url']
                        . '/usersettings.php?mode=edit&msg=51');
            }
        }
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

    if (!COM_isEmail ($A['email'])) {
        return COM_refresh ($_CONF['site_url']
                . '/usersettings.php?mode=edit&msg=52');
    } else if (emailAddressExists ($A['email'], $_USER['uid'])) {
        return COM_refresh ($_CONF['site_url']
                . '/usersettings.php?mode=edit&msg=56');
    } else {
        if ($_US_VERBOSE) {
            COM_errorLog('cooktime = ' . $A['cooktime'],1);
        }

        if ($A['cooktime'] <= 0) {
            $A['cooktime'] = 'NULL';
            $cooktime = 1000;
            setcookie ($_CONF['cookie_name'], $_USER['uid'], time() - $cooktime,
                       $_CONF['cookie_path'], $_CONF['cookiedomain'],
                       $_CONF['cookiesecure']);
        } else {
            setcookie ($_CONF['cookie_name'], $_USER['uid'],
                       time() + $A['cooktime'], $_CONF['cookie_path'],
                       $_CONF['cookiedomain'], $_CONF['cookiesecure']);   
        }

     	// Call custom account registration and save function if enabled and exists
	    if ($_CONF['custom_registration'] AND (function_exists(custom_usersave))) {
		    custom_usersave($_USER['uid']);
	        return COM_refresh("{$_CONF['site_url']}/usersettings.php?mode=edit&msg=5");
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
            $upload->setAllowedMimeTypes(array('image/gif'=>'.gif','image/jpeg'=>'.jpg,.jpeg','image/pjpeg'=>'.jpg,.jpeg','image/x-png'=>'.png','image/png'=>'.png'));
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
        DB_query("UPDATE {$_TABLES['userinfo']} SET pgpkey='" . $A["pgpkey"] . "',about='{$A["about"]}' WHERE uid={$_USER['uid']}");

        if ($_US_VERBOSE) {
            COM_errorLog('**** Leaving saveuser in usersettings.php ****', 1);
        }

        return COM_refresh ($_CONF['site_url']
                . '/usersettings.php?mode=edit&msg=5');
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
    if ($A['emailfromadmin'] == 'on') $A['emailfromadmin'] = 1;
    if ($A['emailfromuser'] == 'on') $A['emailfromuser'] = 1;
    if ($A['showonline'] == 'on') $A['showonline'] = 1;

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
    setcookie ($_CONF['cookie_theme'], $A['theme'], time() + 31536000,
               $_CONF['cookie_path'], $_CONF['cookiedomain'],
               $_CONF['cookiesecure']);
    setcookie ($_CONF['cookie_language'], $A['language'], time() + 31536000,
               $_CONF['cookie_path'], $_CONF['cookiedomain'],
               $_CONF['cookiesecure']);

    DB_query("UPDATE {$_TABLES['userprefs']} SET noicons='{$A['noicons']}', willing='{$A["willing"]}', dfid='{$A["dfid"]}', tzid='{$A["tzid"]}', emailfromadmin='{$A['emailfromadmin']}', emailfromuser='{$A['emailfromuser']}', showonline='{$A['showonline']}' WHERE uid='{$_USER['uid']}'");

    if (empty ($etids)) {
        $etids = '-';
    }
    DB_save($_TABLES['userindex'],"uid,tids,aids,boxes,noboxes,maxstories,etids","'{$_USER['uid']}','$tids','$aids','$selectedblocks','{$A['noboxes']}',{$A['maxstories']},'$etids'");

    DB_save($_TABLES['usercomment'],'uid,commentmode,commentorder,commentlimit',"'{$_USER['uid']}','{$A['commentmode']}','{$A['commentorder']}','{$A['commentlimit']}'");
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
    case 'comments':
        $display .= COM_siteHeader('menu');
        $display .= COM_showMessage($HTTP_GET_VARS['msg']);
        $display .= editpreferences();
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
        PLG_profileExtrasSave ();
        break;
    case 'savepreferences':
        savepreferences ($HTTP_POST_VARS);
        $display .= COM_refresh ($_CONF['site_url']
                                 . '/usersettings.php?mode=preferences&msg=6');
        break;
    case 'confirmdelete':
        $display .= confirmAccountDelete ($HTTP_POST_VARS['account_id']);
        break;
    case 'deleteconfirmed':
        $display .= deleteUserAccount ($HTTP_POST_VARS['account_id']);
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
