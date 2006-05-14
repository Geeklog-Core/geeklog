<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendar Plugin 1.0                                                       |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the CAlendar   |
// | plugin' PHP files.                                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Blaine Lang      - langmail AT sympatico DOT ca                  |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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
// $Id: functions.inc,v 1.17 2006/05/14 19:18:53 dhaun Exp $

$langfile = $_CONF['path'] . 'plugins/calendar/language/'
          . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    require_once ($langfile);
} else {
    require_once ($_CONF['path'] . 'plugins/calendar/language/english.php');
}

require_once ($_CONF['path'] . 'plugins/calendar/config.php');


/**
* Returns the items for this plugin that should appear on the main menu
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
*/
function plugin_getmenuitems_calendar ()
{
    global $_CONF, $_CA_CONF, $LANG_CAL_1;

    $anon = (empty ($_USER['uid']) || ($_USER['uid'] <= 1)) ? true : false;
    if($anon && ($_CONF['loginrequired'] || $_CA_CONF['calendarloginrequired'])) {
        return false;
    } else {
        $menuitems[$LANG_CAL_1['16']] = $_CONF['site_url']
                                         . '/calendar/index.php';
    }

    return $menuitems;
}

/**
* Returns the upcoming event block
*
* Returns the HTML for any upcoming events in the calendar
*
* @param        string      $help       Help file for block
* @param        string      $title      Title to be used in block header
* @return   string  HTML formatted block containing events.
*/
function phpblock_calendar( $help='', $title='' )
{
    global $_CONF, $_TABLES, $_USER, $_CA_CONF, $LANG_CAL_1;

    if( !$_USER['noboxes'] && $_CA_CONF['showupcomingevents'] ) {
        $range = $_CA_CONF['upcomingeventsrange'];
        if( $range == 0 ) {
            $range = 14; // fallback: 14 days
        }
        $dateonly = $_CONF['dateonly'];
        if( empty( $dateonly )) {
            $dateonly = '%d-%b'; // fallback: day - abbrev. month name
        }

        if( empty( $title )) {
            $title = DB_getItem( $_TABLES['blocks'], 'title', "name = 'events_block'" );
        }

        $eventSql = 'SELECT eid,title,url,datestart,dateend,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon '
        . "FROM {$_TABLES['events']} "
        . "WHERE dateend >= NOW() AND (TO_DAYS(datestart) - TO_DAYS(NOW()) < $range) "
        . 'ORDER BY datestart,timestart';

        if(( $_CA_CONF['personalcalendars'] == 1 ) && !empty( $_USER['uid'] )) {
            $personaleventsql = 'SELECT eid,title,url,datestart,dateend,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon '
            . "FROM {$_TABLES['personal_events']} "
            . "WHERE uid = {$_USER['uid']} AND dateend >= NOW() AND (TO_DAYS(datestart) - TO_DAYS(NOW()) < $range) "
            . 'ORDER BY datestart, dateend';
        }

        $allEvents = DB_query( $eventSql );
        $numRows = DB_numRows( $allEvents );
        $totalrows = $numRows;

        $numDays = 0;          // Without limits, I'll force them.
        $theRow = 1;           // Start with today!
        $oldDate1 = 'no_day';  // Invalid Date!
        $oldDate2 = 'last_d';  // Invalid Date!

        if( $_CA_CONF['personalcalendars'] == 1 AND !empty( $_USER['uid'] )) {
            $iterations = 2;
        } else {
            $iterations = 1;
        }

        $eventsFound = 0;
        $skipFirstBreak = false;

        for( $z = 1; $z <= $iterations; $z++ ) {
            if( $z == 2 ) {
                $allEvents = DB_query( $personaleventsql );
                $numRows = DB_numRows( $allEvents );
                $totalrows = $totalrows + $numRows;

                $numDays = 0;          // Without limits, I'll force them.
                $theRow = 1;           // Start with today!
                $oldDate1 = 'no_day';  // Invalid Date!
                $oldDate2 = 'last_d';  // Invalid Date!
                $classname = 'list-personal-events';
                $headline = false;
            } else {
                $classname = 'list-site-events';
                $headline = false;
            }
            if( $_CA_CONF['personalcalendars'] == 0 ) {
                $headline = true; // no headline needed
                $skipFirstBreak = true;
            }

            while( $theRow <= $numRows AND $numDays < $range ) {
                // Retreive the next event, and format the start date.
                $theEvent = DB_fetchArray( $allEvents );

                if( SEC_hasAccess( $theEvent['owner_id'], $theEvent['group_id'],
                                   $theEvent['perm_owner'], $theEvent['perm_group'],
                                   $theEvent['perm_members'], $theEvent['perm_anon'] ) > 0 ) {
                    $eventsFound++;

                    if( !$headline ) {
                        if($z == 2) {
                            if( $numRows > 0 ) {
                                $retval .= '<p><b>' . $LANG_CAL_1[23] . '</b><br>';
                            }
                        } else {
                            if( $totalrows > 0 ) {
                                $retval .= '<b>' . $LANG_CAL_1[24] . '</b><br>';
                            }
                        }
                        $headline = true;
                    }

                    // Start Date strings...
                    $startDate = $theEvent['datestart'];
                    $theTime1 = strtotime( $startDate );
                    $dayName1 = strftime( '%A', $theTime1 );
                    $abbrDate1 = strftime( $dateonly, $theTime1 );

                    // End Date strings...
                    $endDate = $theEvent['dateend'];
                    $theTime2 = strtotime( $endDate );
                    $dayName2 = strftime( '%A', $theTime2 );
                    $abbrDate2 = strftime( $dateonly, $theTime2 );

                    $todaysEvent = false;
                    if( date( 'Ymd', $theTime1 ) == date( 'Ymd', time())) {
                        $todaysEvent = true;
                        if( $z == 2 ) {
                            $todaysClassName = 'personal-event-today';
                        } else {
                            $todaysClassName = 'site-event-today';
                        }
                    }

                    // If either of the dates [start/end] change, then display a new header.
                    if( $oldDate1 != $abbrDate1 OR $oldDate2 != $abbrDate2 ) {
                        $oldDate1 = $abbrDate1;
                        $oldDate2 = $abbrDate2;
                        $numDays ++;

                        if( $numDays < $range ) {
                            if( !empty( $newevents )) {
                                 $retval .= COM_makeList( $newevents, $classname );
                            }
                            if( $skipFirstBreak ) {
                                $skipFirstBreak = false;
                            } else {
                                $retval .= '<br>';
                            }
                            if( $todaysEvent ) {
                                $retval .= '<span class="' . $todaysClassName . '">';
                            }
                            $retval .= '<b>' . $dayName1 . '</b>&nbsp;<small>'
                                    . $abbrDate1 . '</small>';

                            // If different start and end dates, then display end date:
                            if( $abbrDate1 != $abbrDate2 ) {
                                $retval .= ' - <br><b>' . $dayName2 . '</b>&nbsp;<small>' . $abbrDate2 . '</small>';
                            }
                            if( $todaysEvent ) {
                                $retval .= '</span>';
                            }
                        }
                        $newevents = array();
                    }

                    // Now display this event record.
                    if( $numDays < $range ) {
                        // Display the url now!
                        $newevent = '<a href="' . $_CONF['site_url']
                                  . '/calendar/event.php?';

                        if( $z == 2 ) {
                            $newevent .= 'mode=personal&amp;';
                        }

                        $newevent .= 'eid=' . $theEvent['eid'] . '"';
                        if( $todaysEvent ) {
                            $newevent .= ' class="' . $todaysClassName . '"';
                        }
                        $newevent .= '>' . stripslashes( $theEvent['title'] )
                                  . '</a>';
                        $newevents[] = $newevent;
                    }

                    if( !empty( $newevents )) {
                        $retval .= COM_makeList( $newevents, $classname );
                        $newevents = array();
                    }
                }
                $theRow++;
            }
        } // end for z

        if( $eventsFound == 0 ) {
            // There aren't any upcoming events, show a nice message
            $retval .= $LANG_CAL_1[25];
        }
    }

    return $retval;
}

/**
*
* Checks that the current user has the rights to moderate the
* plugin, returns true if this is the case, false otherwise
*
* @return        boolean       Returns true if moderator
*
*/
function plugin_ismoderator_calendar() {
    return SEC_hasRights ('calendar.moderate');
}

/**
* Returns SQL & Language texts to moderation.php
*/
function plugin_itemlist_calendar()
{
    global $_TABLES, $LANG_CAL_1;

    if (plugin_ismoderator_calendar()) {
        $plugin = new Plugin();
        $plugin->submissionlabel = $LANG_CAL_1[19];
        $plugin->submissionhelpfile = 'cceventsubmission.html';
        $plugin->getsubmissionssql = "SELECT eid AS id,title,datestart as day,url "
                                   . "FROM {$_TABLES['eventsubmission']} "
                                   . "ORDER BY datestart ASC";
        $plugin->addSubmissionHeading($LANG_CAL_1[20]);
        $plugin->addSubmissionHeading($LANG_CAL_1[21]);
        $plugin->addSubmissionHeading($LANG_CAL_1[22]);

        return $plugin;
    }
}

/**
* returns list of moderation values
*
* The array returned contains (in order): the row 'id' label, main plugin
* table, moderation fields (comma seperated), and plugin submission table
*
* @return       array        Returns array of useful moderation values
*
*/
function plugin_moderationvalues_calendar()
{
    global $_TABLES;

    return array (
        'eid',
        $_TABLES['events'],
        "eid,title,description,location,address1,address2,city,state,zipcode,datestart,timestart,dateend,timeend,url",
        $_TABLES['eventsubmission']
    );
}


/**
* Performs plugin exclusive work for items approved by moderation
*
* While moderation.php handles the actual move from linkssubmission
* to links tables, within the function we handle all other approval
* relate tasks
*
* @param      string       $id      Identifying string
* @return     string       Any wanted HTML output
*
*/
function plugin_moderationapprove_calendar ($id)
{
    global $_CA_CONF, $_GROUPS, $_TABLES, $_USER;

    $A = array ();
    SEC_setDefaultPermissions ($A, $_CA_CONF['default_permissions']);

    // Since the eventsubmission table does not contain fields for the owner
    // and group, we set those to the current user. Also set the default
    // permissions as specified in the plugin's config.php
    if (isset ($_GROUPS['Calendar Admin'])) {
        $group_id = $_GROUPS['Calendar Admin'];
    } else {
        $group_id = SEC_getFeatureGroup ('calendar.moderate');
    }
    DB_query ("UPDATE {$_TABLES['events']} SET owner_id = '{$_USER['uid']}',"
             ."group_id = '$group_id',perm_owner = {$A['perm_owner']}, "
             ."perm_group = {$A['perm_group']}, perm_members = {$A['perm_members']},"
             ."perm_anon = {$A['perm_anon']} WHERE eid = $id");
}

/**
* Performs plugin exclusive work for items deleted by moderation
*
* While moderation.php handles the actual removal from <plugin>submission
* table, within this function we handle all other deletion
* relate tasks
*
* @param      string       $id      Identifying string
* @return     string       Any wanted HTML output
*
*/
function plugin_moderationdelete_calendar($id)
{
    global $_TABLES;

    // these tables should not contain any rows with ml_id = $id
    // this is done 'just in case'
    DB_delete ($_TABLES['eventsubmission'], 'eid', $id);

    return '';
}

/**
* Check calendar submission form for missing fields
*
*/
function plugin_savesubmission_calendar($A)
{
    global $LANG12;

    $A['title'] = strip_tags (COM_checkWords ($A['title']));
    $A['start_year'] = COM_applyFilter ($A['start_year'], true);
    $A['start_month'] = COM_applyFilter ($A['start_month'], true);
    $A['start_day'] = COM_applyFilter ($A['start_day'], true);

    if (empty ($A['title']) || empty ($A['start_month']) || empty ($A['start_day']) || empty ($A['start_year'])) {
        $retval .= COM_siteHeader ('menu', $LANG12[4])
            . COM_startBlock ($LANG12[22], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[23]
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
            . plugin_submit_calendar ($A['calendar_type'])
            . COM_siteFooter ();

        return $retval;
    }
}

/**
* Saves a calendar submission
*
* @param    array   $A  Data for that submission
* @return   string      HTML redirect
*
*/
function plugin_save_submit_calendar ($A)
{
    global $_CONF, $_CA_CONF, $_TABLES, $_USER, $LANG12;
    
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
            . plugin_submit_calendar (($A['calendar_type'] == 'master') ? '' : 'personal')
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

    $A['description'] = addslashes (htmlspecialchars (COM_checkWords ($A['description'])));
    $A['address1'] = addslashes (strip_tags (COM_checkWords ($A['address1'])));
    $A['address2'] = addslashes (strip_tags (COM_checkWords ($A['address2'])));
    $A['city'] = addslashes (strip_tags (COM_checkWords ($A['city'])));
    $A['zipcode'] = addslashes (strip_tags (COM_checkWords ($A['zipcode'])));
    $A['state'] = addslashes (strip_tags (COM_checkWords ($A['state'])));
    $A['location'] = addslashes (strip_tags (COM_checkWords ($A['location'])));
    $A['event_type'] = addslashes (strip_tags (COM_checkWords ($A['event_type'])));
    $A['title'] = addslashes ($A['title']);

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
                !SEC_hasRights ('calendar.submit')) {
            DB_save ($_TABLES['eventsubmission'], 
			         'eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description', 
					 "{$A['eid']},'{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}'");

            if (isset ($_CONF['notification']) &&
                    in_array ('event', $_CONF['notification'])) {
                CALENDAR_sendNotification ($_TABLES['eventsubmission'], $A);
            }

            $retval = COM_refresh ($_CONF['site_url'] . '/index.php?msg=4');
        } else {
            if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
                $owner_id = $_USER['uid'];
            } else {
                $owner_id = 1; // anonymous user
            }

            DB_save ($_TABLES['events'], 
			         'eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description,owner_id', 
					 "{$A['eid']},'{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}',$owner_id");
            if (isset ($_CONF['notification']) &&
                    in_array ('event', $_CONF['notification'])) {
                CALENDAR_sendNotification ($_TABLES['events'], $A);
            }
            COM_rdfUpToDateCheck ();

            $retval = COM_refresh ($_CONF['site_url'] . '/calendar/index.php');
        }

    } else if ($_CA_CONF['personalcalendars'] == 1) { // add to personal calendar
        if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
            DB_save ($_TABLES['personal_events'], 
			         'uid,eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description', 
					 "{$_USER['uid']},'{$A['eid']}','{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}'");
            $retval = COM_refresh ($_CONF['site_url']
                                   . '/calendar/index.php?mode=personal&msg=17');
        } else {
            // anonymous users don't have personal calendars - bail
            COM_accessLog ("Attempt to write to the personal calendar of user '{$A['uid']}'.");

            $retval = COM_refresh ($_CONF['site_url'] . '/calendar/index.php');
        }

    } else { // personal calendars are disabled
        $retval = COM_refresh ($_CONF['site_url'] . '/calendar/index.php');
    }
    return $retval;
}

/**
* Shows event submission form or diverts to event editor if admin calls in
*
*/
function plugin_submit_calendar($mode = 'master')
{
    global $_CONF, $_USER, $_CA_CONF, $LANG_CAL_1;

    if (isset ($_POST['calendar_type'])) {
        $mode = $_POST['calendar_type'];
    }

    if (($_CA_CONF['personalcalendars'] == 1) && ($mode == 'quickadd')) { // quick add form
       $display = plugin_save_submit_calendar ($_POST);
       return $display;
    } else if (SEC_hasRights('calendar.edit') && ($mode != 'personal')) {
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
                          . '/plugins/calendar/index.php?mode=edit' . $startat);
        exit;
    }

    $retval = '';

    $retval .= COM_startBlock ($LANG_CAL_1[26], 'submitevent.html');
    $eventform = new Template ($_CONF['path'] . 'plugins/calendar/templates/');
    $eventform->set_file ('eventform', 'submitevent.thtml');
    if ($mode != 'personal') {
        $eventform->set_var ('explanation', $LANG_CAL_1[27]);
    } else {
        $eventform->set_var ('explanation', "");
    }
    $eventform->set_var ('site_url', $_CONF['site_url']);
    $eventform->set_var ('layout_url', $_CONF['layout_url']);
    $eventform->set_var ('lang_title', $LANG_CAL_1[28]);
    $types = explode (',', $_CA_CONF['event_types']);
    $catdd = '';
    foreach ($types as $event_type) {
        $catdd .= '<option value="' . $event_type . '">' . $event_type
               . '</option>';
    }
    $eventform->set_var('lang_eventtype', $LANG_CAL_1[37]);
    $eventform->set_var('lang_editeventtypes', $LANG_CAL_1[38]);
    $eventform->set_var('type_options', $catdd);

    $eventform->set_var('lang_link', $LANG_CAL_1[43]);
    $eventform->set_var('max_url_length', 255);
    $eventform->set_var('lang_startdate', $LANG_CAL_1[21]);
    $eventform->set_var('lang_starttime', $LANG_CAL_1[30]);
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

    $eventform->set_var('lang_enddate', $LANG_CAL_1[18]);
    $eventform->set_var('lang_endtime', $LANG_CAL_1[29]);
    $eventform->set_var('lang_alldayevent',$LANG_CAL_1[31]);
    $eventform->set_var('lang_addressline1',$LANG_CAL_1[32]);
    $eventform->set_var('lang_addressline2',$LANG_CAL_1[33]);
    $eventform->set_var('lang_city',$LANG_CAL_1[34]);
    $eventform->set_var('lang_state',$LANG_CAL_1[35]);
    $state_options = '';
    foreach ($_CA_CONF['states'] as $statekey => $state) {
        $state_options .= '<option value="' . $statekey . '">'
                       . $state . '</option>';
    }
    $eventform->set_var('state_options',$state_options);
    $eventform->set_var('lang_zipcode',$LANG_CAL_1[36]);
    $eventform->set_var('lang_location', $LANG_CAL_1[39]);
    $eventform->set_var('lang_description', $LANG_CAL_1[5]);
    $eventform->set_var('lang_htmnotallowed', $LANG_CAL_1[44]);
    $eventform->set_var('lang_submit', $LANG_CAL_1[45]);
    $eventform->parse('theform', 'eventform');
    $retval .= $eventform->finish($eventform->get_var('theform'));
    $retval .= COM_endBlock();

    return $retval;
}

/**
* Delete an event
*
* @param    string  $eid    id of event to delete
* @param    string          HTML redirect
*/
function CALENDAR_deleteEvent ($eid)
{
    global $_CONF, $_TABLES, $_USER;

    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon "
                       ."FROM {$_TABLES['events']} WHERE eid = '$eid'");
    $A = DB_fetchArray ($result);
    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
            $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    if ($access < 3) {
        COM_accessLog ("User {$_USER['username']} tried to illegally delete event $eid.");
        return COM_refresh ($_CONF['site_admin_url'] . '/plugins/calendar/index.php');
    }

    DB_delete ($_TABLES['events'], 'eid', $eid);
    DB_delete ($_TABLES['personal_events'], 'eid', $eid);
    COM_rdfUpToDateCheck ('geeklog', 'calendar', $eid);

    return COM_refresh ($_CONF['site_admin_url'] . '/plugins/calendar/index.php?msg=18');
}

function CALENDAR_listevents()
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG_CAL_ADMIN, $LANG_ACCESS,
           $_IMAGE_TYPE;

    require_once( $_CONF['path_system'] . 'lib-admin.php' );

    $retval = '';

    $header_arr = array(      # dislay 'text' and use table field 'field'
                    array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
                    array('text' => $LANG_ADMIN['copy'], 'field' => 'copy', 'sort' => false),
                    array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true),
                    array('text' => $LANG_CAL_ADMIN[13], 'field' => 'username', 'sort' => true),
                    array('text' => $LANG_ACCESS['access'], 'field' => 'access', 'sort' => false),
                    array('text' => $LANG_CAL_ADMIN[14], 'field' => 'datestart', 'sort' => true),
                    array('text' => $LANG_CAL_ADMIN[15], 'field' => 'dateend', 'sort' => true)
    );

    $defsort_arr = array('field' => 'datestart', 'direction' => 'desc');

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'] . '/plugins/calendar/index.php?mode=edit',
                          'text' => $LANG_ADMIN['create_new']),
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home'])
    );

    $text_arr = array('has_menu' =>  true,
                      'has_extras'   => true,
                      'title' => $LANG_CAL_ADMIN[11],
                      'instructions' => $LANG_CAL_ADMIN[12],
                      'icon' => $_CONF['site_url'] . '/calendar/images/calendar.' . $_IMAGE_TYPE,
                      'form_url' => $_CONF['site_admin_url'] . "/plugins/calendar/index.php");

    $sql = "SELECT {$_TABLES['events']}.*, {$_TABLES['users']}.username "
          ."FROM {$_TABLES['events']} "
          ."LEFT JOIN {$_TABLES['users']} "
          ."ON {$_TABLES['events']}.owner_id={$_TABLES['users']}.uid "
          ."WHERE 1 ";

    $query_arr = array('table' => 'events',
                       'sql' => $sql,
                       'query_fields' => array('title', 'datestart', 'dateend'),
                       'default_filter' => COM_getPermSQL('AND'));

    $retval .= ADMIN_list ('calendar', 'plugin_getListField_calendar',
                           $header_arr, $text_arr, $query_arr, $menu_arr,
                           $defsort_arr);

    return $retval;
}


/**
* Saves a calendar submission
*
* @param    array   $A  Data for that submission
* @return   string      HTML redirect
*
*/
function plugin_save_submit_calendar ($A)
{
    global $_CONF, $_TABLES, $_USER, $_CA_CONF, $LANG12;

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

    $A['description'] = addslashes (htmlspecialchars (COM_checkWords ($A['description'])));
    $A['address1'] = addslashes (strip_tags (COM_checkWords ($A['address1'])));
    $A['address2'] = addslashes (strip_tags (COM_checkWords ($A['address2'])));
    $A['city'] = addslashes (strip_tags (COM_checkWords ($A['city'])));
    $A['zipcode'] = addslashes (strip_tags (COM_checkWords ($A['zipcode'])));
    $A['state'] = addslashes (strip_tags (COM_checkWords ($A['state'])));
    $A['location'] = addslashes (strip_tags (COM_checkWords ($A['location'])));
    $A['event_type'] = addslashes (strip_tags (COM_checkWords ($A['event_type'])));
    $A['title'] = addslashes ($A['title']);

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

        if (($_CA_CONF['eventsubmission'] == 1) &&
                !SEC_hasRights ('event.submit')) {
            DB_save ($_TABLES['eventsubmission'], 
                     'eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description', 
                     "{$A['eid']},'{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}'");

            if (isset ($_CA_CONF['notification']) &&
                    ($_CA_CONF['notification'] == 1)) {
                CALENDAR_sendNotification ($_TABLES['eventsubmission'], $A);
            }

            $retval = COM_refresh ($_CONF['site_url'] . '/index.php?msg=4');
        } else {
            if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
                $owner_id = $_USER['uid'];
            } else {
                $owner_id = 1; // anonymous user
            }

            DB_save ($_TABLES['events'], 
                     'eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description,owner_id', 
                     "{$A['eid']},'{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}',$owner_id");
            if (isset ($_CA_CONF['notification']) &&
                    ($_CA_CONF['notification'] == 1)) {
                CALENDAR_sendNotification ($_TABLES['events'], $A);
            }
            COM_rdfUpToDateCheck ();

            $retval = COM_refresh ($_CONF['site_url'] . '/calendar.php');
        }

    } else if ($_CA_CONF['personalcalendars'] == 1) { // add to personal calendar

        if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
            DB_save ($_TABLES['personal_events'], 
                     'uid,eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description', 
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
* Send an email notification for a new submission.
*
* @param    string  $table  Table where the new submission can be found
* @param    array   $A      submission data
*
*/
function CALENDAR_sendNotification ($table, $A)
{
    global $_CONF, $_TABLES, $LANG_LINKS, $LANG_LINKS_SUBMIT, $LANG08;

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
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
        $mailbody .= "$LANG02[12] <{$_CONF['site_url']}/calendar_event.php?eid={$A['eid']}>\n\n";
    }
    $mailsubject = $_CONF['site_name'] . ' ' . $LANG29[37];
    break;
}


/**
*
* Counts the items that are submitted
*
*/
function plugin_submissioncount_calendar()
{
    global $_TABLES;

    $num = 0;

    if( SEC_hasRights( 'calendar.moderate' ))
    {
        $num += DB_count( $_TABLES['eventsubmission'] );
    }

    return $num;
}

/**
* Implements the [calendar:] autotag.
*
*/
function plugin_autotags_calendar ($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES;

    if ($op == 'tagname' ) {
        return 'calendar';
    } else if ($op == 'parse') {
        $eid = COM_applyFilter ($autotag['parm1']);
        $url = COM_buildUrl ($_CONF['site_url'] . '/calendar/event.php?eid=' . $eid);
        if (empty ($autotag['parm2'])) {
            $linktext = stripslashes (DB_getItem ($_TABLES['events'],
                                      'title', "eid = '$eid'"));
        } else {
            $linktext = $autotag['parm2'];
        }
        $link = '<a href="' . $url . '">' . $linktext . '</a>';
        $content = str_replace ($autotag['tagstr'], $link, $content);

        return $content;
    }
}

/*
* Do we support feeds?
*/
function plugin_getfeednames_calendar()
{
    global $LANG_CAL_1;

    $feeds = array ();

    $feeds[] = array ('id' => 'calendar', 'name' => $LANG_CAL_1[16]);

    return $feeds;

}

/**
* Get content for a feed that holds all events.
*
* @param    string   $limit    number of entries or number of stories
* @param    string   $link     link to homepage
* @param    string   $update   list of story ids
* @return   array              content of the feed
*
*/
function plugin_getfeedcontent_calendar( $limit, &$link, &$update, $feedType, $feedVersion )
{
    global $_CONF, $_TABLES;

    $where = '';
    if( !empty( $limit )) {
        if( substr( $limit, -1 ) == 'h' ) {// next xx hours
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND (datestart <= DATE_ADD(NOW(), INTERVAL $hours HOUR))";
        }
        else {
            $limitsql = ' LIMIT ' . $limit;
        }
    }
    else {
        $limitsql = ' LIMIT 10';
    }

    $sql = "SELECT eid,owner_id,title,description FROM {$_TABLES['events']} "
          ."WHERE perm_anon > 0 AND dateend >= NOW()$where "
          ."ORDER BY datestart,timestart $limitsql";
    $result = DB_query($sql);

    $content = array();
    $eids = array();
    $nrows = DB_numRows( $result );

    for( $i = 1; $i <= $nrows; $i++ )
    {
        $row = DB_fetchArray( $result );
        $eids[] = $row['eid'];

        $eventtitle = stripslashes( $row['title'] );
        $eventtext = SYND_truncateSummary( $row['description'], $contentLength);
        $eventlink  = $_CONF['site_url'] . '/calendar/event.php?eid='
                    . $row['eid'];

        // Need to reparse the date from the event id
        $myyear = substr( $row['eid'], 0, 4 );
        $mymonth = substr( $row['eid'], 4, 2 );
        $myday = substr( $row['eid'], 6, 2 );
        $myhour = substr( $row['eid'], 8, 2 );
        $mymin = substr( $row['eid'], 10, 2 );
        $mysec = substr( $row['eid'], 12, 2 );
        $newtime = "{$mymonth}/{$myday}/{$myyear} {$myhour}:{$mymin}:{$mysec}";
        $creationtime = strtotime( $newtime );
        $extensionTags = PLG_getFeedElementExtensions('event', $row['eid'], $feedType, $feedVersion);
        $content[] = array( 'title'  => $eventtitle,
                            'summary'   => $eventtext,
                            'link'   => $eventlink,
                            'uid'    => $row['owner_id'],
                            'author' => COM_getDisplayName( $row['owner_id'] ),
                            'date'   => $creationtime,
                            'format' => 'plaintext',
                            'extensions' => $extensionTags
                          );
    }

    $link = $_CONF['site_url'] . '/calendar/index.php';
    $update = implode( ',', $eids );

    return $content;
}

/**
* Checking if calendar feeds are up to date
*
* @param    int     $feed           id of feed to be checked
* @param    string  $topic          topic (actually: category)
* @param    string  $update_data    data describing current feed contents
* @param    string  $limit          number of entries or number of hours
* @param    string  $updated_type   (optional) type of feed to be updated
* @param    string  $updated_topic  (optional) feed's "topic" to be updated
* @param    string  $updated_id     (optional) id of entry that has changed
*
*/
function plugin_feedupdatecheck_calendar ($feed, $topic, $update_data, $limit,
                    $updated_type = '', $updated_topic = '', $updated_id = '')
{
    global $_CONF, $_TABLES, $_SYND_DEBUG;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // next xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND (datestart <= DATE_ADD(NOW(), INTERVAL $hours HOUR))";
        }
        else
        {
            $limitsql = ' LIMIT ' . $limit;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    $result = DB_query( "SELECT eid FROM {$_TABLES['events']} WHERE perm_anon > 0 AND dateend >= NOW()$where ORDER BY datestart,timestart $limitsql" );
    $nrows = DB_numRows( $result );

    $eids = array();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );

        if( $A['eid'] == $updated_id )
        {
            // no need to look any further - this feed has to be updated
            return false;
        }

        $eids[] = $A['eid'];
    }
    $current = implode( ',', $eids );

    if ($_SYND_DEBUG) {
        COM_errorLog ("Update check for events: comparing new list ($current) with old list ($update_info)", 1);
    }

    return ( $current != $update_info ) ? false : true;
}


/**
* Calendar will not use comments
*/
function plugin_commentsupport_calendar()
{
    return false;
}


/**
* Shows the statistics for the Calendar plugin on stats.php.
* If $showsitestats is 1 then we are to only print the overall stats in the
* 'site statistics box' otherwise we show the detailed stats
*
* @param    int     showsitestate   Flag to let us know which stats to get
*/
function plugin_showstats_calendar ($showsitestats)
{
    global $_CONF, $_TABLES, $LANG_CAL_1;

    // Top Ten Events
    $result = DB_query("SELECT eid,title,hits from {$_TABLES['events']} WHERE (hits > 0)" . COM_getPermSQL ('AND') . " ORDER BY hits DESC LIMIT 10");
    $nrows  = DB_numRows($result);
    if ($nrows > 0) {
        $header_arr = array(
            array('text' => $LANG_CAL_1[12], 'field' => 'sid'),
            array('text' => $LANG_CAL_1[48], 'field' => 'hits'),
        );
        $data_arr = array();
        $text_arr = array('has_menu'     => false,
                          'title'        => $LANG_CAL_1[47],
        );
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $A['title'] = stripslashes(str_replace('$','&#36;',$A['title']));
            $A['sid'] = "<a href=\"" . COM_buildUrl ($_CONF['site_url']
                      . "/calendar/event.php?eid={$A['eid']}"). "\">{$A['title']}</a>";
            $A['hits'] = COM_NumberFormat ($A['hits']);
            $data_arr[$i] = $A;
        }
        $display .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);
    } else {
        $display .= COM_startBlock($LANG_CAL_1[47]);
        $display .= $LANG_CAL_1[49];
        $display .= COM_endBlock();
    }

    return $display;
}

/**
* New stats plugin API function for proper integration with the site stats
*
* @return   array(item text, item count);
*
*/
function plugin_statssummary_calendar ()
{
    global $LANG_CAL_1, $_TABLES;

    $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['events']}" . COM_getPermSQL ());
    $A = DB_fetchArray ($result);
    return array ($LANG_CAL_1[46], COM_NumberFormat ($A['count']));
}


/**
* This will put an option for polls in the command and control block on
* moderation.php
*
*/
function plugin_cclabel_calendar()
{
    global $_CONF, $LANG_CAL_1;

    if (SEC_hasRights ('calendar.edit')) {
        return array ($LANG_CAL_1[16],
                $_CONF['site_admin_url'] . '/plugins/calendar/index.php',
                plugin_geticon_calendar ());
    }

    return false;
}


/**
* returns the administrative option for this plugin
*
*/
function plugin_getadminoption_calendar()
{
    global $_CONF, $_TABLES, $LANG_CAL_1;

    if (SEC_hasRights ('calendar.edit')) {
        $result = DB_query ("SELECT COUNT(*) AS cnt FROM {$_TABLES['events']}" . COM_getPermSQL ());
        $A = DB_fetchArray ($result);
        $total_events = $A['cnt'];

        return array ($LANG_CAL_1[16],
                      $_CONF['site_admin_url'] . '/plugins/calendar/index.php',
                      $total_events);
    }
}

function plugin_getuseroption_calendar()
{
    global $_CONF, $LANG_CAL_1, $_CA_CONF;

    if( $_CA_CONF['personalcalendars'] == 1 ) {
        $url = $_CONF['site_url'] . '/calendar/index.php?mode=personal';
        return array ($LANG_CAL_1[42], $url, '');
    }
}


/**
* A user is about to be deleted. Update ownership of any polls owned
* by that user or delete them.
*
* @param   uid   int   User id of deleted user
*
*/
function plugin_user_delete_calendar ($uid)
{
    global $_TABLES, $_CA_CONF;

    DB_delete ($_TABLES['personal_events'], 'owner_id', $uid);

    if ($_CA_CONF['delete_event'] == 1) {
        // delete the events
        DB_delete ($_TABLES['events'], 'owner_id', $uid);

    } else {
        // assign ownership to a user from the Root group
        $rootgroup = DB_getItem ($_TABLES['groups'], 'grp_id',
                                 "grp_name = 'Root'");
        $result = DB_query ("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1");
        list($rootuser) = DB_fetchArray ($result);
        DB_query ("UPDATE {$_TABLES['events']} SET owner_id = $rootuser WHERE owner_id = $uid");
    }
}

/**
* Return the current version of code.
* Used in the Plugin Editor to show the registered version and code version
*/
function plugin_chkVersion_calendar()
{
    global $_CA_CONF;

    return $_CA_CONF['version'];
}


/**
* Removes the datastructures for this plugin from the Geeklog database
*
* This may get called by the install routine to undo anything done to this
* point.  To do that, $steps will have a list of steps to undo
*
* @steps   Array    Holds all the steps that have been completed by the install
*
*/
function plugin_uninstall_calendar ($steps = '')
{
    global $_TABLES;

    // Uninstalls the calendar plugin

    COM_errorLog('Dropping events table', 1);
    DB_query("DROP TABLE {$_TABLES['events']}");
    COM_errorLog('...success', 1);
    COM_errorLog('Dropping event submission table', 1);
    DB_query("DROP TABLE {$_TABLES['eventsubmission']}");
    COM_errorLog('...success', 1);
    COM_errorLog('Dropping personal events table', 1);
    DB_query("DROP TABLE {$_TABLES['personal_events']}");
    COM_errorLog('...success', 1);

    // Remove security for this plugin

    // Remove the event admin group
    $grp_id = DB_getItem ($_TABLES['groups'], 'grp_id',
                          "grp_name = 'Event Admin'");

    // Remove Event Admin group from all other groups
    if (!empty ($grp_id)) {
        COM_errorLog ('Attempting to remove Event Admin group from all groups' , 1);
        DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id");
        COM_errorLog ('...success', 1);

        COM_errorLog('Attempting to remove the Event Admin Group', 1);
        DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id");
        COM_errorLog('...success', 1);
    }

    // Remove related features
    $features = array ('event.edit', 'event.moderate', 'event.submit');

    foreach ($features as $f) {
        $feat_id = DB_getItem ($_TABLES['features'], 'ft_id', "ft_name = '$f'");
        if (!empty ($feat_id)) {
            COM_errorLog ("Attempting to remove $f rights from all groups", 1);
            DB_query ("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id");
            COM_errorLog ('...success', 1);

            COM_errorLog ("Attempting to remove the $f feature", 1);
            DB_query ("DELETE FROM {$_TABLES['features']} WHERE ft_id = $feat_id");
            COM_errorLog ('...success', 1);
        }
    }

    // Unregister the plugin with Geeklog
    // Always attempt to remove this entry or lib-common.php would still
    // try and read our functions.inc file ...
    COM_errorLog('Attempting to unregister the calendar plugin from Geeklog', 1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'calendar'");
    COM_errorLog('...success', 1);

    COM_errorLog ('Finished uninstalling the Calendar plugin.', 1);

    return true;
}

/**
* Get path for the template files.
*
* @param    string  $path   subdirectory within the base template path
* @return   string          full path to template directory
*
*/
function calendar_templatePath ($path = '')
{
    global $_CONF;

    if (is_dir ($layout_path)) {
        $retval = $layout_path;
    } else {
        $retval = $_CONF['path'] . 'plugins/calendar/templates';
        if (!empty ($path)) {
            $retval .= '/' . $path;
        }
    }

    return $retval;
}

/**
* Returns the URL of the plugin's icon
*
* @return   string      URL of the icon
*
*/
function plugin_geticon_calendar ()
{
    global $_CONF;

    return $_CONF['site_url'] . '/calendar/images/calendar.png';
}

/**
* Set template variables
*
* @param    string  $templatename   name of template, e.g. 'header'
* @param    ref     $template       reference of actual template
* @return   void
*
* Note: A plugin should use its name as a prefix for the names of its
* template variables, e.g. 'calendar_xxx' and 'lang_calendar_xxx'.
* 'button_calendar' is an exception, as such a variable existed for header.thtml
* in Geeklog 1.4.0 and earlier, where the Calendar was an integral part
* of Geeklog. It is added here for backward-compatibility.
*
*/
function plugin_templatesetvars_calendar ($templatename, &$template)
{
    global $LANG_CAL_1;

    if ($templatename == 'header') {
        $template->set_var ('button_calendar', $LANG_CAL_1[16]);
    }
}

function plugin_getListField_calendar($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_ACCESS, $LANG_ADMIN;

    $retval = '';

    $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],
                            $A['perm_group'],$A['perm_members'],$A['perm_anon']);

    switch($fieldname) {
        case "edit":
            if ($access == 3) {
                $retval = "<a href=\"{$_CONF['site_admin_url']}"
                        . "/plugins/calendar/index.php?mode=edit&amp;eid="
                        . "{$A['eid']}\">{$icon_arr['edit']}</a>";
            }
            break;
        case "copy":
            if ($access == 3) {
                $retval = "<a href=\"{$_CONF['site_admin_url']}"
                        . "/plugins/calendar/index.php?mode=clone&amp;eid="
                        . "{$A['eid']}\">{$icon_arr['copy']}</a>";
            }
            break;
        case 'access':
            if ($access == 3) {
                $retval = $LANG_ACCESS['edit'];
            } else {
                $retval = $LANG_ACCESS['readonly'];
            }
            break;
        case 'title':
            $retval = stripslashes ($A['title']);
            $retval = "<a href=\"{$_CONF['site_url']}/calendar/event.php?eid="
                    . "{$A['eid']}\">$retval</a>";
            break;
        default:
            $retval = $fieldvalue;
            break;
    }
    return $retval;
}

?>
