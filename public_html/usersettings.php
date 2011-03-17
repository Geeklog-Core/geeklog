<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | usersettings.php                                                          |
// |                                                                           |
// | Geeklog user settings page.                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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

require_once 'lib-common.php';
require_once $_CONF['path_system'] . 'lib-user.php';

// Set this to true to have this script generate various debug messages in
// error.log
$_US_VERBOSE = false;

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

/**
* Shows the user's current settings
*
*/
function edituser()
{
    global $_CONF, $_TABLES, $_USER, $LANG_MYACCOUNT, $LANG04, $LANG_ADMIN, $_SCRIPTS;

    $result = DB_query("SELECT fullname,cookietimeout,email,homepage,sig,emailstories,about,location,pgpkey,photo,remoteservice FROM {$_TABLES['users']},{$_TABLES['userprefs']},{$_TABLES['userinfo']} WHERE {$_TABLES['users']}.uid = {$_USER['uid']} AND {$_TABLES['userprefs']}.uid = {$_USER['uid']} AND {$_TABLES['userinfo']}.uid = {$_USER['uid']}");
    $A = DB_fetchArray ($result);

    $preferences = COM_newTemplate($_CONF['path_layout'] . 'preferences');
    $preferences->set_file (array ('profile'       => 'profile.thtml',
                                   'photo'         => 'userphoto.thtml',
                                   'username'      => 'username.thtml',
                                   'password'      => 'password.thtml',
                                   'current_password'      => 'current_password.thtml',
                                   'resynch'      => 'resynch.thtml',
                                   'deleteaccount' => 'deleteaccount.thtml'));

    include ($_CONF['path_system'] . 'classes/navbar.class.php');
    $navbar = new navbar;
    $cnt = 0;
    foreach ($LANG_MYACCOUNT as $id => $label) {
        $navbar->add_menuitem($label,'showhideProfileEditorDiv("'.$id.'",'.$cnt.');return false;',true);
        $cnt++;
    }
    $navbar->set_selected($LANG_MYACCOUNT['pe_namepass']);
    $preferences->set_var ('navbar', $navbar->generate());

    $preferences->set_var ('no_javascript_warning', $LANG04[150]);

    $preferences->set_var ('cssid1', 1);
    $preferences->set_var ('cssid2', 2);

    $preferences->set_var ('preview', USER_showProfile($_USER['uid'], true));
    $preferences->set_var ('prefs', editpreferences());
    
    // Add JavaScript
    $_SCRIPTS->setJavaScriptFile('profile_editor', '/javascript/profile_editor.js');
    
    $js = '<!-- JS Functions which will execute only if JS enabled will un-hide the special features that enhance the profile editor -->
    <script type="text/JavaScript">
    //<![CDATA[
        /* Initially the navbar is hidden - in case JS is disabled. Enable it now */
        document.getElementById("pe_navbar").style.display="";
    
        /* Now cycle through the profile tabs as the number in the template could have been modified (personalized)
           If you add custom panels, just ensure you use the class jsenabled_hide or jsenabled_show
           Build an object that can then be referenced in the functon showhideProfileEditorDiv
        */
    
        var profilepanels = new Object;
        var el;
        el=document.getElementsByTagName("div");
        for(i=0;i<el.length;i++) {
            var divname = el[i].id  
            if(el[i].className == "jsenabled_show"){
                el[i].style.display = "";
                profilepanels[divname] = "show";
            } else if(el[i].className == "jsenabled_hide"){
                el[i].style.display = "none";
                profilepanels[divname] = "hidden";   
            }
        }
    //]]>
    </script>';    
    $_SCRIPTS->setJavaScript($js);    

    // some trickery to ensure alternating colors with the available options ...
    if ($_CONF['allow_username_change'] == 1) {
        $first  = 1;
        $second = 2;
    } else {
        $first  = 2;
        $second = 1;
    }
    $preferences->set_var ('cssid1u', $first);
    $preferences->set_var ('cssid2u', $second);

    if ($_CONF['allow_user_photo'] == 1) {
        $tmp = $first;
        $first = $second;
        $second = $tmp;
    }
    $preferences->set_var ('cssid1p', $first);
    $preferences->set_var ('cssid2p', $second);

    $preferences->set_var ('lang_fullname', $LANG04[3]);
    $preferences->set_var ('lang_fullname_text', $LANG04[34]);
    $preferences->set_var ('lang_username', $LANG04[2]);
    $preferences->set_var ('lang_username_text', $LANG04[87]);
    $preferences->set_var ('lang_password_help_title', $LANG04[146]);
    $preferences->set_var ('lang_password_help', $LANG04[147]);
    $preferences->set_var ('lang_password', $LANG04[4]);
    $preferences->set_var ('lang_password_text', $LANG04[35]);
    $preferences->set_var ('lang_password_conf', $LANG04[108]);
    $preferences->set_var ('lang_password_text_conf', $LANG04[109]);
    $preferences->set_var ('lang_old_password', $LANG04[110]);
    $preferences->set_var ('lang_old_password_text', $LANG04[111]);
    $preferences->set_var ('lang_cooktime', $LANG04[68]);
    $preferences->set_var ('lang_cooktime_text', $LANG04[69]);
    $preferences->set_var ('lang_email', $LANG04[5]);
    $preferences->set_var ('lang_email_text', $LANG04[33]);
    $preferences->set_var ('lang_email_conf', $LANG04[124]);
    $preferences->set_var ('lang_email_conf_text', $LANG04[126]);
    $preferences->set_var ('lang_userinfo_help_title', $LANG04[148]);
    $preferences->set_var ('lang_userinfo_help', $LANG04[149]);
    $preferences->set_var ('lang_homepage', $LANG04[6]);
    $preferences->set_var ('lang_homepage_text', $LANG04[36]);
    $preferences->set_var ('lang_location', $LANG04[106]);
    $preferences->set_var ('lang_location_text', $LANG04[107]);
    $preferences->set_var ('lang_signature', $LANG04[32]);
    $preferences->set_var ('lang_signature_text', $LANG04[37]);
    $preferences->set_var ('lang_userphoto', $LANG04[77]);
    $preferences->set_var ('lang_userphoto_text', $LANG04[78]);
    $preferences->set_var ('lang_about', $LANG04[7]);
    $preferences->set_var ('lang_about_text', $LANG04[38]);
    $preferences->set_var ('lang_pgpkey', $LANG04[8]);
    $preferences->set_var ('lang_pgpkey_text', $LANG04[39]);
    $preferences->set_var ('lang_submit', $LANG04[9]);
    $preferences->set_var ('lang_cancel',$LANG_ADMIN['cancel']);
    $preferences->set_var ('lang_preview_title', $LANG04[145]);
    $preferences->set_var ('lang_enter_current_password', $LANG04[127]);
    $preferences->set_var ('lang_name_legend', $LANG04[128]);
    $preferences->set_var ('lang_password_email_legend', $LANG04[129]);
    $preferences->set_var ('lang_personal_info_legend', $LANG04[130]);
    $preferences->set_var ('lang_resynch', $LANG04[166]);

    $display_name = COM_getDisplayName ($_USER['uid']);

    //$preferences->set_var ('start_block_profile',
    //        COM_startBlock ($LANG04[1] . ' ' . $display_name));
    //$preferences->set_var ('end_block', COM_endBlock ());

    $preferences->set_var ('profile_headline',
                           $LANG04[1] . ' ' . $display_name);

    if ($_CONF['allow_user_photo'] == 1) {
        $preferences->set_var ('enctype', 'enctype="multipart/form-data"');
    } else {
        $preferences->set_var ('enctype', '');
    }
    $preferences->set_var ('fullname_value', htmlspecialchars ($A['fullname']));
    $preferences->set_var ('new_username_value',
                           htmlspecialchars ($_USER['username']));
    
    if ($A['remoteservice'] == '') {
        $preferences->set_var ('password_value', '');
        $preferences->parse ('password_option', 'password', true);
        $preferences->parse ('current_password_option', 'current_password', true);
        $preferences->set_var ('resynch_option', '');
    } else {
        $preferences->set_var ('password_option', '');
        $preferences->set_var ('current_password_option', '');
        if ($_CONF['user_login_method']['oauth'] && (strpos($_USER['remoteservice'], 'oauth.') === 0)) { // OAuth only supports re-synch at the moment
            $preferences->set_var ('resynch_checked', '');
            $preferences->parse ('resynch_option', 'resynch', true);
        } else {
            $preferences->set_var ('resynch_option', '');
        }
    }    
    
    if ($_CONF['allow_username_change'] == 1) {
        $preferences->parse ('username_option', 'username', true);
    } else {
        $preferences->set_var ('username_option', '');
    }

    $selection = '<select id="cooktime" name="cooktime">' . LB;
    $selection .= COM_optionList ($_TABLES['cookiecodes'], 'cc_value,cc_descr',
                                  $A['cookietimeout'], 0);
    $selection .= '</select>';
    $preferences->set_var ('cooktime_selector', $selection);

    $preferences->set_var ('email_value', htmlspecialchars ($A['email']));
    $preferences->set_var ('homepage_value',
                           htmlspecialchars (COM_killJS ($A['homepage'])));
    $preferences->set_var ('location_value',
                           htmlspecialchars (strip_tags ($A['location'])));
    $preferences->set_var ('signature_value', htmlspecialchars ($A['sig']));

    if ($_CONF['allow_user_photo'] == 1) {
        $photo = USER_getPhoto ($_USER['uid'], $A['photo'], $A['email'], -1);
        if (empty ($photo)) {
            $preferences->set_var ('display_photo', '');
        } else {
            if (empty ($A['photo'])) { // external avatar
                $photo = '<br' . XHTML . '>' . $photo;
            } else { // uploaded photo - add delete option
                $photo = '<br' . XHTML . '>' . $photo . '<br' . XHTML . '>' . $LANG04[79]
                       . '&nbsp;<input type="checkbox" name="delete_photo"' . XHTML . '>'
                       . LB;
            }
            $preferences->set_var ('display_photo', $photo);
        }
        if (empty($_CONF['image_lib'])) {
            $scaling = $LANG04[162];
        } else {
            $scaling = $LANG04[161];
        }
        $preferences->set_var('photo_max_dimensions',
            sprintf($LANG04[160],
                    $_CONF['max_photo_width'], $_CONF['max_photo_height'],
                    $_CONF['max_photo_size'], $scaling));
        $preferences->parse ('userphoto_option', 'photo', true);
    } else {
        $preferences->set_var ('userphoto_option', '');
    }

    $result = DB_query("SELECT about,pgpkey FROM {$_TABLES['userinfo']} WHERE uid = {$_USER['uid']}");
    $A = DB_fetchArray($result);

    $reqid = substr (md5 (uniqid (rand (), 1)), 1, 16);
    DB_change ($_TABLES['users'], 'pwrequestid', $reqid, 'uid', $_USER['uid']);

    $preferences->set_var ('about_value', htmlspecialchars ($A['about']));
    $preferences->set_var ('pgpkey_value', htmlspecialchars ($A['pgpkey']));
    $preferences->set_var ('uid_value', $reqid);
    $preferences->set_var ('username_value',
                           htmlspecialchars ($_USER['username']));

    if ($_CONF['allow_account_delete'] == 1) {
        $preferences->set_var ('lang_deleteaccount', $LANG04[156]);
        $preferences->set_var ('delete_text', $LANG04[95]);
        $preferences->set_var ('lang_button_delete', $LANG04[96]);
        $preferences->set_var ('delete_mode', 'confirmdelete');
        $preferences->set_var ('account_id', $reqid);
        if (isset ($LANG04[157])) {
            $preferences->set_var ('lang_deleteoption', $LANG04[157]);
        } else {
            $preferences->set_var ('lang_deleteoption', $LANG04[156]);
        }
        $preferences->parse ('delete_account_option', 'deleteaccount', false);
    } else {
        $preferences->set_var ('delete_account_option', '');
    }

    // Call custom account form and edit function if enabled and exists
    if ($_CONF['custom_registration'] AND (function_exists('CUSTOM_userEdit'))) {
        $preferences->set_var ('customfields', CUSTOM_userEdit($_USER['uid']) );
    }

    PLG_profileVariablesEdit ($_USER['uid'], $preferences);

    $retval = $preferences->finish ($preferences->parse ('output', 'profile'));
    $retval .= PLG_profileBlocksEdit ($_USER['uid']);

    return $retval;
}

/**
* Ask user for confirmation to delete his/her account.
*
* @param    string   form_reqid   request id
* @return   string   confirmation form
*
*/
function confirmAccountDelete ($form_reqid)
{
    global $_CONF, $_TABLES, $_USER, $LANG04;

    if (DB_count ($_TABLES['users'], array ('pwrequestid', 'uid'), array ($form_reqid, $_USER['uid'])) != 1) {
        // not found - abort
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    // to change the password, email address, or cookie timeout,
    // we need the user's current password
    $current_password = DB_getItem($_TABLES['users'], 'passwd',
                                   "uid = {$_USER['uid']}");
    if (empty($_POST['old_passwd']) ||
            (SEC_encryptPassword($_POST['old_passwd']) != $current_password)) {
         return COM_refresh($_CONF['site_url']
                            . '/usersettings.php?msg=84');
    }

    $reqid = substr (md5 (uniqid (rand (), 1)), 1, 16);
    DB_change ($_TABLES['users'], 'pwrequestid', "$reqid",
                                  'uid', $_USER['uid']);

    $retval = '';

    $retval .= COM_siteHeader ('menu', $LANG04[97]);
    $retval .= COM_startBlock ($LANG04[97], '',
                               COM_getBlockTemplate ('_msg_block', 'header'));
    $retval .= '<p>' . $LANG04[98] . '</p>' . LB;
    $retval .= '<form action="' . $_CONF['site_url']
            . '/usersettings.php" method="post"><div>' . LB;
    $retval .= '<p align="center"><input type="submit" name="btnsubmit" value="'
            . $LANG04[96] . '"' . XHTML . '></p>' . LB;
    $retval .= '<input type="hidden" name="mode" value="deleteconfirmed"' . XHTML . '>' . LB;
    $retval .= '<input type="hidden" name="account_id" value="' . $reqid
            . '"' . XHTML . '>' . LB;
    $retval .= '</div></form>' . LB;
    $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $retval .= COM_siteFooter ();

    return $retval;
}

/**
* Delete an account
*
* @param    string   form_reqid   request id
* @return   string   redirection to main page (+ success msg)
*
*/
function deleteUserAccount ($form_reqid)
{
    global $_CONF, $_TABLES, $_USER;

    if (DB_count ($_TABLES['users'], array ('pwrequestid', 'uid'),
                  array ($form_reqid, $_USER['uid'])) != 1) {
        // not found - abort
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    if (!USER_deleteAccount ($_USER['uid'])) {
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    return COM_refresh ($_CONF['site_url'] . '/index.php?msg=57');
}

/**
* Displays user preferences
*
*/
function editpreferences()
{
    global $_CONF, $_TABLES, $_USER, $_GROUPS, $LANG04;

    $result = DB_query("SELECT noicons,willing,dfid,tzid,noboxes,maxstories,tids,aids,boxes,emailfromadmin,emailfromuser,showonline,advanced_editor FROM {$_TABLES['userprefs']},{$_TABLES['userindex']} WHERE {$_TABLES['userindex']}.uid = {$_USER['uid']} AND {$_TABLES['userprefs']}.uid = {$_USER['uid']}");

    $A = DB_fetchArray($result);

    // 'maxstories' may be 0, in which case it will pick up the default
    // setting for the current topic or $_CONF['limitnews'] (see index.php)
    if (empty ($A['maxstories'])) {
        $A['maxstories'] = 0;
    } else if ($A['maxstories'] > 0) {
        if ($A['maxstories'] < $_CONF['minnews']) {
            $A['maxstories'] = $_CONF['minnews'];
        }
    }

    $preferences = COM_newTemplate($_CONF['path_layout'] . 'preferences');
    $preferences->set_file (array ('prefs' => 'displayprefs.thtml',
                                   'display' => 'displayblock.thtml',
                                   'exclude' => 'excludeblock.thtml',
                                   'digest' => 'digestblock.thtml',
                                   'boxes' => 'boxesblock.thtml',
                                   'comment' => 'commentblock.thtml',
                                   'language' => 'language.thtml',
                                   'theme' => 'theme.thtml',
                                   'privacy' => 'privacyblock.thtml',
                                   'editor' => 'editor.thtml'
                                  ));
    $preferences->set_var ('user_name', $_USER['username']);

    $preferences->set_var ('lang_language', $LANG04[73]);
    $preferences->set_var ('lang_theme', $LANG04[72]);
    $preferences->set_var ('lang_theme_text', $LANG04[74]);
    $preferences->set_var ('lang_misc_title', $LANG04[138]);
    $preferences->set_var ('lang_misc_help_title', $LANG04[139]);
    $preferences->set_var ('lang_misc_help', $LANG04[140]);
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
    $preferences->set_var ('lang_excluded_items_title', $LANG04[137]);
    $preferences->set_var ('lang_excluded_items', $LANG04[54]);
    $preferences->set_var ('lang_exclude_title', $LANG04[136]);
    $preferences->set_var ('lang_topics', $LANG04[48]);
    $preferences->set_var ('lang_emailedtopics', $LANG04[76]);
    $preferences->set_var ('lang_digest_top_header', $LANG04[131]);
    $preferences->set_var ('lang_digest_help_header', $LANG04[132]);
    $preferences->set_var ('lang_boxes_title', $LANG04[144]);
    $preferences->set_var ('lang_boxes_help_title', $LANG04[143]);
    $preferences->set_var ('lang_boxes', $LANG04[55]);
    $preferences->set_var ('lang_displaymode', $LANG04[57]);
    $preferences->set_var ('lang_displaymode_text', $LANG04[60]);
    $preferences->set_var ('lang_sortorder', $LANG04[58]);
    $preferences->set_var ('lang_sortorder_text', $LANG04[61]);
    $preferences->set_var ('lang_comment_title', $LANG04[133]);
    $preferences->set_var ('lang_comment_help_title', $LANG04[134]);
    $preferences->set_var ('lang_comment_help', $LANG04[135]);
    $preferences->set_var ('lang_commentlimit', $LANG04[59]);
    $preferences->set_var ('lang_commentlimit_text', $LANG04[62]);
    $preferences->set_var ('lang_privacy_title', $LANG04[141]);
    $preferences->set_var ('lang_privacy_help_title', $LANG04[141]);
    $preferences->set_var ('lang_privacy_help', $LANG04[142]);
    $preferences->set_var ('lang_emailfromadmin', $LANG04[100]);
    $preferences->set_var ('lang_emailfromadmin_text', $LANG04[101]);
    $preferences->set_var ('lang_emailfromuser', $LANG04[102]);
    $preferences->set_var ('lang_emailfromuser_text', $LANG04[103]);
    $preferences->set_var ('lang_showonline', $LANG04[104]);
    $preferences->set_var ('lang_showonline_text', $LANG04[105]);
    $preferences->set_var ('lang_submit', $LANG04[9]);

    $display_name = COM_getDisplayName ($_USER['uid']);

    $preferences->set_var ('lang_authors_exclude', $LANG04[46]);
    $preferences->set_var ('lang_boxes_exclude', $LANG04[47]);

    $preferences->set_var ('start_block_display',
            COM_startBlock ($LANG04[45] . ' ' . $display_name));
    $preferences->set_var ('start_block_digest',
            COM_startBlock ($LANG04[75] . ' ' . $display_name));
    $preferences->set_var ('start_block_comment',
            COM_startBlock ($LANG04[64] . ' ' . $display_name));
    $preferences->set_var ('start_block_privacy',
            COM_startBlock ($LANG04[99] . ' ' . $display_name));
    $preferences->set_var ('end_block', COM_endBlock ());

    $preferences->set_var ('display_headline',
                           $LANG04[45] . ' ' . $display_name);
    $preferences->set_var ('exclude_headline',
                           $LANG04[46] . ' ' . $display_name);
    $preferences->set_var ('digest_headline',
                           $LANG04[75] . ' ' . $display_name);
    $preferences->set_var ('boxes_headline',
                           $LANG04[47] . ' ' . $display_name);
    $preferences->set_var ('comment_headline',
                           $LANG04[64] . ' ' . $display_name);
    $preferences->set_var ('privacy_headline',
                           $LANG04[99] . ' ' . $display_name);

    // display preferences block
    if ($_CONF['allow_user_language'] == 1) {

        if (empty ($_USER['language'])) {
            $userlang = $_CONF['language'];
        } else {
            $userlang = $_USER['language'];
        }

        // Get available languages
        $language = MBYTE_languageList ($_CONF['default_charset']);

        $has_valid_language = count (array_keys ($language, $userlang));
        if ($has_valid_language == 0) {
            // The user's preferred language is no longer available.
            // We have a problem now, since we've overwritten $_CONF['language']
            // with the user's preferred language ($_USER['language']) and
            // therefore don't know what the system's default language is.
            // So we'll try to find a similar language. If that doesn't help,
            // the dropdown will default to the first language in the list ...
            $tmp = explode ('_', $userlang);
            $similarLang = $tmp[0];
        }

        $selection = '<select id="language" name="language">' . LB;

        foreach ($language as $langFile => $langName) {
            $selection .= '<option value="' . $langFile . '"';
            if (($langFile == $userlang) || (($has_valid_language == 0) &&
                    (strpos ($langFile, $similarLang) === 0))) {
                $selection .= ' selected="selected"';
                $has_valid_language = 1;
            } else if ($userlang == $langFile) {
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
        $selection = '<select id="theme" name="theme">' . LB;

        if (empty($_USER['theme'])) {
            $usertheme = $_CONF['theme'];
        } else {
            $usertheme = $_USER['theme'];
        }

        $themeFiles = COM_getThemes();
        usort($themeFiles, 'strcasecmp');

        foreach ($themeFiles as $theme) {
            $selection .= '<option value="' . $theme . '"';
            if ($usertheme == $theme) {
                $selection .= ' selected="selected"';
            }
            $words = explode('_', $theme);
            $bwords = array();
            foreach ($words as $th) {
                if ((strtolower($th[0]) == $th[0]) &&
                    (strtolower($th[1]) == $th[1])) {
                    $bwords[] = ucfirst($th);
                } else {
                    $bwords[] = $th;
                }
            }
            $selection .= '>' . implode(' ', $bwords) . '</option>' . LB;
        }
        $selection .= '</select>';
        $preferences->set_var('theme_selector', $selection);
        $preferences->parse('theme_selection', 'theme', true);
    } else {
        $preferences->set_var('theme_selection', '');
    }

    if ($_CONF['advanced_editor'] == 1) {
        $preferences->set_var('lang_advanced_editor', $LANG04[165]);
        if ($A['advanced_editor'] == 1) {
            $preferences->set_var('advanced_editor_checked', 'checked="checked"');
        } else {
            $preferences->set_var('advanced_editor_checked', '');
        }
        $preferences->parse('advanced_editor_option', 'editor', true);
    } else {
        $preferences->set_var('advanced_editor_option', '');
    }

    // Timezone
    require_once $_CONF['path_system'] . 'classes/timezoneconfig.class.php';

    $timezone = TimeZoneConfig::getUserTimeZone();
    $selection = TimeZoneConfig::getTimeZoneDropDown($timezone,
            array('id' => 'tzid', 'name' => 'tzid'));

    $preferences->set_var('timezone_selector', $selection);
    $preferences->set_var('lang_timezone', $LANG04[158]);

    if (isset ($A['noicons']) && $A['noicons'] == '1') {
        $preferences->set_var ('noicons_checked', 'checked="checked"');
    } else {
        $preferences->set_var ('noicons_checked', '');
    }

    if (isset ($A['noboxes']) && $A['noboxes'] == '1') {
        $preferences->set_var ('noboxes_checked', 'checked="checked"');
    } else {
        $preferences->set_var ('noboxes_checked', '');
    }

    $preferences->set_var ('maxstories_value', $A['maxstories']);
    $selection = '<select id="dfid" name="dfid">' . LB
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
    PLG_profileVariablesEdit ($_USER['uid'], $preferences);
    $preferences->parse ('privacy_block', 'privacy', true);

    // excluded items block
    $permissions = COM_getPermSQL ('');
    $preferences->set_var ('exclude_topic_checklist',
        COM_checkList($_TABLES['topics'], 'tid,topic', $permissions, $A['tids'],
                      'topics'));

    if (($_CONF['contributedbyline'] == 1) &&
        ($_CONF['hide_author_exclusion'] == 0)) {
        $preferences->set_var ('lang_authors', $LANG04[56]);
        $sql = "SELECT DISTINCT story.uid, users.username,users.fullname FROM {$_TABLES['stories']} story, {$_TABLES['users']} users WHERE story.uid = users.uid";
        if ($_CONF['show_fullname'] == 1) {
            $sql .= ' ORDER BY users.fullname';
        } else {
            $sql .= ' ORDER BY users.username';
        }
        $query = DB_query ($sql);
        $nrows = DB_numRows ($query );
        $authors = explode (' ', $A['aids']);

        $selauthors = '';
        for( $i = 0; $i < $nrows; $i++ ) {
            $B = DB_fetchArray ($query);
            $selauthors .= '<option value="' . $B['uid'] . '"';
            if (in_array (sprintf ('%d', $B['uid']), $authors)) {
               $selauthors .= ' selected';
            }
            $selauthors .= '>' . COM_getDisplayName ($B['uid'], $B['username'],
                                                     $B['fullname'])
                        . '</option>' . LB;
        }

        if (DB_count($_TABLES['topics']) > 10) {
            $Selboxsize = intval (DB_count ($_TABLES['topics']) * 1.5);
        } else {
            $Selboxsize = 15;
        }
        $preferences->set_var ('exclude_author_checklist', '<select name="selauthors[]" multiple="multiple" size="'. $Selboxsize. '">' . $selauthors . '</select>');
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
            $etids = USER_getAllowedTopics();
            $user_etids = implode(' ', $etids);
        } elseif ($user_etids == '-') { // this means "no topics"
            $user_etids = '';
        }
        $tmp = COM_checkList($_TABLES['topics'], 'tid,topic', $permissions,
                             $user_etids, 'etids');
        $preferences->set_var('email_topic_checklist',
                str_replace($_TABLES['topics'], 'etids', $tmp));
        $preferences->parse('digest_block', 'digest', true);
    } else {
        $preferences->set_var('digest_block', '');
    }

    // boxes block
    $selectedblocks = '';
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
    $whereblock .= "((type != 'gldefault' AND is_enabled = 1) OR "
                 . "(type = 'gldefault' AND is_enabled = 1 AND name IN ('whats_new_block','older_stories'))) "
                 . "ORDER BY onleft desc,blockorder,title";
    $preferences->set_var ('boxes_checklist', COM_checkList ($_TABLES['blocks'],
            'bid,title,type', $whereblock, $selectedblocks, 'blocks'));
    $preferences->parse ('boxes_block', 'boxes', true);

    // comment preferences block
    $result = DB_query("SELECT commentmode,commentorder,commentlimit FROM {$_TABLES['usercomment']} WHERE uid = {$_USER['uid']}");
    $A = DB_fetchArray ($result);

    if (empty ($A['commentmode'])) {
        $A['commentmode'] = $_CONF['comment_mode'];
    }
    if (empty ($A['commentorder'])) $A['commentorder'] = 0;
    if (empty ($A['commentlimit'])) $A['commentlimit'] = 100;

    $selection = '<select id="commentmode" name="commentmode">';
    $selection .= COM_optionList ($_TABLES['commentmodes'], 'mode,name',
                                  $A['commentmode']);
    $selection .= '</select>';
    $preferences->set_var ('displaymode_selector', $selection);

    $selection = '<select id="commentorder" name="commentorder">';
    $selection .= COM_optionList ($_TABLES['sortcodes'], 'code,name',
                                  $A['commentorder']);
    $selection .= '</select>';
    $preferences->set_var ('sortorder_selector', $selection);
    $preferences->set_var ('commentlimit_value', $A['commentlimit']);
    $preferences->parse ('comment_block', 'comment', true);

    return $preferences->finish ($preferences->parse ('output', 'prefs'));
}

/**
* Check if an email address already exists in the database
*
* NOTE:    Allows remote accounts to have duplicate email addresses
*
* @param   email   string   email address to check
* @param   uid     int      user id of current user
* @return          boolean  true = exists, false = does not exist
*
*/
function emailAddressExists ($email, $uid)
{
    global $_TABLES;

    $old_email = DB_getItem($_TABLES['users'], 'email', "uid = '$uid'");
    if ($email == $old_email) {
        // email address didn't change so don't care
        return false;
    }

    $email = addslashes($email);
    $result = DB_query("SELECT uid FROM {$_TABLES['users']} WHERE email = '$email' AND uid <> '$uid' AND (remoteservice IS NULL OR remoteservice = '')");
    if (DB_numRows($result) > 0) {
        // email address is already in use for another non-remote account
        return true;
    }

    return false;
}

/**
* Upload new photo, delete old photo
*
* @param    string  $delete_photo   'on': delete old photo
* @return   string                  filename of new photo (empty = no new photo)
*
*/
function handlePhotoUpload ($delete_photo = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG24;

    require_once ($_CONF['path_system'] . 'classes/upload.class.php');

    $upload = new upload();
    if (!empty ($_CONF['image_lib'])) {
        if ($_CONF['image_lib'] == 'imagemagick') {
            // Using imagemagick
            $upload->setMogrifyPath ($_CONF['path_to_mogrify']);
        } elseif ($_CONF['image_lib'] == 'netpbm') {
            // using netPBM
            $upload->setNetPBM ($_CONF['path_to_netpbm']);
        } elseif ($_CONF['image_lib'] == 'gdlib') {
            // using the GD library
            $upload->setGDLib ();
        }
        $upload->setAutomaticResize (true);
        if (isset ($_CONF['debug_image_upload']) &&
                $_CONF['debug_image_upload']) {
            $upload->setLogFile ($_CONF['path'] . 'logs/error.log');
            $upload->setDebug (true);
        }
        if (isset($_CONF['jpeg_quality'])) {
            $upload->setJpegQuality($_CONF['jpeg_quality']);
        }
    }
    $upload->setAllowedMimeTypes (array ('image/gif'   => '.gif',
                                         'image/jpeg'  => '.jpg,.jpeg',
                                         'image/pjpeg' => '.jpg,.jpeg',
                                         'image/x-png' => '.png',
                                         'image/png'   => '.png'
                                 )      );
    if (!$upload->setPath ($_CONF['path_images'] . 'userphotos')) {
        $display = COM_siteHeader ('menu', $LANG24[30]);
        $display .= COM_startBlock ($LANG24[30], '',
                COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $upload->printErrors (false);
        $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block',
                                                        'footer'));
        $display .= COM_siteFooter ();
        COM_output($display);
        exit; // don't return
    }

    $filename = '';
    if (!empty ($delete_photo) && ($delete_photo == 'on')) {
        $delete_photo = true;
    } else {
        $delete_photo = false;
    }

    $curphoto = DB_getItem ($_TABLES['users'], 'photo',
                            "uid = {$_USER['uid']}");
    if (empty ($curphoto)) {
        $delete_photo = false;
    }

    // see if user wants to upload a (new) photo
    $newphoto = $_FILES['photo'];
    if (!empty ($newphoto['name'])) {
        $pos = strrpos ($newphoto['name'], '.') + 1;
        $fextension = substr ($newphoto['name'], $pos);
        $filename = $_USER['username'] . '.' . $fextension;

        if (!empty ($curphoto) && ($filename != $curphoto)) {
            $delete_photo = true;
        } else {
            $delete_photo = false;
        }
    }

    // delete old photo first
    if ($delete_photo) {
        USER_deletePhoto ($curphoto);
    }

    // now do the upload
    if (!empty ($filename)) {
        $upload->setFileNames ($filename);
        $upload->setPerms ('0644');
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
        $upload->uploadFiles ();

        if ($upload->areErrors ()) {
            $display = COM_siteHeader ('menu', $LANG24[30]);
            $display .= COM_startBlock ($LANG24[30], '',
                    COM_getBlockTemplate ('_msg_block', 'header'));
            $display .= $upload->printErrors (false);
            $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block',
                                                            'footer'));
            $display .= COM_siteFooter ();
            COM_output($display);
            exit; // don't return
        }
    } else if (!$delete_photo && !empty ($curphoto)) {
        $filename = $curphoto;
    }

    return $filename;
}

/**
* Saves the user's information back to the database
*
* @param    array   $A  User's data
* @return   string      HTML error message or meta redirect
*
*/
function saveuser($A)
{
    global $_CONF, $_TABLES, $_USER, $LANG04, $LANG24, $_US_VERBOSE;

    if ($_US_VERBOSE) {
        COM_errorLog('**** Inside saveuser in usersettings.php ****', 1);
    }

    $reqid = DB_getItem ($_TABLES['users'], 'pwrequestid',
                         "uid = {$_USER['uid']}");
    if ($reqid != $A['uid']) {
        DB_change ($_TABLES['users'], 'pwrequestid', "NULL",
                   'uid', $_USER['uid']);
        COM_accessLog ("An attempt was made to illegally change the account information of user {$_USER['uid']}.");

        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    if (! isset($A['cooktime'])) {
        // If not set or possibly removed from template - set to default
        $A['cooktime'] = $_CONF['default_perm_cookie_timeout'];
    } else {
        $A['cooktime'] = COM_applyFilter($A['cooktime'], true);
    }
    // If empty or invalid - set to user default
    // So code after this does not fail the user password required test
    if ($A['cooktime'] < 0) { // note that == 0 is allowed!
        $A['cooktime'] = $_USER['cookietimeout'];
    }

    // to change the password, email address, or cookie timeout,
    // we need the user's current password
    $service = DB_getItem ($_TABLES['users'], 'remoteservice', "uid = {$_USER['uid']}"); 
    if ($service == '') {
        $current_password = DB_getItem($_TABLES['users'], 'passwd',
                                       "uid = {$_USER['uid']}");
        if (!empty ($A['passwd']) || ($A['email'] != $_USER['email']) ||
                ($A['cooktime'] != $_USER['cookietimeout'])) {
            if (empty($A['old_passwd']) ||
                    (SEC_encryptPassword($A['old_passwd']) != $current_password)) {
    
                return COM_refresh ($_CONF['site_url']
                                    . '/usersettings.php?msg=83');
            } elseif ($_CONF['custom_registration'] &&
                        function_exists ('CUSTOM_userCheck')) {
                $ret = CUSTOM_userCheck ($A['username'], $A['email']);
                if (!empty($ret)) {
                    // Need a numeric return for the default message handler
                    // - if not numeric use default message
                    if (!is_numeric($ret['number'])) {
                        $ret['number'] = 400;
                    }
                    return COM_refresh("{$_CONF['site_url']}/usersettings.php?msg={$ret['number']}");
                }
            }
        } elseif ($_CONF['custom_registration'] &&
                    function_exists ('CUSTOM_userCheck')) {
            $ret = CUSTOM_userCheck ($A['username'], $A['email']);
            if (!empty($ret)) {
                // Need a numeric return for the default message handler
                // - if not numeric use default message
                if (!is_numeric($ret['number'])) {
                    $ret['number'] = 400;
                }
                return COM_refresh("{$_CONF['site_url']}/usersettings.php?msg={$ret['number']}");
            }
        }
    } else {
         if (($A['email'] != $_USER['email']) || ($A['cooktime'] != $_USER['cookietimeout'])) {
             // re athenticate remote user again for these changes to take place

             // Can't just be done here since user may have to relogin to his service which then sends us back here and we lose his changes
             
         }
    }
    // no need to filter the password as it's encoded anyway
    if ($_CONF['allow_username_change'] == 1) {
        $A['new_username'] = COM_applyFilter ($A['new_username']);
        if (!empty ($A['new_username']) &&
                ($A['new_username'] != $_USER['username'])) {
            $A['new_username'] = addslashes ($A['new_username']);
            if (DB_count ($_TABLES['users'], 'username', $A['new_username']) == 0) {
                if ($_CONF['allow_user_photo'] == 1) {
                    $photo = DB_getItem ($_TABLES['users'], 'photo',
                                         "uid = {$_USER['uid']}");
                    if (!empty ($photo)) {
                        $newphoto = preg_replace ('/' . $_USER['username'] . '/',
                                    $A['new_username'], $photo, 1);
                        $imgpath = $_CONF['path_images'] . 'userphotos/';
                        if (rename ($imgpath . $photo,
                                    $imgpath . $newphoto) === false) {
                            $display = COM_siteHeader ('menu', $LANG04[21]);
                            $display .= COM_errorLog ('Could not rename userphoto "' . $photo . '" to "' . $newphoto . '".');
                            $display .= COM_siteFooter ();

                            return $display;
                        }
                        DB_change ($_TABLES['users'], 'photo',
                               addslashes ($newphoto), "uid", $_USER['uid']);
                    }
                }

                DB_change ($_TABLES['users'], 'username', $A['new_username'],
                           "uid", $_USER['uid']);
            } else {
                return COM_refresh ($_CONF['site_url']
                        . '/usersettings.php?msg=51');
            }
        }
    }

    // a quick spam check with the unfiltered field contents
    $profile = '<h1>' . $LANG04[1] . ' ' . $_USER['username'] . '</h1><p>';
    // this is a hack, for some reason remoteservice links made SPAMX SLV check barf
    if (empty($service)) {
        $profile .= COM_createLink($A['homepage'], $A['homepage']) . '<br' . XHTML . '>';
    }
    $profile .= $A['location'] . '<br' . XHTML . '>' . $A['sig'] . '<br' . XHTML . '>'
                . $A['about'] . '<br' . XHTML . '>' . $A['pgpkey'] . '</p>';
    $result = PLG_checkforSpam ($profile, $_CONF['spamx']);
    if ($result > 0) {
        COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden');
    }

    $A['email'] = COM_applyFilter ($A['email']);
    $A['email_conf'] = COM_applyFilter ($A['email_conf']);
    $A['homepage'] = COM_applyFilter ($A['homepage']);

    // basic filtering only
    $A['fullname'] = strip_tags (COM_stripslashes ($A['fullname']));
    $A['location'] = strip_tags (COM_stripslashes ($A['location']));
    $A['sig'] = strip_tags (COM_stripslashes ($A['sig']));
    $A['about'] = strip_tags (COM_stripslashes ($A['about']));
    $A['pgpkey'] = strip_tags (COM_stripslashes ($A['pgpkey']));

    if (!COM_isEmail ($A['email'])) {
        return COM_refresh ($_CONF['site_url']
                . '/usersettings.php?msg=52');
    } else if ($A['email'] !== $A['email_conf']) {
        return COM_refresh ($_CONF['site_url']
                . '/usersettings.php?msg=78');
    } else if (emailAddressExists ($A['email'], $_USER['uid'])) {
        return COM_refresh ($_CONF['site_url']
                . '/usersettings.php?msg=56');
    } else {
        $passwd = '';
        if ($service == '') {
            if (!empty($A['passwd'])) {
                if (($A['passwd'] == $A['passwd_conf']) &&
                        (SEC_encryptPassword($A['old_passwd']) == $current_password)) {
                    $passwd = SEC_encryptPassword($A['passwd']);
                    DB_change($_TABLES['users'], 'passwd', "$passwd",
                              "uid", $_USER['uid']);
                    if ($A['cooktime'] > 0) {
                        $cooktime = $A['cooktime'];
                    } else {
                        $cooktime = -1000;
                    }
                    SEC_setCookie($_CONF['cookie_password'], $passwd,
                                  time() + $cooktime);
                } elseif (SEC_encryptPassword($A['old_passwd']) != $current_password) {
                    return COM_refresh ($_CONF['site_url']
                                        . '/usersettings.php?msg=68');
                } elseif ($A['passwd'] != $A['passwd_conf']) {
                    return COM_refresh ($_CONF['site_url']
                                        . '/usersettings.php?msg=67');
                }
            }
        } else {
            // Cookie
            if ($A['cooktime'] > 0) {
                $cooktime = $A['cooktime'];
            } else {
                $cooktime = -1000;
            }
            SEC_setCookie($_CONF['cookie_password'], $passwd, time() + $cooktime);
        }
            

        if ($_US_VERBOSE) {
            COM_errorLog('cooktime = ' . $A['cooktime'],1);
        }

        if ($A['cooktime'] <= 0) {
            $cooktime = 1000;
            SEC_setCookie($_CONF['cookie_name'], $_USER['uid'],
                          time() - $cooktime);
        } else {
            SEC_setCookie($_CONF['cookie_name'], $_USER['uid'],
                          time() + $A['cooktime']);
        }

        if ($_CONF['allow_user_photo'] == 1) {
            $delete_photo = '';
            if (isset ($A['delete_photo'])) {
                $delete_photo = $A['delete_photo'];
            }
            $filename = handlePhotoUpload ($delete_photo);
        }

        if (!empty ($A['homepage'])) {
            $pos = MBYTE_strpos ($A['homepage'], ':');
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
        $A['location'] = addslashes ($A['location']);
        $A['sig'] = addslashes ($A['sig']);
        $A['about'] = addslashes ($A['about']);
        $A['pgpkey'] = addslashes ($A['pgpkey']);

        if (!empty ($filename)) {
            if (!file_exists ($_CONF['path_images'] . 'userphotos/' . $filename)) {
                $filename = '';
            }
        }

        DB_query("UPDATE {$_TABLES['users']} SET fullname='{$A['fullname']}',email='{$A['email']}',homepage='{$A['homepage']}',sig='{$A['sig']}',cookietimeout={$A['cooktime']},photo='$filename' WHERE uid={$_USER['uid']}");
        DB_query("UPDATE {$_TABLES['userinfo']} SET pgpkey='{$A['pgpkey']}',about='{$A['about']}',location='{$A['location']}' WHERE uid={$_USER['uid']}");

        // Call custom registration save function if enabled and exists
        if ($_CONF['custom_registration'] AND (function_exists('CUSTOM_userSave'))) {
            CUSTOM_userSave($_USER['uid']);
        }

        PLG_userInfoChanged ($_USER['uid']);

        $msg = 5;
        // Re Sync data if needed
        if (isset($A['resynch'])) {
            if ($_CONF['user_login_method']['oauth'] && (strpos($_USER['remoteservice'], 'oauth.') === 0)) {       
                $modules = SEC_collectRemoteOAuthModules();

                $active_service = (count($modules) == 0) ? false : in_array(substr($_USER['remoteservice'], 6), $modules);
                if (!$active_service) {
                    $status = -1;
                    $msg = 115; // Remote service has been disabled.
                } else {
                    $query[] = '';
                    $callback_url = $_CONF['site_url'] . '/usersettings.php?mode=synch&oauth_login=' . $service;

                    if ($service == 'oauth.facebook') {
                        // facebook does resynch during refresh
                        return COM_refresh($callback_url);
                    } else {
                        // all other services use reauth/callback method
                        // send request to OAuth Service for user information
                        require_once $_CONF['path_system'] . 'classes/oauthhelper.class.php';
            
                        $consumer = new OAuthConsumer($service);
    
                        $url = $consumer->find_identity_info($callback_url, $query);
                        if (empty($url)) {
                            $msg = 110; // Can not get URL for authentication.'
                        } else {
                            header('Location: ' . $url);
                            exit;
                        }
                    }
                }            
            }
            
            if ($msg != 5) {
                $msg = 114; // Account saved but re-synch failed.
            }
        }
        
        if ($_US_VERBOSE) {
            COM_errorLog('**** Leaving saveuser in usersettings.php ****', 1);
        }
        

        return COM_refresh ($_CONF['site_url'] . '/users.php?mode=profile&amp;uid='
                            . $_USER['uid'] . '&amp;msg=' . $msg);
    }
}

/**
* Saves user's preferences back to the database
*
* @param    array   $A  User's data to save
* @return   void
*
*/
function savepreferences($A)
{
    global $_CONF, $_TABLES, $_USER;

    if (isset ($A['noicons']) && ($A['noicons'] == 'on')) {
        $A['noicons'] = 1;
    } else {
        $A['noicons'] = 0;
    }
    if (isset ($A['willing']) && ($A['willing'] == 'on')) {
        $A['willing'] = 1;
    } else {
        $A['willing'] = 0;
    }
    if (isset ($A['noboxes']) && ($A['noboxes'] == 'on')) {
        $A['noboxes'] = 1;
    } else {
        $A['noboxes'] = 0;
    }
    if (isset ($A['emailfromadmin']) && ($A['emailfromadmin'] == 'on')) {
        $A['emailfromadmin'] = 1;
    } else {
        $A['emailfromadmin'] = 0;
    }
    if (isset ($A['emailfromuser']) && ($A['emailfromuser'] == 'on')) {
        $A['emailfromuser'] = 1;
    } else {
        $A['emailfromuser'] = 0;
    }
    if (isset ($A['showonline']) && ($A['showonline'] == 'on')) {
        $A['showonline'] = 1;
    } else {
        $A['showonline'] = 0;
    }
    if ($_CONF['advanced_editor'] == 1) {
        if (isset($A['advanced_editor']) && ($A['advanced_editor'] == 'on')) {
            $A['advanced_editor'] = 1;
        } else {
            $A['advanced_editor'] = 0;
        }
    } else {
        // when Advanced Editor is not enabled, make sure we don't overwrite
        // the user's current setting
        $A['advanced_editor'] = DB_getItem($_TABLES['userprefs'],
                                    'advanced_editor', "uid = {$_USER['uid']}");
    }

    $A['maxstories'] = COM_applyFilter ($A['maxstories'], true);
    if (empty ($A['maxstories'])) {
        $A['maxstories'] = 0;
    } else if ($A['maxstories'] > 0) {
        if ($A['maxstories'] < $_CONF['minnews']) {
            $A['maxstories'] = $_CONF['minnews'];
        }
    }

    $TIDS  = @array_values($A['topics']);       // array of strings
    $AIDS  = @array_values($A['selauthors']);   // array of integers
    $BOXES = @array_values($A['blocks']);       // array of integers
    $ETIDS = @array_values($A['etids']);        // array of strings
    $AETIDS = USER_getAllowedTopics();          // array of strings (fetched, needed to "clean" $TIDS and $ETIDS)

    $tids = '';
    if (count($TIDS) > 0) {
        // the array_intersect mitigates the need to scrub the TIDS input
        $tids = addslashes (implode (' ', array_intersect ($AETIDS, $TIDS)));
    }

    $aids = '';
    if (count($AIDS) > 0) {
        // Scrub the AIDS array to prevent SQL injection and bad values
        foreach ($AIDS as $key => $val) {
            $AIDS[$key] = COM_applyFilter($val, true);
        }
        $aids = addslashes (implode (' ', $AIDS));
    }

    $selectedblocks = '';
    if (count ($BOXES) > 0) {
        // Scrub the BOXES array to prevent SQL injection and bad values
        foreach ($BOXES as $key => $val) {
            $BOXES[$key] = COM_applyFilter($val, true);
        }
        $boxes = addslashes (implode (',', $BOXES));

        $blockresult = DB_query("SELECT bid,name FROM {$_TABLES['blocks']} WHERE bid NOT IN ($boxes)");
        $numRows = DB_numRows($blockresult);
        for ($x = 1; $x <= $numRows; $x++) {
            $row = DB_fetchArray ($blockresult);
            if ($row['name'] <> 'user_block' AND $row['name'] <> 'admin_block' AND $row['name'] <> 'section_block') {
                $selectedblocks .= $row['bid'];
                if ($x <> $numRows) {
                    $selectedblocks .= ' ';
                }
            }
        }
    }
    $selectedblocks = trim($selectedblocks);

    $etids = '';
    if (($_CONF['emailstories'] == 1) && (count($ETIDS) > 0)) {
        // the array_intersect mitigates the need to scrub the ETIDS input
        $etids = addslashes (implode (' ', array_intersect ($AETIDS, $ETIDS)));
    }

    if (isset ($A['tzid'])) {
        $A['tzid'] = COM_applyFilter ($A['tzid']);
    } else {
        $A['tzid'] = '';
    }

    if (isset($A['theme'])) {
        $A['theme'] = COM_applyFilter($A['theme']);
    }
    if (empty($A['theme'])) {
        $A['theme'] = $_CONF['theme'];
    }

    if (isset($A['language'])) {
        $A['language'] = COM_applyFilter($A['language']);
    }
    if (empty($A['language'])) {
        $A['language'] = $_CONF['language'];
    }

    // Save theme, when doing so, put in cookie so we can set the user's theme
    // even when they aren't logged in
    $theme = addslashes ($A['theme']);
    $language = addslashes ($A['language']);
    DB_query("UPDATE {$_TABLES['users']} SET theme='$theme',language='$language' WHERE uid = '{$_USER['uid']}'");
    setcookie ($_CONF['cookie_theme'], $A['theme'], time() + 31536000,
               $_CONF['cookie_path'], $_CONF['cookiedomain'],
               $_CONF['cookiesecure']);
    setcookie ($_CONF['cookie_language'], $A['language'], time() + 31536000,
               $_CONF['cookie_path'], $_CONF['cookiedomain'],
               $_CONF['cookiesecure']);
    setcookie ($_CONF['cookie_tzid'], $A['tzid'], time() + 31536000,
               $_CONF['cookie_path'], $_CONF['cookiedomain'],
               $_CONF['cookiesecure']);

    $A['dfid'] = COM_applyFilter ($A['dfid'], true);

    DB_query("UPDATE {$_TABLES['userprefs']} SET noicons='{$A['noicons']}', willing='{$A['willing']}', dfid='{$A['dfid']}', tzid='{$A['tzid']}', emailfromadmin='{$A['emailfromadmin']}', emailfromuser='{$A['emailfromuser']}', showonline='{$A['showonline']}', advanced_editor='{$A['advanced_editor']}' WHERE uid='{$_USER['uid']}'");

    if (empty ($etids)) {
        $etids = '-';
    }
    DB_save($_TABLES['userindex'],"uid,tids,aids,boxes,noboxes,maxstories,etids","{$_USER['uid']},'$tids','$aids','$selectedblocks','{$A['noboxes']}',{$A['maxstories']},'$etids'");
    $A['commentmode'] = COM_applyFilter ($A['commentmode']);
    if (empty ($A['commentmode'])) {
        $A['commentmode'] = $_CONF['comment_mode'];
    }
    $A['commentmode'] = addslashes ($A['commentmode']);

    $A['commentorder'] = COM_applyFilter ($A['commentorder']);
    if (empty ($A['commentorder'])) {
        $A['commentorder'] = 'ASC';
    }
    $A['commentorder'] = addslashes ($A['commentorder']);

    $A['commentlimit'] = COM_applyFilter ($A['commentlimit'], true);
    if ($A['commentlimit'] <= 0) {
        $A['commentlimit'] = $_CONF['comment_limit'];
    }

    DB_save($_TABLES['usercomment'],'uid,commentmode,commentorder,commentlimit',"{$_USER['uid']},'{$A['commentmode']}','{$A['commentorder']}','{$A['commentlimit']}'");
    PLG_userInfoChanged ($_USER['uid']);
}

// MAIN
$mode = '';
if (isset($_POST['btncancel']) AND $_POST['btncancel'] == $LANG_ADMIN['cancel']) {
    echo COM_refresh($_CONF['site_url']);
    exit;
} else if (isset($_POST['btnsubmit']) AND ($_POST['btnsubmit'] == $LANG04[96]) && ($_POST['mode'] != 'deleteconfirmed')) {
    $mode = 'confirmdelete';
} else if (isset ($_POST['mode'])) {
    $mode = COM_applyFilter ($_POST['mode']);
} else if (isset ($_GET['mode'])) {
    $mode = COM_applyFilter ($_GET['mode']);
}

$display = '';

if (! COM_isAnonUser()) {
    switch ($mode) {
    case 'saveuser':
        savepreferences ($_POST);
        $display .= saveuser($_POST);
        PLG_profileExtrasSave ();
        break;

    case 'savepreferences':
        savepreferences ($_POST);
        $display .= COM_refresh ($_CONF['site_url']
                                 . '/usersettings.php?mode=preferences&amp;msg=6');
        break;

    case 'confirmdelete':
        if (($_CONF['allow_account_delete'] == 1) && ($_USER['uid'] > 1)) {
            $accountId = COM_applyFilter ($_POST['account_id']);
            if (!empty ($accountId)) {
                $display .= confirmAccountDelete ($accountId);
            } else {
                $display = COM_refresh ($_CONF['site_url'] . '/index.php');
            }
        } else {
            $display = COM_refresh ($_CONF['site_url'] . '/index.php');
        }
        break;

    case 'deleteconfirmed':
        if (($_CONF['allow_account_delete'] == 1) && ($_USER['uid'] > 1)) {
            $accountId = COM_applyFilter ($_POST['account_id']);
            if (!empty ($accountId)) {
                $display .= deleteUserAccount ($accountId);
            } else {
                $display = COM_refresh ($_CONF['site_url'] . '/index.php');
            }
        } else {
            $display = COM_refresh ($_CONF['site_url'] . '/index.php');
        }
        break;

    case 'plugin':
        PLG_profileExtrasSave ($_POST['plugin']);
        $display = COM_refresh ($_CONF['site_url']
                                . '/usersettings.php?msg=5');
        break;
        
    case 'synch':
        // This mode is the result of a callback from an OAuth service. The user has made a request to resynch their Geeklog user account with the OAuth service they used to login with.
        if ($_CONF['user_login_method']['oauth'] && (strpos($_USER['remoteservice'], 'oauth.') === 0) && isset($_GET['oauth_login'])) {
            $msg = 5;
            $query[] = '';
            
            // Here we go with the handling of OAuth authentification        
            $modules = SEC_collectRemoteOAuthModules();
            $active_service = (count($modules) == 0) ? false : in_array(substr($_GET['oauth_login'], 6), $modules);
            if (!$active_service) {
                $status = -1;
                $msg = 114; // Your re-synch with your remote account has failed but your other account information has been successfully saved.
            } else {
                $query = array_merge($_GET, $_POST);
                $service = $query['oauth_login'];
    
                require_once $_CONF['path_system'] . 'classes/oauthhelper.class.php';

                $consumer = new OAuthConsumer($service);

                if ($service == 'oauth.facebook') {
                    // facebook resynchronizations are easier to perform
                    // we'll use a FB consumer-specific hack/method
                    $oauth_userinfo = $consumer->refresh_userinfo();
                    if (empty($oauth_userinfo)) {
                        $msg = 114; // account information saved but resynch failed
                        COM_errorLog($MESSAGE[$msg]);
                    } else {
                        $consumer->doSynch($oauth_userinfo);
                    }
                } else {
                    // standard OAuth services utilize multiple callback method
                    $callback_url = $_CONF['site_url'] . '/usersettings.php?mode=synch&oauth_login=' . $service;
                    $callback_query_string = $consumer->getCallback_query_string();
                    $cancel_query_string = $consumer->getCancel_query_string();
    
                    if (!isset($query[$callback_query_string]) && (empty($cancel_query_string) || !isset($query[$cancel_query_string]))) {
                        $msg = 114; // Your re-synch with your remote account has failed but your other account information has been successfully saved.
                    } elseif (isset($query[$callback_query_string])) {
                        $oauth_userinfo = $consumer->sreq_userinfo_response($query);
                        if (empty($oauth_userinfo)) {
                            $msg = 111; // Authentication error.
                        } else {
                            $consumer->doSynch($oauth_userinfo);
                        }
                    } elseif (!empty($cancel_query_string) && isset($query[$cancel_query_string])) {
                            $msg = 112; // Certification has been canceled.
                    } else {
                        $msg = 91; // You specified an invalid identity URL.
                    }
                }
            }   
            
            if ($_US_VERBOSE) {
                COM_errorLog('**** Leaving saveuser in usersettings.php ****', 1);
            }
            
            if ($msg == 5) {
                $display = COM_refresh ($_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $_USER['uid'] . '&amp;msg=5');
            } else {
                $display = COM_refresh ($_CONF['site_url'] . '/usersettings.php?msg=' . $msg);
            }
            break;
        }
        
        // Go right into default

    default: // also if $mode == 'edit', 'preferences', or 'comments'
        $display .= COM_siteHeader('menu', $LANG04[16]);
        $display .= COM_showMessageFromParameter();
        $display .= edituser();
        $display .= COM_siteFooter();
        break;
    }
} else {
    $display .= COM_siteHeader ('menu');
    $display .= COM_startBlock ($LANG04[70] . '!');
    $display .= '<br' . XHTML . '>' . $LANG04[71] . '<br' . XHTML . '><br' . XHTML . '>';
    $display .= COM_endBlock ();
    $display .= COM_siteFooter ();
}

COM_output($display);

?>
