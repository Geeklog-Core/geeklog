<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | syndication.php                                                           |
// |                                                                           |
// | Geeklog content syndication administration                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Michael Jervis    - mike AT fuckingbrit DOT com                  |
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
// $Id: syndication.php,v 1.26 2005/11/02 15:24:55 ospiess Exp $


require_once ('../lib-common.php');

if (!SEC_inGroup ('Root')) {
    $display .= COM_siteHeader ()
        . COM_startBlock ($MESSAGE[30], '',
                          COM_getBlockTemplate ('_msg_block', 'header'))
        . $MESSAGE[31]
        . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
        . COM_siteFooter ();
    COM_accessLog("User {$_USER['username']} tried to illegally access the content syndication administration screen.");
    echo $display;
    exit;
}

/**
* Toggle status of a feed from enabled to disabled and back
*
* @param    int     $fid    ID of the feed
* @return   void
*
*/
function changeFeedStatus ($fid)
{
    global $_TABLES;

    $feed_id = addslashes (COM_applyFilter ($fid, true));
    if (!empty ($fid)) {
        $is_enabled = 1;
        if (DB_getItem ($_TABLES['syndication'], 'is_enabled', "fid = '$fid'")) {
            $is_enabled = 0;
        }
        DB_query ("UPDATE {$_TABLES['syndication']} SET is_enabled = '$is_enabled' WHERE fid = '$fid'");
    }
}

/**
* Get a list of feed formats from the feed parser factory.
*
* @return   array   array of names of feed formats (and versions)
*
*/
function find_feedFormats ()
{
    global $_CONF;

    // Import the feed handling classes:
    require_once ($_CONF['path_system']
                  . '/classes/syndication/parserfactory.class.php');

    $factory = new FeedParserFactory ();
    $formats = $factory->getFeedTypes ();
    sort ($formats);

    return $formats;
}

/**
* Create a list of feed types that Geeklog offers.
*
* @return   string   an array with id/name pairs for every feed
*
*/
function get_geeklogFeeds ()
{
    global $_CONF, $_TABLES, $LANG33;

    $options = array ();

    $sql = "SELECT tid,topic FROM {$_TABLES['topics']} WHERE perm_anon >= 2 ORDER BY ";
    if ($_CONF['sortmethod'] == 'alpha') {
        $sql .= 'topic ASC';
    } else {
        $sql .= 'sortnum';
    }
    $result = DB_query ($sql);
    $num = DB_numRows ($result);

    if ($num > 0) {
        $options[] = array ('id' => '::all', 'name' => $LANG33[23]);
    }

    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray ($result);
        $options[] = array ('id' => $A['tid'], 'name' => '-- ' . $A['topic']);
    }

    $options[] = array ('id' => '::events', 'name' => $LANG33[42]);

    return $options;
}

/**
* Display the feed editor.
*
* @param    int      $fid    feed id (0 for new feeds)
* @param    string   $type   type of feed, e.g. 'geeklog'
* @return   string           HTML for the feed editor
*
*/
function editfeed ($fid = 0, $type = '')
{
    global $_CONF, $_TABLES, $LANG33;

    if ($fid > 0) {
        $result = DB_query ("SELECT *,UNIX_TIMESTAMP(updated) AS date FROM {$_TABLES['syndication']} WHERE fid = '$fid'");
        $A = DB_fetchArray ($result);
        $fid = $A['fid'];
    }
    if ($fid == 0) {
        if (!empty ($type)) { // set defaults
            $A['fid'] = $fid;
            $A['type'] = $type;
            $A['format'] = 'RSS-2.0';
            $A['limits'] = $_CONF['rdf_limit'];
            $A['content_length'] = $_CONF['rdf_storytext'];
            $A['language'] = $_CONF['rdf_language'];
            $A['charset'] = $_CONF['default_charset'];
            $A['is_enabled'] = 1;
        } else {
            return COM_refresh ($_CONF['site_admin_url'] . '/syndication.php');
        }
    }

    $retval = '';

    $feed_template = new Template ($_CONF['path_layout'] . 'admin/syndication');
    $feed_template->set_file ('editor', 'feededitor.thtml');

    $feed_template->set_var ('site_url', $_CONF['site_url']);
    $feed_template->set_var ('site_admin_url', $_CONF['site_admin_url']);
    $feed_template->set_var ('layout_url', $_CONF['layout_url']);

    $feed_template->set_var ('start_feed_editor', COM_startBlock ($LANG33[24],
            '', COM_getBlockTemplate ('_admin_block', 'header')));
    $feed_template->set_var ('end_block',
            COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));

    $feed_template->set_var ('lang_feedtitle', $LANG33[25]);
    $feed_template->set_var ('lang_enabled', $LANG33[19]);
    $feed_template->set_var ('lang_format', $LANG33[17]);
    $feed_template->set_var ('lang_limits', $LANG33[26]);
    $feed_template->set_var ('lang_content_length', $LANG33[27]);
    $feed_template->set_var ('lang_clen_explain', $LANG33[28]);
    $feed_template->set_var ('lang_description', $LANG33[29]);
    $feed_template->set_var ('lang_feedlogo', $LANG33[49]);
    $feed_template->set_var ('lang_feedlogo_explain', $LANG33[50]);
    $feed_template->set_var ('lang_filename', $LANG33[16]);
    $feed_template->set_var ('lang_updated', $LANG33[30]);
    $feed_template->set_var ('lang_type', $LANG33[15]);
    $feed_template->set_var ('lang_charset', $LANG33[31]);
    $feed_template->set_var ('lang_language', $LANG33[32]);
    $feed_template->set_var ('lang_topic', $LANG33[33]);
    
    if ($A['header_tid'] == 'all') {
        $feed_template->set_var('all_selected', 'selected="selected"');
    } elseif ($A['header_tid'] == 'none') {
        $feed_template->set_var('none_selected', 'selected="selected"');
    }

    $feed_template->set_var('lang_header_all', $LANG33[43]);
    $feed_template->set_var('lang_header_none', $LANG33[44]);
    $feed_template->set_var('lang_header_topic', $LANG33[45]);
    $feed_template->set_var('header_topic_options', COM_topicList('tid,topic',$A['header_tid']));
    $feed_template->set_var('lang_save', $LANG33[2]);
    $feed_template->set_var('lang_cancel', $LANG33[4]);
    if ($A['fid'] > 0) {
        $feed_template->set_var ('delete_option', '<input type="submit" value="'
                                 . $LANG33[3] . '" name="mode">');
    }
    $feed_template->set_var ('feed_id', $A['fid']);
    $feed_template->set_var ('feed_title', $A['title']);
    $feed_template->set_var ('feed_description', $A['description']);
    $feed_template->set_var ('feed_logo', $A['feedlogo']);
    $feed_template->set_var ('feed_content_length', $A['content_length']);
    $feed_template->set_var ('feed_filename', $A['filename']);
    $feed_template->set_var ('feed_type', $A['type']);
    $feed_template->set_var ('feed_type_display', ucwords ($A['type']));
    $feed_template->set_var ('feed_charset', $A['charset']);
    $feed_template->set_var ('feed_language', $A['language']);

    $nicedate = COM_getUserDateTimeFormat ($A['date']);
    $feed_template->set_var ('feed_updated', $nicedate[0]);

    $formats = find_feedFormats ();
    $selection = '<select name="format">' . LB;
    foreach ($formats as $f) {
        // if one changes this format below ('name-version'), also change parsing
        // in COM_siteHeader. It uses explode( "-" , $string )
        $selection .= '<option value="' . $f['name'] . '-' . $f['version']
                   . '"';
        if ($A['format'] == $f['name'] . '-' . $f['version']) {
            $selection .= ' selected="selected"';
        }
        $selection .= '>' . ucwords ($f['name'] . ' ' . $f['version'])
                   . '</option>' . LB;
    }
    $selection .= '</select>' . LB;
    $feed_template->set_var ('feed_format', $selection);

    $limits = $A['limits'];
    $hours = false;
    if (substr ($A['limits'], -1) == 'h') {
        $limits = substr ($A['limits'], 0, -1);
        $hours = true;
    }
    $selection = '<select name="limits_in">' . LB;
    $selection .= '<option value="0"';
    if (!$hours) {
        $selection .= ' selected="selected"';
    }
    $selection .= '>' . $LANG33[34] . '</option>' . LB;
    $selection .= '<option value="1"';
    if ($hours) {
        $selection .= ' selected="selected"';
    }
    $selection .= '>' . $LANG33[35] . '</option>' . LB;
    $selection .= '</select>' . LB;
    $feed_template->set_var ('feed_limits', $limits);
    $feed_template->set_var ('feed_limits_what', $selection);

    if ($A['type'] == 'geeklog') {
        $options = get_geeklogFeeds ();
    } else {
        $options = PLG_getFeedNames ($A['type']);
    }
    $selection = '<select name="topic">' . LB;
    foreach ($options as $o) {
        $selection .= '<option value="' . $o['id'] . '"';
        if ($A['topic'] == $o['id']) {
            $selection .= ' selected="selected"';
        }
        $selection .= '>' . $o['name'] . '</option>' . LB;
    }
    $selection .= '</select>' . LB;
    $feed_template->set_var ('feed_topic', $selection);

    if ($A['is_enabled'] == 1) {
        $feed_template->set_var ('is_enabled', 'checked="checked"');
    } else {
        $feed_template->set_var ('is_enabled', '');
    }

    $retval .= $feed_template->finish ($feed_template->parse ('output',
                                                              'editor'));
    return $retval;
}

/**
* Create a new feed. This is an extra step to take once you have a plugin
* installed that supports the new Feed functions in the Plugin API. This
* will let you select for which plugin (or Geeklog) you're creating the feed.
*
* @return   string   HTML for the complete page (selection or feed editor)
*
*/
function newfeed ()
{
    global $_CONF, $LANG33;

    $retval = '';

    $plugins = PLG_supportingFeeds ();
    if (sizeof ($plugins) == 0) {
        // none of the installed plugins are supporting feeds
        // - go directly to the feed editor
        $retval = COM_siteHeader ('menu')
                . editfeed (0, 'geeklog')
                . COM_siteFooter ();
    } else {
        $selection = '<select name="type">' . LB;
        $selection .= '<option value="geeklog">Geeklog</option>' . LB;
        foreach ($plugins as $p) {
            $selection .= '<option value="' . $p . '">' . ucwords ($p)
                       . '</option>' . LB;
        }
        $selection .= '</select>' . LB;

        $feed_template = new Template ($_CONF['path_layout']
                                       . 'admin/syndication');
        $feed_template->set_file ('type', 'selecttype.thtml');

        $feed_template->set_var ('site_url', $_CONF['site_url']);
        $feed_template->set_var ('site_admin_url', $_CONF['site_admin_url']);
        $feed_template->set_var ('layout_url', $_CONF['layout_url']);

        $feed_template->set_var ('type_selection', $selection);

        $feed_template->set_var ('lang_explain', $LANG33[37]);
        $feed_template->set_var ('lang_go', $LANG33[1]);

        $retval .= COM_siteHeader ('menu');
        $retval .= COM_startBlock ($LANG33[36], '',
                COM_getBlockTemplate ('_admin_block', 'header'));
        $retval .= $feed_template->finish ($feed_template->parse ('output',
                                                                  'type'));
        $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
        $retval .= COM_siteFooter ();
    }

    return $retval;
}

/**
* Save feed.
*
* @param    array    $A
* @return   string   HTML redirect on success or feed editor + error message
*
*/
function savefeed ($A)
{
    global $_CONF, $_TABLES, $LANG33;

    foreach ($A as $name => $value) {
        $A[$name] = COM_stripslashes ($value);
    }

    if ($A['is_enabled'] == 'on') {
        $A['is_enabled'] = 1;
    } else {
        $A['is_enabled'] = 0;
    }

    if (empty ($A['title']) || empty ($A['description']) ||
            empty ($A['filename'])) {
        $retval = COM_siteHeader ('menu')
                . COM_startBlock ($LANG33[38], '',
                        COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG33[39]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                . editfeed ($A['fid'], $A['type'])
                . COM_siteFooter ();
        return $retval;
    }
    if ($A['limits'] <= 0) {
        $retval = COM_siteHeader ('menu')
                . COM_startBlock ($LANG33[38], '',
                        COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG33[40]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                . editfeed ($A['fid'], $A['type'])
                . COM_siteFooter ();
        return $retval;
    }
    if ($A['limits_in'] == 1) {
        $A['limits'] .= 'h';
    }

    // we can compensate if these are missing ...
    if (empty ($A['charset'])) {
        $A['charset'] = $_CONF['default_charset'];
        if (empty ($A['charset'])) {
            $A['charset'] = 'UTF-8';
        }
    }
    if (empty ($A['language'])) {
        $A['language'] = $_CONF['rdf_language'];
        if (empty ($A['language'])) {
            $A['language'] = $_CONF['locale'];
        }
    }
    if ($A['content_length'] < 0) {
        $A['content_length'] = 0;
    }

    foreach ($A as $name => $value) {
        $A[$name] = addslashes ($value);
    }

    DB_save ($_TABLES['syndication'], 'fid,type,topic,header_tid,format,limits,content_length,title,description,feedlogo,filename,charset,language,is_enabled,updated,update_info',
        "{$A['fid']},'{$A['type']}','{$A['topic']}','{$A['header_tid']}','{$A['format']}','{$A['limits']}',{$A['content_length']},'{$A['title']}','{$A['description']}','{$A['feedlogo']}','{$A['filename']}','{$A['charset']}','{$A['language']}',{$A['is_enabled']},'0000-00-00 00:00:00',NULL");

    if ($A['fid'] == 0) {
        $A['fid'] = DB_insertId ();
    }
    SYND_updateFeed ($A['fid']);

    return COM_refresh ($_CONF['site_admin_url'] . '/syndication.php?msg=58');
}

/**
* Delete a feed.
*
* @param    int      $fid   feed id
* @return   string          HTML redirect
*
*/
function deletefeed ($fid)
{
    global $_CONF, $_TABLES;

    if ($fid > 0) {
        DB_delete ($_TABLES['syndication'], 'fid', $fid);

        return COM_refresh ($_CONF['site_admin_url']
                            . '/syndication.php?msg=59');
    }

    return COM_refresh ($_CONF['site_admin_url'] . '/syndication.php');
}


// MAIN
$display = '';

if ($_CONF['backend'] && isset ($_POST['feedChange'])) {
    changeFeedStatus ($_POST['feedChange']);
}

if ($_REQUEST['mode'] == 'edit') {
    if ($_REQUEST['fid'] == 0) {
        $display .= newfeed ();
    } else {
        $display .= COM_siteHeader ('menu')
                 . editfeed ($_REQUEST['fid'])
                 . COM_siteFooter ();
    }
}
else if (($_REQUEST['mode'] == $LANG33[1]) && !empty ($LANG33[1]))
{
    $display .= COM_siteHeader ('menu')
             . editfeed (0, $_REQUEST['type'])
             . COM_siteFooter ();
}
else if (($_REQUEST['mode'] == $LANG33[2]) && !empty ($LANG33[2]))
{
    $display .= savefeed ($_POST);
}
else if (($_REQUEST['mode'] == $LANG33[3]) && !empty ($LANG33[3]))
{
    $display .= deletefeed ($_REQUEST['fid']);
}
else
{
    $display .= COM_siteHeader ('menu');
    if (isset ($_REQUEST['msg'])) {
        $display .= COM_showMessage ($_REQUEST['msg']);
    }

    $header_arr = array(      # dislay 'text' and use table field 'field'
                    array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
                    array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true),
                    array('text' => $LANG_ADMIN['type'], 'field' => 'type', 'sort' => true),
                    array('text' => $LANG33[17], 'field' => 'format', 'sort' => true),
                    array('text' => $LANG33[16], 'field' => 'filename', 'sort' => true),
                    array('text' => $LANG_ADMIN['topic'], 'field' => 'header_tid', 'sort' => true),
                    array('text' => $LANG33[18], 'field' => 'updated', 'sort' => true),
                    array('text' => $LANG_ADMIN['enabled'], 'field' => 'is_enabled', 'sort' => true)
    );

    $defsort_arr = array('field' => 'title', 'direction' => 'asc');

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'] . '/syndication.php?mode=edit',
                          'text' => $LANG_ADMIN['create_new']),
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home'])
    );

    $text_arr = array('has_menu' =>  true,
                      'title' => $LANG33[10], 'instructions' => $LANG33[13],
                      'icon' => $_CONF['layout_url'] . '/images/icons/syndication.png',
                      'form_url' => $_CONF['site_admin_url'] . "/syndication.php");

    $query_arr = array('table' => 'syndication',
                       'sql' => "SELECT *,UNIX_TIMESTAMP(updated) AS date FROM {$_TABLES['syndication']} WHERE 1",
                       'query_fields' => array('title', 'filename'),
                       'default_filter' => '',
                       'query' => $_REQUEST['q'],
                       'query_limit' => COM_applyFilter ($_REQUEST['query_limit'], true));

    $display .= ADMIN_list ("syndication", "SYND_getListField", $header_arr, $text_arr,
                            $query_arr, $menu_arr, $defsort_arr);

    $display .= COM_siteFooter ();
}

echo $display;

?>
