<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | submit.php                                                                |
// |                                                                           |
// | Let users submit stories, events and plugin stuff.                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
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
//
// $Id: submit.php,v 1.1 2006/03/08 13:23:26 ospiess Exp $

require_once ('lib-common.php');
require_once ($_CONF['path_system'] . 'lib-story.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

/**
* Shows a given submission form
*
* This is the submission it is modular to allow us to write as little as
* possible.  It takes a type and formats a form for the user.  Currently the
* types are story and event.  If no type is provided, Story is assumed.
*
* @param    string  $type   type of submission ('event', 'story')
* @param    string  $mode   calendar mode ('personal' or empty string)
* @param    int     $month  month (for events)
* @param    int     $day    day (for events)
* @param    int     $year   year (for events)
* @param    int     $hour   hour (for events)
* @param    string  $topic  topic (for stories)
* @return   string          HTML for submission form
*
*/
function submissionform($mode = '', $month='', $day='', $year='', $hour='', $topic = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG12, $LANG_LOGIN;

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
            $loginreq->set_var('layout_url', $_CONF['layout_url']);
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
            $retval .= submitevent($mode,$month,$day,$year,$hour);
            }
        }
    }

    return $retval;
}

/**
* Shows the event submission form
*
*/
function submitevent($mode = '', $month = '', $day = '', $year = '', $hour = -1)
{
    global $_CONF, $_USER, $LANG12, $LANG30, $_STATES;

    $retval = '';

    $retval .= COM_startBlock ($LANG12[4], 'submitevent.html');
    $eventform = new Template ($_CONF['path_layout'] . 'submit');
    $eventform->set_file ('eventform', 'submitevent.thtml');
    $eventform->set_var ('explanation', $LANG12[37]);
    $eventform->set_var ('site_url', $_CONF['site_url']);
    $eventform->set_var ('layout_url', $_CONF['layout_url']);
    $eventform->set_var ('lang_title', $LANG12[10]); 
    $types = explode (',', $_CONF['event_types']);
    $catdd = '';
    foreach ($types as $event_type) {
        $catdd .= '<option value="' . $event_type . '">' . $event_type
               . '</option>';
    }
    $eventform->set_var('lang_eventtype', $LANG12[49]);
    $eventform->set_var('lang_editeventtypes', $LANG12[50]);
    $eventform->set_var('type_options', $catdd);
    $eventform->set_var('lang_addeventto', $LANG12[38]);
    $eventform->set_var('lang_mastercalendar', $LANG12[39]);

    if (($_CONF['personalcalendars'] == 1) &&
            isset ($_USER['uid']) && $_USER['uid'] > 1) {
        $eventform->set_var('lang_personalcalendar', $LANG12[40]);
        if ($mode == 'personal') {
            $eventform->set_var('personal_option', '<option value="personal" selected="selected">'
                                                   . $LANG12[40] . '</option>');
        } else {
            $eventform->set_var('personal_option', '<option value="personal">'
                                                   . $LANG12[40] . '</option>');
            $eventform->set_var('master_checked', 'selected="selected"');
        }
    } else {
        $eventform->set_var('master_checked', 'selected="selected"');
        $eventform->set_var('personal_option', '');
    }

    $eventform->set_var('lang_link', $LANG12[11]);
    $eventform->set_var('max_url_length', 255);
    $eventform->set_var('lang_startdate', $LANG12[12]);
    $eventform->set_var('lang_starttime', $LANG12[42]);
    if (empty ($month)) {
        $month = date ('m', time ());
    }
    if (empty ($day)) {
        $day = date ('d', time ());
    }
    if (empty ($year)) {
        $year = date ('Y', time ());
    } 
    $eventform->set_var ('month_options', COM_getMonthFormOptions ($month));
    $eventform->set_var ('day_options', COM_getDayFormOptions ($day));
    $eventform->set_var ('year_options', COM_getYearFormOptions ($year));

    if ($hour < 0) {
        $cur_hour = date ('H', time ());
    } else {
        $cur_hour = $hour;
    }
    if ($cur_hour >= 12) {
        $eventform->set_var ('am_selected', '');
        $eventform->set_var ('pm_selected', 'selected="selected"');
    } else {
        $eventform->set_var ('am_selected', 'selected="selected"');
        $eventform->set_var ('pm_selected', '');
    }
    if ($cur_hour > 12) {
        $cur_hour = $cur_hour - 12;
    } else if ($cur_hour == 0) {
        $cur_hour = 12;
    }
    $eventform->set_var ('hour_options', COM_getHourFormOptions ($cur_hour));

    $eventform->set_var('lang_enddate', $LANG12[13]);
    $eventform->set_var('lang_endtime', $LANG12[41]);
    $eventform->set_var('lang_alldayevent',$LANG12[43]);
    $eventform->set_var('lang_location', $LANG12[51]);
    $eventform->set_var('lang_addressline1',$LANG12[44]);
    $eventform->set_var('lang_addressline2',$LANG12[45]);
    $eventform->set_var('lang_city',$LANG12[46]);
    $eventform->set_var('lang_state',$LANG12[47]);
    $state_options = '';
    foreach ($_STATES as $statekey => $state) {
        $state_options .= '<option value="' . $statekey . '">'
                       . $state . '</option>';
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
* Send an email notification for a new submission.
*
* @param    string  $table  Table where the new submission can be found
* @param    string  $id     Id of the new submission
*
*/
function sendNotification ($table, $A)
{
    global $_CONF, $_TABLES, $LANG01, $LANG02, $LANG06, $LANG08, $LANG09,
           $LANG12, $LANG24, $LANG29, $LANG30;

    $title = stripslashes ($A['title']);
    $description = stripslashes ($A['description']);

    $mailbody = "$LANG09[16]: $title\n"
              . "$LANG09[17]: " . strftime ($_CONF['date'],
                strtotime ($A['datestart'] . ' ' . $A['timestart']));
    if ($A['allday']) {
        $mailbody .= ' (' . $LANG30[26] . ')';
    }
    $mailbody .= "\n";
    if (!empty ($A['url']) && ($A['url'] != 'http://')) {
        $mailbody .= "$LANG09[33]: <" . $A['url'] . ">\n";
    }
    $mailbody .= "\n" . $description . "\n\n";
    if ($table == $_TABLES['eventsubmission']) {
        $mailbody .= "$LANG01[10] <{$_CONF['site_admin_url']}/moderation.php>\n\n";
    } else {
        $mailbody .= "$LANG02[12] <{$_CONF['site_url']}/calendar/event.php?eid={$A['eid']}>\n\n";
    }
    $mailsubject = $_CONF['site_name'] . ' ' . $LANG29[37];

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
}

/**
* Saves an event submission
*
* @param    array   $A  Data for that submission
* @return   string      HTML redirect
*
*/
function saveevent ($A)
{
    global $_CONF, $_TABLES, $_USER, $LANG12;

    $retval = '';

    $A['title'] = strip_tags (COM_checkWords ($A['title']));
    $A['start_year'] = COM_applyFilter ($A['start_year'], true);
    $A['start_month'] = COM_applyFilter ($A['start_month'], true);
    $A['start_day'] = COM_applyFilter ($A['start_day'], true);

    if (empty ($A['title']) || empty ($A['start_month']) ||
            empty ($A['start_day']) || empty ($A['start_year'])) {
        $retval .= COM_siteHeader ('menu', $LANG12[4])
            . COM_startBlock ($LANG12[22], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[23]
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
            . submissionform ('event',
                    ($A['calendar_type'] == 'master') ? '' : 'personal')
            . COM_siteFooter ();

        return $retval;
    }

    $A['end_year'] = COM_applyFilter ($A['end_year'], true);
    $A['end_month'] = COM_applyFilter ($A['end_month'], true);
    $A['end_day'] = COM_applyFilter ($A['end_day'], true);

    $A['datestart'] = sprintf ('%4d-%02d-%02d',
                        $A['start_year'], $A['start_month'], $A['start_day']);
    if (empty ($A['end_year']) || empty ($A['end_month']) ||
            empty ($A['end_day'])) {
        $A['dateend'] = $A['datestart'];
    } else {
        $A['dateend'] = sprintf ('%4d-%02d-%02d',
                            $A['end_year'], $A['end_month'], $A['end_day']);
    }

    // pseudo-formatted event description for the spam check
    $spamcheck = '<p><a href="' . $A['url'] . '">' . $A['title'] . '</a><br>'
               . $A['location'] . '<br>' . $A['address1'] . '<br>'
               . $A['address2'] . '<br>' . $A['city'] . ', ' . $A['zipcode']
               . '<br>' . $A['description'] . '</p>';
    $result = PLG_checkforSpam ($spamcheck, $_CONF['spamx']);
    if ($result > 0) {
        COM_updateSpeedlimit ('submit');
        COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden');
    }
    
    $input_arr = array('description','address1','address2','city','zipcode',
                       'state','location','event_type','title');
    for ($i=0; count($input_arr); $i++) {
        $A[$input_arr[$i]] = addslashes (htmlspecialchars (COM_checkWords ($A[$input_arr[$i]])));
    }

    $A['url'] = strip_tags ($A['url']);
    if (!empty ($A['url'])) {
        $pos = strpos ($A['url'], ':');
        if ($pos === false) {
            $A['url'] = 'http://' . $A['url'];
        } else {
            $prot = substr ($A['url'], 0, $pos + 1);
            if (($prot != 'http:') && ($prot != 'https:')) {
                $A['url'] = 'http:' . substr ($A['url'], $pos + 1);
            }
        }
        $A['url'] = addslashes ($A['url']);
    }
    if ($A['url'] == 'http://') {
        $A['url'] = '';
    }

    $A['eid'] = addslashes (COM_makeSid ());

    COM_updateSpeedlimit ('submit');

    if ($A['allday'] == 'on') {
        $A['allday'] = 1;
    } else {
        $A['allday'] = 0;
    }

    $A['start_hour'] = COM_applyFilter ($A['start_hour'], true);
    $A['start_minute'] = COM_applyFilter ($A['start_minute'], true);
    $A['end_hour'] = COM_applyFilter ($A['end_hour'], true);
    $A['end_minute'] = COM_applyFilter ($A['end_minute'], true);

    if ($A['start_ampm'] == 'pm' AND $A['start_hour'] <> 12) {
        $A['start_hour'] = $A['start_hour'] + 12;
    }
    if ($A['start_ampm'] == 'am' AND $A['start_hour'] == 12) {
        $A['start_hour'] = '00';
    }
    if ($A['end_ampm'] == 'pm' AND $A['end_hour'] <> 12) {
        $A['end_hour'] = $A['end_hour'] + 12;
    }
    if ($A['end_ampm'] == 'am' AND $A['end_hour'] == 12) {
        $A['end_hour'] = '00';
    }
    $A['timestart'] = $A['start_hour'] . ':' . $A['start_minute'] . ':00';
    $A['timeend'] = $A['end_hour'] . ':' . $A['end_minute'] . ':00';

    if ($A['calendar_type'] == 'master') { // add to site calendar

        if (($_CONF['eventsubmission'] == 1) &&
                !SEC_hasRights ('event.submit')) {
            DB_save ($_TABLES['eventsubmission'], 'eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description',
                                                  "{$A['eid']},'{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}'");

            if (isset ($_CONF['notification']) &&
                    in_array ('event', $_CONF['notification'])) {
                sendNotification ($_TABLES['eventsubmission'], $A);
            }

            $retval = COM_refresh ($_CONF['site_url'] . '/index.php?msg=4');
        } else {
            if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
                $owner_id = $_USER['uid'];
            } else {
                $owner_id = 1; // anonymous user
            }

            DB_save ($_TABLES['events'], 'eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description,owner_id',
                                         "{$A['eid']},'{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}',$owner_id");
            if (isset ($_CONF['notification']) &&
                    in_array ('event', $_CONF['notification'])) {
                sendNotification ($_TABLES['events'], $A);
            }
            COM_rdfUpToDateCheck ();

            $retval = COM_refresh ($_CONF['site_url'] . '/calendar.php');
        }

    } else if ($_CONF['personalcalendars'] == 1) { // add to personal calendar

        if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
            DB_save ($_TABLES['personal_events'], 'uid,eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description',
                                                  "{$_USER['uid']},'{$A['eid']}','{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}'");

            $retval = COM_refresh ($_CONF['site_url']
                                   . '/calendar.php?mode=personal&msg=17');
        } else {
            // anonymous users don't have personal calendars - bail
            COM_accessLog ("Attempt to write to the personal calendar of user '{$A['uid']}'.");

            $retval = COM_refresh ($_CONF['site_url'] . '/calendar.php');
        }

    } else { // personal calendars are disabled
        $retval = COM_refresh ($_CONF['site_url'] . '/calendar.php');
    }

    return $retval;
}

/**
* This will save a submission
*
* @param    string  $type   Type of submission we are dealing with
* @param    array   $A      Data for that submission
*
*/
function savesubmission($A)
{
    global $_CONF, $_TABLES, $_USER, $LANG12;

    $retval = COM_siteHeader ();

    COM_clearSpeedlimit ($_CONF['speedlimit'], 'submit');

    $last = COM_checkSpeedlimit ('submit');

    if ($last > 0) {
        $retval .= COM_startBlock ($LANG12[26], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[30]
            . $last
            . $LANG12[31]
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
            . COM_siteFooter ();

        return $retval;
    }
    $retval = saveevent ($A);
    return $retval;
}

// MAIN

$display = '';

$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode']);
}

if (($mode == $LANG12[8]) && !empty ($LANG12[8])) { // submit
    if (empty ($_USER['username']) &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['submitloginrequired'] == 1))) {
        $display = COM_refresh ($_CONF['site_url'] . '/index.php');
    } else {
        $display .= savesubmission ($type, $_POST);
    }
} else if (($mode == $LANG12[52]) && !empty ($LANG12[52])) { // delete
    // this is only meant for deleting personal events
    if (($_CONF['personalcalendars'] == 1) && ($_REQUEST['type'] == 'event') &&
            isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
        $eid = COM_applyFilter ($_REQUEST['eid']);
        if (!empty ($eid)) {
            $eid = addslashes ($eid);
            DB_query ("DELETE FROM {$_TABLES['personal_events']} "
                     ."WHERE uid={$_USER['uid']} AND eid='$eid'");
            echo COM_refresh ($_CONF['site_url']
                              . '/calendar/index.php?mode=personal&amp;msg=26');
            exit;
        }
    }
    $display = COM_refresh ($_CONF['site_url'] . '/index.php');
} else if (($_CONF['personalcalendars'] == 1) && isset ($_POST['calendar_type']) &&
        ($_POST['calendar_type'] == 'personal')) { // quick add form
   $display = saveevent ($_POST);
} else {
    if (SEC_hasRights('event.edit') && ($mode != 'personal')) {
        if (isset ($_REQUEST['year'])) {
            $year = COM_applyFilter ($_REQUEST['year'], true);
        } else {
            $year = date ('Y', time ());
        }
        if (isset ($_REQUEST['month'])) {
            $month = COM_applyFilter ($_REQUEST['month'], true);
        } else {
            $month = date ('m', time ());
        }
        if (isset ($_REQUEST['day'])) {
            $day = COM_applyFilter ($_REQUEST['day'], true);
        } else {
            $day = date ('d', time ());
        }
        if (isset ($_REQUEST['hour'])) {
            $hour = COM_applyFilter ($_REQUEST['hour'], true);
        } else {
            $hour = date ('H', time ());
        }
        $startat = '';
        if ($year > 0) {
            $startat = '&datestart='
                     . urlencode (sprintf ('%04d-%02d-%02d', $year,
                                           $month, $day))
                     . '&timestart=' . urlencode (sprintf ('%02d:00:00',
                                                           $hour));
        }

        echo COM_refresh ($_CONF['site_admin_url']
                          . '/event.php?mode=edit' . $startat);
        exit;
    }

    $year = 0;
    if (isset ($_REQUEST['year'])) {
        $year = COM_applyFilter ($_REQUEST['year'], true);
    }
    $month = 0;
    if (isset ($_REQUEST['month'])) {
        $month = COM_applyFilter ($_REQUEST['month'], true);
    }
    $day = 0;
    if (isset ($_REQUEST['day'])) {
        $day = COM_applyFilter ($_REQUEST['day'], true);
    }
    if (isset ($_REQUEST['hour'])) {
        $hour = COM_applyFilter ($_REQUEST['hour'], true);
    } else {
        $hour = -1;
    }
    $topic = '';
    if (isset ($_REQUEST['topic'])) {
        $topic = COM_applyFilter ($_REQUEST['topic']);
    }
    $pagetitle = $LANG12[4];
    $display .= COM_siteHeader ('menu', $pagetitle);
    $display .= submissionform($mode, $month, $day, $year, $hour, $topic); 
    $display .= COM_siteFooter();
}

echo $display;

?>
