<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | submit.php                                                                |
// |                                                                           |
// | Let users submit stories, links, and events.                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
// $Id: submit.php,v 1.54 2003/06/25 08:39:02 dhaun Exp $

require_once('lib-common.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($HTTP_POST_VARS);

/**
* Shows a given submission form
*
* This is the submission it is modular to allow us to write as little as
* possible.  It takes a type and formats a form for the user.  Currently the
* types are link, story and event.  If no type is provided, Story is assumeda
*
* @type		string		Type of submission user is making
*
*/
function submissionform($type='story', $mode = '', $month='', $day='', $year='', $hour='', $topic = '')
{
    global $_TABLES, $_CONF, $LANG12, $REMOTE_ADDR, $_USER, $HTTP_POST_VARS,
           $LANG_LOGIN;

    $retval = '';
	
    COM_clearSpeedlimit ($_CONF['speedlimit'], 'submit');

    $last = COM_checkSpeedlimit ('submit');

    if ($last > 0) {
        $retval .= COM_startBlock ($LANG12[26], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[30]
            . $last
            . $LANG12[31]
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    } else {
        if (empty ($_USER['username']) &&
            (($_CONF['loginrequired'] == 1) || ($_CONF['submitloginrequired'] == 1))) {
            $retval .= COM_startBlock ($LANG_LOGIN[1], '',
                               COM_getBlockTemplate ('_msg_block', 'header'));
            $loginreq = new Template($_CONF['path_layout'] . 'submit');
            $loginreq->set_file('loginreq', 'submitloginrequired.thtml');
            $loginreq->set_var('login_message', $LANG_LOGIN[2]);
            $loginreq->set_var('site_url', $_CONF['site_url']);
            $loginreq->set_var('lang_login', $LANG_LOGIN[3]);
            $loginreq->set_var('lang_newuser', $LANG_LOGIN[4]);
            $loginreq->parse('errormsg', 'loginreq');
            $retval .= $loginreq->finish($loginreq->get_var('errormsg'));
            $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            return $retval;
        } else {
            $retval .= COM_startBlock($LANG12[19])
                . $LANG12[9]
                . COM_endBlock();

            switch ($type) {
            case 'link':
                $retval .= submitlink();
                break;
            case 'event':
                $retval .= submitevent($mode,$month,$day,$year,$hour);
                break;
            default:
                if ((strlen($type) > 0) && ($type <> 'story')) {
                    $retval .= PLG_showSubmitForm($type);
                    break;
                } 
                $retval .= submitstory($topic);
                break;
            }
        }
    }

    return $retval;

}

/**
* Shows the event submission form
*
*/
function submitevent($mode = '', $month = '', $day = '', $year = '', $hour='') 
{
    global $_CONF,$LANG12, $LANG30, $_STATES, $_USER;

    $retval = '';

    $retval .= COM_startBlock($LANG12[4],'submitevent.html');
    $eventform = new Template($_CONF['path_layout'] . 'submit');
    $eventform->set_file('eventform', 'submitevent.thtml');
    $eventform->set_var('explanation', $LANG12[37]);
    $eventform->set_var('site_url', $_CONF['site_url']);
    $eventform->set_var('lang_title', $LANG12[10]); 
    $types = explode(',',$_CONF['event_types']);
    reset($types);
    for ($i = 1; $i <= count($types); $i++) {
        $catdd .= '<option value="' . current($types) . '">' . current($types) . '</option>';
        next($types);
    }
    $eventform->set_var('lang_eventtype', $LANG12[49]);
    $eventform->set_var('lang_editeventtypes', $LANG12[50]);
    $eventform->set_var('type_options', $catdd);
    $eventform->set_var('lang_addeventto',$LANG12[38]);
    $eventform->set_var('lang_mastercalendar',$LANG12[39]);
    if ($_CONF['personalcalendars'] == 1 AND $_USER['uid'] > 1) {
        $eventform->set_var('lang_personalcalendar',$LANG12[40]);
        if ($mode == 'personal') {
            $eventform->set_var('personal_option', '<option value="personal" selected="SELECTED">' . $LANG12[40] . '</option>');
        } else {
            $eventform->set_var('personal_option', '<option value="personal">' . $LANG12[40] . '</option>');
            $eventform->set_var('master_checked', 'selected="SELECTED"');
        }
    } else {
        $eventform->set_var('master_checked', 'selected="SELECTED"');
        $eventform->set_var('personal_option', '');
    }
    $eventform->set_var('lang_link', $LANG12[11]);
    $eventform->set_var('lang_startdate', $LANG12[12]);
    $eventform->set_var('lang_starttime', $LANG12[42]);
    $month_options = '';
    if (empty($month)) {
        $month = date('m',time());
    }
    if (empty($day)) {
        $day = date('d',time());
    }
    if (empty($year)) {
        $year = date('Y',time());
    } 
    for ($i = 1; $i <= 12; $i++) {
        if ($i < 10) {
            $mval = '0' . $i;
        } else {
            $mval = $i;
        }
        $month_options .= '<option value="' . $mval . '" ';
        if ($i == $month) {
            $month_options .= 'selected="SELECTED"';
        }
        $month_options .= '>' . $LANG30[$mval+12] . '</option>';
    }
    $eventform->set_var('month_options', $month_options);
    $day_options = '';
    for ($i = 1; $i <= 31; $i++) {
        if ($i < 10) {
            $dval = '0' . $i;
        } else {
            $dval = $i;
        }
        $day_options .= '<option value="' . $dval . '" ';
        if ($i == $day) {
            $day_options .= 'selected="SELECTED"';
        }
        $day_options .= '>' . $dval . '</option>';
    }
    $eventform->set_var('day_options', $day_options);
    $year_options = '';
    $cur_year = date('Y',time());
    if (!empty($hour)) {
        $cur_hour = $hour;
    } else {
        $cur_hour = date('H',time());
    }
    if (empty($year)) {
        $year = $cur_year;
    }
    for ($i = $cur_year; $i <= $cur_year + 5; $i++) {
        $year_options .= '<option value="' . $i . '" ';
        if ($i == $year) {
            $year_options .= 'selected="SELECTED"';
        }
        $year_options .= '>' . $i . '</option>';
    }
    $eventform->set_var('year_options', $year_options);
    $hour_options = '';
    if ($cur_hour > 12) $cur_hour = $cur_hour-12;
    for ($i = 1; $i <= 11; $i++) {
        if ($i < 10) {
            $hval = '0' . $i;
        } else {
            $hval = $i;
        }
        if ($i == 1 ) {
            $hour_options .= '<option value="12" ';
            if ($cur_hour == 12) {
                $hour_options .= 'selected="SELECTED"';
            }
            $hour_options .= '>12</option>';
        }
        $hour_options .= '<option value="' . $hval . '" ';
        if ($cur_hour == $i) {
            $hour_options .= 'selected="SELECTED"';
        }
        $hour_options .= '>' . $i . '</option>';
    }
    if ($hour >= 12) {
        $eventform->set_var('pm_selected','selected="SELECTED"');
    } else {
        $eventform->set_var('am_selected','selected="SELECTED"');
    }
    $eventform->set_var('hour_options', $hour_options);
    $eventform->set_var('lang_enddate', $LANG12[13]);
    $eventform->set_var('lang_endtime', $LANG12[41]);
    $eventform->set_var('lang_alldayevent',$LANG12[43]);
    $eventform->set_var('lang_location', $LANG12[51]);
    $eventform->set_var('lang_addressline1',$LANG12[44]);
    $eventform->set_var('lang_addressline2',$LANG12[45]);
    $eventform->set_var('lang_city',$LANG12[46]);
    reset($_STATES);
    $eventform->set_var('lang_state',$LANG12[47]);
    $state_options = '';
    for ($i = 1; $i <= count($_STATES); $i++) {
        $state_options .= '<option value="' . key($_STATES) . '" ';
        if (key($_STATES) == $cur_state) {
            $state_options .= 'selected="SELECTED"';
        }
        $state_options .= '>' . current($_STATES) . '</option>';
        next($_STATES);
    }
    $eventform->set_var('state_options',$state_options);
    $eventform->set_var('lang_zipcode',$LANG12[48]);
    $eventform->set_var('lang_location', $LANG12[14]);
    $eventform->set_var('lang_description', $LANG12[15]);
    $eventform->set_var('lang_htmnotallowed', $LANG12[35]);
    $eventform->set_var('lang_submit', $LANG12[8]);
    $eventform->parse('theform', 'eventform');
    $retval .= $eventform->finish($eventform->get_var('theform'));
    $retval .= COM_endBlock();
		
    return $retval;
}

/**
* Shows link submission form
*
*/
function submitlink() 
{
    global $_TABLES, $_CONF, $LANG12;

    $retval .= COM_startBlock($LANG12[5],'submitlink.html');

    $linkform = new Template($_CONF['path_layout'] . 'submit');
    $linkform->set_file('linkform', 'submitlink.thtml');
    $linkform->set_var('site_url', $_CONF['site_url']);
    $linkform->set_var('lang_title', $LANG12[10]);	
    $linkform->set_var('lang_link', $LANG12[11]);
    $linkform->set_var('lang_category', $LANG12[17]);
    $linkform->set_var('link_category_options',  COM_optionList($_TABLES['links'],'DISTINCT category,category', '', 0));
    $linkform->set_var('lang_other', $LANG12[18]);
    $linkform->set_var('lang_ifother', $LANG12[16]);
    $linkform->set_var('lang_description', $LANG12[15]);
    $linkform->set_var('lang_htmlnotallowed', $LANG12[35]);
    $linkform->set_var('lang_submit', $LANG12[8]);
    $linkform->parse('theform', 'linkform');
    $retval .= $linkform->finish($linkform->get_var('theform'));
    $retval .= COM_endBlock();
	
    return $retval;
}

/**
* Shows the story submission form
*
*/
function submitstory($topic = '') 
{
    global $_TABLES, $HTTP_POST_VARS, $_CONF, $LANG12, $_USER;

    if ($HTTP_POST_VARS['mode'] == $LANG12[32]) { // preview
        $A = $HTTP_POST_VARS;
    } else {
        $A['sid'] = COM_makeSid();
        if (empty ($_USER['username'])) { 
            $A['uid'] = 1;
        } else {
            $A['uid'] = $_USER['uid'];
        }
        $A['unixdate'] = time();
    }

    if (empty($A['postmode'])) {
        $A['postmode'] = $_CONF['postmode'];
    }

    if (!empty($A['title'])) {
        $introtext = stripslashes ($A['introtext']);
        $introtext = str_replace('$','&#36;',$introtext);
        $title = stripslashes ($A['title']);
        $title = str_replace('$','&#36;',$title);

        if ($A['postmode'] == 'html') {
            $A['introtext'] = addslashes(COM_checkHTML(COM_checkWords($A['introtext'])));
            $A['title'] = addslashes(COM_checkHTML(COM_checkWords($A['title'])));
        } else {
            $A['introtext'] = htmlspecialchars(COM_checkWords($A['introtext']));
            $A['introtext'] = str_replace('$','&#36;',$A['introtext']);

            $A['title'] = htmlspecialchars(COM_checkWords($A['title']));
            $A['title'] = str_replace('$','&#36;',$A['title']);
        }
        $introtext = str_replace('{','&#123;',$introtext);
        $introtext = str_replace('}','&#125;',$introtext);
        $A['introtext'] = str_replace('{','&#123;',$A['introtext']);
        $A['introtext'] = str_replace('}','&#125;',$A['introtext']);

        $A['show_topic_icon'] = 1;
        $A['hits'] = 0;
        $retval .= COM_startBlock($LANG12[32])
            . COM_article($A,'n')
            . COM_endBlock();
    }

    $retval .= COM_startBlock($LANG12[6],'submitstory.html');

    $storyform = new Template($_CONF['path_layout'] . 'submit');
    if (($_CONF['advanced_editor'] == 1) && file_exists ($_CONF['path_layout'] . 'submit/submitstory_advanced.thtml')) { 
        $storyform->set_file('storyform','submitstory_advanced.thtml');
    } else {
        $storyform->set_file('storyform','submitstory.thtml');
    }
    $storyform->set_var('site_url', $_CONF['site_url']);
    $storyform->set_var('lang_username', $LANG12[27]);

    if (!empty($_USER['username'])) {
        $storyform->set_var('story_username', $_USER['username']);
        $storyform->set_var('status_url', $_CONF['site_url'] . '/users.php?mode=logout');
        $storyform->set_var('lang_loginout', $LANG12[34]);
    } else {
        $storyform->set_var('status_url', $_CONF['site_url'] . '/users.php');
        $storyform->set_var('lang_loginout', $LANG12[2]);
        $storyform->set_var('seperator', ' | ');
        $storyform->set_var('create_account','<a href="' . $_CONF['site_url'] . '/users.php?mode=new">' . $LANG12[53] . '</a>');
    }

    $storyform->set_var('lang_title', $LANG12[10]);
    $storyform->set_var('story_title', htmlspecialchars ($title));	
    $storyform->set_var('lang_topic', $LANG12[28]);
    if (empty ($A['tid']) && !empty ($topic)) {
        $A['tid'] = $topic;
    }
    if (empty ($A['tid'])) {
        $A['tid'] = DB_getItem ($_TABLES['topics'], 'tid', 'is_default = 1' . COM_getPermSQL ('AND'));
    }
    $storyform->set_var('story_topic_options', COM_topicList('tid,topic',$A['tid']));
    $storyform->set_var('lang_story', $LANG12[29]);
    $storyform->set_var('story_introtext', $introtext);
    $storyform->set_var('lang_postmode', $LANG12[36]);
    $storyform->set_var('story_postmode_options', COM_optionList($_TABLES['postmodes'],'code,name',$A['postmode']));
    $storyform->set_var('allowed_html', COM_allowedHTML());
    $storyform->set_var('story_uid', $A['uid']);
    $storyform->set_var('story_sid', $A['sid']);
    $storyform->set_var('story_date', $A['unixdate']);

    if (($_CONF['skip_preview'] == 1) || ($A['mode'] == $LANG12[32])) {
        $storyform->set_var('save_button', '<input name="mode" type="submit" value="' . $LANG12[8] . '">');
    }

    $storyform->set_var('lang_preview', $LANG12[32]);
    $storyform->parse('theform', 'storyform');
    $retval .= $storyform->finish($storyform->get_var('theform'));
    $retval .= COM_endBlock();

    return $retval;
}

/**
* Send an email notification for a new submission.
*
* @table    string      Table where the new submission can be found
* @id       string      Id of the new submission
*
*/
function sendNotification ($table, $A)
{
    global $_CONF, $_TABLES, $LANG_CHARSET, $LANG01, $LANG02, $LANG06, $LANG08,
           $LANG09, $LANG12, $LANG24, $LANG29, $LANG30;

    switch ($table) {
        case $_TABLES['storysubmission']:
        case $_TABLES['stories']:
            $title = COM_undoSpecialChars (stripslashes ($A['title']));
            if ($A['postmode'] == 'html') {
                $A['introtext'] = strip_tags ($A['introtext']);
            }
            $introtext = COM_undoSpecialChars (stripslashes ($A['introtext']));
            $storyauthor = DB_getItem ($_TABLES['users'], 'username',
                                       "uid = {$A['uid']}");
            $topic = stripslashes (DB_getItem ($_TABLES['topics'], 'topic',
                                               "tid = '{$A['tid']}'"));

            $mailbody = "$LANG08[31]: {$title}\r\n"
                      . "$LANG24[7]: {$storyauthor}\r\n"
                      . "$LANG08[32]: " . strftime ($_CONF['date']) . "\r\n"
                      . "$LANG24[14]: {$topic}\r\n\r\n";

            if ($_CONF['emailstorieslength'] > 0) {
                if ($_CONF['emailstorieslength'] > 1) {
                    $introtext = substr ($introtext, 0,
                            $_CONF['emailstorieslength']) . '...';
                }
                $mailbody .= $introtext . "\r\n\r\n";
            }
            if ($table == $_TABLES['storysubmission']) {
                $mailbody .= "$LANG01[10] <{$_CONF['site_admin_url']}/moderation.php>\r\n\r\n";
            } else {
                $mailbody .= "$LANG08[33] <{$_CONF['site_url']}/article.php?story={$A['sid']}>\r\n\r\n";
            }
            $mailsubject = $_CONF['site_name'] . ' ' . $LANG29[35];
            break;

        case $_TABLES['eventsubmission']:
        case $_TABLES['events']:
            $title = stripslashes ($A['title']);
            $description = stripslashes ($A['description']);

            $mailbody = "$LANG09[16]: $title\r\n"
                      . "$LANG09[17]: " . strftime ($_CONF['date'],
                        strtotime ($A['datestart'] . ' ' . $A['timestart']));
            if ($A['allday']) {
                $mailbody .= ' (' . $LANG30[26] . ')';
            }
            $mailbody .= "\r\n";
            if (!empty ($A['url']) && ($A['url'] != 'http://')) {
                $mailbody .= "$LANG09[33]: <" . $A['url'] . ">\r\n";
            }
            $mailbody .= "\r\n" . $description . "\r\n\r\n";
            if ($table == $_TABLES['eventsubmission']) {
                $mailbody .= "$LANG01[10] <{$_CONF['site_admin_url']}/moderation.php>\r\n\r\n";
            } else {
                $mailbody .= "$LANG02[12] <{$_CONF['site_url']}/calendar_event.php?eid={$A['eid']}>\r\n\r\n";
            }
            $mailsubject = $_CONF['site_name'] . ' ' . $LANG29[37];
            break;

        case $_TABLES['linksubmission']:
        case $_TABLES['links']:
            $title = stripslashes ($A['title']);
            $description = stripslashes ($A['description']);

            $mailbody = "$LANG12[10]: $title\r\n"
                      . "$LANG12[11]: <{$A['url']}>\r\n"
                      . "$LANG12[17]: {$A['category']}\r\n\r\n"
                      . $description . "\r\n\r\n";
            if ($table == $_TABLES['linksubmission']) {
                $mailbody .= "$LANG01[10] <{$_CONF['site_admin_url']}/moderation.php>\r\n\r\n";
            } else {
                $mailbody .= "$LANG06[1] <{$_CONF['site_url']}/links.php?category=" . urlencode ($A['category']) . ">\r\n\r\n";
            }
            $mailsubject = $_CONF['site_name'] . ' ' . $LANG29[36];
            break;
    }

    $mailbody .= "\r\n------------------------------\r\n";
    $mailbody .= "\r\n$LANG08[34]\r\n";
    $mailbody .= "\r\n------------------------------\r\n";

    if (empty ($LANG_CHARSET)) {
        $charset = $_CONF['default_charset'];
        if (empty ($charset)) {
            $charset = "iso-8859-1";
        }
    } else {
        $charset = $LANG_CHARSET;
    }
    $mailheaders = "From: {$_CONF['site_name']} <{$_CONF['site_mail']}>\r\n"
                 . "Return-Path: {$_CONF['site_mail']}\r\n"
                 . "Content-Type: text/plain; charset=$charset\r\n"
                 . "X-Mailer: GeekLog " . VERSION;

    @mail ($_CONF['site_mail'], $mailsubject, $mailbody, $mailheaders);
}

/**
* This will save a submission
*
* @type     string      Type of submission we are dealing with
* @A        array       Data for that submission
*
*/
function savesubmission($type,$A) 
{
    global $_TABLES, $LANG12, $_USER, $REMOTE_ADDR, $_CONF;

    switch ($type) {
    case 'link':
        if (!empty($A['title']) && !empty($A['description']) && !empty($A['url'])) {
            if ($A['categorydd'] != $LANG12[18] && !empty($A['categorydd'])) {
                $A['category'] = $A['categorydd'];
            } else if ($A['categorydd'] != $LANG12[18]) {
                $retval .= COM_startBlock ($LANG12[20], '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
                    . $LANG12[21]
                    . COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'))
                    . submissionform($type);
					    
                    return $retval;
            }
            $A['description'] = addslashes(htmlspecialchars(COM_checkWords($A['description'])));
            $A['title'] = addslashes(strip_tags(COM_checkWords($A['title'])));
            $A['url'] = strip_tags ($A['url']);
            if (!empty ($A['url'])) {
                $pos = strpos ($A['url'], ':');
                if ($pos === false) {
                    $A['url'] = 'http://' . $A['url'];
                }
                else {
                    $prot = substr ($A['url'], 0, $pos + 1);
                    if (($prot != 'http:') && ($prot != 'https:')) {
                        $A['url'] = 'http:' . substr ($A['url'], $pos + 1);
                    }
                }
                $A['url'] = addslashes ($A['url']);
            }
            $A['lid'] = COM_makeSid();
            COM_updateSpeedlimit ('submit');
            if (($_CONF['linksubmission'] == 1) && !SEC_hasRights('link.submit')) {
                $result = DB_save($_TABLES['linksubmission'],'lid,category,url,description,title,date',"{$A["lid"]},'{$A["category"]}','{$A["url"]}','{$A["description"]}','{$A['title']}',NOW()",$_CONF['site_url']."/index.php?msg=3");
                if (isset ($_CONF['notification']) && in_array ('link', $_CONF['notification'])) {
                    sendNotification ($_TABLES['linksubmission'], $A);
                }
            } else { // add link directly
                if (empty ($_USER['username'])) { // anonymous user
                    $owner_id = 1;
                } else {
                    $owner_id = $_USER['uid'];
                }
                $result = DB_save($_TABLES['links'],'lid,category,url,description,title,date,owner_id', "{$A["lid"]},'{$A["category"]}','{$A["url"]}','{$A["description"]}','{$A['title']}',NOW(),$owner_id", $_CONF['site_url'] . '/links.php');
                if (isset ($_CONF['notification']) && in_array ('link', $_CONF['notification'])) {
                    sendNotification ($_TABLES['links'], $A);
                }
            }
        } else {
            $retval .= COM_startBlock ($LANG12[22], '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG12[23]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                . submissionform($type);

            return $retval; 
        }
        break;
    case "event":
        if (!empty($A['title']) && (!empty($A['start_month']) AND !empty($A['start_day']) AND !empty($A['start_year']))) {
            $A['datestart'] = $A['start_year'] . '-' . $A['start_month'] . '-' . $A['start_day'];
            if (empty($A['end_year'])) {
                $A['dateend'] = $A['datestart'];
            } else {
                $A['dateend'] = $A['end_year'] . '-' . $A['end_month'] . '-' . $A['end_day'];
            }
            $A['description'] = addslashes(htmlspecialchars(COM_checkWords($A["description"])));
            $A['title'] = addslashes(strip_tags(COM_checkWords($A['title'])));
            $A['address1'] = addslashes(strip_tags(COM_checkWords($A['address1'])));
            $A['address2'] = addslashes(strip_tags(COM_checkWords($A['address2'])));
            $A['city'] = addslashes(strip_tags(COM_checkWords($A['city'])));
            $A['location'] = addslashes(strip_tags(COM_checkWords($A['location'])));
            $A['url'] = strip_tags ($A['url']);
            if (!empty ($A['url'])) {
                $pos = strpos ($A['url'], ':');
                if ($pos === false) {
                    $A['url'] = 'http://' . $A['url'];
                }
                else {
                    $prot = substr ($A['url'], 0, $pos + 1);
                    if (($prot != 'http:') && ($prot != 'https:')) {
                        $A['url'] = 'http:' . substr ($A['url'], $pos + 1);
                    }
                }
                $A['url'] = addslashes ($A['url']);
            }
            if (empty($A['eid'])) {
                $A['eid'] = COM_makesid();
            }

            COM_updateSpeedlimit ('submit');

            if ($A['allday'] == 'on') {
                $A['allday'] = 1;
            } else {
                $A['allday'] = 0;
                if ($A['start_ampm'] == 'pm' AND $A['start_hour'] <> 12) {
                    $A['start_hour'] = $A['start_hour'] + 12;
                }
                if ($A['start_ampm'] == 'am' AND $A['start_hour'] == 12) {
                    $A['start_hour'] = '00';
                }
                if ($A['end_ampm'] == 'pm') {
                    $A['end_hour'] = $A['end_hour'] + 12;
                }
                if ($A['end_ampm'] == 'am' AND $A['end_hour'] == 12) {
                    $A['end_hour'] = '00';
                }
                $A['timestart'] = $A['start_hour'] . ':' . $A['start_minute'] . ':00';
                if (empty($A['end_hour'])) {
                    $A['timeend'] = $A['start_hour'] + 1 . ':' . $A['start_minute'] . ':00';
                } else {
                    $A['timeend'] = $A['end_hour'] . ':' . $A['end_minute'] . ':00';
                }
            }

            if ($A['calendar_type'] == 'master') {
                if (($_CONF['eventsubmission'] == 1) && !SEC_hasRights('event.submit')) {
                    $result = DB_save($_TABLES['eventsubmission'],'eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description',"{$A['eid']},'{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}'",$_CONF['site_url']."/index.php?msg=4");
                    if (isset ($_CONF['notification']) && in_array ('event', $_CONF['notification'])) {
                        sendNotification ($_TABLES['eventsubmission'], $A);
                    }
                } else {
                    if (empty ($_USER['username'])) { // anonymous user
                        $owner_id = 1;
                    } else {
                        $owner_id = $_USER['uid'];
                    }
                    $result = DB_save($_TABLES['events'],'eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description,owner_id',"{$A['eid']},'{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}',$owner_id", $_CONF['site_url'] . '/calendar.php');
                    if (isset ($_CONF['notification']) && in_array ('event', $_CONF['notification'])) {
                        sendNotification ($_TABLES['events'], $A);
                    }
                }
            } else {
                if (empty($A['uid'])) {
                    $A['uid'] = $_USER['uid'];
                }
                $result = DB_save($_TABLES['personal_events'],'uid,eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description',"{$A['uid']},'{$A['eid']}','{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}'",$_CONF['site_url']."/calendar.php?mode=personal&msg=4");
            }
                
        } else {
            $retval .= COM_startBlock ($LANG12[22], '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG12[23]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                . submissionform($type);

                return $retval;
        }
        break;
    default:
        if ((strlen($type) > 0) && ($type <> 'story')) {
            // Update the submitspeedlimit for user - assuming Plugin approves
            // submission record
            COM_updateSpeedlimit ('submit');

            // see if this is a submission that needs to be handled by a plugin
            // and should include it's own redirect
            if (!PLG_saveSubmission($type, $A)) {
                COM_errorLog("Could not save your submission.  Bad type: $type");
            }	
            // plugin should include it's own redirect - but in case handle
            // it here and redirect to the main page
            $retval = COM_refresh ($_CONF['site_url'] . '/index.php');
            return $retval;
        }

        if (!empty($A['title']) && !empty($A['introtext'])) {
            $A['title'] = addslashes(strip_tags(COM_checkWords($A['title'])));
            $A['title'] = str_replace('$','&#36;',$A['title']);
            $introtext = $A['introtext'];
            if ($A['postmode'] == 'html') {
                $A['introtext'] = addslashes(COM_checkHTML(COM_checkWords($A['introtext'])));
            } else {
                $A['introtext'] = addslashes(htmlspecialchars(COM_checkWords($A['introtext'])));
            }
            $A['sid'] = COM_makeSid();
            if (empty($_USER['uid'])) { 
                $_USER['uid'] = 1;
            }					
            COM_updateSpeedlimit ('submit');
            if (($_CONF['storysubmission'] == 1) && !SEC_hasRights('story.submit')) {
                DB_save($_TABLES['storysubmission'],"sid,tid,uid,title,introtext,date,postmode","{$A["sid"]},'{$A["tid"]}',{$_USER['uid']},'{$A['title']}','{$A["introtext"]}',NOW(),'{$A["postmode"]}'",$_CONF['site_url']."/index.php?msg=2");
                if (isset ($_CONF['notification']) && in_array ('story', $_CONF['notification'])) {
                    $A['uid'] = $_USER['uid'];
                    sendNotification ($_TABLES['storysubmission'], $A);
                }
            } else { // post this story directly
                $result = DB_query ("SELECT * FROM {$_TABLES['topics']} where tid='{$A["tid"]}'");
                $T = DB_fetchArray ($result);
                $related = addslashes (COM_whatsRelated ($introtext, $_USER['uid'], $A['tid']));
                DB_save ($_TABLES['stories'], 'sid,uid,tid,title,introtext,related,date,commentcode,postmode,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon', "{$A["sid"]},{$_USER['uid']},'{$A["tid"]}','{$A['title']}','{$A["introtext"]}','{$related}',NOW(),{$_CONF['comment_code']},'{$A["postmode"]}',{$_USER['uid']},{$T['group_id']},{$T['perm_owner']},{$T['perm_group']},{$T['perm_members']},{$T['perm_anon']}");
                if (isset ($_CONF['notification']) && in_array ('story', $_CONF['notification'])) {
                    $A['uid'] = $_USER['uid'];
                    sendNotification ($_TABLES['stories'], $A);
                }
                $retval = COM_refresh ($_CONF['site_url'] . '/article.php?story=' . $A['sid']);
            }
        } else {
            $retval .= COM_startBlock ($LANG12[22], '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG12[23]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                . submissionform($type);
					
            return $retval;
        }
        break;
    }
    return $retval;
}

// MAIN

$display = '';
$display .= COM_siteHeader();

if ($mode == $LANG12[8]) { // submit
    $display .= savesubmission($type,$HTTP_POST_VARS);
} else if ($mode == $LANG12[52]) { // delete
    if (!empty($eid)) {
        DB_delete($_TABLES['personal_events'], 'eid',$eid,$_CONF['site_url'].'/calendar.php?mode=personal');
    }  
} else {
    switch($type) {
        case 'link':
            if (SEC_hasRights('link.edit')) {
                echo COM_refresh($_CONF['site_admin_url'] . '/link.php?mode=edit');
                exit;
            }
            break;
        case 'event':
            if (SEC_hasRights('event.edit') && ($mode != 'personal')) {
                echo COM_refresh($_CONF['site_admin_url'] . '/event.php?mode=edit');
                exit;
            }
            break;
        default:
            if ((strlen ($type) > 0) && ($type <> 'story')) {
                if (SEC_hasRights ("$type.edit") ||
                    SEC_hasRights ("$type.admin"))  {
                    echo COM_refresh ($_CONF['site_admin_url']
                         . "/plugins/$type/index.php?mode=edit");
                    exit;
                }
            } elseif (SEC_hasRights ('story.edit')) {
                echo COM_refresh ($_CONF['site_admin_url']
                     . '/story.php?mode=edit');
                exit;
            }
            break;
    }

    $display .= submissionform($type, $mode, $month, $day, $year, $hour, $topic); 

}
$display .= COM_siteFooter();		
echo $display;

?>
