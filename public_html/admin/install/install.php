<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// | Geeklog installation script.                                              |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@dingoblue.net.au                    |
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
// | See the INSTALL.HTML file for more information on configuration           |
// | information                                                               |
// +---------------------------------------------------------------------------+
//
// $Id: install.php,v 1.3 2001/12/11 21:02:30 tony_bibbs Exp $

define(LB, "\n");

// Turn this on to have the install process print debug messages.  NOTE: these
// message will get written to installerrors.log as this file may not know
// anything about error.log (the Geeklog error log file)
$_INST_DEBUG = false;


function INST_getCookieTimeoutValues($selected = '')
{
    $timeouts = array(
        '3600'=>'1 hour',
        '7200'=>'2 hours',
        '10800'=>'3 hours',
        '28800'=>'8 hours',
        '86400'=>'1 day',
        '172800'=>'2 days',
        '604800'=>'1 week',
        '1209600'=>'2 weeks',
        '2678400'=>'1 month',
        '31536000'=>'1 year'
    );
    $retval = '';
    for ($i = 1; $i <= count($timeouts); $i++) {
        $retval .= '<option value="' . key($timeouts) . '" ';
        if (key($timeouts) == $selected) {
            $retval .= 'selected="SELECTED"';
        }
        $retval .= '>' . current($timeouts) . '</option>';
        next($timeouts);
    }
    return $retval;
}
/**
* This is called if this is a fresh installation of Geeklog.
* This will load our system defaults and return them.
*
*/
function INST_loadDefaults($gl_path) 
{
    global $_INST_DEBUG;

    $_CONF['path'] = $gl_path . '/';
    include_once($gl_path . '/config.default');

    return $_CONF;
}

/**
* Shows welcome page and gets location of /path/to/geeklog/. NOTE: this
* Doesn't use the template class because we need to know the path to geeklog
* before we can include it.
*
*/
function INST_welcomePage()
{
    $retval = '';

    $retval .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">' . LB;
    $retval .= '<html>' . LB;
    $retval .= '<head>' . LB;
    $retval .= '<title>Geeklog 1.3 Installation</title>' . LB;
    $retval .= '<body bgcolor="#ffffff">' . LB;
    $retval .= '<h2>Geeklog Installation (Step 1 of 3)</h2>' . LB;
    $retval .= '<P>Welcome to Geeklog 1.3, the Ultimate Weblog!  Of all the choices of open-source weblogs we are glad you have chosen to install Geeklog.  With Geeklog version 1.3 you will be able to experience rich features, easy administration and an extendable platform that is fast and, most importantly, secure!  Ok, enough of the marketing rant...now for the installation! You are only 3 short steps from having Geeklog running on your system.<P>Before we get started it is important that if you are upgrading an existing Geeklog installation you back up your database AND your file system.  This installation script will alter either your Geeklog database, your filesystem or both.  <b>YOU HAVE BEEN WARNED</b>! <P> Also, this script will only upgrade you from 1.2.5-1 to version 1.3.  If you are running a version of Geeklog older than 1.2.5-1 then you will need to manaully upgrade to 1.2.5-1 using the scripts in /path/to/geeklog/sql/updates. This script will do incremental upgrades after this version (i.e. when 1.3.1 comes out this script will be able to upgrade from 1.2.5-1 or 1.3 directly to 1.3.1.  Please note this script will not upgrade any beta version of 1.3. <P>To make the installation go easier, we need to know where your Geeklog installation resides on the file system.  Please enter the path to your geeklog installation.  On *nix systems that would be something like /path/to/geeklog.  On windows systems this would be something like C:\path\to\geeklog.' . LB;
    $retval .= '<center>' . LB;
    $retval .= '<form action="install.php" method="post">' . LB;
    $retval .= '<table border="0" cellpadding="0" cellspacing="0">' . LB;
    $retval .= '<tr><td align="right">Path to Geeklog: </td><td><input type="text" name="geeklog_path"> do not include trailing "/" or "\".</td></tr><tr><td align="right">Check if you want your database upgraded</td><td><input type="checkbox" name="upgrade"></td></tr>' . LB;
    $retval .= '<tr><td colspan="2" align="center"><input type="submit" value="Next >>"></td></tr>' . LB;
    $retval .= '</table>' . LB;
    $retval .= '<input type="hidden" name="page" value="1">' . LB;
    $retval .= '</form>' . LB;
    $retval .= '</center>' . LB;
    $retval .= '<body>' . LB;
    $retval .= '</body>' . LB;
    $retval .= '</html>' . LB;

    return $retval;
}

/**
* This function shows the form needed to get the server settings for Geeklog
*
* @gl_path          string      Path to Geeklog on the filesystem
*
*/
function INST_getServerSettings($gl_path,$upgrade)
{
    global $_CONF;

    $server_template = new Template($gl_path . '/system/install_templates');
    $server_template->set_file('server', 'serversettings.tpl');
    $server_template->set_var('path', $gl_path);
    if ($upgrade == 'on') {
        $upgrade = 1;
    } else {
        $upgrade = 0;
    }
    $server_template->set_var('upgrade', $upgrade);
    $server_template->set_var('path_system', $_CONF['path_system']);
    $server_template->set_var('path_html', $_CONF['path_html']);
    $server_template->set_var('path_log', $_CONF['path_log']);
    $server_template->set_var('path_language', $_CONF['path_language']);
    $server_template->set_var('rdf_file', $_CONF['rdf_file']);
    $server_template->set_var('site_name', $_CONF['site_name']);
    $server_template->set_var('site_slogan', $_CONF['site_slogan']);
    $server_template->set_var('site_email', $_CONF['site_mail']);
    $server_template->set_var('site_url', $_CONF['site_url']);
    $server_template->set_var('layout_url', $_CONF['layout_url']);
    $server_template->set_var('path_themes', $_CONF['path_themes']);

    // Get available themes
    $server_template->set_var('theme', $_CONF['theme']);
    if ($_CONF['allow_user_themes'] == 1) {
        $server_template->set_var('userthemes_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('userthemes_checked', '');
    }
    // Get available languages
    $language_options = '';
    $fd = opendir($_CONF['path_language']);
    while (($file = @readdir($fd)) == TRUE) {
        if (is_file($_CONF['path_language'].$file)) {
            clearstatcache();
            $file = str_replace('.php', '', $file);
            $language_options .= '<option value="' . $file . '" ';
            if ($_CONF['language'] == $file) {
                $language_options .= 'selected="SELECTED"';
            }
            $language_options .= '>' . $file . '</option>';
        }
    }
    $server_template->set_var('language_options', $language_options);

    // Get locale options
    $server_template->set_var('locale', $_CONF['locale']);

    // Get date format options
    $server_template->set_var('date', $_CONF['date']);

    // Get day/time format options
    $server_template->set_var('daytime', $_CONF['daytime']);

    // Short date options
    $server_template->set_var('shortdate', $_CONF['shortdate']);
    if ($_CONF['cookie_ip'] == 1) {
        $server_template->set_var('cookieip_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('cookieip_checked', '');
    } 

    // Long-term cookie timeout options
    $longterm_options = INST_getCookieTimeoutValues($_CONF['default_perm_cookie_timeout']);
    $server_template->set_var('longterm_options', $longterm_options);
    $server_template->set_var('cookie_name', $_CONF['cookie_name']);

    // Session cookie timeout options
    $session_options = INST_getCookieTimeoutValues($_CONF['session_cookie_timeout']        = 7200);
    $server_template->set_var('session_options', $session_options);
    $server_template->set_var('cookie_session', $_CONF['cookie_session']);
    $server_template->set_var('cookie_path', $_CONF['cookie_path']);
    $server_template->set_var('unzipcommand', $_CONF['unzipcommand']);
    $server_template->set_var('rmcommand', $_CONF['rmcommand']);

    if ($_CONF['loginrequired'] == 1) {
        $server_template->set_var('loginrequired_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('loginrequired_checked', '');
    }

    // Get post mode options
    if ($_CONF['postmode'] == 'plaintext') {
        $server_template->set_var('plaintext_selected', 'selected="SELECTED"');
    } else {
        $server_template->set_var('html_selected', 'selected="SELECTED"');
    }
    $postmode_options = '';
    $server_template->set_var('postmode_options', $postmode_options);
    $server_template->set_var('speedlimit', $_CONF['speedlimit']);
    if ($_CONF['sortmethod'] = 'sortnum') {
        $server_template->set_var('sortnum_checked', 'selected="SELECTED"');
        $server_template->set_var('alpha_checked', '');
    } else {
        $server_template->set_var('sortnum_checked', '');
        $server_template->set_var('alpha_checked', 'selected="SELECTED"');
    }
    if ($_CONF['showstorycount'] == 1) {
        $server_template->set_var('showstorycount_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('showstorycount_checked', '');
    }
    if ($_CONF['showsubmissioncount'] == 1) {
        $server_template->set_var('showsubmissioncount_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('showsubmissioncount_checked', '');
    }
    if ($_CONF['whatsnewbox'] == 1) {
        $server_template->set_var('whatsnewbox_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('whatsnewbox_checked', '');
    }
    // Get new story interval options
    $newstoriesinterval_options = INST_getCookieTimeoutValues($_CONF['newstoriesinterval']);
    $server_template->set_var('newstoriesinterval_options', $newstoriesinterval_options);
    // Get new comment interval options
    $newcommentsinterval_options = INST_getCookieTimeoutValues($_CONF['newcommentsinterval']);
    $server_template->set_var('newcommentsinterval_options', $newcommentsinterval_options);
    // Get new interval options
    $newlinksinterval_options = INST_getCookieTimeoutValues($_CONF['newlinksinterval']);
    $server_template->set_var('newlinksinterval_options', $newlinksinterval_options);
    
    if ($_CONF['emailstories'] == 1) { 
        $server_template->set_var('emailstories_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('emailstories_checked', '');
    }

    if ($_CONF['personalcalendars'] == 1) {
        $server_template->set_var('personalcalendars_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('personalcalendars_checked', '');
    }
    if ($_CONF['showupcomingevents'] == 1) {
        $server_template->set_var('showupcomingevents_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('showupcomingevents_checked', '');
    }
    $server_template->set_var('event_types', $_CONF['event_types']);

    if ($_CONF['backend'] == 1) {
        $server_template->set_var('backend_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('backend_checked', '');
    }
    $server_template->set_var('limitnews', $_CONF['limitnews']);
    $server_template->set_var('minnews', $_CONF['minnews']);
    if ($_CONF['olderstuff'] == 1) {
        $server_template->set_var('olderstuff_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('olderstuff_checked', '');
    }
    if ($_CONF['contributedbyline'] == 1) {
        $server_template->set_var('contributedbyline_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('contributedbyline_checked', '');
    }
    if ($_CONF['article_image_align'] == 'right') {
        $server_template->set_var('right_checked', 'selected="SELECTED"');
        $server_template->set_var('left_checked', '');
    } else {
        $server_template->set_var('right_checked', '');
        $server_template->set_var('left_checked', 'selected="SELECTED"');
    }
    if ($_CONF['commentsloginrequired'] == 1) {
        $server_template->set_var('commentsloginrequired_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('commentsloginrequired_checked', '');
    }
    $server_template->set_var('commentspeedlimit', $_CONF['commentspeedlimit']);

    $server_template->set_var('comment_limit', $_CONF['comment_limit']);

    $server_template->set_var($_CONF['comment_mode'] . '_selected','selected="SELECTED"');

    $server_template->set_var('maxanswers', $_CONF['maxanswers']);
    
    $pollcookietime_options = INST_getCookieTimeoutValues($_CONF['pollcookietime']    = '86400');
    $server_template->set_var('pollcookietime_options', $pollcookietime_options);

    $polladdresstime_options = INST_getCookieTimeoutValues($_CONF['polladdresstime']   = '604800');
    $server_template->set_var('polladdresstime_options', $polladdresstime_options);

    $server_template->set_var('allowablehtml', $_CONF['allowablehtml']);
    if ($_CONF['censormode'] == 1) {
        $server_template->set_var('censormode_checked', 'checked="CHECKED"');
    } else {
        $server_template->set_var('censormode_checked', '');
    }
    $server_template->set_var('censorreplace', $_CONF['censorreplace']);
    if (!empty($_CONF['censorlist'])) {
        $wordlist = implode(',',$_CONF['censorlist']);
    } else {
        $wordlist = '';
    }
    $server_template->set_var('censorlist',$wordlist);

    return $server_template->parse('output','server');
    
}

function INST_saveServerSettings($A) 
{
    $config_template = new Template($A['geeklog_path'] . '/system/install_templates');
    $config_template->set_file(array('config'=>'config.tpl','common'=>'lib-common.tpl'));
    $config_template->set_var('cfg_path', $A['geeklog_path'] . '/');
    $config_template->set_var('cfg_path_system',$A['path_system']);
    $config_template->set_var('cfg_path_html', $A['path_html']);
    $config_template->set_var('cfg_path_log', $A['path_log']);
    $config_template->set_var('cfg_path_language', $A['path_language']);
    $config_template->set_var('cfg_rdf_file', $A['rdf_file']);
    $config_template->set_var('cfg_site_name', $A['site_name']);
    $config_template->set_var('cfg_site_slogan', $A['site_slogan']);
    $config_template->set_var('cfg_site_mail', $A['site_mail']);
    $config_template->set_var('cfg_site_url', $A['site_url']);
    $config_template->set_var('cfg_theme', $A['theme']);
    $config_template->set_var('cfg_layout_url', $A['site_url'] . '/layout/' . $A['theme']);
    $config_template->set_var('cfg_path_themes', $A['path_html'] . 'layout/');
    if ($A['allow_user_themes'] == 'on') {
        $config_template->set_var('cfg_allow_user_themes',1);
    } else {
        $config_template->set_var('cfg_allow_user_themes',0);
    }
    $config_template->set_var('cfg_path_layout', $A['path_html'] . 'layout/' . $A['theme'] . '/');
    $config_template->set_var('cfg_language', $A['language']);
    $config_template->set_var('cfg_locale', $A['locale']);
    $config_template->set_var('cfg_date', $A['date']);
    $config_template->set_var('cfg_daytime', $A['daytime']);
    $config_template->set_var('cfg_shortdate', $A['shortdate']);
    if ($A['cookie_ip'] == 'on') {
        $config_template->set_var('cfg_cookie_ip', 1);
    } else {
        $config_template->set_var('cfg_cookie_ip', 0);
    }
    $config_template->set_var('cfg_default_perm_cookie_timeout', $A['default_perm_cookie_timeout']);
    $config_template->set_var('cfg_session_cookie_timeout', $A['session_cookie_timeout']);
    $config_template->set_var('cfg_cookie_session', $A['cookie_session']);
    $config_template->set_var('cfg_cookie_name', $A['cookie_name']);
    $config_template->set_var('cfg_cookie_path', $A['cookie_path']);
    $config_template->set_var('cfg_unzipcommand', $A['unzipcommand']);
    $config_template->set_var('cfg_rmcommand', $A['rmcommand']);
    if ($A['loginrequired'] == 'on') {
        $config_template->set_var('cfg_loginrequired', 1);
    } else {
        $config_template->set_var('cfg_loginrequired', 0);
    }
    $config_template->set_var('cfg_postmode', $A['postmode']);
    $config_template->set_var('cfg_speedlimit', $A['speedlimit']);
    $config_template->set_var('cfg_sortmethod', $A['sortmethod']);
    if ($A['showstorycount'] == 'on') {
        $config_template->set_var('cfg_showstorycount', 1);
    } else {
        $config_template->set_var('cfg_showstorycount', 0);
    }
    if ($A['showsubmissioncount'] == 'on') {
        $config_template->set_var('cfg_showsubmissioncount', 1);
    } else {
        $config_template->set_var('cfg_showsubmissioncount', 0);
    }
    if ($A['whatsnewbox'] == 'on') {
        $config_template->set_var('cfg_whatsnewbox', 1);
    } else {
        $config_template->set_var('cfg_whatsnewbox', 0);
    }
    if ($A['emailstories'] == 'on') {
        $config_template->set_var('cfg_emailstories', 1);
    } else {
        $config_template->set_var('cfg_emailstories', 0);
    }
    $config_template->set_var('cfg_newstoriesinterval', $A['newstoriesinterval']);
    $config_template->set_var('cfg_newcommentsinterval', $A['newcommentsinterval']);
    $config_template->set_var('cfg_newlinksinterval', $A['newlinksinterval']);
    if ($A['personalcalendars'] == 'on') {
        $config_template->set_var('cfg_personalcalendars', 1);
    } else {
        $config_template->set_var('cfg_personalcalendars', 0);
    }
    if ($A['showupcomingevents'] == 'on') {
        $config_template->set_var('cfg_showupcomingevents', 1);
    } else {
        $config_template->set_var('cfg_showupcomingevents', 0);
    }
    $config_template->set_var('cfg_event_types', $A['event_types']);
    if ($A['backend'] == 'on') {
        $config_template->set_var('cfg_backend', 1);
    } else {
        $config_template->set_var('cfg_backend', 0);
    }
    $config_template->set_var('cfg_limitnews', $A['limitnews']);
    $config_template->set_var('cfg_minnews', $A['minnews']);
    if ($A['olderstuff'] == 'on') {
        $config_template->set_var('cfg_olderstuff', 1);
    } else {
        $config_template->set_var('cfg_olderstuff', 0);
    }
    $config_template->set_var('cfg_olderstufforder', $A['olderstufforder']);
    if ($A['contributedbyline'] == 'on') {
        $config_template->set_var('cfg_contributedbyline', 1);
    } else {
        $config_template->set_var('cfg_contributedbyline', 0);
    }
    $config_template->set_var('cfg_article_image_align', $A['article_image_align']);
    if ($A['commentsloginrequired'] == 'on') {
        $config_template->set_var('cfg_commentsloginrequired', 1);
    } else {
        $config_template->set_var('cfg_commentsloginrequired', 0);
    }
    $config_template->set_var('cfg_commentspeedlimit', $A['commentspeedlimit']);
    $config_template->set_var('cfg_commentsloginrequired', $A['commentsloginrequired']);
    $config_template->set_var('cfg_comment_limit', $A['comment_limit']);
    $config_template->set_var('cfg_comment_mode', $A['comment_mode']);
    $config_template->set_var('cfg_maxanswers', $A['maxanswers']);
    $config_template->set_var('cfg_pollcookietime', $A['pollcookietime']);
    $config_template->set_var('cfg_polladdresstime', $A['polladdresstime']);
    $config_template->set_var('cfg_allowablehtml', $A['allowablehtml']);
    $config_template->set_var('cfg_parsemode', $A['parsemode']);
    if ($A['censormode'] == 'on') {
        $config_template->set_var('cfg_censormode', 1);
    } else {
        $config_template->set_var('cfg_censormode', 0);
    } 
    $config_template->set_var('cfg_censorreplace', $A['censorreplace']);
    $censorarray = explode(',',$A['censorlist']);
    $wordlist = '';
    for ($j = 1; $j <= count($censorarray); $j++) {
        $wordlist .= '"' . current($censorarray) . '"';
        if ($j <> count($censorarray)) {
            $wordlist .= ',';
        }
        next($censorarray);
    }
    $config_template->set_var('cfg_censorlist', $wordlist);

    // Done substituting variables...now write it all out!
    $output = $config_template->parse('output', 'config');
    $outputfile = $A['geeklog_path'] . '/config.php';
    if (!$file = @fopen($outputfile,w)) {
        print 'Unable to open config.php for writing in install script' . "\n";
        return false;
    } else {
        fputs($file,$output);
        fclose($file);
    }

    // Now write path to config.php to lib-common.php
    $outputfile2 = $A['path_html'] . 'lib-common.php';
    if (!$file = @fopen($outputfile2,w)) {
        print 'Unable to open lib-common.php for writing in install script' . "\n";
        return false;
    } else {
        $config_template->set_var('config_path', $A['geeklog_path'] . '/');
        fputs($file, $config_template->parse('output2','common'));
        fclose($file);
    }

    return true;
}

function INST_getDatabaseSettings($geeklog_path,$upgrade)
{
    global $_CONF;

    if ($upgrade == 1 AND file_exists($_CONF['path_system'] . 'lib-database.php')) {
        include_once($_CONF['path_system'] . 'lib-database.php');
    } else {
        // In this case load database defaults
        include_once($_CONF['path_system'] . 'install_templates/database_defaults.php');
        $_DB_dbms = 'mysql';
        $_DB_host = 'localhost';
        $_DB_name = 'geeklog';
        $_DB_user = 'username';
        $_DB_pass = '';
        $_DB_table_prefix = '';
    }
    $db_templates = new Template($_CONF['path_system'] . 'install_templates');
    $db_templates->set_file(array('db'=>'databasesettings.tpl','tables'=>'tablesettings.tpl','tableentry'=>'table.tpl'));
    $db_templates->set_var('dbms', $_DB_dbms);
    $db_templates->set_var('dbhost', $_DB_host);
    $db_templates->set_var('dbname', $_DB_name);
    $db_templates->set_var('dbuser', $_DB_user);
    $db_templates->set_var('dbpass', $_DB_pass);
    $db_templates->set_var('geeklog_path', $geeklog_path);
    
    if ($upgrade == 1) {
        $db_templates->set_var('upgrade',1);
        // The already have a lib-database file...they can't chnage their tables names
        $old_versions = array('1.2.5-1');
        $versiondd = '<tr><td align="right"><b>Current Geeklog Version:</b></td><td><select name="version">';
        for ($j = 1; $j <= count($old_versions); $j++) {
           $versiondd .= '<option>' . current($old_versions) . '</option>';
           next($old_versions);
        }
        $versiondd .= '</select></td></tr>';
        $db_templates->set_var('UPGRADE_OPTIONS', $versiondd);
        $db_templates->set_var('DB_TABLE_OPTIONS', '');
    } else {
        // This is a fresh installation, let them change their table settings
        $db_templates->set_var('upgrade',0);
        reset($_TABLES);
        for ($i = 1; $i <= count($_TABLES); $i++) {
            $db_templates->set_var('orig_tablename', key($_TABLES));
            $db_templates->set_var('new_tablename', current($_TABLES));
            $db_templates->parse('TABLE_ENTRY', 'tableentry', true);
            next($_TABLES);
        }
        $db_templates->set_var('UPGRADE_OPTIONS','');
        $db_templates->parse('DB_TABLE_OPTIONS', 'tables'); 
    }

    return $db_templates->parse('output','db');
}

/**
* This function saves the DB settings
*
* Writes DB settings to lib-database.php which in return is included
* in by lib-common.php 
*
* @A    Array   Array of database settings to save
*
*/
function INST_saveDatabaseSettings($A)
{
    global $_CONF;

    $db_template = new Template($_CONF['path_system'] . 'install_templates');
    $db_template->set_file('dblib','lib-database.tpl');
    $db_template->set_var('dbms', $A['dbms']);
    $db_template->set_var('dbhost', $A['dbhost']);
    $db_template->set_var('dbname', $A['dbname']);
    $db_template->set_var('dbuser', $A['dbuser']);
    $db_template->set_var('dbpass', $A['dbpass']);
    $db_template->set_var('dbprefix', $A['dbprefix']);

    // To make this easier to automate load, defaults and loop through those instead
    // of doing a set_var for each table
    include_once($_CONF['path_system'] . 'install_templates/database_defaults.php');
    reset($_TABLES);

    // Ok, if this is an upgrade then we will use current table names.  Otherwise
    // use the user-supplied table names
    if ($A['upgrade'] == 1) {
        // This is an upgrade
        for ($i = 1; $i <= count($_TABLES); $i++) {
            $varname = 'cfg_tbl_' . key($_TABLES);
            $db_template->set_var($varname, key($_TABLES));
            next($_TABLES);
        }
    } else {
        // This is a fresh installation, get user settings
        $db_template->set_var('dbprefix', $A['prefix']);
        for ($i = 1; $i <= count($_TABLES); $i++) {
            $varname = 'cfg_tbl_' . key($_TABLES);
            $db_template->set_var($varname, $A['prefix'] . $A[key($_TABLES)]);
            next($_TABLES);
        }
    }

    // Now write path to config.php to lib-common.php
    $outputfile = $_CONF['path_system'] . 'lib-database.php';
    if (!$file = @fopen($outputfile,w)) {
        print 'Unable to open lib-database.php for writing in install script' . "\n";
        return false;
    } else {
        fputs($file, $db_template->parse('output','dblib'));
        fclose($file);
    }

    return true;
    
}

function INST_createDatabaseStructures() {
    global $_CONF;

    // Because the create table syntax can vary from dbms-to-dbms we are
    // leaving that up to each database driver (e.g. mysql.class.php, 
    // postgresql.class.php, etc)


    // Include lib-database.php now that it exists
    include_once($_CONF['path_system'] . 'lib-database.php');
    include_once($_CONF['path_system'] . 'databases/' . $_DB_dbms . '.class.php');
    $instDB = new database($_DB_host,$_DB_name,$_DB_user,$_DB_pass,'');


    // Get DBMS-specific create table array and data array
    include_once($_CONF['path'] . 'sql/' . $_DB_dbms . '_tableanddata.php');

    $progress = '';

    for ($i = 1; $i <= count($_SQL); $i++) {
        //DB_query(current($_SQL));
        $progress .= "executing " . current($_SQL) . "<br>\n";
        $instDB->dbQuery(current($_SQL));
        $error = $instDB->dbError(current($_SQL));
        if (!empty($error)) {
            echo $progress . $error;
            exit;
        }
        next($_SQL);
    }

    // Now insert mandatory data and a small subset of initial data
    for ($i = 1; $i <= count($_DATA); $i++) {
        $progress .= "executing " . current($_DATA) . "<br>\n";
        $instDB->dbQuery(current($_DATA));
        $error = $instDB->dbError(current($_DATA));
        if (!empty($error)) {
            echo $progress . $error;
            exit;
        }
        next($_DATA);
    }
    // Done with installation...redirect to success page
    echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_CONF['site_url'] . '/admin/install/success.php"></head></html>';    
}

function INST_doDatabaseUpgrades($current_gl_version) {
    global $_CONF;

    // Because the upgrade sql syntax can vary from dbms-to-dbms we are
    // leaving that up to each database driver

    // Include lib-database.php now that it exists
    include_once($_CONF['path_system'] . 'lib-database.php');
    include_once($_CONF['path_system'] . 'databases/' . $_DB_dbms . '.class.php');
    $instDB = new database($_DB_host,$_DB_name,$_DB_user,$_DB_pass,'');

    $done = false;
    $progress = '';
    while ($done == false) {
        switch ($current_gl_version) {
        case '1.2.5-1':
            // Get DMBS-specific update sql
            include_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.2.5-1_to_1.3.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                $instDB->dbQuery(current($_SQL),1);
                $error = $instDB->dbError(current($_SQL));
                if (!empty($error)) {
                    echo $progress . $error;
                    exit;
                }
                next($_SQL);
            }
            // OK, now we need to add all users except anonymous to the All Users group and Logged in users group
            // I can hard-code these group numbers because the group table was JUST created with these numbers
            $result = $instDB->dbQuery("SELECT uid FROM {$_TABLES['users']} WHERE uid <> 1");
            $nrows = $instDB->dbNumRows($result);
            for ($i = 1; $i <= $nrows; $i++) {
                $U = $instDB->dbFetchArray($result);
                $instDB->dbQuery("INSERT INTO {$_TABLES['group_assignments']} VALUES (2, {$U['uid']}, NULL)");
                $instDB->dbQuery("INSERT INTO {$_TABLES['group_assignments']} VALUES (13, {$U['uid']}, NULL)");
            }
            $current_gl_version = '1.3';
            break;
        default:
            $done = true;
        }
    }
    // Done with installation...redirect to success page
    echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_CONF['site_url'] . '/admin/install/success.php"></head></html>';
}

// Main

$display = '';

// If possible, load the config file so we can get current settings.  If we
// can't then that means this is a fresh installation OR they want to start
// with the our system defaults.

// Include template class if we got it
if ($page > 0) {
    include_once($geeklog_path . '/system/classes/template.class.php');
}

if (file_exists($geeklog_path . '/config.php')) {
    // We are trying to change settings, load config file
    $config_file = $geeklog_path . '/config.php';
    include_once($config_file);
} else {
    if ($page > 0) {
        $_CONF = INST_loadDefaults($geeklog_path);
    }
}
if ($action == '<< Previous') {
    $page = $page - 2;
}
switch ($page) {
case 1:
    $display .= INST_getServerSettings($geeklog_path,$upgrade); 
    break;
case 2:
    if (INST_saveServerSettings($HTTP_POST_VARS)) {
        $display .= INST_getDatabaseSettings($geeklog_path,$upgrade);
    }
    break;
case 3:
    if (INST_saveDatabaseSettings($HTTP_POST_VARS)) {
        if ($upgrade == 1) {
            if (INST_doDatabaseUpgrades($version)) {
                // Great, installation is complete
            } else {
                // Error occured while updating DB structures
            }
        } else {
            if (INST_createDatabaseStructures()) {
                // Great, installation is complete
            } else {
                // Error occured creating DB structures
            }
        }
    }
    break;
case 4:
default:
    // Ok, let's display a welcome page
    $display .= INST_welcomePage();
    break;
}

echo $display;

?>
