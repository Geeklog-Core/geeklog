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
        $A = DB_fetchRow($result);

        $last = time() - $A[0];
        $retval .= COM_startBlock($LANG12[26])
            . $LANG12[30]
            . $last
            . $LANG12[31]
            . COM_endBlock();
    } else {
        if ($_CONF['loginrequired'] == 1 && empty($_USER['username'])) {
            $retval .= COM_startBlock($LANG12[7])
                . $LANG12[1]
                . '<br>[ <a href="' . $_CONF['site_url'] . '">' . $LANG12[2] . '</a> | <a href="' 
                . $_CONF['site_url'] . '/users.php">' . $LANG12[3] . '</a> ]';
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
	
    $retval .= COM_startBlock($LANG12[4],'submitevent.html')
        . $LANG12[37]
        .'<form action="' . $_CONF['site_url'] . '/submit.php" method="post">'
        . '<table border="0" cellspacing="0" cellpadding="3">' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[10] . ':</b></td>' . LB
        . '<td><input type="text" size="36" maxlength="96" name="title"></td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[11] . ':</b></td>' . LB
        . '<td><input type="text" size="36" maxlength="96" name="url" value="http://"></td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[12] . ':</b></td>' . LB
        . '<td><input type="text" size="10" maxlength="10" name="datestart" value="yyyy-mm-dd"></td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[13]. ' :</b></td>' . LB
        . '<td><input type="text" size="10" maxlength="10" name="dateend" value="yyyy-mm-dd"></td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[14] . ':</b></td>' . LB
        . '<td><textarea name="location" cols=45 rows=3 wrap=virtual></textarea></td></td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[15] . ':</b></td>' . LB
        . '<td><textarea name="description" cols="45" rows="6" wrap="virtual"></textarea></td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="center" colspan="2">' . $LANG12[35] . '</td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="center" colspan="2"><input type="hidden" name="mode" value="' . $LANG12[8] . '">'
        . '<input type="hidden" name="type" value="event"><input type="submit" value="' . $LANG12[8] . '"></td>' . LB
        . '</tr>' . LB
        . '</table></form>'
        . COM_endBlock();
		
    return $retval;
}

/**
* Shows link submission form
*
*/
function submitlink() 
{
    global $_TABLES, $_CONF, $LANG12;
	
    $retval .= COM_startBlock($LANG12[5],'submitlink.html')
        . '<form action="' . $_CONF['site_url'] . '/submit.php" method="post">'
        . '<table border="0" cellspacing="0" cellpadding="3">' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[10] . ':</b></td>' . LB
        . '<td><input type="text" size="36" maxlength="96" name="title"></td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[11] . ':</b></td>' . LB
        . '<td><input type="text" size="36" maxlength="96" name="url" value="http://"></td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[17] . ':</b></td>' . LB
        . '<td><select name="categorydd">' . LB;
		
    $result = DB_query("SELECT DISTINCT category FROM {$_CONF['db_prefix']}links");
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($i = 0; $i < $nrows; $i++) {
            $CAT = DB_fetchArray($result);
            $retval .= '<option value="' . $CAT['category'] . '">' . $CAT['category'] . '</option>' . LB;
        }
    }
	
    $retval .= '<option>' . $LANG12[18] . '</option>' . LB
        . '</select>'
        . ' <b>' . $LANG12[16] . ':</b> <input type="text" name="category" size="12" maxlength="32"></td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[15] . ':</b></td>' . LB
        . '<td><textarea name="description" cols="45" rows="6" wrap="virtual"></textarea></td>' . LB
        . '</tr>' . LB
        . '<tr><td align="center" colspan="2">' . $LANG12[35] . '</td></tr>' . LB
        . '<tr><td align="center" colspan="2"><input type="hidden" name="mode" value="' . $LANG12[8] . '">'
        . '<input type="hidden" name="type" value="link"><input type="submit" value="' . $LANG12[8] . '"></td>' . LB
        . '</tr>' . LB
        . '</table></form>'
        . COM_endBlock();
	
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
	
    $retval .= COM_startBlock($LANG12[6],'submitstory.html')
        . '<form action="' . $_CONF['site_url'] . '/submit.php" method="post">'
        . '<table border="0" cellspacing="0" cellpadding="3">' . LB;
		
    if (!empty($_USER['username'])) {
        $retval .= '<tr>' . LB
            . '<td align="right"><b>' . $LANG12[27] . ':</b></td>' . LB
            . '<td>' . $_USER['username'] . ' [ <a href="' . $_CONF['site_url'] . '/users.php?mode=logout">' 
            . $LANG12[34] . '</a> ]</td>' . LB
            . '</tr>' . LB;
    } else {
        $retval .= '<tr>' . LB
            . '<td align="right"><b>' . $LANG12[27] . ':</b></td>' . LB
            . '<td>[ <a href="' . $_CONF['site_url'] . '/users.php">Log In</a> | <a href="' . $_CONF['site_url'] . '/users.php?mode=new">Create Account</a> ]</td>' . LB
            . '</tr>' . LB;
    }
	
    $retval .= '<tr>'
        . '<td align="right"><b>' . $LANG12[10] . ':</b></td>' . LB
        . '<td><input type="text" size="36" maxlength="96" name="title" value="' . $A['title'] . '"></td>' . LB
        . '</tr>' . LB
        . '<tr>' . LB
        . '<td align="right"><b>' . $LANG12[28] . ':</b></td>' . LB
        . '<td><select name=tid>' . LB
        . COM_optionList($_TABLES['topics'],'tid,topic',$A['tid'])
        . '</select></td>' . LB
        . '</tr>' . LB
        . '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG12[29] . ':</b></td>' . LB
        . '<td><textarea name="introtext" cols="45" rows="12" wrap="virtual">' . stripslashes($A['introtext']) 
        . '</textarea></td>' . LB
        . '</tr>' . LB
        . '<tr valign="top">' . LB
        . '<td align="right"><b>' . $LANG12[36] . ':</b></td>' . LB
        . '<td><select name="postmode">'
        . COM_optionList($_TABLES['postmodes'],'code,name',$A['postmode'])
        . '</select><br>' . COM_allowedHTML() . '</td>' . LB
        . '</tr>' .LB
        . '<tr>' . LB
        . '<td align="center" colspan="2"><input type="hidden" name="type" value=story>'
        . '<input type="hidden" name="uid" value="'.$A['uid'] . '">'
        . '<input type="hidden" name="sid" value="'.$A['sid'] . '">'
        . '<input type="hidden" name="date" value="'.$A['unixdate'] . '">';

    if ($A['mode'] == $LANG12[32]) {
        $retval .= '<input name="mode" type="submit" value="' . $LANG12[8] . '">';
    }
	
    $retval .= ' <input name="mode" type="submit" value="' . $LANG12[32] . '"></td>' . LB
        . '</tr>' . LB
        . '</table></form>'
        . COM_endBlock();

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
            $A["eid"] = makesid();
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

$display .= site_header();
	
if ($mode == $LANG12[8]) { 
    $display .= savesubmission($type,$HTTP_POST_VARS);
} else { 
    $display .= submissionform($type); 
}
	
$display .= site_footer();	
	
echo $display;

?>
