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

// +---------------------------------------------------------------------------+
// | SERVER SETTINGS                                                           |
// |                                                                           |
// | All paths must have a trailing slash ('/'). The 'path' value signifies    |
// | where the config.php (this file) resides                                  | 
// +---------------------------------------------------------------------------+

$_CONF['path']          = '{cfg_path}';
$_CONF['path_system']   = '{cfg_path_system}';
$_CONF['path_html']     = '{cfg_path_html}';
$_CONF['path_log']      = '{cfg_path_log}';
$_CONF['path_language'] = '{cfg_path_language}';
$_CONF['rdf_file']      = '{cfg_rdf_file}';

// +---------------------------------------------------------------------------+
// | SITE SETTINGS                                                             |
// |                                                                           |
// | These settings help define your Geeklog site.                             |
// +---------------------------------------------------------------------------+

$_CONF['site_name']     = "{cfg_site_name}";
$_CONF['site_slogan']   = "{cfg_site_slogan}";
$_CONF['site_mail']     = '{cfg_site_mail}';
$_CONF['site_url']      = '{cfg_site_url}';
$_CONF['theme']         = '{cfg_theme}';
$_CONF['layout_url']    = '{cfg_layout_url}';
$_CONF['path_themes']   = '{cfg_path_html}layout/';
$_CONF['path_layout']   = '{cfg_path_themes}{cfg_theme}/';
$_CONF['allow_user_themes'] = '{cfg_allow_user_themes}';

// +---------------------------------------------------------------------------+
// | LOCALE SETTINGS                                                           |
// +---------------------------------------------------------------------------+

$_CONF['language']  = '{cfg_language}';
$_CONF['locale']    = '{cfg_locale}';
$_CONF['date']      = '{cfg_date}';
$_CONF['daytime']   = '{cfg_daytime}';
$_CONF['shortdate'] = '{cfg_shortdate}';

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

$_CONF['cookie_ip']                     = '{cfg_cookie_ip}';
$_CONF['default_perm_cookie_timeout']   = '{cfg_default_perm_cookie_timeout}';
$_CONF['session_cookie_timeout']        = '{cfg_session_cookie_timeout}';
$_CONF['cookie_session']                = '{cfg_cookie_session}';
$_CONF['cookie_name']                   = '{cfg_cookie_name}';
$_CONF['cookie_path']                   = '{cfg_cookie_path}';


// +---------------------------------------------------------------------------+
// | PLUGIN SETTINGS                                                           |
// |                                                                           |
// | You can have only one of the following two lines uncommented. The         |
// | first one is for *nix users and assumes you are using tar.                |
// | The second entry is for windows users and this is configured to work with |
// | FilZip.  You can get FilZip from http://www.filzip.com.  Make sure        |
// | you add the FilZip directory to your path OR fully qualify the path       |
// | here. Regardless of OS, make sure you leave a trailing space at the end.  |
// |									       |
// | If you know what you are doing you can also modify these lines to fit     |
// | your servers needs (such as if you have a different compression package)  |
// | *nix user be sure that the tar binary is in the /bin directory...if not   |
// | change change accordingly. 					       |
// | 									       |
// +---------------------------------------------------------------------------+

$_CONF['unzipcommand']      = '{cfg_unzipcommand}';

// +---------------------------------------------------------------------------+
// | Command needed to remove a directory recursively and quietly              |
// | First one is typical for *nix boxes and the second is for                 |
// | windows machines.                                                         |
// +---------------------------------------------------------------------------+

$_CONF['rmcommand']     = '{cfg_rmcommand}';

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

$_CONF['loginrequired'] = '{cfg_loginrequired}'; 
$_CONF['postmode']      = '{cfg_postmode}'; // can be plaintext or html
$_CONF['speedlimit']    = '{cfg_speedlimit}'; // in seconds

// Topic Settings

// Topics can be assigned a sort number so that you can control what order they
// appear in the 'Sections' block on the homepage.  If you prefer you can also
// have this sort alphabetically by changing the value to 'alpha' (default is
// by 'sortnum'

$_CONF['sortmethod'] = '{cfg_sortmethod}';

// Show the number of stories in a topic in Section Block
$_CONF['showstorycount'] = '{cfg_showstorycount}';

// Show the number of story submissions for a topic in Section Block
$_CONF['showsubmissioncount'] = '{cfg_showsubmissioncount}';

// Show any new articles, comments and links
$_CONF['whatsnewbox'] = '{cfg_whatsnewbox}';

// Show Who's online block
$_CONF['whosonline'] = '{cfg_whosonline}';

// How long an anonymous (guest) user session is good for
$_CONF['whosonline_threshold'] = '{cfg_whosonline_threshold}'; // in seconds

// Let users get stories emailed to them
// Requires cron and the use of php as a shell script
$_CONF['emailstories'] = '{cfg_emailstories}';

// Following times are in seconds
$_CONF['newstoriesinterval']  = '{cfg_newstoriesinterval}';
$_CONF['newcommentsinterval'] = '{cfg_newcommentsinterval}';
$_CONF['newlinksinterval']    = '{cfg_newlinksinterval}';

// Calendar Settings
//$_CONF['enablecalendar']      = '1'; // NOT IMPLEMENTED YET 
$_CONF['personalcalendars']     = '{cfg_personalcalendars}';
$_CONF['showupcomingevents']    = '{cfg_showupcomingevents}';
$_CONF['event_types']           = '{cfg_event_types}';

// Story Settings
$_CONF['pagetitle']             = '';
$_CONF['backend']               = '{cfg_backend}';
$_CONF['limitnews']             = '{cfg_limitnews}';
$_CONF['minnews']               = '{cfg_minnews}';	// minimum number of stories per page
$_CONF['olderstuff']            = '{cfg_olderstuff}';
$_CONF['contributedbyline']     = '{cfg_contributedbyline}';	// If 1, show contributed by line
$_CONF['article_image_align']   = '{cfg_article_image_align}'; 	// Options are left or right.
	
// Comment Settings
$_CONF['commentspeedlimit']     = '{cfg_commentspeedlimit}';
$_CONF['commentsloginrequired'] = '{cfg_commentsloginrequired}';
$_CONF['comment_limit']         = '{cfg_comment_limit}';        // Default Number of Comments under Story
$_CONF['comment_mode']          = '{cfg_comment_mode}'; // Default Comment Mode; from 'threaded','nestde','nocomments',and 'flat'

// Poll Settings
$_CONF['maxanswers']        = '{cfg_maxanswers}';
$_CONF['pollcookietime']    = '{cfg_pollcookietime}';
$_CONF['polladdresstime']   = '{cfg_polladdresstime}';

// Parameters for checking words and HTML tags

$_CONF['allowablehtml'] = '{cfg_allowablehtml}';
$_CONF['parsemode']     = '{cfg_parsemode}';
$_CONF['censormode']    = '{cfg_censormode}';
$_CONF['censorreplace'] = "{cfg_censorreplace}";
$_CONF['censorlist']    = array({cfg_censorlist});

// Define a few useful things for GL
define('LB',"\n");
define('VERSION', '1.3.2');

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
