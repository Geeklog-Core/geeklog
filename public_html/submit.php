<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-common.php                                                            |
// | Geeklog common library.                                                   |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
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
//
// $Id

include_once('lib-common.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

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
function submissionform($type='story') 
{
    global $_TABLES, $_CONF, $LANG12, $REMOTE_ADDR, $_USER;

    $retval = '';
	
    DB_query("DELETE FROM {$_TABLES['submitspeedlimit']} WHERE date < unix_timestamp() - {$_CONF["speedlimit"]}");

    $id = DB_count($_TABLES['submitspeedlimit'],'ipaddress',$REMOTE_ADDR);

    if ($id > 0) {
        $result = DB_query("SELECT date FROM {$_TABLES['submitspeedlimit']} WHERE ipaddress = '$REMOTE_ADDR'");
        $A = DB_fetchArray($result);

        $last = time() - $A['date'];
        $retval .= COM_startBlock($LANG12[26])
            . $LANG12[30]
            . $last
            . $LANG12[31]
            . COM_endBlock();
    } else {
        if ($_CONF['loginrequired'] == 1 && empty($_USER['username'])) {
            $retval .= COM_startBlock($LANG12[7]);
            $loginreq = new Template($_CONF['path_layout'] . 'submit');
            $loginreq->set_file('loginreq', 'submitloginrequired.thtml');
            $loginreq->set_var('login_message', $LANG12[1]);
            $loginreq->set_var('site_url', $_CONF['site_url']);
            $loginreq->set_var('lang_login', $LANG12[2]);
            $loginreq->set_var('lang_newuser', $LANG12[3]);
            $loginreq->parse('errormsg', 'loginreq');
            $retval .= $loginreq->finish($loginreq->get_var('errormsg'));
            $retval .= COM_endBlock();
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
                $retval .= submitevent();
                break;
            default:
                if ((strlen($type) > 0) && ($type <> 'story')) {
                    $retval .= SubmitPlugin($type);
                    break;
                } 
                $retval .= submitstory();
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
function submitevent() 
{
    global $_CONF,$LANG12;

    $retval = '';

    $retval .= COM_startBlock($LANG12[4],'submitevent.html');
    $eventform = new Template($_CONF['path_layout'] . 'submit');
    $eventform->set_file('eventform', 'submitevent.thtml');
    $eventform->set_var('explanation', $LANG12[37]);
    $eventform->set_var('site_url', $_CONF['site_url']);
    $eventform->set_var('lang_title', $LANG12[10]); 
    $eventform->set_var('lang_link', $LANG12[11]);
    $eventform->set_var('lang_startdate', $LANG12[12]);
    $eventform->set_var('lang_enddate', $LANG12[13]);
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
function submitstory() 
{
    global $_TABLES, $HTTP_POST_VARS, $_CONF, $LANG12, $_USER;

    if ($HTTP_POST_VARS['mode'] == $LANG12[32]) {
        $A = $HTTP_POST_VARS;
    } else {
        $A['sid'] = COM_makeSid();
        $A['uid'] = $_USER['uid'];
        $A['unixdate'] = time();
    }

    if (empty($A['postmode'])) {
        $A['postmode'] = $_CONF['postmode'];
    }

    if (!empty($A['title'])) {
        if ($A['postmode'] == 'html') {
            $A['introtext'] = addslashes(COM_checkHTML(COM_checkWords($A['introtext'])));
        } else {
            $A['introtext'] = htmlspecialchars(COM_checkWords($A['introtext']));
        }
        $A['title'] = stripslashes($A['title']);
        $retval .= COM_startBlock($LANG12[32])
            . COM_article($A,'n')
            . COM_endBlock();
    }
	
    $retval .= COM_startBlock($LANG12[6],'submitstory.html');

    $storyform = new Template($_CONF['path_layout'] . 'submit');
    $storyform->set_file('storyform','submitstory.thtml');
    $storyform->set_var('site_url', $_CONF['site_url']);
    $storyform->set_var('lang_username', $LANG12[27]);
		
    if (!empty($_USER['username'])) {
        $storyform->set_var('story_username', $_USER['username']);
        $storyform->set_var('status_url', $_CONF['site_url'] . '/users.php?mode=logout');
        $storyform->set_var('lang_loginout', $LANG12[34]);
    } else {
        $storyform->set_var('status_url', $_CONF['site_url'] . '/users.php');
        $storyform->set_var('lang_loginout', 'Log In');
        $storyform->set_var('seperator', ' | ');
        $storyform->set_var('create_account','<a href="' . $_CONF['site_url'] . '/users.php?mode=new">Create Account</a>');
    }

    $storyform->set_var('lang_title', $LANG12[10]);
    $storyform->set_var('story_title', $A['title']);	
    $storyform->set_var('lang_topic', $LANG12[28]);
    $storyform->set_var('story_topic_options',  COM_optionList($_TABLES['topics'],'tid,topic',$A['tid']));
    $storyform->set_var('lang_story', $LANG12[29]);
    $storyform->set_var('story_introtext', stripslashes($A['introtext']));
    $storyform->set_var('lang_postmode', $LANG12[36]);
    $storyform->set_var('story_postmode_options', COM_optionList($_TABLES['postmodes'],'code,name',$A['postmode']));
    $storyform->set_var('allowed_html', COM_allowedHTML());
    $storyform->set_var('story_uid', $A['uid']);
    $storyform->set_var('story_sid', $A['sid']);
    $storyform->set_var('story_date', $A['unixdate']);

    if ($A['mode'] == $LANG12[32]) {
        $storyform->set_var('save_button', '<input name="mode" type="submit" value="' . $LANG12[8] . '">');
    }
	
    $storyform->set_var('lang_preview', $LANG12[32]);
    $storyform->parse('theform', 'storyform');
    $retval .= $storyform->finish($storyform->get_var('theform'));
    $retval .= COM_endBlock();

    return $retval;
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
    global $_TABLES, $LANG12, $_USER, $REMOTE_ADDR;
	
    DB_save($_TABLES['submitspeedlimit'],'ipaddress, date',"'$REMOTE_ADDR',unix_timestamp()");

    switch ($type) {
    case 'link':
        if (!empty($A['title']) && !empty($A['description']) && !empty($A['url'])) {
            if ($A['categorydd'] != $LANG12[18] && !empty($A['categorydd'])) {
                $A['category'] = $A['categorydd'];
            } else if ($A['categorydd'] != $LANG12[18]) {
                $retval .= COM_startBlock($LANG12[20])
                    . $LANG12[21]
                    . COM_endBlock()
                    . submissionform($type);
					    
                    return $retval;
            }
            $A['description'] = addslashes(htmlspecialchars(COM_checkWords($A['description'])));
            $A['title'] = addslashes(strip_tags(COM_checkWords($A['title'])));
            $A['lid'] = COM_makeSid();
            $result = DB_save($_TABLES['linksubmission'],'lid,category,url,description,title',"{$A["lid"]},'{$A["category"]}','{$A["url"]}','{$A["description"]}','{$A['title']}'","index.php?msg=3");
        } else {
            $retval .= COM_startBlock($LANG12[22])
                . $LANG12[23]
                . COM_endBlock()
                . submissionform($type);

            return $retval; 
        }
        break;
    case "event":
        if (!empty($A['title']) && !empty($A["description"])) {
            $A['description'] = addslashes(htmlspecialchars(COM_checkWords($A["description"])));
            $A['title'] = addslashes(strip_tags(COM_checkWords($A['title'])));
            $A['eid'] = COM_makesid();
            $result = DB_save($_TABLES['eventsubmission'],'eid,title,url,datestart,dateend,location,description',"{$A["eid"]},'{$A['title']}','{$A["url"]}','{$A["datestart"]}','{$A["dateend"]}','{$A["location"]}','{$A["description"]}'","index.php?msg=4");
        } else {
            $retval .= COM_startBlock($LANG12[22])
                . $LANG12[23]
                . COM_endBlock()
                . submissionform($type);
				
                return $retval;
        }
        break;
    default:
        if ((strlen($type) > 0) && ($type <> 'story')) {
            // see if this is a submission that needs to be handled by a plugin
            if (SavePluginSubmission($type, $A)) {
                // great, it worked, lets get out of here
                break;
            } else {
                // something went wrong, exit
                $retval .= COM_errorLog("Could not save your submission.  Bad type: $type");
                return $retval;
            }
        }			
        if (!empty($A['title']) && !empty($A['introtext'])) {
            if ($A['postmode'] == 'html') {
                $A['introtext'] = addslashes(COM_checkHTML(COM_checkWords($A['introtext'])));
            } else {
                $A['introtext'] = addslashes(htmlspecialchars(COM_checkWords($A['introtext'])));
            }
            $A['title'] = addslashes(strip_tags(COM_checkWords($A['title'])));
            $A['sid'] = COM_makeSid();
            if (empty($_USER['uid'])) { 
                $_USER['uid'] = 1;
            }					
            DB_save($_TABLES['storysubmission'],"sid,tid,uid,title,introtext,date,postmode","{$A["sid"]},'{$A["tid"]}',{$_USER['uid']},'{$A['title']}','{$A["introtext"]}',NOW(),'{$A["postmode"]}'","index.php?msg=2");
        } else {
            $retval .= COM_startBlock($LANG12[22])
                . $LANG12[23]
                . COM_endBlock()
                . submissionform($type);
					
            return $retval;
        }
        break;
    }
    return $retval;
}

// MAIN

$display = '';

if ($mode == $LANG12[8]) { 
    $page_content .= savesubmission($type,$HTTP_POST_VARS);
} else { 
    $page_content .= submissionform($type); 
}
$display .= COM_siteHeader();
$display .= $page_content;	
$display .= COM_siteFooter();	
	
echo $display;

?>
