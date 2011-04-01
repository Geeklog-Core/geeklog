<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendar Plugin 1.1                                                       |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the Calendar   |
// | plugin's PHP files.                                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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

/**
* Implementation of the Plugin API for the Calendar plugin
*
* @package Calendar
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}

$plugin_path = $_CONF['path'] . 'plugins/calendar/';
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';

if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $plugin_path . 'language/english.php';
}

/*
* Check and see if we need to load the plugin configuration
*/
if (!isset($_CA_CONF['calendarloginrequired'])) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $ca_config = config::get_instance();
    $_CA_CONF = $ca_config->get_config('calendar');
}


// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Returns the items for this plugin that should appear on the main menu
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
*/
function plugin_getmenuitems_calendar ()
{
    global $_CONF, $_USER, $_CA_CONF, $LANG_CAL_1;

    $anon = (empty ($_USER['uid']) || ($_USER['uid'] <= 1)) ? true : false;
    if (($_CA_CONF['hidecalendarmenu'] == 1) || ($anon &&
            ($_CONF['loginrequired'] || $_CA_CONF['calendarloginrequired']))) {
        return false;
    }

    $menuitems[$LANG_CAL_1[16]] = $_CONF['site_url'] . '/calendar/index.php';

    return $menuitems;
}

/**
* Returns the upcoming events block
*
* Returns the HTML for any upcoming events in the calendar
*
* @param        string      $help       Help file for block
* @param        string      $title      Title to be used in block header
* @return   string  HTML formatted block containing events.
*/
function phpblock_calendar( $help='', $title='' )
{
    global $_CONF, $_TABLES, $_USER, $_CA_CONF, $LANG_CAL_1, $_DB_dbms;

    $retval = '';

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
            $title = DB_getItem( $_TABLES['blocks'], 'title',
                                 "name = 'events_block'" );
        }
        $eventSql = 'SELECT eid,title,url,datestart,dateend,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon '
        . "FROM {$_TABLES['events']} ";
        if($_DB_dbms == 'mssql') {
            $eventSql .= "WHERE dateend >= DATEADD(hh, 24, NOW()) AND (TO_DAYS(datestart) - TO_DAYS(NOW()) < $range) ";
        } else if($_DB_dbms =='pgsql')
        {
            $eventSql .= "WHERE dateend >= (NOW() - INTERVAL '1 day') AND (NOW() - INTERVAL '$range days') < datestart ";   
        } 
        else {
            $eventSql .= "WHERE dateend >= (NOW() - INTERVAL 24 HOUR) AND (TO_DAYS(datestart) - TO_DAYS(NOW()) < $range) ";            
        }
        $eventSql .= 'ORDER BY datestart,timestart';

        if (($_CA_CONF['personalcalendars'] == 1) && !COM_isAnonUser()) {
            $personaleventsql = 'SELECT eid,title,url,datestart,dateend,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon '
            . "FROM {$_TABLES['personal_events']} ";
            if($_DB_dbms == 'mssql') {
                $personaleventsql .= "WHERE uid = {$_USER['uid']} AND dateend >= DATEADD(hh, 24, getUTCDate())  AND (TO_DAYS(datestart) - TO_DAYS(NOW()) < $range) ";
            }
            else if($_DB_dbms=='pgsql')
            {
                $personaleventsql .= "WHERE uid = {$_USER['uid']} AND dateend >= (NOW() - INTERVAL '1 day')  AND (NOW() - INTERVAL '$range days') < datestart ";
            }
             else {
                $personaleventsql .= "WHERE uid = {$_USER['uid']} AND dateend >= (NOW() - INTERVAL 24 HOUR)  AND (TO_DAYS(datestart) - TO_DAYS(NOW()) < $range) ";
            }
            $personaleventsql .= 'ORDER BY datestart, dateend';
        }

        $allEvents = DB_query( $eventSql );
        $numRows = DB_numRows( $allEvents );
        $totalrows = $numRows;

        $numDays = 0;          // Without limits, I'll force them.
        $theRow = 1;           // Start with today!
        $oldDate1 = 'no_day';  // Invalid Date!
        $oldDate2 = 'last_d';  // Invalid Date!

        if (($_CA_CONF['personalcalendars'] == 1) AND !COM_isAnonUser()) {
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
                $classname = 'list-new-plugins';
                $headline = false;
            } else {
                $classname = 'list-new-plugins';
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
                                $retval .= '<p><b>' . $LANG_CAL_1[23] . '</b><br' . XHTML . '>';
                            }
                        } else {
                            if( $totalrows > 0 ) {
                                $retval .= '<b>' . $LANG_CAL_1[24] . '</b><br' . XHTML . '>';
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
                                $retval .= '<br' . XHTML . '>';
                            }
                            if( $todaysEvent ) {
                                $retval .= '<span class="' . $todaysClassName . '">';
                            }
                            $retval .= '<b>' . $dayName1 . '</b>&nbsp;<small>'
                                    . $abbrDate1 . '</small>';

                            // If different start and end dates, then display end date:
                            if( $abbrDate1 != $abbrDate2 ) {
                                $retval .= ' - <br' . XHTML . '><b>' . $dayName2 . '</b>&nbsp;<small>' . $abbrDate2 . '</small>';
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
                        $newevent_url = $_CONF['site_url']
                                  . '/calendar/event.php?';

                        if( $z == 2 ) {
                            $newevent_url .= 'mode=personal&amp;';
                        }

                        $newevent_url .= 'eid=' . $theEvent['eid'];
                        $attr = array();
                        if( $todaysEvent ) {
                            $attr = array('class' => $todaysClassName);
                        }

                        $newevent = COM_createLink(
                            stripslashes( $theEvent['title'] ),
                            $newevent_url,
                            $attr
                        );
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
function plugin_ismoderator_calendar()
{
    return SEC_hasRights('calendar.moderate');
}

/**
* Returns SQL & Language texts to moderation.php
*
* @return   mixed   Plugin object or void if not allowed
*
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
        "eid,title,description,location,address1,address2,city,state,zipcode,datestart,timestart,dateend,timeend,url,owner_id",
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
function plugin_moderationapprove_calendar($id)
{
    global $_CA_CONF, $_GROUPS, $_TABLES;

    // The eventsubmission table only keeps track of the submitter's uid,
    // but not of groups and permissions. So set those to sensible defaults.

    if (isset($_GROUPS['Calendar Admin'])) {
        $group_id = $_GROUPS['Calendar Admin'];
    } else {
        $group_id = SEC_getFeatureGroup('calendar.moderate');
    }

    $A = array();
    SEC_setDefaultPermissions($A, $_CA_CONF['default_permissions']);

    DB_query("UPDATE {$_TABLES['events']} SET group_id = '$group_id', perm_owner = '{$A['perm_owner']}', perm_group = '{$A['perm_group']}', perm_members = '{$A['perm_members']}', perm_anon = '{$A['perm_anon']}' WHERE eid = '$id'");

    return '';
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
* and Saves a calendar submission
*
* @param    array   $A  Data for that submission
* @return   string      HTML redirect
*
*/
function plugin_savesubmission_calendar($A)
{
    global $_CONF, $_CA_CONF, $_TABLES, $_USER, $LANG12, $LANG_CAL_1;

    $A['title'] = strip_tags (COM_checkWords ($A['title']));
    $A['start_year'] = COM_applyFilter ($A['start_year'], true);
    $A['start_month'] = COM_applyFilter ($A['start_month'], true);
    $A['start_day'] = COM_applyFilter ($A['start_day'], true);

    // check for missing textfields
    if (empty ($A['title']) || empty ($A['start_month']) || empty ($A['start_day']) || empty ($A['start_year'])) {
        $retval .= COM_siteHeader ('menu', $LANG_CAL_1[27])
            . COM_startBlock ($LANG12[22], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[23]
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
            . plugin_submit_calendar ($A['calendar_type'])
            . COM_siteFooter ();

        return $retval;
    }
    // check ok, proceed to saving
    if (isset($A['end_year'])) {
        $A['end_year'] = COM_applyFilter($A['end_year'], true);
    }
    if (isset($A['end_month'])) {
        $A['end_month'] = COM_applyFilter($A['end_month'], true);
    }
    if (isset($A['end_day'])) {
        $A['end_day'] = COM_applyFilter($A['end_day'], true);
    }

    $A['datestart'] = sprintf ('%4d-%02d-%02d',
                        $A['start_year'], $A['start_month'], $A['start_day']);
    if (empty ($A['end_year']) || empty ($A['end_month']) ||
            empty ($A['end_day'])) {
        $A['dateend'] = $A['datestart'];
    } else {
        $A['dateend'] = sprintf ('%4d-%02d-%02d',
                            $A['end_year'], $A['end_month'], $A['end_day']);
    }

    // for the quickadd form, which doesn't have end date/time fields
    if (!isset ($A['end_hour'])) {
        $A['end_hour'] = $A['start_hour'];
    }
    if (!isset ($A['end_minute'])) {
        $A['end_minute'] = $A['start_minute'];
    }

    $A['title']       = (isset($A['title']) ? $A['title'] : '');
    $A['url']         = (isset($A['url']) ? $A['url'] : '');
    $A['location']    = (isset($A['location']) ? $A['location'] : '');
    $A['address1']    = (isset($A['address1']) ? $A['address1'] : '');
    $A['address2']    = (isset($A['address2']) ? $A['address2'] : '');
    $A['city']        = (isset($A['city']) ? $A['city'] : '');
    $A['zipcode']     = (isset($A['zipcode']) ? $A['zipcode'] : '');
    $A['state']       = (isset($A['state']) ? $A['state'] : '');
    $A['description'] = (isset($A['description']) ? $A['description'] : '');
    $A['event_type']  = (isset($A['event_type']) ? $A['event_type'] : '');

    if ($A['url'] == 'http://') {
        // remove default entry now to avoid false spam reports
        $A['url'] = '';
    }

    // pseudo-formatted event description for the spam check
    $spamcheck = '';
    if (empty($A['url'])) {
        $spamcheck .= $A['title'];
    } else {
        $spamcheck .= COM_createLink($A['title'], $A['url']);
    }
    $spamcheck .= '<br' . XHTML . '>' . $A['location'] . '<br' . XHTML . '>'
               . $A['address1'] . '<br' . XHTML . '>' . $A['address2']
               . '<br' . XHTML . '>' . $A['city'] . ', ' . $A['zipcode']
               . '<br' . XHTML . '>' . $A['description'] . '</p>';
    $result = PLG_checkforSpam($spamcheck, $_CONF['spamx']);
    if ($result > 0) {
        COM_updateSpeedlimit('submit');
        COM_displayMessageAndAbort($result, 'spamx', 403, 'Forbidden');
    }

    $msg = PLG_itemPreSave('calendar', $A);
    if (! empty($msg)) {
        $retval .= COM_siteHeader('menu', $LANG_CAL_1[27])
            . COM_errorLog($msg, 2)
            . plugin_submit_calendar($A['calendar_type'])
            . COM_siteFooter();

        return $retval;
    }

    // Remove any autotags the user doesn't have permission to use
    $A['description'] = PLG_replaceTags($A['description'], '', true);
     $A['description'] = addslashes (htmlspecialchars (COM_checkWords ($A['description'])));
    $A['address1'] = addslashes (strip_tags (COM_checkWords ($A['address1'])));
    $A['address2'] = addslashes (strip_tags (COM_checkWords ($A['address2'])));
    $A['city'] = addslashes (strip_tags (COM_checkWords ($A['city'])));
    $A['zipcode'] = addslashes (strip_tags (COM_checkWords ($A['zipcode'])));
    $A['state'] = addslashes (strip_tags (COM_checkWords ($A['state'])));
    $A['location'] = addslashes (strip_tags (COM_checkWords ($A['location'])));
    $A['event_type'] = addslashes (strip_tags (COM_checkWords ($A['event_type'])));
    $A['title'] = addslashes ($A['title']);

    $A['url'] = addslashes(COM_sanitizeUrl($A['url']));

    if (!empty ($A['eid'])) {
        $A['eid'] = addslashes (COM_applyFilter ($A['eid']));
    }
    if (empty ($A['eid'])) {
        $A['eid'] = addslashes (COM_makeSid ());
    }

    COM_updateSpeedlimit ('submit');

    if (isset ($A['allday']) && ($A['allday'] == 'on')) {
        $A['allday'] = 1;
    } else {
        $A['allday'] = 0;
    }

    if (isset ($A['hour_mode']) && ($A['hour_mode'] == 24)) {
        $start_hour = COM_applyFilter ($A['start_hour'], true);
        if ($start_hour >= 12) {
            $A['start_ampm'] = 'pm';
            $A['start_hour'] = $start_hour - 12;
        } else {
            $A['start_ampm'] = 'am';
            $A['start_hour'] = $start_hour;
        }
        if ($A['start_hour'] == 0) {
            $A['start_hour'] = 12;
        }
        $end_hour = COM_applyFilter ($A['end_hour'], true);
        if ($end_hour >= 12) {
            $A['end_ampm'] = 'pm';
            $A['end_hour'] = $end_hour - 12;
        } else {
            $A['end_ampm'] = 'am';
            $A['end_hour'] = $end_hour;
        }
        if ($A['end_hour'] == 0) {
            $A['end_hour'] = 12;
        }
    }
    if (!isset ($A['end_ampm'])) {
        $A['end_ampm'] = $A['start_ampm'];
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
                !SEC_hasRights('calendar.submit')) {

            if (COM_isAnonUser()) {
                $uid = 1;
            } else {
                $uid = $_USER['uid'];
            }

            DB_save ($_TABLES['eventsubmission'],
                     'eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description,owner_id',
                     "{$A['eid']},'{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}',{$uid}");

            if (isset ($_CA_CONF['notification']) &&
                    ($_CA_CONF['notification'] == 1)) {
                CALENDAR_sendNotification ($_TABLES['eventsubmission'], $A);
            }

            $retval = COM_refresh($_CONF['site_url']
                                  . '/calendar/index.php?msg=4');
        } else {
            if (COM_isAnonUser()) {
                $owner_id = 1; // anonymous user
            } else {
                $owner_id = $_USER['uid'];
            }

            if (SEC_hasRights('calendar.submit')) {
                $A['group_id'] = SEC_getFeatureGroup('calendar.submit');
            } else {
                $A['group_id'] = DB_getItem($_TABLES['groups'], 'grp_id',
                                            "grp_name = 'All Users'");
            }
            SEC_setDefaultPermissions($A, $_CA_CONF['default_permissions']);

            DB_save ($_TABLES['events'],
                     'eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',
                     "{$A['eid']},'{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}',$owner_id,{$A['group_id']},{$A['perm_owner']},{$A['perm_group']},{$A['perm_members']},{$A['perm_anon']}");

            PLG_itemSaved($A['eid'], 'calendar');

            if (isset($_CA_CONF['notification']) &&
                    ($_CA_CONF['notification'] == 1)) {
                CALENDAR_sendNotification($_TABLES['events'], $A);
            }
            COM_rdfUpToDateCheck('calendar', $A['event_type'], $A['eid']);

            $retval = COM_refresh($_CONF['site_url']
                                  . '/calendar/index.php?msg=17');
        }

    } else if ($_CA_CONF['personalcalendars'] == 1) { // add to personal calendar
        if (COM_isAnonUser()) {
            // anonymous users don't have personal calendars - bail
            COM_accessLog("Attempt to write to the personal calendar of user '{$A['uid']}'.");

            $retval = COM_refresh($_CONF['site_url'] . '/calendar/index.php');
        } else {
            DB_save ($_TABLES['personal_events'],
                     'uid,eid,title,event_type,url,datestart,timestart,dateend,timeend,allday,location,address1,address2,city,state,zipcode,description',
                     "{$_USER['uid']},'{$A['eid']}','{$A['title']}','{$A['event_type']}','{$A['url']}','{$A['datestart']}','{$A['timestart']}','{$A['dateend']}','{$A['timeend']}',{$A['allday']},'{$A['location']}','{$A['address1']}','{$A['address2']}','{$A['city']}','{$A['state']}','{$A['zipcode']}','{$A['description']}'");
            $retval = COM_refresh ($_CONF['site_url']
                                   . '/calendar/index.php?mode=personal&amp;msg=17');
        }

    } else { // personal calendars are disabled
        $retval = COM_refresh ($_CONF['site_url'] . '/calendar/index.php');
    }

    return $retval;
}

function plugin_getheadercode_calendar()
{
    global $_SCRIPTS;

    // use the CSS only if we are on the plugin's pages
    if (substr_count ($_SERVER['PHP_SELF'], '/calendar/') > 0) {
        $_SCRIPTS->setCSSFile('calendar', '/calendar/style.css', false);
    }
}

/**
* Shows event submission form or diverts to event editor if admin calls in
*
*/
function plugin_submit_calendar($mode = 'master')
{
    global $_CONF, $_CA_CONF, $LANG_CAL_1, $LANG12;

    if (isset($_POST['calendar_type'])) {
        $mode = $_POST['calendar_type'];
    } else if (isset($_REQUEST['mode']) && ($_REQUEST['mode'] == 'personal')) {
        $mode = 'personal';
    }

    if (($_CA_CONF['personalcalendars'] == 1) && ($mode == 'quickadd')) {
        // quick add form, just save it.
        $display = plugin_savesubmission_calendar ($_POST);
        return $display;
    } else if (SEC_hasRights('calendar.edit') && ($mode != 'personal')) {
        // admin posts non-personal, go to editor
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
            $startat = '&amp;datestart='
                     . urlencode (sprintf ('%04d-%02d-%02d', $year,
                                           $month, $day))
                     . '&amp;timestart=' . urlencode (sprintf ('%02d:00:00',
                                                           $hour));
        }

        echo COM_refresh ($_CONF['site_admin_url']
                          . '/plugins/calendar/index.php?mode=edit' . $startat);
        exit;
    }
    // otherwise non-admin or admin-personal. do personal form or public submission.

    $retval = '';

    $retval .= COM_startBlock ($LANG_CAL_1[26], 'submitevent.html');
    $eventform = COM_newTemplate($_CONF['path'] . 'plugins/calendar/templates/');
    $eventform->set_file ('eventform', 'submitevent.thtml');
    if ($mode != 'personal') {
        $eventform->set_var ('explanation', $LANG_CAL_1[27]);
        $eventform->set_var ('submit_url', '/submit.php');
    } else {
        $eventform->set_var ('explanation', '');
        $eventform->set_var ('submit_url', '/calendar/index.php?view=savepersonal');
    }
    if (isset ($_CA_CONF['hour_mode']) && ($_CA_CONF['hour_mode'] == 24)) {
        $eventform->set_var ('hour_mode', 24);
    } else {
        $eventform->set_var ('hour_mode', 12);
    }
    $eventform->set_var ('lang_title', $LANG_CAL_1[28]);

    $eventform->set_var('lang_eventtype', $LANG_CAL_1[37]);
    $eventform->set_var('lang_editeventtypes', $LANG_CAL_1[38]);
    $eventform->set_var('type_options', CALENDAR_eventTypeList ());

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

    if (empty ($hour) || ($hour < 0)) {
        $cur_hour = date ('H', time ());
    } else {
        $cur_hour = $hour;
    }
    $cur_hour_24 = $cur_hour % 24;
    if ($cur_hour >= 12) {
        $ampm = 'pm';
    } else {
        $ampm = 'am';
    }

    $eventform->set_var ('startampm_selection',
                         COM_getAmPmFormSelection ('start_ampm', $ampm));
    $eventform->set_var ('endampm_selection',
                         COM_getAmPmFormSelection ('end_ampm', $ampm));

    if ($cur_hour > 12) {
        $cur_hour = $cur_hour - 12;
    } else if ($cur_hour == 0) {
        $cur_hour = 12;
    }

    if (isset ($_CA_CONF['hour_mode']) && ($_CA_CONF['hour_mode'] == 24)) {
        $eventform->set_var ('hour_options',
                             COM_getHourFormOptions ($cur_hour_24, 24));
    } else {
        $eventform->set_var ('hour_options',
                             COM_getHourFormOptions ($cur_hour));
    }
    $cur_min = intval (date ('i') / 15) * 15;
    $eventform->set_var ('minute_options',
                         COM_getMinuteFormOptions ($cur_min, 15));

    $eventform->set_var('lang_enddate', $LANG_CAL_1[18]);
    $eventform->set_var('lang_endtime', $LANG_CAL_1[29]);
    $eventform->set_var('lang_alldayevent',$LANG_CAL_1[31]);
    $eventform->set_var('lang_addressline1',$LANG_CAL_1[32]);
    $eventform->set_var('lang_addressline2',$LANG_CAL_1[33]);
    $eventform->set_var('lang_city',$LANG_CAL_1[34]);
    $eventform->set_var('lang_state',$LANG_CAL_1[35]);
    $eventform->set_var('state_options', '');
    $eventform->set_var('lang_zipcode',$LANG_CAL_1[36]);
    $eventform->set_var('lang_location', $LANG_CAL_1[39]);
    $eventform->set_var('lang_description', $LANG_CAL_1[5]);
    $allowed = COM_allowedHTML('links.edit', false, 2);
    $eventform->set_var('lang_allowed_html', $allowed);       
    PLG_templateSetVars('calendar', $eventform);
    $eventform->set_var('lang_submit', $LANG12[8]);
    $eventform->set_var('mode', $mode);
    if ($mode == 'personal') {
        $token = SEC_createToken();
        $hidden_fields = '<input type="hidden" name="' . CSRF_TOKEN
                       . "\" value=\"{$token}\"" . XHTML . ">";
        $eventform->set_var('hidden_fields', $hidden_fields);
    } else {
        $eventform->set_var('hidden_fields', '');
    }
    $eventform->parse('theform', 'eventform');
    $retval .= $eventform->finish($eventform->get_var('theform'));
    $retval .= COM_endBlock();

    return $retval;
}

/**
* Delete an event
*
* @param    string  $eid    id of event to delete
* @param    string  $type   'submission' when attempting to delete a submission
* @param    string          HTML redirect
*/
function CALENDAR_deleteEvent($eid, $type = '')
{
    global $_CONF, $_TABLES, $_USER;

    if (empty($type)) { // delete regular event
        $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['events']} WHERE eid = '$eid'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon']);
        if ($access < 3) {
            COM_accessLog("User {$_USER['username']} tried to illegally delete event $eid.");
            return COM_refresh($_CONF['site_admin_url']
                               . '/plugins/calendar/index.php');
        }

        DB_delete($_TABLES['events'], 'eid', $eid);
        DB_delete($_TABLES['personal_events'], 'eid', $eid);

        PLG_itemDeleted($eid, 'calendar');
        COM_rdfUpToDateCheck('calendar');

        return COM_refresh($_CONF['site_admin_url'] . '/plugins/calendar/index.php?msg=18');
    } elseif ($type == 'submission') {
        if (plugin_ismoderator_calendar()) {
            DB_delete($_TABLES['eventsubmission'], 'eid', $eid);
        } else {
            COM_accessLog("User {$_USER['username']} tried to illegally delete event submission $eid.");
        }
    } else {
        COM_accessLog("User {$_USER['username']} tried to illegally delete event $eid of type $type.");
    }

    return COM_refresh($_CONF['site_admin_url']
                       . '/plugins/calendar/index.php');
}

function CALENDAR_listOld()
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG_CAL_ADMIN, $LANG_ACCESS,
           $LANG01, $_IMAGE_TYPE;

    if (isset($_REQUEST['usr_time'])) {
        $usr_time = $_REQUEST['usr_time'];
    } else {
        $usr_time = 12;
    }

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true)
    );
    if ($_CONF['show_fullname'] == 1) {
        $header_arr[] = array('text' => $LANG_CAL_ADMIN[13], 'field' => 'fullname', 'sort' => true);
    } else {
        $header_arr[] = array('text' => $LANG_CAL_ADMIN[13], 'field' => 'username', 'sort' => true);
    }
    $header_arr[] = array('text' => $LANG_ACCESS['access'], 'field' => 'access', 'sort' => false);
    $header_arr[] = array('text' => $LANG_CAL_ADMIN[14], 'field' => 'datestart', 'sort' => true);
    $header_arr[] = array('text' => $LANG_CAL_ADMIN[15], 'field' => 'dateend', 'sort' => true);

    $defsort_arr = array('field' => 'datestart', 'direction' => 'desc');

    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'] . '/plugins/calendar/index.php?mode=edit',
            'text' => $LANG_ADMIN['create_new']),
        array('url' => $_CONF['site_admin_url'] . '/plugins/calendar/index.php',
            'text' => $LANG_CAL_ADMIN['32']),
        array('url' => $_CONF['site_admin_url'],
            'text' => $LANG_ADMIN['admin_home'])
    );

    $cal_templates = COM_newTemplate($_CONF['path'] . 'plugins/calendar/templates/admin');
    $cal_templates->set_file(array('form' => 'batchdelete.thtml'));
    $cal_templates->set_var('usr_time', $usr_time);
    $cal_templates->set_var('lang_text_start', $LANG_CAL_ADMIN[28]);
    $cal_templates->set_var('lang_text_end', $LANG_CAL_ADMIN[29]);
    $cal_templates->set_var('lang_updatelist', $LANG_CAL_ADMIN[30]);
    $cal_templates->set_var('lang_delete_sel', $LANG_ADMIN['delete_sel']);
    $cal_templates->set_var('lang_delconfirm', $LANG_CAL_ADMIN[31]);
    $cal_templates->parse('form', 'form');
    $desc = $cal_templates->finish($cal_templates->get_var('form'));

    $text_arr = array(
        'has_menu' =>  true,
        'has_extras' => true,
        'title' => $LANG_CAL_ADMIN[11],
        'instructions' => $LANG_CAL_ADMIN[27] . $usr_time . "$desc",
        'form_url' => $_CONF['site_admin_url'] . "/plugins/calendar/index.php?mode=batchdelete"
    );

    $sql = "SELECT {$_TABLES['events']}.*, {$_TABLES['users']}.username, {$_TABLES['users']}.fullname "
        ."FROM {$_TABLES['events']} "
        ."LEFT JOIN {$_TABLES['users']} "
        ."ON {$_TABLES['events']}.owner_id={$_TABLES['users']}.uid "
        ."WHERE 1=1 ";

    $filterstr = " AND UNIX_TIMESTAMP() - UNIX_TIMESTAMP(dateend) > " . $usr_time * 2592000 . " ";

    $query_arr = array (
        'table' => 'events',
        'sql' => $sql,
        'query_fields' => array('title', 'datestart', 'dateend'),
        'default_filter' => $filterstr . COM_getPermSQL('AND')
    );

    $listoptions = array('chkdelete' => true, 'chkfield' => 'eid');
    $retval .= ADMIN_createMenu($menu_arr, $LANG_CAL_ADMIN[27] . $usr_time . "$desc", plugin_geticon_calendar());

    $token = SEC_createToken();
    $form_arr['bottom'] = "<input type=\"hidden\" name=\"" . CSRF_TOKEN
                        . "\" value=\"{$token}\"" . XHTML . ">";
    $retval .= ADMIN_list('calendar', 'plugin_getListField_calendar',
                          $header_arr, $text_arr, $query_arr,
                          $defsort_arr, '', '', $listoptions, $form_arr);

    return $retval;
}


/**
* This function deletes the events selected in the listOld function
*
* @return   string          HTML with success or error message
*
*/
function CALENDAR_deleteOld()
{
    global $_CONF, $LANG_CAL_ADMIN;

    $msg = '';
    $event_list = array();
    if (isset($_POST['delitem'])) {
        $event_list = $_POST['delitem'];
    }

    if (count($event_list) == 0) {
        $msg = $LANG_CAL_ADMIN[33] . "<br" . XHTML . ">";
    }
    $c = 0;
    if (isset($event_list) AND is_array($event_list)) {
        foreach($event_list as $delitem) {
            $delitem = COM_applyFilter($delitem);
            if (!CALENDAR_deleteEvent ($delitem)) {
                $msg .= "<strong>{$LANG_CAL_ADMIN[34]} $delitem $LANG_CAL_ADMIN[35]}</strong><br" . XHTML . ">\n";
            } else {
                $c++; // count the deleted users
            }
        }
    }

    // Since this function is used for deletion only, its necessary to say that
    // zero were deleted instead of just leaving this message away.
    COM_numberFormat($c); // just in case we have more than 999 ...
    $msg .= "{$LANG_CAL_ADMIN[36]}: $c<br" . XHTML . ">\n";

    return $msg;
}

function CALENDAR_listevents()
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG_CAL_ADMIN, $LANG_ACCESS,
           $_IMAGE_TYPE;

    require_once( $_CONF['path_system'] . 'lib-admin.php' );

    $retval = '';

    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG_ADMIN['copy'], 'field' => 'copy', 'sort' => false),
        array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true)
    );
    if ($_CONF['show_fullname'] == 1) {
        $header_arr[] = array('text' => $LANG_CAL_ADMIN[13], 'field' => 'fullname', 'sort' => true);
    } else {
        $header_arr[] = array('text' => $LANG_CAL_ADMIN[13], 'field' => 'username', 'sort' => true);
    }
    $header_arr[] = array('text' => $LANG_ACCESS['access'], 'field' => 'access', 'sort' => false);
    $header_arr[] = array('text' => $LANG_CAL_ADMIN[14], 'field' => 'datestart', 'sort' => true);
    $header_arr[] = array('text' => $LANG_CAL_ADMIN[15], 'field' => 'dateend', 'sort' => true);

    $defsort_arr = array('field' => 'datestart', 'direction' => 'desc');

    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'] . '/plugins/calendar/index.php?mode=edit',
              'text' => $LANG_ADMIN['create_new']),
        array('url' => $_CONF['site_admin_url'] . '/plugins/calendar/index.php?mode=batchdelete',
              'text' => $LANG_CAL_ADMIN[26]),
        array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home'])
    );

    $retval .= COM_startBlock($LANG_CAL_ADMIN[11], '',
                              COM_getBlockTemplate('_admin_block', 'header'));
    $retval .= ADMIN_createMenu($menu_arr, $LANG_CAL_ADMIN[12], plugin_geticon_calendar());

    $text_arr = array(
        'has_extras' => true,
        'form_url'   => $_CONF['site_admin_url'] . '/plugins/calendar/index.php'
    );

    $sql = "SELECT {$_TABLES['events']}.*, {$_TABLES['users']}.username, {$_TABLES['users']}.fullname "
          ."FROM {$_TABLES['events']} "
          ."LEFT JOIN {$_TABLES['users']} "
          ."ON {$_TABLES['events']}.owner_id={$_TABLES['users']}.uid "
          ."WHERE 1=1 ";

    $query_arr = array(
        'table' => 'events',
        'sql' => $sql,
        'query_fields' => array('title', 'datestart', 'dateend'),
        'default_filter' => COM_getPermSQL('AND')
    );

    $retval .= ADMIN_list ('calendar', 'plugin_getListField_calendar',
                           $header_arr, $text_arr, $query_arr,
                           $defsort_arr);

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

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
    global $_CONF, $_TABLES, $LANG01, $LANG08, $LANG09, $LANG_CAL_1, $LANG_CAL_2;

    $title = stripslashes ($A['title']);
    $description = stripslashes ($A['description']);

    $mailbody = "$LANG09[16]: $title\n"
              . "$LANG09[17]: " . strftime ($_CONF['date'],
                strtotime ($A['datestart'] . ' ' . $A['timestart']));
    if ($A['allday']) {
        $mailbody .= ' (' . $LANG_CAL_2[26] . ')';
    }
    $mailbody .= "\n";
    if (!empty ($A['url']) && ($A['url'] != 'http://')) {
        $mailbody .= "$LANG09[33]: <" . $A['url'] . ">\n";
    }
    $mailbody .= "\n" . $description . "\n\n";
    if ($table == $_TABLES['eventsubmission']) {
        $mailbody .= "$LANG01[10] <{$_CONF['site_admin_url']}/moderation.php>\n\n";
    } else {
        $mailbody .= "$LANG_CAL_1[12] <{$_CONF['site_url']}/calendar/event.php?eid={$A['eid']}>\n\n";
    }
    $mailsubject = $_CONF['site_name'] . ' ' . $LANG_CAL_2[43];

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
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
* Implements the [event:] autotag.
*
*/
function plugin_autotags_calendar ($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES, $LANG_CAL_1, $_CA_CONF, $_GROUPS;

    if ($op == 'tagname' ) {
        return 'event';
    } elseif ($op == 'permission' || $op == 'nopermission') {
        if ($op == 'permission') {
            $flag = true;
        } else {
            $flag = false;
        }
        $tagnames = array();

        if (isset($_GROUPS['Calendar Admin'])) {
            $group_id = $_GROUPS['Calendar Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                                   "grp_name = 'Calendar Admin'");
        }
        $owner_id = SEC_getDefaultRootUser();

        if (COM_getPermTag($owner_id, $group_id, $_CA_CONF['autotag_permissions_event'][0], $_CA_CONF['autotag_permissions_event'][1], $_CA_CONF['autotag_permissions_event'][2], $_CA_CONF['autotag_permissions_event'][3]) == $flag) {
            $tagnames[] = 'event';
        }

        if (count($tagnames) > 0) {
            return $tagnames;
        }
    } elseif ($op == 'description') {
        return array (
            'event' => $LANG_CAL_1['autotag_desc_event']
            );        
    } else if ($op == 'parse') {
        $eid = COM_applyFilter($autotag['parm1']);
        if (! empty($eid)) {
            $url = $_CONF['site_url'] . '/calendar/event.php?eid=' . $eid;
            if (empty ($autotag['parm2'])) {
                $linktext = stripslashes (DB_getItem ($_TABLES['events'],
                                          'title', "eid = '$eid'"));
            } else {
                $linktext = $autotag['parm2'];
            }
            $link = COM_createLink($linktext, $url);
            $content = str_replace ($autotag['tagstr'], $link, $content);
        }

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
* @param    string   $feed     feed ID
* @param    string   $link     link to homepage
* @param    string   $update   list of story ids
* @return   array              content of the feed
*
*/
function plugin_getfeedcontent_calendar( $feed, &$link, &$update, $feedType, $feedVersion )
{
    global $_CONF, $_TABLES;

    $limit = DB_getItem($_TABLES['syndication'], 'limits', "fid = '$feed'");

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
        $eventtext = SYND_truncateSummary( $row['description'], MBYTE_strlen($row['description']));
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
        $extensionTags = array(); // PLG_getFeedElementExtensions('calendar', $row['eid'], $feedType, $feedVersion, $eventtitle, );
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

    return ( $current != $update_data ) ? false : true;
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

    $display = '';

    // Top Ten Events
    $result = DB_query("SELECT eid,title,hits FROM {$_TABLES['events']} WHERE (hits > 0)" . COM_getPermSQL ('AND') . " ORDER BY hits DESC LIMIT 10");
    $nrows  = DB_numRows($result);
    if ($nrows > 0) {
        $header_arr = array(
            array('text' => $LANG_CAL_1[12], 'field' => 'sid', 'header_class' => 'stats-header-title'),
            array('text' => $LANG_CAL_1[48], 'field' => 'hits', 'field_class'  => 'stats-list-count'),
        );
        $data_arr = array();
        $text_arr = array('has_menu'     => false,
                          'title'        => $LANG_CAL_1[47],
        );
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $A['title'] = stripslashes(str_replace('$','&#36;',$A['title']));
            $A['sid'] = COM_createLink($A['title'], $_CONF['site_url']
                      . "/calendar/event.php?eid={$A['eid']}");
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
* This will put an option for the calendar in the command and control block on
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
* A user is about to be deleted. Update ownership of any events owned
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
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/calendar/autoinstall.php';

    $inst_parms = plugin_autoinstall_calendar('calendar');

    return $inst_parms['info']['pi_version'];
}

/**
* Update the Calendar plugin
*
* @return   int     Number of message to display (true = generic success msg)
*
*/
function plugin_upgrade_calendar()
{
    global $_CONF, $_TABLES, $_DB_dbms;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                                    "pi_name = 'calendar'");
    $code_version = plugin_chkVersion_calendar();
    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/calendar/autoinstall.php';

    if (! plugin_compatible_with_this_version_calendar('calendar')) {
        return 3002;
    }

    $inst_parms = plugin_autoinstall_calendar('calendar');
    $pi_gl_version = $inst_parms['info']['pi_gl_version'];

    require_once $_CONF['path'] . 'plugins/calendar/sql/'
                                . $_DB_dbms . '_updates.php';
                                
    require_once $_CONF['path'] . 'plugins/calendar/install_updates.php';                                   

    $current_version = $installed_version;
    $done = false;
    while (! $done) {
        switch ($current_version) {
        case '1.0.3':
            $current_version = '1.1.0';
            break;

        case '1.1.0':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }

            $current_version = '1.1.1';
            break;

        case '1.1.1':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }
            
            calendar_update_ConfValues_1_1_1();
            
            calendar_update_ConfigSecurity_1_1_1();

            $current_version = '1.1.2';
            break;            

        default:
            $done = true;
            break;
        }
    }

    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '$pi_gl_version' WHERE pi_name = 'calendar'");

    return true;
}

/**
* Called during site migration - handle changed URLs or paths
*
* @param    array   $old_conf   contents of the $_CONF array on the old site
* @param    boolean             true on success, otherwise false
*
*/
function plugin_migrate_calendar($old_conf)
{
    global $_CONF;

    $tables = array(
        'events'            => 'eid, description, url',
        'eventsubmission'   => 'eid, description, url',
        'personal_events'   => 'eid, description, url'
    );

    if ($old_conf['site_url'] != $_CONF['site_url']) {
        INST_updateSiteUrl($old_conf['site_url'], $_CONF['site_url'], $tables);
    }

    return true;
}

/**
* Geeklog informs us that we're about to be enabled or disabled
*
* @param    boolean     $enabled    true = we're being enabled, false = disabled
* @return   void
*/
function plugin_enablestatechange_calendar ($enable)
{
    global $_TABLES;

    $is_enabled = $enable ? 1 : 0;

    // toggle calendar feeds
    DB_query ("UPDATE {$_TABLES['syndication']} SET is_enabled = $is_enabled WHERE type = 'calendar'");

    // toggle upcoming events block
    DB_query ("UPDATE {$_TABLES['blocks']} SET is_enabled = $is_enabled WHERE (type = 'phpblock') AND (phpblockfn = 'phpblock_calendar')");
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
*/
function plugin_autouninstall_calendar ()
{
    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array('events','eventsubmission','personal_events'),
        /* give the full name of the group, as in the db */
        'groups' => array('Calendar Admin'),
        /* give the full name of the feature, as in the db */
        'features' => array('calendar.edit', 
                            'calendar.moderate', 
                            'calendar.submit',
                            'config.calendar.tab_main',
                            'config.calendar.tab_permissions',
                            'config.calendar.tab_autotag_permissions'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array('phpblock_calendar'),
        /* give all vars with their name */
        'vars'=> array()
    );
    return $out;
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

    if (empty ($path)) {
        $layout_path = $_CONF['path_layout'] . calendar;
    } else {
        $layout_path = $_CONF['path_layout'] . calendar . '/' . $path;
    }

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
* Geeklog is asking us to provide any items that show up in the type
* drop-down on search.php.  Let's users search for events.
*
* @return   array   (plugin name/entry title) pair for the dropdown
*
*/
function plugin_searchtypes_calendar()
{
    global $LANG_CAL_1;

    $tmp['calendar'] = $LANG_CAL_1[50];

    return $tmp;
}

/**
* This searches for events matching the user query and returns an array for the
* header and table rows back to search.php where it will be formated and printed
*
* @param    string  $query      Keywords user is looking for
* @param    date    $datestart  Start date to get results for
* @param    date    $dateend    End date to get results for
* @param    string  $topic      The topic they were searching in
* @param    string  $type       Type of items they are searching, or 'all' (deprecated)
* @param    int     $author     Get all results by this author
* @param    string  $keyType    search key type: 'all', 'phrase', 'any'
* @param    int     $page       page number of current search (deprecated)
* @param    int     $perpage    number of results per page (deprecated)
* @return   object              search result object
*
*/
function plugin_dopluginsearch_calendar($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage)
{
    global $_TABLES, $_USER, $LANG_CAL_1;

    // Make sure the query is SQL safe
    $query = trim(addslashes($query));

    if (COM_isAnonUser()) {
        $uid = 1;
    } else {
        $uid = $_USER['uid'];
    }

    $sql_e = "SELECT eid AS id, title, description, UNIX_TIMESTAMP(datestart) AS date, owner_id AS uid, hits, ";
    $sql_e .= "CONCAT('/calendar/event.php?eid=',eid) AS url ";
    $sql_e .= "FROM {$_TABLES['events']} WHERE 1=1 ";

    $sql_p = "SELECT eid AS id, title, description, UNIX_TIMESTAMP(datestart) AS date, owner_id AS uid, 0 AS hits, ";
    $sql_p .= "CONCAT('/calendar/event.php?mode=personal&eid=',eid) AS url ";
    $sql_p .= "FROM {$_TABLES['personal_events']} WHERE (uid = $uid) ";

    $sql = COM_getPermSQL('AND') . ' ';

    if (!empty ($author)) {
        $sql .= "AND (owner_id = '$author') ";
    }

    // Search the public events
    $search_e = new SearchCriteria('calendar', array($LANG_CAL_1[16],$LANG_CAL_1[24]));

    $columns = array('title' => 'title', 'location', 'description');
    $sql .= $search_e->getDateRangeSQL('AND', 'datestart', $datestart, $dateend);
    list($sql_tmp,$ftsql_tmp) = $search_e->buildSearchSQL($keyType, $query, $columns, $sql_e . $sql);

    $search_e->setSQL($sql_tmp);
    $search_e->setFTSQL($ftsql_tmp);
    $search_e->setRank(2);

    if (COM_isAnonUser()) {
        return $search_e;
    }

    // Search personal events
    $search_p = new SearchCriteria('calendar', array($LANG_CAL_1[16],$LANG_CAL_1[23]));

    $columns = array('title' => 'title', 'location', 'description');
    list($sql_tmp,$ftsql_tmp) = $search_p->buildSearchSQL($keyType, $query, $columns, $sql_p . $sql);

    $search_p->setSQL($sql_tmp);
    $search_p->setFTSQL($ftsql_tmp);
    $search_p->setRank(2);

    return array($search_e,$search_p);
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

    if (($templatename == 'header') || ($templatename == 'footer')) {
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
    case 'delete':
        $retval = "<input type=\"checkbox\" name=\"delitem[{$A['eid']}]\" checked=\"checked\"" . XHTML . ">";
        break;

    case 'edit':
        if ($access == 3) {
            $retval = COM_createLink(
                $icon_arr['edit'],
                "{$_CONF['site_admin_url']}/plugins/calendar/index.php"
                . "?mode=edit&amp;eid={$A['eid']}");
        }
        break;

    case 'copy':
        if ($access == 3) {
            $retval = COM_createLink(
                $icon_arr['copy'],
                "{$_CONF['site_admin_url']}/plugins/calendar/index.php"
                . "?mode=clone&amp;eid={$A['eid']}");
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
        $retval = COM_createLink(stripslashes($A['title']),
                    "{$_CONF['site_url']}/calendar/event.php?eid={$A['eid']}");
        break;

    case 'username':
    case 'fullname':
        $retval = COM_getDisplayName($A['owner_id'], $A['username'],
                                     $A['fullname']);
        break;

    default:
        $retval = $fieldvalue;
        break;
    }

    return $retval;
}

/**
* Creates a dropdown list of all the event types
*
* @param    string  $currtype   current event type (to preselect in the list)
* @return   string              <option> list of event types
*
*/
function CALENDAR_eventTypeList ($currtype = '')
{
    global $_CA_CONF;

    $retval = '';

    if (!isset($_CA_CONF['event_types']) ||
            !is_array($_CA_CONF['event_types'])) {
        $event_types = array();
    } else {
        $event_types = $_CA_CONF['event_types'];
    }
    asort($event_types);

    foreach ($event_types as $type) {
        $retval .= '<option value="' . $type . '"';
        if ($currtype == $type) {
            $retval .= ' selected="selected"';
        }
        $retval .= '>' . $type . '</option>';
    }

    return $retval;
}

/**
* Return information for an event
*
* @param    string  $eid        event ID or '*'
* @param    string  $what       comma-separated list of properties
* @param    int     $uid        user ID or 0 = current user
* @param    array   $options    (reserved for future extensions)
* @return   mixed               string or array of strings with the information
*
*/
function plugin_getiteminfo_calendar($eid, $what, $uid = 0, $options = array())
{
    global $_CONF, $_TABLES;

    // parse $what to see what we need to pull from the database
    $properties = explode(',', $what);
    $fields = array();
    foreach ($properties as $p) {
        switch ($p) {
        // no date! we don't keep track of the _item's_ create/modify dates!
        case 'description':
        case 'excerpt':
            $fields[] = 'description';
            break;
        case 'id':
            $fields[] = 'eid';
            break;
        case 'title':
            $fields[] = 'title';
            break;
        case 'url':
            if ($eid == '*') {
                // in this case, we need the eid to build the URL
                $fields[] = 'eid';
            }
            break;
        default:
            // nothing to do
            break;
        }
    }

    $fields = array_unique($fields);

    if (count($fields) == 0) {
        $retval = array();

        return $retval;
    }

    // prepare SQL request
    if ($eid == '*') {
        $where = '';
        $permOp = 'WHERE';
    } else {
        $where = " WHERE eid = '" . addslashes($eid) . "'";
        $permOp = 'AND';
    }
    if ($uid > 0) {
        $permSql = COM_getPermSql($permOp, $uid);
    } else {
        $permSql = COM_getPermSql($permOp);
    }
    $sql = "SELECT " . implode(',', $fields)
            . " FROM {$_TABLES['events']}" . $where . $permSql;
    if ($eid != '*') {
        $sql .= ' LIMIT 1';
    }

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    $retval = array();
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);

        $props = array();
        foreach ($properties as $p) {
            switch ($p) {
            case 'description':
            case 'excerpt':
                $props[$p] = $A['description'];
                break;
            case 'id':
                $props['id'] = $A['eid'];
                break;
            case 'title':
                $props['title'] = stripslashes($A['title']);
                break;
            case 'url':
                if (empty($A['eid'])) {
                    $props['url'] = $_CONF['site_url'] . '/calendar/event.php?'
                                  . 'eid=' . $eid;
                } else {
                    $props['url'] = $_CONF['site_url'] . '/calendar/event.php?'
                                  . 'eid=' . $A['eid'];
                }
                break;
            default:
                // return empty string for unknown properties
                $props[$p] = '';
                break;
            }
        }

        $mapped = array();
        foreach ($props as $key => $value) {
            if ($eid == '*') {
                if ($value != '') {
                    $mapped[$key] = $value;
                }
            } else {
                $mapped[] = $value;
            }
        }

        if ($eid == '*') {
            $retval[] = $mapped;
        } else {
            $retval = $mapped;
            break;
        }
    }

    if (($eid != '*') && (count($retval) == 1)) {
        $retval = $retval[0];
    }

    return $retval;
}

/**
* Provide URL of a documentation file
*
* @param    string  $file   documentation file being requested, e.g. 'config'
* @return   mixed           URL or false when not available
*
*/
function plugin_getdocumentationurl_calendar($file)
{
    global $_CONF;

    static $docurl;

    switch ($file) {
    case 'index':
    case 'config':
        if (isset($docurl)) {
            $retval = $docurl;
        } else {
            $doclang = COM_getLanguageName();
            $docs = 'docs/' . $doclang . '/calendar.html';
            if (file_exists($_CONF['path_html'] . $docs)) {
                $retval = $_CONF['site_url'] . '/' . $docs;
            } else {
                $retval = $_CONF['site_url'] . '/docs/english/calendar.html';
            }
            $docurl = $retval;
        }
        break;

    default:
        $retval = false;
        break;
    }

    return $retval;
}

?>
