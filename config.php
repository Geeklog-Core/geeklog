<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// | Geeklog configuration file.                                               |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2001 by the following authors:                              |
// |                                                                           |
// | Authors: Tony Bibbs - tony@tonybibbs.com                                  |
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
// $Id: config.php,v 1.37 2002/05/20 18:07:56 tony_bibbs Exp $

// ----------------------------------------------------------------------------+
// | SITE STATUS                                                               |
// |                                                                           |
// | To disable your Geeklog site quickly, simply set this flag to false       |
// +---------------------------------------------------------------------------+
$_CONF['site_enabled'] = true;  // true or false
// Message shown when site is down
$_CONF['site_disabled_msg'] = 'Geeklog Site is down. Please come back soon.';

// +---------------------------------------------------------------------------+
// | DATABASE SETTINGS                                                         |
// |                                                                           |
// | All paths must have a trailing slash ('/'). The 'path' value signifies    |
// | where the config.php (this file) resides                                  |
// +---------------------------------------------------------------------------+
$_DB_dbms           = 'adodb';              // Currently only mysql or adodb support
$_DB_host           = 'localhost';  
$_DB_name           = 'geeklog';            // Yes, your DB must exists before running installer!
$_DB_user           = 'username';
$_DB_pass           = 'password';
$_DB_table_prefix   = 'gl_';                // e.g. 'gl_'
$_DB_mysqldump_path = '/usr/bin/mysqldump'; // path to mysqldump binary e.g. /usr/bin/mysqldump
$_CONF['allow_mysqldump']   = 1;            // 1 = on, 0 = off

// +---------------------------------------------------------------------------+
// | SERVER SETTINGS                                                           |
// |                                                                           |
// | All paths must have a trailing slash ('/'). The 'path' value signifies    |
// | where the config.php (this file) resides                                  | 
// +---------------------------------------------------------------------------+
$_CONF['path']              = '/path/to/geeklog/'; // C:/inetpub/wwwroot/geeklog
$_CONF['path_system']       = $_CONF['path'] . 'system/';
$_CONF['path_html']         = $_CONF['path'] . 'public_html/';
$_CONF['path_log']          = $_CONF['path'] . 'logs/';
$_CONF['path_language']     = $_CONF['path'] . 'language/';
$_CONF['rdf_file']          = $_CONF['path_html'] . 'backend/geeklog.rdf';
$_CONF['backup_path']       = $_CONF['path'] . 'backups/';

// Experimental, only works with staticpages right now. This feature is known
// to have issues that are unresolvable with systems running IIS.  Have not
// tested on windows with apache yet.  This feature when fully implemented,
// will make your site crawler friendly.  Problems with IIS are known PHP CGI
// bug.

$_CONF['url_rewrite']       = false; // false = off, true = on

// +---------------------------------------------------------------------------+
// | SITE SETTINGS                                                             |
// |                                                                           |
// | These settings help define your Geeklog site.                             |
// +---------------------------------------------------------------------------+
$_CONF['site_name']         = 'Geeklog Site';
$_CONF['site_slogan']       = 'Another Nifty Geeklog Site';
$_CONF['site_mail']         = 'admin@example.com';
$_CONF['site_url']          = 'http://www.example.com';
$_CONF['site_admin_url']    = $_CONF['site_url'] . '/admin';
$_CONF['theme']             = 'XSilver';  // default theme
$_CONF['layout_url']        = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];
$_CONF['path_themes']       = $_CONF['path_html'] . 'layout/';
$_CONF['path_layout']       = $_CONF['path_themes'] . $_CONF['theme'] .'/';
$_CONF['allow_user_themes'] = 1;
$_CONF['allow_user_photo'] = 1; // 1 = on, 0 = off...flag that allows users to upload self-photo

// +---------------------------------------------------------------------------+
// | LOCALE SETTINGS                                                           |
// +---------------------------------------------------------------------------+
$_CONF['language']  = 'english';
$_CONF['locale']    = 'en-gb';
$_CONF['date']      = '%A, %B %d %Y @ %I:%M %p %Z';
$_CONF['daytime']   = '%m/%d %I:%M%p';
$_CONF['shortdate'] = '%x';
$_CONF['default_charset'] = 'iso-8859-1';

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

$_CONF['cookie_ip']                     = 0;
$_CONF['default_perm_cookie_timeout']   = 604800;
$_CONF['session_cookie_timeout']        = 7200;
$_CONF['cookie_session']                = 'gl_session';
$_CONF['cookie_name']                   = 'geeklog';
$_CONF['cookie_path']                   = '/';

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
// | MISCELLANEOUS SETTINGS                                                    |
// |                                                                           |
// | These are other various Geeklog settings.  The defaults should work OK    |
// | for most situations.                                                      |
// +---------------------------------------------------------------------------+

// Submission Settings

$_CONF['loginrequired'] = 0;
$_CONF['postmode']      = 'plaintext';  // can be plaintext or html
$_CONF['speedlimit']    = 45;         // in seconds

// Topic Settings

// Topics can be assigned a sort number so that you can control what order they
// appear in the 'Sections' block on the homepage.  If you prefer you can also
// have this sort alphabetically by changing the value to 'alpha' (default is
// by 'sortnum'

$_CONF['sortmethod'] = 'sortnum';

// Show the number of stories in a topic in Section Block
$_CONF['showstorycount'] = 1;

// Show the number of story submissions for a topic in Section Block
$_CONF['showsubmissioncount'] = 1;

// How long an anonymous (guest) user session is good for
$_CONF['whosonline_threshold'] = 300; // in seconds

// Let users get stories emailed to them
// Requires cron and the use of php as a shell script
$_CONF['emailstories'] = 0;

// Specify length of stories in those emails:
// 0 = send only title + link, 1 = send entire introtext,
// any other number = max. number of characters per story
$_CONF['emailstorieslength'] = 1;

// Following times are in seconds
$_CONF['newstoriesinterval']  = 86400;
$_CONF['newcommentsinterval'] = 172800;
$_CONF['newlinksinterval']    = 1209600;

// Calendar Settings
//$_CONF['enablecalendar']      = 1; // NOT IMPLEMENTED YET 
$_CONF['personalcalendars']     = 1;
$_CONF['showupcomingevents']    = 1;
$_CONF['event_types']           = 'Anniversary,Appointment,Birthday,Business,Education,Holiday,Meeting,Miscellaneous,Personal,Phone Call,Special Occasion,Travel,Vacation';

// Story Settings
$_CONF['maximagesperarticle']   = 5;
$_CONF['backend']               = 1;
$_CONF['limitnews']             = 10;
$_CONF['minnews']               = 1;	// minimum number of stories per page
$_CONF['olderstuff']            = 1;
$_CONF['contributedbyline']     = 1;	// If 1, show contributed by line
$_CONF['article_image_align']   = 'right'; 	// Options are left or right.
	
// Comment Settings
$_CONF['commentspeedlimit']     = 45;
$_CONF['commentsloginrequired'] = 0;
$_CONF['comment_limit']         = 100;        // Default Number of Comments under Story
$_CONF['comment_mode']          = 'threaded'; // Default Comment Mode; from 'threaded','nested','nocomments',and 'flat'

// Poll Settings                                            
$_CONF['maxanswers']        = 10;
// 'submitorder' is order answers are saved in admin/poll.php
// 'voteorder' will list answers in order of number of votes (highest->lowest);
$_CONF['answerorder']       = 'submitorder';
$_CONF['pollcookietime']    = 86400;
$_CONF['polladdresstime']   = 604800;

// Parameters for checking words and HTML tags

$_CONF['allowablehtml'] = '<p>,<b>,<i>,<a>,<em>,<br>,<tt>,<hr>,<li>,<ol>,<div>,<ul>,<code>,<pre>';
$_CONF['adminhtml'] = $_CONF['allowablehtml'] . ',<table>,<tr>,<td>,<th>';
$_CONF['parsemode']     = '';
$_CONF['censormode']    = 1;
$_CONF['censorreplace'] = '*censored*';
$_CONF['censorlist']    = array('fuck','cunt','fucker','fucking','pussy','cock','c0ck',' cum ','twat','clit','bitch','fuk','fuking','motherfucker');

// Define a few useful things for GL
if (!defined ('LB')) {
    define('LB',"\n");
}
define('VERSION', '1.3.5');

//$_CONF['default_state_cde'] = 'IA'; // NOT IMPLEMENTED
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
        'NJ'=>'New Jersy',
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
        'WV'=>'West Viginia',
        'WI'=>'Wisconsin',
        'WY'=>'Wyoming'
    );

?>
