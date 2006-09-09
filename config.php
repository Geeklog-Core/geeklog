<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// |                                                                           |
// | Geeklog configuration file.                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2001-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs - tony AT tonybibbs DOT com                           |
// |          Dirk Haun  - dirk AT haun-online DOT de                          |
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
// | See the docs/install.html and docs/config.html files for more information |
// | on configuration.                                                         |
// +---------------------------------------------------------------------------+
//
// $Id: config.php,v 1.232 2006/09/09 17:59:11 dhaun Exp $

// When setting up Geeklog for the first time, you need to make sure the
// settings in the following 3 sections are correct:
// (1) Database Settings
// (2) Paths
// (3) Site Settings
// You can adjust the other settings once your site is up and running.

// +---------------------------------------------------------------------------+
// | (1) Database Settings                                                     |
// +---------------------------------------------------------------------------+

$_DB_host         = 'localhost';   // host name or IP address of your DB server
$_DB_name         = 'geeklog';     // name of your database,
                                   // must exist before running the installer!
$_DB_user         = 'username';    // MySQL user name
$_DB_pass         = 'password';    // MySQL password

// The table prefix is prepended to each table used by Geeklog to avoid name
// collisions with other tables that may already exist in your database.
$_DB_table_prefix = 'gl_';         // e.g. 'gl_'


// +---------------------------------------------------------------------------+
// | (2) Paths                                                                 |
// +---------------------------------------------------------------------------+

// Note for Windows users: It's safe to use the forward slash '/' instead of
// the backslash '\' in paths. Make sure each path starts with a drive letter!

// This should point to the directory where your config.php file resides.
$_CONF['path']            = '/path/to/geeklog/'; // should end in a slash

// You only need to change this if you moved or renamed the public_html
// directory. In that case, you should specify the complete path to the
// directory (i.e. without the $_CONF['path']) like this:
// $_CONF['path_html']      = '/path/to/your/public_html/';
$_CONF['path_html']         = $_CONF['path'] . 'public_html/';


// +---------------------------------------------------------------------------+
// | (3) Site Settings                                                         |
// +---------------------------------------------------------------------------+

// Make sure this is the correct URL to your site, i.e. to where Geeklog's
// index.php file resides (no trailing slash).
$_CONF['site_url']          = 'http://www.example.com';

// Some hosting services have a preconfigured admin directory. In that case,
// you need to rename Geeklog's admin directory to something like "myadmin"
// and change the following URL as well. Leave as is until you experience any
// problems accessing Geeklog's admin menu.
$_CONF['site_admin_url']    = $_CONF['site_url'] . '/admin';

// This is the return address for all email sent by Geeklog and contact info
// displayed in syndication feeds:
$_CONF['site_mail']         = 'admin@example.com';

// Name and slogan of your site
$_CONF['site_name']         = 'Geeklog Site';
$_CONF['site_slogan']       = 'Another Nifty Geeklog Site';


// ****************************************************************************
// * If you set up Geeklog for the first time, you shouldn't need to change   *
// * anything below this line. Come back here once the site is up and running.*
// ****************************************************************************


// Note: See the file docs/config.html for more information on the settings.

// +---------------------------------------------------------------------------+
// | OTHER PATH SETTINGS                                                       |
// |                                                                           |
// | All paths must have a trailing slash ('/').                               |
// +---------------------------------------------------------------------------+

// you shouldn't need to edit theses
$_CONF['path_system']   = $_CONF['path'] . 'system/';
$_CONF['path_log']      = $_CONF['path'] . 'logs/';
$_CONF['path_language'] = $_CONF['path'] . 'language/';
$_CONF['backup_path']   = $_CONF['path'] . 'backups/';
$_CONF['path_data']     = $_CONF['path'] . 'data/';

// If you set path_images to something other than the default, you will need to
// make sure that you add the following subdirectories to that directory:
// articles/, userphotos/
$_CONF['path_images']   = $_CONF['path_html'] . 'images/';

// +---------------------------------------------------------------------------+
// | PEAR Settings                                                             |
// |                                                                           |
// | Geeklog uses PEAR to send emails (see "Email Settings" below). Here you   |
// | can tell Geeklog whether to use the PEAR packages installed on your       |
// | server or to use the included packages.                                   |
// +---------------------------------------------------------------------------+

// If your server is running PHP 4.3.0 (or newer) then chances are that PEAR
// is already installed and you can change this to: $_CONF['have_pear'] = true;
$_CONF['have_pear'] = false;

// Geeklog comes with the necessary PEAR packages and will pick them up from
// the following directory if $_CONF['have_pear'] = false (above).
$_CONF['path_pear'] = $_CONF['path_system'] . 'pear/';

// +---------------------------------------------------------------------------+
// | Email Settings                                                            |
// |                                                                           |
// | Configure how Geeklog sends email: Via PHP's mail() function, sendmail,   |
// | or via an SMTP server.                                                    |
// +---------------------------------------------------------------------------+

// To send email from Geeklog, you will need to select one of the following
// email backends:
// - 'mail', i.e. use PHP's built-in mail() function
// - 'sendmail', i.e. use the sendmail utility
// - 'smtp', i.e. talk directly to your SMTP server
// The default is 'mail' and will work in most environments.

$_CONF['mail_settings'] = array (
    'backend' => 'mail', // can be one of 'mail', 'sendmail', 'smtp'

    // sendmail parameters (only needed for 'backend' => 'sendmail')
    'sendmail_path' => '/usr/bin/sendmail',
    'sendmail_args' => '',

    // SMTP parameters (only needed for 'backend' => 'smtp')
    'host'     => 'smtp.example.com',
    'port'     => '25',
    'auth'     => false,
    'username' => 'smtp-username',
    'password' => 'smtp-password'
);

// +---------------------------------------------------------------------------+
// | OTHER DATABASE SETTINGS                                                   |
// |                                                                           |
// | Database type and database backup settings.                               |
// +---------------------------------------------------------------------------+

$_DB_dbms = 'mysql'; // can be either 'mysql' or 'mssql' (Microsoft SQL Server)


// the following options are for MySQL only

// optional settings for making database backups from within Geeklog
$_CONF['allow_mysqldump']   = 1;      // 1 = on, 0 = off

// full path of the mysqldump executable (Windows users: add ".exe"!)
$_DB_mysqldump_path = '/usr/bin/mysqldump';

// additional options for mysqldump
// If you're using InnoDB tables, include '--single-transaction' or you
// may end up with inconsistent backups!
$_CONF['mysqldump_options'] = '-Q';


// +---------------------------------------------------------------------------+
// | SITE SETTINGS                                                             |
// |                                                                           |
// | These settings help define your Geeklog site.                             |
// +---------------------------------------------------------------------------+
$_CONF['theme']             = 'professional';  // default theme

// List of entries that you want to see in the site's menu bar (if you're using
// a theme that uses the {menu_elements} variable in its header.thtml).
// Choose any combination of the following (order here = order in the menu).
$_CONF['menu_elements'] = array
(
    // 'home',      // link to homepage
    'contribute',   // contribute / "submit a story" link
    'search',       // link to advanced search
    'stats',        // link to site stats
    'directory',    // link to list of past stories
    // 'prefs',     // link to user's preferences
    'plugins'       // links added by plugins, like {plg_menu_elements}
    // 'custom'     // for custom links (see lib-custom.php)
);

// you shouldn't need to edit the following
$_CONF['layout_url']        = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];
$_CONF['path_themes']       = $_CONF['path_html'] . 'layout/';
$_CONF['path_layout']       = $_CONF['path_themes'] . $_CONF['theme'] . '/';

// stops new registrations if set to true.
$_CONF['disable_new_user_registration'] = false; // set to true to block users.

// optional settings (1 = on, 0 = off)
$_CONF['allow_user_themes']   = 1;
$_CONF['allow_user_language'] = 1; // works only if default_charset is utf-8
$_CONF['allow_user_photo']    = 1; // allow users to upload self-photo

// Allow users to change their username (if set to 1).
$_CONF['allow_username_change'] = 0;

// Allow users to delete their account (if set to 1).
$_CONF['allow_account_delete']  = 0;

// hides the list of authors from the preferences
$_CONF['hide_author_exclusion'] = 0;

// Used by COM_getDisplayName to return Members's Full Name else username
$_CONF['show_fullname'] = 0; // 1 = show user's full name

// Used by COM_getDisplayName to return users remote login service, if they have one.
$_CONF['show_servicename'] = true; // Set to false to not show it.

// +---------------------------------------------------------------------------+
// | Support for custom user registration form and account details             |
// | Requires custom functions to be written that can be placed in lib-custom  |
// | Function hooks are in users.php, usersettings.php and admin/user.php      |
// +---------------------------------------------------------------------------+
$_CONF['custom_registration'] = false;  // Set to true if you have custom code

// +---------------------------------------------------------------------------+
// | Support for remote authentication of users, i.e. logging in via other     |
// | supported remote servers. Requires custom classes in:                     |
// | system/classes/authentication/                                            |
// +---------------------------------------------------------------------------+
$_CONF['remoteauthentication'] = false;  // Set to true to enable remote logins.

// +---------------------------------------------------------------------------+
// | Define action to be taken by Spam-X module if spam detected               |
// | Current Spam-X module supports two actions which can be combined          |
// | Additional classes can be added as well as other plugin extensions        |
// | Actions: 128 = ignore comment and redirect to homepage                    |
// |            8 = mail admin message                                         |
// |          136 (SUM) ignore and email admin                                 |
// +---------------------------------------------------------------------------+
$_CONF['spamx'] = 128;  // Default to ignore comment.

// +---------------------------------------------------------------------------+
// | Sort the links in the admin block and the admin panel.                    |
// +---------------------------------------------------------------------------+
$_CONF['sort_admin'] = true;

// +---------------------------------------------------------------------------+
// | Path to user files relative to the $_CONF['site_url'] (no trailing slash) |
// | Relative Directory where the Editor Image Library store                   |
// +---------------------------------------------------------------------------+
$_CONF_FCK['imagelibrary'] = '/images/library';

// +---------------------------------------------------------------------------+
// | LOCALE SETTINGS                                                           |
// |                                                                           |
// | see docs/config.html#locale for details                                   |
// +---------------------------------------------------------------------------+
$_CONF['language']        = 'english'; // set this to a utf-8 language if you
                            // want users to be able to change their language
$_CONF['locale']          = 'en_GB';
$_CONF['date']            = '%A, %B %d %Y @ %I:%M %p %Z';
$_CONF['daytime']         = '%m/%d %I:%M%p';
$_CONF['shortdate']       = '%x';
$_CONF['dateonly']        = '%d-%b';
$_CONF['timeonly']        = '%I:%M%p';
$_CONF['week_start']      = 'Sun'; // can be 'Sun' or 'Mon'
$_CONF['hour_mode']       = 12;    // 12 hour am/pm or 24 hour format
$_CONF['default_charset'] = 'iso-8859-1'; //  should be same as in $_CONF['language']

// Number formatting
$_CONF['thousand_separator'] = ",";  // could be ' , . etc.
$_CONF['decimal_separator']  = ".";  // could be , . etc.
$_CONF['decimal_count']      = "2";  // if a number has decimals,
                                     //  force to this depth

// Multi-language support
// (note that this section is commented out - remove the '/*' and '*/' lines
//  below to activate it and make sure you understand what it does)
/*

// IMPORTANT!
// 1) Both the $_CONF['language_files'] and the $_CONF['languages'] arrays
//    (see below) must have the same number of elements.
// 2) The shortcuts used must be the same in both arrays.
// 3) All shortcuts must have the same length, e.g. 2 characters.

// The shortcuts are to be used in IDs of objects that are multi-language
// aware, e.g. /article.php/introduction_en and /article.php/introduction_de
// for the English and German version of an introductory article.

// Supported languages
// Maps a shortcut to a Geeklog language file (without the '.php' extension)
$_CONF['language_files'] = array (
    'en' => 'english',
    'de' => 'german_formal'
);

// Display names of supported languages
// Maps the same shortcuts as above to a language name. The language names
// are used to let users switch languages, e.g. in a drop-down menu.
$_CONF['languages'] = array (
    'en' => 'English',
    'de' => 'Deutsch'
);

*/

// "Timezone Hack"
// If your webserver is located in a different timezone than yourself but you
// prefer Geeklog to post stories in your local time, then set your local
// timezone here.
//
// Please note that this does not work when safe_mode is on!
//
// For more information, see this discussion on geeklog.net:
// http://www.geeklog.net/forum/viewtopic.php?showtopic=21232
// $_CONF['timezone'] = 'Etc/GMT-6'; // e.g. 6 hours behind GMT


// +---------------------------------------------------------------------------+
// | SITE STATUS                                                               |
// |                                                                           |
// | To disable your Geeklog site quickly, simply set this flag to false       |
// +---------------------------------------------------------------------------+
$_CONF['site_enabled'] = true;  // true or false

// Message shown when site is down
// When this starts with 'http:' visitors are redirected to that URL
$_CONF['site_disabled_msg'] = 'Geeklog Site is down. Please come back soon.';

// When set to true, this will display /detailed/ debug information in the event
// of a PHP error. ONLY set this to true with your non-production development
// environments!
$_CONF['rootdebug'] = false;

// +---------------------------------------------------------------------------+
// | SESSION SETTINGS                                                          |
// |                                                                           |
// | cookie_ip will store md5(remoteip + randomnum) as the session ID in the   |
// | cookie. This is more secure but will more than likely require dialed up   |
// | users to login each and every time.  If ipbasedsessid is turned off       |
// | (which it is by default) it will just store a random number as the        |
// | session ID in the cookie.                                                 |
// |                                                                           |
// | default_perm_cookie_timeout is how long you want the permanent cookie     |
// | to persist for (in seconds).  This can be overridden by the user in       |
// | their user prefs if they want.  If you set the default to 0, users will   |
// | have to log in again once their session expired.                          |
// |                                                                           |
// | session_cookie_time is how long you want the session cookie to persist    |
// | for.  Only really useful in scenarios where you don't want to allow       |
// | permanent cookies                                                         |
// +---------------------------------------------------------------------------+

$_CONF['cookie_session']                = 'gl_session';
$_CONF['cookie_name']                   = 'geeklog';
$_CONF['cookie_password']               = 'password';
$_CONF['cookie_theme']                  = 'theme';
$_CONF['cookie_language']               = 'language';

$_CONF['cookie_ip']                     = 0;
$_CONF['default_perm_cookie_timeout']   = 28800;
$_CONF['session_cookie_timeout']        = 7200;
$_CONF['cookie_path']                   = '/';
$_CONF['cookiedomain']                  = ''; // e.g. '.example.com'
$_CONF['cookiesecure']                  = 0;

// Geeklog keeps track of when a user last logged in. Set this to false
// if you don't want that.
$_CONF['lastlogin']                     = true;


// +---------------------------------------------------------------------------+
// | This is really redundant but I am including this as a reminder that those |
// | people writing Geeklog Plugins that are OS dependent should check either  |
// | the $_CONF variable below or PHP_OS directly.  If you are writing an      |
// | addon that is OS specific your addon should check the system is using the |
// | right OS.  If not, be sure to show a friendly message that says their GL  |
// | distro isn't running the right OS. Do not modify this value               |
// +---------------------------------------------------------------------------+

$_CONF['ostype']    = PHP_OS;


// Note: PDF conversion didn't make it into this release. Leave as is.
$_CONF['pdf_enabled'] = 0;


// +---------------------------------------------------------------------------+
// | SEARCH SETTINGS                                                           |
// +---------------------------------------------------------------------------+

// default number of search results (per type) to be displayed per page
$_CONF['num_search_results'] = 10;


// +---------------------------------------------------------------------------+
// | MISCELLANEOUS SETTINGS                                                    |
// |                                                                           |
// | These are other various Geeklog settings.  The defaults should work OK    |
// | for most situations.                                                      |
// +---------------------------------------------------------------------------+

// this lets you select which functions are available for registered users only
$_CONF['loginrequired'] = 0; // all of them, if set to 1 will override all else
$_CONF['submitloginrequired']     = 0;
$_CONF['commentsloginrequired']   = 0;
$_CONF['statsloginrequired']      = 0;
$_CONF['searchloginrequired']     = 0;
$_CONF['profileloginrequired']    = 0;
$_CONF['emailuserloginrequired']  = 0;
$_CONF['emailstoryloginrequired'] = 0;
$_CONF['directoryloginrequired']  = 0;

// Submission Settings

// enable (set to 1) or disable (set to 0) submission queues:
$_CONF['storysubmission'] = 1;
$_CONF['usersubmission']  = 0; // 1 = new users must be approved

// When set to 1, this will display an additional block on the submissions page
// that lists all stories that have the 'draft' flag set.
$_CONF['listdraftstories'] = 0;

// Send an email notification when a new submission has been made. The contents
// of the array can be any combination of 'story', 'comment', 'trackback',
// 'pingback', and 'user'.
// Example: $_CONF['notification'] = array ('story', 'comment');
// The email will be sent to $_CONF['site_mail'] (see above).
$_CONF['notification'] = array ();

$_CONF['postmode']      = 'plaintext';  // can be 'plaintext' or 'html'
$_CONF['speedlimit']    = 45;           // in seconds
$_CONF['skip_preview']  = 0; // If = 1, allow user to submit comments and stories without previewing

// +---------------------------------------------------------------------------+
// | Support for custom templates to support advanced Rich Text Editor         |
// | Checked in comment.php, submit.php, admin/story.php and                   |
// | staticpages/index.php. If set true and advanced template exists           |
// | Note: If enabled, the default postmode will be html                       |
// +---------------------------------------------------------------------------+
$_CONF['advanced_editor'] = false;

// +---------------------------------------------------------------------------+
// | Internal Geeklog CRON or scheduled Task/Function setting                  |
// | Plugins can use the runScheduledTask API to activate any automated tasks  |
// | or add code in lib-custom to the CUSTOM_runScheduledTask function         |
// +---------------------------------------------------------------------------+
$_CONF['cron_schedule_interval']        = 86400;   // Seconds - Default 1 day


// Topic Settings

// Topics can be assigned a sort number so that you can control what order they
// appear in the 'Topics' block on the homepage.  If you prefer you can also
// have this sort alphabetically by changing the value to 'alpha' (default is
// by 'sortnum'

$_CONF['sortmethod'] = 'sortnum'; // or 'alpha'

// Show the number of stories in a topic in Topics Block
$_CONF['showstorycount'] = 1;

// Show the number of story submissions for a topic in Topics Block
$_CONF['showsubmissioncount'] = 1;

// Hide 'Home' link from Topics block (if set to 1)
$_CONF['hide_home_link'] = 0;


// Who's Online block settings

// How long an anonymous (guest) user session is good for
$_CONF['whosonline_threshold'] = 300; // in seconds

// If set to 1, don't show names of registered users to anonymous users
$_CONF['whosonline_anonymous'] = 0; // 1 = don't show names to anon. users


// "Daily Digest" settings

// Let users get stories emailed to them
// Requires cron and the use of php as a shell script
$_CONF['emailstories'] = 0;

// Specify length of stories in those emails:
// 0 = send only title + link, 1 = send entire introtext,
// any other number = max. number of characters per story
$_CONF['emailstorieslength'] = 1;

// New users get stories emailed to them per default (= 1) or not (= 0)
$_CONF['emailstoriesperdefault'] = 0;


// When user submission is activated, allow users from these domains to
// register without having to go through the submission queue.
$_CONF['allow_domains'] = ''; // e.g. 'mycompany.com,myothercompany.com'

// Comma-separated list of domain names that are not allowed for new user
// signups (for all new registrations - not only for the user submission queue)
$_CONF['disallow_domains'] = ''; // e.g. 'somebaddomain.com,anotherbadone.com'


// Following times are in seconds
$_CONF['newstoriesinterval']   =   86400; // = 24 hours
$_CONF['newcommentsinterval']  =  172800; // = 48 hours
$_CONF['newtrackbackinterval'] =  172800; // = 48 hours

// Set to 1 to hide a section from the What's New block:
$_CONF['hidenewstories']    = 0;
$_CONF['hidenewcomments']   = 0;
$_CONF['hidenewtrackbacks'] = 0;
$_CONF['hidenewplugins']    = 0;

// max. length of titles to be displayed in the What's New block
$_CONF['title_trim_length'] = 20;

// Disable trackback comments by setting this to 'false'
$_CONF['trackback_enabled'] = true;

// Disable pingbacks by setting this to 'false'
$_CONF['pingback_enabled'] = true;

// Disable pinging weblog directory services by setting this to 'false'.
$_CONF['ping_enabled'] = true;

// Allow / disallow trackbacks and pingbacks to stories by default
// (can be changed individually for every story)
$_CONF['trackback_code'] = 0;   // 0 = trackbacks enabled, -1 = disabled

// how to handle multiple trackbacks and pingbacks from the same URL:
// 0 = reject, 1 = only keep the latest, 2 = allow multiple posts
$_CONF['multiple_trackbacks'] = 0;

// min. time between trackbacks or pingbacks, in seconds
$_CONF['trackbackspeedlimit'] = 300;

// Use this option to check the validity of Trackbacks:
// 0 = don't check anything,
// 1 = check against $_CONF['site_url'], 2 = check full URL
// 4 = check IP address of sender against the site's IP in the Trackback
// add the values to do more than one check, e.g. 2 + 4 = 6, i.e. check URL + IP
$_CONF['check_trackback_link'] = 2;

// how to handle pingbacks from one article on our site to another:
// 0 = skip, 1 = allow, with speed limit, 2 = allow, without speed limit
$_CONF['pingback_self'] = 0;

// Link to the documentation from the Admin block (0 = hide link, 1 = show)
$_CONF['link_documentation'] = 1;

// Story Settings
$_CONF['maximagesperarticle']   = 5;
$_CONF['limitnews']             = 10;
$_CONF['minnews']               = 1;        // minimum number of stories per page
$_CONF['contributedbyline']     = 1;        // If 1, show contributed by line
$_CONF['hideviewscount']        = 0;        // If 1, hide Viewed X times line
$_CONF['hideemailicon']         = 0;    // If 1, hide "email story" option
$_CONF['hideprintericon']       = 0;    // If 1, hide "printer friendly" option
$_CONF['allow_page_breaks']     = 1;    // allow [page_break] in stories
$_CONF['page_break_comments']   = 'last';  // When an article has a page break,
                                           // show comments on the 'first',
                                           //'last' or 'all' pages?
$_CONF['article_image_align']   = 'right'; // Topic icon on left or right.
$_CONF['show_topic_icon']       = 1;       // default for new stories
$_CONF['draft_flag']            = 0;       // default for new stories
$_CONF['frontpage']             = 1;       // default for new stories
$_CONF['hide_no_news_msg']      = 0;       // If 1, hide No News To Display msg
$_CONF['hide_main_page_navigation'] = 0;   // hide "google paging" on index.php


// Advanced theme settings

// Set the default whether to display the right-side blocks (= true) or not
// (= false). In the default configuration, Geeklog will only display the
// right-side blocks on the index page. Please note that setting this to true
// will reduce the amount of space available for the actual page content,
// especially for users with narrow browser windows.
// May require theme changes in article/article.thtml (depending on the theme
// used) to avoid the What's Related and Story Options "blocks" showing up in
// an extra (fourth) column.
$_CONF['show_right_blocks'] = false;

// It is recommended to leave these unchanged and overwrite them in the theme's
// functions.php instead.

// When set to 1, only root users will be able to feature a story
$_CONF['onlyrootfeatures'] = 0;

// When set to 1, this will render the first story on any page using the
// templates for featured stories - even if that story is not featured.
$_CONF['showfirstasfeatured'] = 0;

// When set to 1, this will make the {left_blocks} variable available in
// footer.thtml (and disable it in header.thtml). This is really only useful
// for two-column layouts where you want the left column contain the stories
// and the right column contain the standard blocks.
$_CONF['left_blocks_in_footer'] = 0;

// +---------------------------------------------------------------------------+
// | RSS feed settings                                                         |
// |                                                                           |
// | Settings for RSS feeds (aka RDF feeds). Please note that most of these    |
// | are merely default settings for the feeds created from the "Content       |
// | Syndication" entry in the Admin's menu.                                   |
// +---------------------------------------------------------------------------+

$_CONF['backend']       = 1;    // 1 = activate feeds, 0 = off

// path to your site's default RSS feed
$_CONF['rdf_file']      = $_CONF['path_html'] . 'backend/geeklog.rss';

// This allows a person to limit the rss feed to a certain number of stories
// (e.g. 10 or 12) or else limit the rss feed to all stories within a certain
// period of time in hours (e.g. 24h or 168h).
$_CONF['rdf_limit']     = 10;   // number of stories (10) or hours (24h)

// Include the story's entire intro text in the feed (= 1) or limit the number
// of characters from the intro text (any number > 1) or don't include the text
// at all (= 0).
$_CONF['rdf_storytext'] = 1;

// Default language for the feed - may have to be different than the locale
$_CONF['rdf_language']  = 'en-gb';

// Upper limit for all imported feeds (0 = unlimited, i.e. import all of the
// headlines from the feed).
// Individual limits can be set for every feed in the portal block's settings.
$_CONF['syndication_max_headlines'] = 0;


// Uncomment the following line to set the copyright year in the site's footer
// to a specific year. Otherwise, the current year will be used.
// $_CONF['copyrightyear'] = '2006';


// Optional Image Settings

// If you set $_CONF['image_lib'] below, you must supply a path for the library
// you will use.  Setting this also assumes that if a photo is uploaded that is
// too big either by the image sizes below or by overriding them using the
// upload object then the library you choose will attempt to resize the image.
// Leaving this value empty disables this feature
$_CONF['image_lib'] = ''; // can be one of 'netpbm', 'imagemagick', 'gdlib'

// If you set image_lib to 'imagemagick' give the complete path to mogrify
// here (i.e. including the name of the executable), otherwise comment it out
// NOTE: requires ImageMagick version 5.4.9 (or newer)
//$_CONF['path_to_mogrify']       = '/path/to/mogrify';

// If you set image_lib to 'netpbm' give the path to the netpbm directory, you
// need the trailing slash here.
// NOTE: if you use NETPBM, use the latest package from the Gallery package for
// your operating system found at http://sourceforge.net/projects/gallery in
// the download section.  You need to take the netpbm tarball from them and
// uncompress the file which will create a netpbm directory.  If you plan to
// only use netpbm with Geeklog, put that entire folder in /path/to/geeklog and
// adjust the path below.  The only programs you need from netpbm are giftopnm,
// jpegtopnm, pngtopnm, ppmtogif, pnmtojpeg, pnmtopng and pnmscale
//$_CONF['path_to_netpbm']        = '/path/to/netpbm/';

// Uncomment the following line if you experience problems with the image
// upload. Debug messages will be added to the error.log file.
// $_CONF['debug_image_upload'] = true;

// When set to 1, Geeklog will keep the original, unscaled images and make
// the smaller image link to the unscaled image.
$_CONF['keep_unscaled_image']   = 0; // 1 = keep original images

// when above is set to one and this here also, the user can choose between
// using the original or scaled image in a story
$_CONF['allow_user_scaling']    = 1; // 1 = allow the user to choose

// Story image settings
$_CONF['max_image_width']       = 160;  // In pixels
$_CONF['max_image_height']      = 120;  // In pixels
$_CONF['max_image_size']        = 1048576; // 1048576 = 1MB

// Topic icon settings
$_CONF['max_topicicon_width']   = 48; // In pixels
$_CONF['max_topicicon_height']  = 48; // In pixels
$_CONF['max_topicicon_size']    = 65536; // 65536 = 64KB

// User photo settings
$_CONF['max_photo_width']       = 128; // In pixels
$_CONF['max_photo_height']      = 128; // In pixels
$_CONF['max_photo_size']        = 65536; // 65536 = 64KB

// Use avatars from gravatar.com (if set = true).
// A gravatar will only be requested if there is no uploaded photo.
$_CONF['use_gravatar'] = false;

// gravatar.com provides "movie-style" ratings of the avatars (G, PG, R, X).
// Setting this to 'R' would allow avatars rated as G, PG, and R (but not X).
// $_CONF['gravatar_rating'] = 'R';

// Force a max. width when displaying the user photo (also used for gravatars)
// $_CONF['force_photo_width'] = 75;

// Use this image when there's neither an uploaded photo nor a gravatar.
// Should be the complete URL of the image.
// $_CONF['default_photo'] = 'http://example.com/default.jpg';

// Comment Settings
$_CONF['commentspeedlimit']     = 45;         // minimum time between comment posts, in seconds
$_CONF['comment_limit']         = 100;        // Default Number of Comments under Story
// Default Comment Mode; from 'threaded','nested', 'nocomments', or 'flat'
$_CONF['comment_mode']          = 'threaded';
// Allow / disallow comments to stories by default (can be changed individually for every story)
$_CONF['comment_code']          = 0;          // 0 = comments enabled, -1 = disabled

// Password setting: minimum time between two requests for a new password
$_CONF['passwordspeedlimit'] = 300; // seconds = 5 minutes

// Login Speedlimit.
$_CONF['login_attempts']   = 3;   // number of login attempts allowed before speedlimit kicks in
$_CONF['login_speedlimit'] = 300; // wait (in seconds) after $_CONF['login_attempts'] failed logins


// Parameters for checking HTML tags

// *** Warning: Adding the following tags to the list of allowable HTML can
// *** make your site vulnerable to scripting attacks!
// *** Use with care: <img> <span> <marquee> <script> <embed> <object> <iframe>

/* This is a list of HTML tags that users are allowed to use in their posts.
 * Each tag can have a list of allowed attributes (see 'a' for an example).
 * Any attributes not listed will be filtered, i.e. removed.
 */
$_CONF['user_html'] = array (
    'p'    => array(),
    'b'    => array(),
    'strong'  => array(),
    'i'    => array(),
    'a'    => array('href' => 1, 'title' => 1, 'rel' => 1),
    'em'   => array(),
    'br'   => array(),
    'tt'   => array(),
    'hr'   => array(),
    'li'   => array(),
    'ol'   => array(),
    'ul'   => array(),
    'code' => array(),
    'pre'  => array()
);

/* This is a list of HTML tags that Admins (site admin and story admins) can
 * use in their posts. It will be merged with the above list of user-allowable
 * tags ($_CONF['user_html']). You can also add tags that have already been
 * listed for the user-allowed HTML, so as to allow admins to use more
 * attributes (see 'p' for an example).
 */
$_CONF['admin_html'] = array (
    'p'     => array('class' => 1, 'id' => 1, 'align' => 1),
    'div'   => array('class' => 1, 'id' => 1),
    'span'  => array('class' => 1, 'id' => 1),
    'table' => array('class' => 1, 'id' => 1, 'width' => 1, 'border' => 1,
                     'cellspacing' => 1, 'cellpadding' => 1),
    'tr'    => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1),
    'th'    => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1,
                     'colspan' => 1, 'rowspan' => 1),
    'td'    => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1,
                     'colspan' => 1, 'rowspan' => 1)
);

/* Optional HTML Tags that will be enabled if advanced editor is enabled
 * Posible to add tags to the allowable general USER $_CONF['user_html'] as well
*/
if ($_CONF['advanced_editor']) {
    $_CONF['admin_html']['a']       = array('href' => 1, 'title' => 1, 'id' => 1, 'lang' => 1, 'name' => 1, 'type' => 1, 'rel' => 1);
    $_CONF['admin_html']['hr']      = array ('style' => 1);
    $_CONF['admin_html']['ol']      = array ('style' => 1);
    $_CONF['admin_html']['ul']      = array ('style' => 1);
    $_CONF['admin_html']['caption'] = array ();
    $_CONF['admin_html']['table']   = array ('class' => 1, 'id' => 1, 'style' => 1, 'align' => 1, 'width' => 1,
                                             'border' => 1, 'cellspacing' => 1, 'cellpadding' => 1);
    $_CONF['admin_html']['tbody']   = array ();
    $_CONF['admin_html']['img']     = array('src' => 1, 'width' => 1, 'height' => 1, 'vspace' => 1, 'hspace' => 1,
                                            'dir' => 1, 'align' => 1, 'valign' => 1, 'border' => 1, 'lang' => 1,
                                            'longdesc' => 1, 'title' => 1, 'id' => 1, 'alt' => 1);
    $_CONF['admin_html']['font']    = array('face' => 1, 'size' => 1, 'style' => 1);
}

// When set to 1, disables the HTML filter for all users in the 'Root' group.
// Obviously, you should only enable this if you know what you're doing and
// when you can trust all the users in the 'Root' group not to use this for
// Cross Site Scripting, defacements, etc. USE AT YOUR OWN RISK!
$_CONF['skip_html_filter_for_root'] = 0;

// list of protocols that are allowed in links
$_CONF['allowed_protocols'] = array ('http', 'https', 'ftp');

// disables autolinks if set to 1
$_CONF['disable_autolinks'] = 0; // 0 = autolinks enabled

// Parameters for checking for "bad" words
$_CONF['censormode']    = 1;
$_CONF['censorreplace'] = '*censored*';
$_CONF['censorlist']    = array('fuck','cunt','fucker','fucking','pussy','cock','c0ck',' cum ','twat','clit','bitch','fuk','fuking','motherfucker');


// IP lookup support
//
// If $_CONF['ip_lookup'] contains the URL to a web-based service for IP
// address lookups, Geeklog will let you click on IP addresses so that you
// can find out where a visitor came from. This can either be a remote
// service or a plugin like Tom Willet's Nettools.
// The '*' in the URL will be replaced with the IP address to look up.
//
// uncomment this line if you have Tom Willet's Nettools installed
// $_CONF['ip_lookup'] = $_CONF['site_url'] . '/nettools/whois.php?domain=*';


// This feature, when activated, makes some of Geeklog's URLs more crawler
// friendly, i.e. more likely to be picked up by search engines.
// Only implemented for stories, static pages, and portal links right now.
//
// Note: Works with Apache (Linux and Windows successfully tested).
//       Unresolvable issues with systems running IIS; known PHP CGI bug.
$_CONF['url_rewrite'] = false; // false = off, true = on

// Define default permissions for new objects created from the Admin panels.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 3 = read + write permissions (perm_owner and perm_group only)
// 2 = read-only
// 0 = neither read nor write permissions
// (a value of 1, ie. write-only, does not make sense and is not allowed)
$_CONF['default_permissions_block'] = array (3, 2, 2, 2);
$_CONF['default_permissions_story'] = array (3, 2, 2, 2);
$_CONF['default_permissions_topic'] = array (3, 2, 2, 2);

// Define a few useful things for GL

// Story Record Options for the STATUS Field
define('STORY_ARCHIVE_ON_EXPIRE', '10');
define('STORY_DELETE_ON_EXPIRE', '11');

if (!defined ('LB')) {
    define('LB',"\n");
}
if (!defined ('VERSION')) {
    define('VERSION', '1.4.1cvs');
}

$_STATES = array(
        '--'=>'',
        'AL'=>'Alabama',
        'AK'=>'Alaska',
        'AZ'=>'Arizona',
        'AR'=>'Arkansas',
        'CA'=>'California',
        'CO'=>'Colorado',
        'CT'=>'Connecticut',
        'DE'=>'Delaware',
        'DC'=>'District of Columbia',
        'FL'=>'Florida',
        'GA'=>'Georgia',
        'HI'=>'Hawaii',
        'ID'=>'Idaho',
        'IL'=>'Illinois',
        'IN'=>'Indiana',
        'IA'=>'Iowa',
        'KS'=>'Kansas',
        'KY'=>'Kentucky',
        'LA'=>'Louisiana',
        'ME'=>'Maine',
        'MD'=>'Maryland',
        'MA'=>'Massachusetts',
        'MI'=>'Michigan',
        'MN'=>'Minnesota',
        'MS'=>'Mississippi',
        'MO'=>'Missouri',
        'MT'=>'Montana',
        'NE'=>'Nebraska',
        'NV'=>'Nevada',
        'NH'=>'New Hampshire',
        'NJ'=>'New Jersey',
        'NM'=>'New Mexico',
        'NY'=>'New York',
        'NC'=>'North Carolina',
        'ND'=>'North Dakota',
        'OH'=>'Ohio',
        'OK'=>'Oklahoma',
        'OR'=>'Oregon',
        'PA'=>'Pennsylvania',
        'RI'=>'Rhode Island',
        'SC'=>'South Carolina',
        'SD'=>'South Dakota',
        'TN'=>'Tennessee',
        'TX'=>'Texas',
        'UT'=>'Utah',
        'VT'=>'Vermont',
        'VA'=>'Virginia',
        'WA'=>'Washington',
        'WV'=>'West Virginia',
        'WI'=>'Wisconsin',
        'WY'=>'Wyoming'
    );

?>
