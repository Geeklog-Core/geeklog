<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Page Geeklog Plugin 1.4.3                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | This is the main page for the Geeklog Static Page Plugin                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
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
// $Id: index.php,v 1.38 2007/02/12 09:20:28 ospiess Exp $

require_once ('../lib-common.php');


/**
* Prepare static page for display.
*
* @param    string  $page       static page id
* @param    array   $A          static page data
* @param    int     $noboxes    the user's "noboxes" setting (see Preferences)
* @return   string              HTML for the static page
*
*/
function display_page ($page, $A, $noboxes)
{
    global $_CONF, $LANG01, $LANG11, $LANG_STATIC, $_IMAGE_TYPE, $_SP_CONF;

    $retval = '';

    if ($A['sp_format'] == 'allblocks' OR $A['sp_format'] == 'leftblocks') {
        $retval .= COM_siteHeader ('menu');
    } else {
        if ($A['sp_format'] <> 'blankpage') {
            $retval .= COM_siteHeader ('none');
        }
    }
    if (($A['sp_inblock'] == 1) && ($A['sp_format'] != 'blankpage')) {
        $retval .= COM_startBlock (stripslashes ($A['sp_title']), $A['sp_help'],
                        COM_getBlockTemplate ('_staticpages_block', 'header'));
    }

    $spage = new Template( $_CONF['path'] . 'plugins/staticpages/templates/' );
    $spage -> set_file( array('page'=>'staticpage.thtml'));

    if ($A['sp_format'] <> 'blankpage') {
        $icons = '';
        if ($_CONF['hideprintericon'] == 0) {
            $printicon = '<img src="' . $_CONF['layout_url'] . '/images/print.'
                . $_IMAGE_TYPE . '" alt="' . $LANG01[65] . '" title="'
                . $LANG_STATIC['printable_format'] . '">';
            $printurl = COM_buildURL ($_CONF['site_url']
                . '/staticpages/index.php?page=' . $page . '&amp;mode=print');
            $icons .= COM_createLink($printicon, $print_url);
        }
        if ((SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
                $A['perm_group'], $A['perm_members'], $A['perm_anon']) == 3) &&
                SEC_hasRights ('staticpages.edit')) {
            $url = $_CONF['site_admin_url']
                . '/plugins/staticpages/index.php?mode=edit&amp;sp_id=' . $page;
            $attr = array('class' => 'editlink','title' => $LANG_STATIC['edit']);
            $editicon = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
            $editiconhtml = '<img src="' . $editicon . '" alt="' . $LANG_STATIC['edit']
                . '" title="' . $LANG_STATIC['edit'] . '">';
            $icons .=
                '&nbsp;' . COM_createLink(
                $editiconhtml, //display
                $url,  //target
                $attr //other attributes
            );
        }
    }
    $spage->set_var('icons', $icons);

    $content = SP_render_content (stripslashes ($A['sp_content']), $A['sp_php']);
    $spage->set_var('content', $content );

    if ($A['sp_format'] <> 'blankpage') {
        $curtime = COM_getUserDateTimeFormat ($A['sp_date']);
        if ($_SP_CONF['show_date'] == 1) {
            $lastupdate = $LANG_STATIC['lastupdated']. ' ' . $curtime[0];
            $spage->set_var('lastupdate', $lastupdate);
        }


        if ($_SP_CONF['show_hits'] == 1) {
            if ($_SP_CONF['show_date'] == 1) {
                $hits = "| ";
            }
            $hits = COM_numberFormat ($A['sp_hits']) . ' ' . $LANG_STATIC['hits'];
            $spage->set_var('hits', $hits);
        }

    }
    $retval .= $spage->finish($spage->parse('output', 'page'));
    if (($A['sp_inblock'] == 1) && ($A['sp_format'] != 'blankpage')) {
        $retval .= COM_endBlock (COM_getBlockTemplate ('_staticpages_block',
                                                       'footer'));
    }

    if ($A['sp_format'] <> 'blankpage') {
        if (($A['sp_format'] == 'allblocks') && ($noboxes != 1)) {
            $retval .= COM_siteFooter (true);
        } else {
            $retval .= COM_siteFooter ();
        }
    }

    return $retval;
}

/**
* Prepare static page for print (i.e. display as "printable version").
*
* @param    string  $page       static page id
* @param    array   $A          static page data
* @return   string              HTML for the static page
*
*/
function print_page ($page, $A)
{
    global $_CONF;

    $template_path = staticpages_templatePath ();
    $print = new Template ($template_path);
    $print->set_file (array ('print' => 'printable.thtml'));
    $print->set_var ('site_url', $_CONF['site_url']);
    $print->set_var ('site_name', $_CONF['site_name']);
    $print->set_var ('site_slogan', $_CONF['site_slogan']);

    $print->set_var ('page_title', $_CONF['site_name'] . ' - '
                                   . stripslashes ($A['sp_title']));
    $print->set_var ('sp_url', COM_buildUrl ($_CONF['site_url']
                               . '/staticpages/index.php?page=' . $page));
    $print->set_var ('sp_title', stripslashes ($A['sp_title']));
    $print->set_var ('sp_content',
            SP_render_content (stripslashes ($A['sp_content']), $A['sp_php']));
    $print->set_var ('sp_hits', COM_numberFormat ($A['sp_hits']));
    $print->parse ('output', 'print');

    return $print->finish ($print->get_var ('output'));
}


// MAIN
$error = 0;

if (!empty ($_USER['uid'])) {
    $noboxes = DB_getItem ($_TABLES['userindex'], 'noboxes',
                           "uid = '{$_USER['uid']}'");
} else {
    $noboxes = 0;
}

COM_setArgNames (array ('page', 'mode'));
$page = COM_applyFilter (COM_getArgument ('page'));
$mode = COM_applyFilter (COM_getArgument ('mode'));
if ($mode != 'print') {
    unset ($mode);
}

if (empty ($page)) {
    $error = 1;
} else {

    $perms = SP_getPerms ();
    if (!empty ($perms)) {
        $perms = ' AND ' . $perms;
    }
    $sql = array();
    $sql['mysql'] = "SELECT sp_title,sp_content,sp_hits,sp_date,sp_format,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,sp_help,sp_php,sp_inblock FROM {$_TABLES['staticpage']} WHERE (sp_id = '$page')" . $perms;
    $sql['mssql'] = "SELECT sp_title,CAST(sp_content AS text) AS sp_content,sp_hits,sp_date,sp_format,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,sp_help,sp_php,sp_inblock FROM {$_TABLES['staticpage']} WHERE (sp_id = '$page')" . $perms;
    $result = DB_query ($sql);
    $count = DB_numRows ($result);

    if ($count == 0 || $count > 1) {
        $error = 1;
    }
}

if (!($error)) {
    $A = DB_fetchArray ($result);
    $_CONF['pagetitle'] = stripslashes ($A['sp_title']);

    if (!empty ($mode) && ($mode == 'print')) {
        $retval = print_page ($page, $A);
    } else {
        $retval = display_page ($page, $A, $noboxes);
    }

    // increment hit counter for page
    DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_hits = sp_hits + 1 WHERE sp_id = '$page'");

} else { // an error occured (page not found, access denied, ...)

    if (empty ($page)) {
        $failflg = 0;
    } else {
        $failflg = DB_getItem ($_TABLES['staticpage'], 'sp_nf', "sp_id='$page'");
    }
    if ($failflg) {
        $retval = COM_siteHeader ('menu');
        $retval .= COM_startBlock ($LANG_LOGIN[1], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $login = new Template ($_CONF['path_layout'] . 'submit');
        $login->set_file (array ('login' => 'submitloginrequired.thtml'));
        $login->set_var ('login_message', $LANG_LOGIN[2]);
        $login->set_var ('site_url', $_CONF['site_url']);
        $login->set_var ('lang_login', $LANG_LOGIN[3]);
        $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
        $login->parse ('output', 'login');
        $retval .= $login->finish ($login->get_var ('output'));
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $retval .= COM_siteFooter (true);
    } else {
        $retval = COM_siteHeader ('menu');
        $retval .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= $LANG_STATIC['deny_msg'];
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $retval .= COM_siteFooter (true);
    }
}

echo $retval;

?>
