<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// |                                                                           |
// | Geeklog configuration file.                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2001-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs - tony@tonybibbs.com                                  |
// |          Dirk Haun  - dirk@haun-online.de                                 |
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
// $Id: config.php,v 1.97 2003/09/04 09:50:15 dhaun Exp $

// When setting up Geeklog for the first time, you need to make sure the
// settings in the following 5 sections are correct:
// (1) Database Settings
// (2) Paths
// (3) Site Settings
// (4) PEAR Settings
// (5) Email Settings
// You can adjust the other settings once your site is up and running.

// +---------------------------------------------------------------------------+
// | (1) Database Settings                                                     |
// +---------------------------------------------------------------------------+

$_DB_host         = 'localhost';   // host name or IP address of your DB server
$_DB_name         = 'geeklog';     // name of your database,
                                   // must exist before running the installer!
$_DB_user         = 'username';    // MySQL user name
$_DB_pass         = 'password';    // MySQL password

// The table prefix is prepended to each table used be Geeklog to avoid name
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

// This is the return address for all email sent by Geeklog:
$_CONF['site_mail']         = 'admin@example.com';

// Name and slogan of your site
$_CONF['site_name']         = 'Geeklog Site';
$_CONF['site_slogan']       = 'Another Nifty Geeklog Site';


// +---------------------------------------------------------------------------+
// | (4) PEAR Settings                                                         |
// +---------------------------------------------------------------------------+

// If your server is running PHP 4.3.0 (or newer) then chances are that PEAR
// is already installed and you can leave this as "true".
$_CONF['have_pear'] = true;

// Geeklog comes with the necessary PEAR packages, so if you don't have PEAR
// installed, set $_CONF['have_pear'] = false (above). The following path
// points to those packages (leave as is unless you know what your're doing).
$_CONF['path_pear'] = $_CONF['path_system'] . 'pear/';


// +---------------------------------------------------------------------------+
// | (5) Email Settings                                                        |
// +---------------------------------------------------------------------------+

// To send email from Geeklog, you will need to select one of the following
// email backends:
// - 'mail', i.e. use PHP's built-in mail() function
// - 'sendmail', i.e. use the sendmail utility
// - 'smtp', i.e. talk directly to your SMTP server

$_CONF['mail_settings'] = array (  
    'backend' => 'mail', // can be one of 'mail', 'sendmail', 'smtp'

    // sendmail parameters
    'sendmail_path' => '/usr/bin/sendmail',
    'sendmail_args' => '',

    // SMTP parameters
    'host'     => 'smtp.example.com',
    'port'     => '25',
    'auth'     => false,
    'username' => 'smtp-username',
    'password' => 'smtp-password'
);


// ****************************************************************************
// * If you set up Geeklog for the first time, you shouldn't need to change   *
// * anything below this line. Come back here once the site is up and running.*
// ****************************************************************************


// Note: See the file docs/config.html for more information on the settings.

// +---------------------------------------------------------------------------+
// | OTHER DATABASE SETTINGS                                                   |
// |                                                                           |
// | These settings tell Geeklog about your database and how to connect to it. |
// +---------------------------------------------------------------------------+

$_DB_dbms = 'mysql';   // Do not change (currently, only MySQL is supported)

// optional settings for making database backups from within Geeklog
$_CONF['allow_mysqldump']   = 1;      // 1 = on, 0 = off
$_DB_mysqldump_path         = '/usr/bin/mysqldump'; // path to mysqldump binary
$_CONF['mysqldump_options'] = '-Q';   // additional options for mysqldump

// +---------------------------------------------------------------------------+
// | OTHER PATH SETTINGS                                                       |
// |                                                                           |
// | All paths must have a trailing slash ('/').                               |
// +---------------------------------------------------------------------------+

// you shouldn't need to edit theses
$_CONF['path_system']     = $_CONF['path'] . 'system/';
$_CONF['path_log']        = $_CONF['path'] . 'logs/';
$_CONF['path_language']   = $_CONF['path'] . 'language/';
$_CONF['backup_path']     = $_CONF['path'] . 'backups/';

// path to your site's RSS/RDF feed
$_CONF['rdf_file']        = $_CONF['path_html'] . 'backend/geeklog.rdf';

// +---------------------------------------------------------------------------+
// | SITE SETTINGS                                                             |
// |                                                                           |
// | These settings help define your Geeklog site.                             |
// +---------------------------------------------------------------------------+
$_CONF['theme']             = 'XSilver';  // default theme

// you shouldn't need to edit the following
$_CONF['layout_url']        = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];
$_CONF['path_themes']       = $_CONF['path_html'] . 'layout/';
$_CONF['path_layout']       = $_CONF['path_themes'] . $_CONF['theme'] .'/';

// optional settings
$_CONF['allow_user_themes']   = 1;
$_CONF['allow_user_language'] = 1;
$_CONF['allow_user_photo']    = 1; // 1 = on, 0 = off...flag that allows users to upload self-photo

// hides the list of authors from the preferences
$_CONF['hide_author_exclusion'] = 0;


// +---------------------------------------------------------------------------+
// | Support for custom user registration form and account details             |
// | Requires custom functions to be written that can be placed in lib-custom  |
// | Function hooks are in users.php, usersettings.php and admin/user.php      |
// +---------------------------------------------------------------------------+
$_CONF['custom_registration'] = false;  // Set to true if you have custom code


// +---------------------------------------------------------------------------+
// | LOCALE SETTINGS                                                           |
// +---------------------------------------------------------------------------+
$_CONF['language']  = 'english';
$_CONF['locale']    = 'en-gb';
$_CONF['date']      = '%A, %B %d %Y @ %I:%M %p %Z';
$_CONF['daytime']   = '%m/%d %I:%M%p';
$_CONF['shortdate'] = '%x';
$_CONF['dateonly']  = '%d-%b';
$_CONF['timeonly']  = '%I:%M %p %Z';
$_CONF['default_charset'] = 'iso-8859-1';
$_CONF['rdf_language']    = 'en-gb'; // may have to be different than the locale

// ----------------------------------------------------------------------------+
// | SITE STATUS                                                               |
// |                                                                           |
// | To disable your Geeklog site quickly, simply set this flag to false       |
// +---------------------------------------------------------------------------+
$_CONF['site_enabled'] = true;  // true or false

// Message shown when site is down
// When this starts with 'http:' visitors are redirected to that URL
$_CONF['site_disabled_msg'] = 'Geeklog Site is down. Please come back soon.';

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
// | to persist for.  This can be overridden by the user in their user prefs   |
// | if they want.  If you don't want to allow permanent cookies set the       |
// | value to an empty string ''.                                              |
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
$_CONF['cookie_lastvisit']              = 'LastVisit';
$_CONF['cookie_lastvisittemp']          = 'LastVisitTemp';

$_CONF['cookie_ip']                     = 0;
$_CONF['default_perm_cookie_timeout']   = 604800;
$_CONF['session_cookie_timeout']        = 7200;
$_CONF['cookie_path']                   = '/';
$_CONF['cookiedomain']                  = ''; // e.g. '.example.com'
$_CONF['cookiesecure']                  = 0;

// Set to false if you don't want to store last login data and time in the userinfo table
$_CONF['lastlogin']                     = true;

// +---------------------------------------------------------------------------+
// | This is really redundant but I am including this as a reminder that those |
// | people writing Geeklog Plug-ins that are OS dependent should check either |
// | the $_CONF variable below or PHP_OS directly.  If you are writing an      |
// | addon that is OS specific your addon should check the system is using the |
// | right OS.  If not, be sure to show a friendly message that says their GL  |
// | distro isn't running the right OS. Do not modify this value               |
// +---------------------------------------------------------------------------+

$_CONF['ostype']    = PHP_OS;

// +---------------------------------------------------------------------------+
// | SEARCH SETTINGS                                                           |
// |                                                                           |
// | These aren't really used at the moment - leave as is ...                  |
// +---------------------------------------------------------------------------+

// Indicates if we should expand search results or not.
//     true = show title with summary
//     false = title date author hits on one line
$_CONF['expanded_search_results']  =  true;
    
// 0: use users max stories per page
// 1: Show all
// any other number is the # of results per page
$_CONF['max_search_results']  =  1;
    
// maximum length for the summary text for search results should be    
$_CONF['summary_length']  =  250;
    
    
// +---------------------------------------------------------------------------+
// | MISCELLANEOUS SETTINGS                                                    |
// |                                                                           |
// | These are other various Geeklog settings.  The defaults should work OK    |
// | for most situations.                                                      |
// +---------------------------------------------------------------------------+

// this lets you select which functions are available for registered users only 
$_CONF['loginrequired'] = 0; // all of them, if set to 1 will override all else 
$_CONF['submitloginrequired'] = 0;
$_CONF['commentsloginrequired'] = 0;
$_CONF['linksloginrequired'] = 0;
$_CONF['pollsloginrequired'] = 0;
$_CONF['calendarloginrequired'] = 0;
$_CONF['statsloginrequired'] = 0;
$_CONF['searchloginrequired'] = 0;
$_CONF['profileloginrequired'] = 0;
$_CONF['emailuserloginrequired'] = 0;
$_CONF['emailstoryloginrequired'] = 0;

// Submission Settings

// enable (set to 1) or disable (set to 0) submission queues:
$_CONF['storysubmission'] = 1;
$_CONF['linksubmission']  = 1;
$_CONF['eventsubmission'] = 1;
$_CONF['usersubmission']  = 0;

// When set to 1, this will display an additional block on the submissions page
// that lists all stories that have the 'draft' flag set.
$_CONF['listdraftstories'] = 0;

// Send an email notification when a new submission has been made. The contents
// of the array can be any combination of 'story', 'link', 'event', and 'user'.
// Example: $_CONF['notification'] = array ('story', 'link', 'event');
// The email will be sent to $_CONF['site_mail'] (see above).
$_CONF['notification'] = array ();

$_CONF['postmode']      = 'plaintext';  // can be 'plaintext' or 'html'
$_CONF['speedlimit']    = 45;         // in seconds
$_CONF['skip_preview']  = 0; // If = 1, allow user to submit comments and stories without previewing

// Allow users to change their username (if set to 1).
$_CONF['allow_username_change'] = 0;

// Allow users to delete their account (if set to 1).
$_CONF['allow_account_delete']  = 0;


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

// Show blocks for empty search results
$_CONF['showemptysearchresults'] = 0;

// How long an anonymous (guest) user session is good for
$_CONF['whosonline_threshold'] = 300; // in seconds


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

// Following times are in seconds
$_CONF['newstoriesinterval']  = 86400;
$_CONF['newcommentsinterval'] = 172800;
$_CONF['newlinksinterval']    = 1209600;

// Set to 1 to hide a section from the What's New block:
$_CONF['hidenewstories'] = 0;
$_CONF['hidenewcomments'] = 0;
$_CONF['hidenewlinks'] = 0;

// Calendar Settings
$_CONF['personalcalendars']     = 1;
$_CONF['showupcomingevents']    = 1;
$_CONF['upcomingeventsrange']   = 14; // days
$_CONF['event_types']           = 'Anniversary,Appointment,Birthday,Business,Education,Holiday,Meeting,Miscellaneous,Personal,Phone Call,Special Occasion,Travel,Vacation';

// Story Settings
$_CONF['maximagesperarticle']   = 5;
$_CONF['limitnews']             = 10;
$_CONF['minnews']               = 1;	// minimum number of stories per page
$_CONF['contributedbyline']     = 1;	// If 1, show contributed by line
$_CONF['article_image_align']   = 'right';   // Topic icon on left or right.
$_CONF['hideemailicon']         = 0;    // If 1, hide "email story" option
$_CONF['hideprintericon']       = 0;    // If 1, hide "printer friendly" option

// When set to 1, this will render the first story on any page using the
// templates for featured stories - even if that story is not featured.
$_CONF['showfirstasfeatured']   = 0;

// RSS/RDF feed settings
$_CONF['backend']               = 1;    // 1 = active, 0 = off
// This allows a person to limit the rdf feed to a certain number of stories
// (e.g. 10 or 12) or else limit the rdf feed to all stories within a certain
// period of time in hours (e.g. 24h or 168h). 
$_CONF['rdf_limit']             = 10;   // number of stories (10) or hours (24h)
// Include the story's entire intro text in the feed (= 1) or limit the number
// of characters from the intro text (any number > 1) or don't include the text
// at all (= 0).
$_CONF['rdf_storytext']         = 0;

// Uncomment the following line to set the copyright year in the site's footer
// to a specific year. Otherwise, the current year will be used.
// $_CONF['copyrightyear'] = '2003';


// Optional Image Settings

// If you set $_CONF['image_lib'] below, you must supply a path for the library
// you will use.  Setting this also assumes that if a photo is uploaded that is
// too big either by the image sizes below or by overriding them using the
// upload object then the library you choose will attempt to resize the image.
// Leaving this value empty disables this feature
$_CONF['image_lib']             = ''; // can be netpbm, imagemagick

// If you set image_lib to imagemagick give this path otherwise comment it out
// NOTE: you will need a fairly recent version of ImageMagick for this to work.
// ImageMagick version 5.4.9 (or newer) is recommended.
//$_CONF['path_to_mogrify']       = '/path/to/mogrify';

// If you set image_lib to netpbm give the path to the netpbm directory, you
// need the trailing slash here.
// NOTE: if you use NETPBM, use the latest package from the Gallery package for
// your operating system found at http://sourceforge.net/projects/gallery in
// the download section.  You need to take the netpbm tarball from them and
// uncompress the file which will create a netpbm directory.  If you plan to
// only use netpbm with Geeklog, put that entire folder in /path/to/geeklog and
// adjust the path below.  The only programs you need from netpbm are giftopnm,
// jpegtopnm, pngtopnm, ppmtogif, ppmtojpeg, pnmtopng and pnmscale
//$_CONF['path_to_netpbm']        = '/path/to/netpbm/';

// When set to 1, Geeklog will keep the original, unscaled images and make
// the smaller image link to the unscaled image.
$_CONF['keep_unscaled_image']   = 0; // 1 = keep original images

// Story image settings
$_CONF['max_image_width']       = 300;  // In pixels
$_CONF['max_image_height']      = 300;  // In pixels
$_CONF['max_image_size']        = 1048576; // 1048576 = 1MB 

// User photo settings
$_CONF['max_photo_width']       = 96;  // In pixels
$_CONF['max_photo_height']      = 96;  // In pixels
$_CONF['max_photo_size']        = 65536; // 65536 = 64KB

// Comment Settings
$_CONF['commentspeedlimit']     = 45;
$_CONF['comment_limit']         = 100;        // Default Number of Comments under Story
$_CONF['comment_mode']          = 'threaded'; // Default Comment Mode; from 'threaded','nested','nocomments',and 'flat'
// Allow / disallow comments to stories by default (can be changed individually for every story)
$_CONF['comment_code']          = 0; // 0 = comments enabled, -1 = disabled

// Poll Settings
$_CONF['maxanswers']        = 10;
// 'submitorder' is order answers are saved in admin/poll.php
// 'voteorder' will list answers in order of number of votes (highest->lowest);
$_CONF['answerorder']       = 'submitorder';
$_CONF['pollcookietime']    = 86400;
$_CONF['polladdresstime']   = 604800;

// Password setting: minimum time between two requests for a new password
$_CONF['passwordspeedlimit'] = 300; // seconds = 5 minutes

// Links Settings
// You can set both of the following to 0 to get back the old (pre-1.3.6)
// style of the links section. Setting only linkcols to 0 will hide the
// categories but keep the paging. Setting only linksperpage to 0 will list
// all the links of the selected category on one page.
$_CONF['linkcols']     =  3; // categories per column
$_CONF['linksperpage'] = 10; // links per page

// Parameters for checking words and HTML tags

// *** Warning: Adding the following tags to the list of allowable HTML can     
// *** make your site vulnerable to scripting attacks!
// *** Use with care: <img> <span> <marquee> <script> <embed> <object> <iframe> 
$_CONF['allowablehtml'] = '<p>,<b>,<i>,<a>,<em>,<br>,<tt>,<hr>,<li>,<ol>,<ul>,<code>,<pre>';
$_CONF['adminhtml'] = $_CONF['allowablehtml'] . ', <div>,<table>,<tr>,<td>,<th>';
$_CONF['censormode']    = 1;
$_CONF['censorreplace'] = '*censored*';
$_CONF['censorlist']    = array('fuck','cunt','fucker','fucking','pussy','cock','c0ck',' cum ','twat','clit','bitch','fuk','fuking','motherfucker');

// EXPERIMENTAL!
// This feature when fully implemented, will make your site crawler friendly.
// Only works with staticpages right now.
//
// Note: Works with Apache (Linux and Windows successfully tested).
//       Unresolvable issues with systems running IIS; known PHP CGI bug.
$_CONF['url_rewrite']       = false; // false = off, true = on

// Define a few useful things for GL
if (!defined ('LB')) {
    define('LB',"\n");
}
if (!defined ('VERSION')) {
    define('VERSION', '1.3.8-1');
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
