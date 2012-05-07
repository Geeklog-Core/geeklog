<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Links Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the Links      |
// | Plugins' PHP files.                                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs         - tony AT tonybibbs DOT com                   |
// |          Mark Limburg       - mlimburg AT users.sourceforge DOT net       |
// |          Jason Whittenburg  - jwhitten AT securitygeeks DOT com           |
// |          Dirk Haun          - dirk AT haun-online DOT de                  |
// |          Trinity Bays       - trinity93 AT gmail DOT com                  |
// |          Oliver Spiesshofer - oliver AT spiesshofer DOT com               |
// |          Euan McKay         - info AT heatherengineering DOT com          |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* Implementation of the Plugin API for the Links plugin
*
* @package Links
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}

$plugin_path = $_CONF['path'] . 'plugins/links/';

/**
* Language file include
*/
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';
if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $plugin_path . 'language/english.php';
}

/**
* Check and see if we need to load the plugin configuration
*/
if (!isset($_LI_CONF['linksloginrequired'])) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $li_config = config::get_instance();
    $_LI_CONF = $li_config->get_config('links');
}


// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementation                                         |
// +---------------------------------------------------------------------------+

/**
* Returns the items for this plugin that should appear on the main menu
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
* @return   mixed   menu entry, or boolean false if disabled / hidden
*
*/
function plugin_getmenuitems_links()
{
    global $_CONF, $_USER, $_LI_CONF, $LANG_LINKS;

    $anon = (empty ($_USER['uid']) || ($_USER['uid'] <= 1)) ? true : false;
    if (($_LI_CONF['hidelinksmenu'] == 1) || ($anon &&
                ($_CONF['loginrequired'] || $_LI_CONF['linksloginrequired']))) {
        return false;
    }

    $menuitems[$LANG_LINKS[114]] = $_CONF['site_url'] . '/links/index.php';

    return $menuitems;
}

/**
* Return headlines for New Links section in the What's New block, if enabled
*
* @return   mixed       array(headline, byline), or boolean false if disabled
*
*/
function plugin_whatsnewsupported_links()
{
    global $_LI_CONF, $LANG_LINKS, $LANG_WHATSNEW;

    if ($_LI_CONF['hidenewlinks'] == 0) {
        $retval = array($LANG_LINKS[84],
                        COM_formatTimeString($LANG_WHATSNEW['new_last'],
                                             $_LI_CONF['newlinksinterval'])
                       );
    } else {
        $retval = false;
    }

    return $retval;
}

/**
* Return new links for the What's New block
*
* @return   string  HTML list of new links
*
*/
function plugin_getwhatsnew_links()
{
    global $_CONF, $_TABLES, $_USER, $_LI_CONF, $LANG_LINKS,$_DB_dbms;

    $retval = '';

    // Get newest links
    if($_DB_dbms=='pgsql')
    {
        $sql = "SELECT lid,title FROM {$_TABLES['links']} WHERE (date >= (NOW() - INTERVAL '{$_LI_CONF['newlinksinterval']} SECONDS'))" . COM_getPermSQL('AND') . LINKS_getCategorySQL('AND') . ' ORDER BY date DESC LIMIT 15';   
    }
    else
    {
        $sql = "SELECT lid,title FROM {$_TABLES['links']} WHERE (date >= (DATE_SUB(NOW(), INTERVAL {$_LI_CONF['newlinksinterval']} SECOND)))" . COM_getPermSQL('AND') . LINKS_getCategorySQL('AND') . ' ORDER BY date DESC LIMIT 15';
    }
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    if ($nrows > 0) {
        $newlinks = array();
        for ($x = 0; $x < $nrows; $x++) {
            $A = DB_fetchArray($result);
            $A['title'] = stripslashes($A['title']);

            // redirect link via portal.php so we can count the clicks
            $lcount = COM_buildUrl($_CONF['site_url']
                    . '/links/portal.php?what=link&amp;item=' . $A['lid']);

            $title = COM_truncate($A['title'], $_CONF['title_trim_length'],
                                  '...');
            $link_title = array();
            if ($title != $A['title']) {
                $link_title = array('title' => $A['title']);
            }

            $newlinks[] = COM_createLink($title, $lcount, $link_title) . LB;
        }

        $retval .= COM_makeList($newlinks, 'list-new-plugins');
    } else {
        $retval .= $LANG_LINKS[88] . '<br' . XHTML . '>' . LB;
    }

    return $retval;
}

/**
* Implements the [link:] autotag.
*
* @param    string  $op         operation to perform
* @param    string  $content    item (e.g. story text), including the autotag
* @param    array   $autotag    parameters used in the autotag
* @param    mixed               tag names (for $op='tagname') or formatted content
*
*/
function plugin_autotags_links($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES, $LANG_DIRECTION, $LANG_LINKS, $_LI_CONF, $_GROUPS;

    if ($op == 'tagname' ) {
        return 'link';
    } elseif ($op == 'permission' || $op == 'nopermission') {
        if ($op == 'permission') {
            $flag = true;
        } else {
            $flag = false;
        }
        $tagnames = array();

        if (isset($_GROUPS['Links Admin'])) {
            $group_id = $_GROUPS['Links Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                                   "grp_name = 'Links Admin'");
        }
        $owner_id = SEC_getDefaultRootUser();

        if (COM_getPermTag($owner_id, $group_id, $_LI_CONF['autotag_permissions_link'][0], $_LI_CONF['autotag_permissions_link'][1], $_LI_CONF['autotag_permissions_link'][2], $_LI_CONF['autotag_permissions_link'][3]) == $flag) {
            $tagnames[] = 'link';
        }
        
        if (count($tagnames) > 0) {
            return $tagnames;
        }
    } elseif ($op == 'description') {
        return array (
            'link' => $LANG_LINKS['autotag_desc_link']
            );
    } else if ($op == 'parse') {
        $lid = COM_applyFilter($autotag['parm1']);
        if (! empty($lid)) {
            $url = COM_buildUrl($_CONF['site_url']
                            . '/links/portal.php?what=link&amp;item=' . $lid);
            if (empty($autotag['parm2'])) {
                $result = DB_query("SELECT url, title FROM {$_TABLES['links']} WHERE lid = '$lid'");
                list($siteurl, $linktext) = DB_fetchArray($result);
                $linktext = stripslashes($linktext);
            } else {
                $linktext = $autotag['parm2'];
                $siteurl = DB_getItem($_TABLES['links'], 'url', "lid = '$lid'");
            }
            $class = 'ext-link';
            if ((!empty($LANG_DIRECTION)) && ($LANG_DIRECTION == 'rtl')) {
                $class .= '-rtl';
            }
            $attr = array(
                        'title' => $siteurl,
                        'class' => $class
                         );
            $link = COM_createLink($linktext, $url, $attr);
            $content = str_replace($autotag['tagstr'], $link, $content);
        }

        return $content;
    }
}

/**
* Called by the plugin Editor to display the current plugin code version
* This may be different than the version installed and registered currently.
* If newer then you may want to run the update
*
* @return   string  version number
*
*/
function plugin_chkVersion_links ()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/links/autoinstall.php';          

    $inst_parms = plugin_autoinstall_links('links'); 

    return $inst_parms['info']['pi_version'];
}

/**
* Helper function: count number of links and total number of clicks
*
* @return   array(number of links, number of clicks);
*
*/
function LINKS_countLinksAndClicks()
{
    global $_TABLES;

    $result = DB_query("SELECT COUNT(*) AS count,SUM(hits) AS clicks FROM {$_TABLES['links']}" . COM_getPermSQL() . LINKS_getCategorySQL('AND'));
    $A = DB_fetchArray($result);
    $total_links = $A['count'];
    $total_clicks = $A['clicks'];
    if (empty($total_clicks)) {
        $total_clicks = 0;
    }

    return array($total_links, $total_clicks);
}

/**
* Shows the statistics for the links plugin on stats.php.
* If $showsitestats is 1 then we are to only print the overall stats in the
* 'site statistics box' otherwise we show the detailed stats
*
* @param    int     $showsitestate  Flag to let us know which stats to get
* @param    string                  HTML for the stats section
*
*/
function plugin_showstats_links ($showsitestats)
{
    global $_CONF, $_TABLES, $LANG_LINKS_STATS;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    $result = DB_query("SELECT lid,url,title,hits FROM {$_TABLES['links']} WHERE (hits > 0)" . COM_getPermSQL('AND') . LINKS_getCategorySQL('AND') . " ORDER BY hits DESC LIMIT 10");
    $nrows  = DB_numRows ($result);
    if ($nrows > 0) {
        $header_arr = array(
            array('text'         => $LANG_LINKS_STATS['stats_page_title'],
                  'field'        => 'sid',
                  'header_class' => 'stats-header-title'
            ),
            array('text'         => $LANG_LINKS_STATS['stats_hits'],
                  'field'        => 'hits',
                  'header_class' => 'stats-header-count',
                  'field_class'  => 'stats-list-count'
            )
        );
        $data_arr = array();
        $text_arr = array('has_menu' => false,
                          'title'    => $LANG_LINKS_STATS['stats_headline'],
        );
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray ($result);
            $title = stripslashes (str_replace ('$', '&#36;', $A['title']));
            $url = COM_buildUrl ($_CONF['site_url']
                        . '/links/portal.php?what=link&amp;item=' . $A['lid']);
            $sid = COM_createLink($title, $url, array('title' => $A['url']));
            $hits = COM_numberFormat ($A['hits']);
            $data_arr[] = array('title' => $title,
                                'sid' => $sid,
                                'hits' => $hits
                          );
        }
        $retval .= ADMIN_simpleList ('', $header_arr, $text_arr, $data_arr);
    } else {
        $retval .= COM_startBlock ($LANG_LINKS_STATS['stats_headline']);
        $retval .= $LANG_LINKS_STATS['stats_no_hits'];
        $retval .= COM_endBlock ();
    }

    return $retval;
}

/**
* New stats plugin API function for proper integration with the site stats
*
* @return   array(item text, item count);
*
*/
function plugin_statssummary_links ()
{
    global $LANG_LINKS_STATS;

    list($total_links, $total_clicks) = LINKS_countLinksAndClicks ();

    $item_count = COM_NumberFormat ($total_links)
                . ' (' . COM_NumberFormat ($total_clicks) . ')';


    return array ($LANG_LINKS_STATS['links'], $item_count);
}

/**
* Geeklog is asking us to provide any items that show up in the type
* drop-down on search.php.  Let's users search for links.
*
* @return   array   (plugin name/entry title) pair for the dropdown
*
*/
function plugin_searchtypes_links()
{
    global $LANG_LINKS;

    $tmp['links'] = $LANG_LINKS[14];

    return $tmp;
}


/**
* This searches for links matching the user query and returns an array for the
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
function plugin_dopluginsearch_links($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage)
{
    global $_TABLES, $LANG_LINKS,$_DB_dbms;

    // Make sure the query is SQL safe
    $query = trim(addslashes($query));

    $sql = "SELECT lid AS id, title, description, UNIX_TIMESTAMP(date) AS date, owner_id AS uid, hits, CONCAT('/links/portal.php?what=link&amp;item=', lid) AS url ";
    $sql .= "FROM {$_TABLES['links']} WHERE date";
    if($_DB_dbms=='pgsql'){$sql .='<> NULL ';}
    else{$sql .=" <> 1 "; }
    $sql .= COM_getPermSQL('AND') . ' ';

    if (!empty ($author)) {
        $sql .= "AND (owner_id = '$author') ";
    }

    $search = new SearchCriteria('links', $LANG_LINKS[14]);

    $columns = array('title' => 'title', 'description');
    $sql .= $search->getDateRangeSQL('AND', 'date', $datestart, $dateend);
    list($sql,$ftsql) = $search->buildSearchSQL($keyType, $query, $columns, $sql);

    $search->setSQL($sql);
    $search->setFTSQL($ftsql);
    $search->setRank(3);
    $search->setAppendQuery(false);
    $search->setURLRewrite(true);

    return $search;
}


/**
* This will put an option for links in the command and control block on
* moderation.php
*
* @return   mixed   array(title, url, icon), or boolean false when not allowed
*
*/
function plugin_cclabel_links()
{
    global $_CONF, $LANG_LINKS;

    if (SEC_hasRights ('links.edit')) {
        return array ($LANG_LINKS[14],
                      $_CONF['site_admin_url'] . '/plugins/links/index.php',
                      plugin_geticon_links ());
    }

    return false;
}

/**
* returns the administrative option for this plugin
*
* @return   mixed   array(title, url, num. links), or void when not allowed
*
*/
function plugin_getadminoption_links()
{
    global $_CONF, $_TABLES, $LANG_LINKS;

    if (SEC_hasRights ('links.edit,links.delete', 'OR')) {
        $total_links = DB_getItem ($_TABLES['links'], 'COUNT(*)',
                                   COM_getPermSql (''));

        return array ($LANG_LINKS[14],
                      $_CONF['site_admin_url'] . '/plugins/links/index.php',
                      $total_links);
    }
}

/**
* A user is about to be deleted. Update ownership of any links owned
* by that user or delete them.
*
* @param    int     $uid    User id of deleted user
* @return   void
*
*/
function plugin_user_delete_links ($uid)
{
    global $_TABLES, $_LI_CONF;

    if (DB_count ($_TABLES['links'], 'owner_id', $uid) == 0) {
        return;
    }

    if ($_LI_CONF['delete_links'] == 1) {
        // delete the links
        DB_delete($_TABLES['links'], 'owner_id', $uid);
    } else {
        // assign ownership to a user from the Root group
        $rootgroup = DB_getItem ($_TABLES['groups'], 'grp_id',
                                 "grp_name = 'Root'");
        $result = DB_query ("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1");
        $A = DB_fetchArray ($result);
        $rootuser = $A['ug_uid'];
        DB_query ("UPDATE {$_TABLES['links']} SET owner_id = $rootuser WHERE owner_id = $uid");
    }
}

/**
* Do we support feeds?
*
* @return   array   id/name pairs of all supported feeds
*
*/
function plugin_getfeednames_links()
{
    global $_TABLES;

    $feeds = array ();

    $result = DB_query ("SELECT cid,category FROM {$_TABLES['linkcategories']} GROUP BY cid,category ORDER BY category ASC");
    $num = DB_numRows ($result);

    if ($num > 0) {
        $feeds[] = array ('id' => 'all', 'name' => 'all categories');

        for ($i = 0; $i < $num; $i++) {
            $A = DB_fetchArray ($result);
            $feeds[] = array ('id' => $A['cid'], 'name' => $A['category']);
        }
    }

    return $feeds;
}

/**
* Provide feed data
*
* @param    int     $feed       feed ID
* @param    ref     $link
* @param    ref     $update
* @return   array               feed entries
*
*/
function plugin_getfeedcontent_links ($feed, &$link, &$update)
{
    global $_CONF, $_TABLES;

    $result = DB_query( "SELECT topic,limits,content_length FROM {$_TABLES['syndication']} WHERE fid = '$feed'" );
    $S = DB_fetchArray( $result );

    $result = DB_query( "SELECT lid,owner_id,title,description,UNIX_TIMESTAMP(date) AS modified FROM " . $_TABLES['links'] . links_buildSql ($S['topic'], $S['limits']) );

    $content = array();
    $lids = array();
    $nrows = DB_numRows( $result );

    for( $i = 0; $i < $nrows; $i++ )
    {
        $row = DB_fetchArray( $result );
        $lids[] = $row['lid'];

        $linktitle = stripslashes( $row['title'] );
        $linkdesc = PLG_replaceTags( stripslashes($row['description']) );

        $linklink = COM_buildUrl( $_CONF['site_url']
                  . '/links/portal.php?what=link&amp;item=' . $row['lid'] );

        $content[] = array( 'title'   => $linktitle,
                            'summary' => $linkdesc,
                            'link'    => $linklink,
                            'uid'     => $row['owner_id'],
                            'author'  => COM_getDisplayName( $row['owner_id'] ),
                            'date'    => $row['modified'],
                            'format'  => 'plaintext'
                          );
    }

    $link = $_CONF['site_url'] . '/links/index.php';
    $update = implode( ',', $lids );

    return $content;
}

/**
* Helper function: Build part of an SQL request
*
* @param    string  $cid        category id
* @param    string  $limits     limit (number of entries or number of hours)
* @return   string              part of an SQL request
*
*/
function links_buildSql($cid, $limits)
{
    global $_DB_dbms;
    $where = '';
    if ($cid != 'all') {
        $where = "cid='" . addslashes($cid) . "'";
    }

    $limitsql = '';
    if (!empty ($limits)) {
        if (substr ($limits, -1) == 'h') { // last xx hours
            $limitsql = '';
            $hours = substr ($limits, 0, -1);
            if (!empty ($where)) {
                $where .= ' AND ';
            }
            if($_DB_dbms=='pgsql') {$where .= "date >= (NOW() - INTERVAL '$hours HOURS')"; } else
            {$where .= "date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)"; }
        } else {
            $limitsql = ' LIMIT ' . $limits;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    if (!empty ($where)) {
        $where = ' WHERE ' . $where;
    }

    $sql = $where . ' ORDER BY date DESC' . $limitsql;

    return $sql;
}

/**
* Checking if links feeds are up to date
*
* @param    int     $feed           id of feed to be checked
* @param    string  $topic          topic (actually: cid)
* @param    string  $update_data    data describing current feed contents
* @param    string  $limit          number of entries or number of hours
* @param    string  $updated_type   (optional) type of feed to be updated
* @param    string  $updated_topic  (optional) feed's "topic" to be updated
* @param    string  $updated_id     (optional) id of entry that has changed
* @return   boolean                 true: feed data is up to date; false: isn't
*
*/
function plugin_feedupdatecheck_links ($feed, $topic, $update_data, $limit, $updated_type = '', $updated_topic = '', $updated_id = '')
{
    global $_TABLES;

    $is_current = true;

    if ($updated_type != 'links') {
        // we're not interested
        $updated_type = '';
        $updated_topic = '';
        $updated_id = '';
    }

    $sql = "SELECT lid FROM {$_TABLES['links']}" . links_buildSql ($topic, $limit);
    $result = DB_query ($sql);
    $num = DB_numRows ($result);

    $lids = array ();
    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray ($result);

        if ($A['lid'] == $updated_id) {
            // this feed has to be updated - no further checks needed
            return false;
        }

        $lids[] = $A['lid'];
    }
    $current = implode (',', $lids);

    return ($current != $update_data) ? false : true;
}

/**
* Update the Links plugin
*
* @return   int     Number of message to display (true = generic success msg)
*
*/
function plugin_upgrade_links()
{
    global $_CONF, $_TABLES, $_LI_CONF, $_DB_dbms;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                                    "pi_name = 'links'");
    $code_version = plugin_chkVersion_links();
    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/links/autoinstall.php';

    if (! plugin_compatible_with_this_version_links('links')) {
        return 3002;
    }

    $inst_parms = plugin_autoinstall_links('links');
    $pi_gl_version = $inst_parms['info']['pi_gl_version'];

    require_once $_CONF['path'] . 'plugins/links/sql/'
                                . $_DB_dbms . '_updates.php';

    require_once $_CONF['path'] . 'plugins/links/install_updates.php';

    $current_version = $installed_version;
    $done = false;
    $current_config = false;
    while (! $done) {
        switch ($current_version) {
        case '1.0.1':
            require_once $_CONF['path_system'] . 'classes/config.class.php';

            $plugin_path = $_CONF['path'] . 'plugins/links/';
            require_once $plugin_path . 'install_defaults.php';

            if (file_exists($plugin_path . 'config.php')) {
                global $_DB_table_prefix, $_LI_CONF;

                require_once $plugin_path . 'config.php';
            }

            if (!plugin_initconfig_links()) {
                echo 'There was an error upgrading the Links plugin';
                return false;
            }

            $li_config = config::get_instance();
            $_LI_CONF = $li_config->get_config('links');

            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                $_SQL = INST_checkInnodbUpgrade($_SQL);
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }
            links_update_set_categories();
            $current_config = true;

            $current_version = '2.0.0';
            break;

        case '2.0.0':
            // no db changes
            $current_version = '2.0.1';
            break;

        case '2.0.1': // Last version of old install (Geeklog 1.5.2)
            if (! $current_config) {
                if (! isset($_LI_CONF['new_window'])) {
                    $c = config::get_instance();
                    $c->add('new_window',false,'select',0,0,1,55,TRUE,'links');
                }
    
                if (! isset($_LI_CONF['category_permissions'])) {
                    $c = config::get_instance();
                    $c->add('fs_cpermissions', NULL, 'fieldset', 0, 3, NULL, 0, true, 'links');
                    $c->add('category_permissions', array (3, 2, 2, 2),
                            '@select', 0, 3, 12, 150, true, 'links');
                }
            }

            $current_version = '2.1.0';
            break;

        case '2.1.0':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }

            if (! $current_config) {
                // Update to Config Tables must be performed here and not in regualar SQL update array since if config is current then they shouldn't be run   
                // Set new Tab column to whatever fieldset is
                $sql = "UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'links'";
                DB_query($sql);
                
                links_update_ConfValues_2_1_0();
            }
            
            links_update_ConfigSecurity_2_1_0();

            $current_version = '2.1.1';
            break;

        case '2.1.1':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }

            $current_version = '2.1.2';
            break;
            
        default:
            $done = true;
        }
    }

    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '$pi_gl_version' WHERE pi_name = 'links'");

    return true;
}

/**
* Called during site migration - handle changed URLs or paths
*
* @param    array   $old_conf   contents of the $_CONF array on the old site
* @param    boolean             true on success, otherwise false
*
*/
function plugin_migrate_links($old_conf)
{
    global $_CONF;

    $tables = array(
        'linkcategories'    => 'cid, description',
        'links'             => 'lid, description, url',
        'linksubmission'    => 'lid, description, url'
    );

    if ($old_conf['site_url'] != $_CONF['site_url']) {
        INST_updateSiteUrl($old_conf['site_url'], $_CONF['site_url'], $tables);
    }

    return true;
}

/**
* Geeklog informs us that we're about to be enabled or disabled
*
* @param    boolean     $enable     true = we're being enabled, false = disabled
* @return   void
*
*/
function plugin_enablestatechange_links ($enable)
{
    global $_TABLES;

    $is_enabled = $enable ? 1 : 0;

    // toggle links feeds
    DB_query ("UPDATE {$_TABLES['syndication']} SET is_enabled = $is_enabled WHERE type = 'links'");
}

/**
* Counts the items that are submitted
*
* @return   int     number of items in submission queue
*
*/
function plugin_submissioncount_links()
{
    global $_TABLES;

    $retval = 0;

    if (plugin_ismoderator_links ()) {
        $retval = DB_count ($_TABLES['linksubmission']);
    }

    return $retval;
}

/**
* Checks that the current user has the rights to moderate the
* plugin, returns true if this is the case, false otherwise
*
* @return        boolean       Returns true if moderator
*
*/
function plugin_ismoderator_links()
{
    return SEC_hasRights ('links.moderate');
}


/**
* Returns SQL & Language texts to moderation.php
*
* @return   mixed   Plugin object or void if not allowed
*
*/
function plugin_itemlist_links()
{
    global $_TABLES, $LANG_LINKS_SUBMIT;

    if (plugin_ismoderator_links()) {
        $plugin = new Plugin();
        $plugin->submissionlabel = $LANG_LINKS_SUBMIT[11];
        $plugin->submissionhelpfile = 'cclinksubmission.html';
        $plugin->getsubmissionssql = "SELECT lid AS id,title,cid AS category,url FROM {$_TABLES['linksubmission']} ORDER BY title ASC";
        $plugin->addSubmissionHeading($LANG_LINKS_SUBMIT[8]);
        $plugin->addSubmissionHeading($LANG_LINKS_SUBMIT[10]);
        $plugin->addSubmissionHeading($LANG_LINKS_SUBMIT[9]);

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
function plugin_moderationvalues_links()
{
    global $_TABLES;

    return array ('lid',
                  $_TABLES['links'],
                  'lid,cid,url,description,title,date,owner_id',
                  $_TABLES['linksubmission']);
}


/**
* Performs plugin exclusive work for items approved by moderation
*
* While moderation.php handles the actual move from linkssubmission
* to links tables, within the function we handle all other approval
* relate tasks
*
* @param    string  $id     Identifying string
* @return   string          Any wanted HTML output
*
*/
function plugin_moderationapprove_links($id)
{
    global $_TABLES, $_USER, $_GROUPS, $_LI_CONF;

    // The linksubmission only keeps track of the submitter's uid, but not
    // of grous and permissions. So set those to sensible defaults.

    if (isset($_GROUPS['Links Admin'])) {
        $group_id = $_GROUPS['Links Admin'];
    } else {
        $group_id = SEC_getFeatureGroup('links.moderate');
    }

    $A = array();
    SEC_setDefaultPermissions($A, $_LI_CONF['default_permissions']);

    DB_query("UPDATE {$_TABLES['links']} SET group_id = '$group_id', perm_owner = '{$A['perm_owner']}', perm_group = '{$A['perm_group']}', perm_members = '{$A['perm_members']}', perm_anon = '{$A['perm_anon']}' WHERE lid = '$id'");

    return '';
}

/**
* Performs plugin exclusive work for items deleted by moderation
*
* While moderation.php handles the actual removal from <plugin>submission
* table, within this function we handle all other deletion
* related tasks
*
* @param    string  $id     Identifying string
* @return   string          Any wanted HTML output
*
*/
function plugin_moderationdelete_links($id)
{
    global $_TABLES;

    // these tables should not contain any rows with ml_id = $id
    // this is done 'just in case'
    DB_delete ($_TABLES['linksubmission'], 'lid', $id);

    return '';
}

/**
* Check submission form values and save if OK. Else show form again
*
* @param    array   $A  The link record
* @return   string      Any wanted HTML output
*
*/
function plugin_savesubmission_links($A)
{
    global $LANG12;

    $retval = '';

    if (!empty($A['title']) && !empty($A['description']) && !empty($A['url'])
            && ($A['url'] != 'http://')) {
        $retval = plugin_save_submit_links($A);
    } else {
        $retval .= COM_startBlock ($LANG12[22], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[23]
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
            . plugin_submit_links();
        $retval = COM_createHTMLDocument($retval);
    }

    return $retval;
}

/**
* Shows link submission form
*
* @return   string  HTML for the link submission form
*
*/
function plugin_submit_links()
{
    global $_CONF, $LANG_LINKS_SUBMIT, $LANG12;

    $retval = COM_startBlock ($LANG_LINKS_SUBMIT[1], 'submitlink.html');

    $linkform = COM_newTemplate($_CONF['path'] . 'plugins/links/templates');
    $linkform->set_file('linkform', 'submitlink.thtml');
    $linkform->set_var('lang_title', $LANG12[10]);
    $linkform->set_var('lang_link', $LANG_LINKS_SUBMIT[2]);
    $linkform->set_var('lang_category', $LANG_LINKS_SUBMIT[3]);
    $category = '';
    if (isset($_REQUEST['cid'])) {
        $category = $_REQUEST['cid'];
    }
    $linkform->set_var('link_category_options', links_select_box(2, $category));
    $linkform->set_var('lang_description', $LANG12[15]);
    $linkform->set_var('lang_htmlnotallowed', $LANG12[35]);
    $allowed = COM_allowedHTML('links.edit', false, 2);
    $linkform->set_var('lang_allowed_html', $allowed);    
    PLG_templateSetVars('links', $linkform);
    $linkform->set_var('lang_submit', $LANG12[8]);
    $linkform->set_var('max_url_length', 255);
    $linkform->parse('theform', 'linkform');
    $retval .= $linkform->finish($linkform->get_var('theform'));
    $retval .= COM_endBlock();

    return $retval;
}

/**
* Saves a link submission
*
* @param    array   $A  Data for that submission
* @return   string      HTML redirect
*
*/
function plugin_save_submit_links($A)
{
    global $_CONF, $_TABLES, $_USER, $_LI_CONF, $LANG12;

    $retval = '';

    // pseudo-formatted link description for the spam check
    if ($A['url'] == 'http://') {
        $link = $A['title'];
    } else {
        $link = COM_createLink($A['title'], $A['url']);
    }
    $spamcheck = '<p>'. $link .' (' . $A['categorydd'] . ')<br' . XHTML . '>'
               . $A['description'] . '</p>';
    $result = PLG_checkforSpam($spamcheck, $_CONF['spamx']);
    if ($result > 0) {
        COM_updateSpeedlimit('submit');
        COM_displayMessageAndAbort($result, 'spamx', 403, 'Forbidden');
    }

    $msg = PLG_itemPreSave('links', $A);
    if (! empty($msg)) {
        COM_updateSpeedlimit('submit');
        $retval .= COM_errorLog($msg, 2)
                . plugin_submit_links();
        $retval = COM_createHTMLDocument($retval);

        return $retval;
    }

    $A['cid'] = strip_tags(COM_stripslashes($A['categorydd']));

    $validcat = false;
    if (!empty($A['cid'])) {
        $cid = addslashes($A['cid']);
        $cat = DB_getItem($_TABLES['linkcategories'], 'category',
                          "cid = '$cid'");
        if (!empty($cat)) {
            $validcat = true;
        }
    }
    if (!$validcat) {
        $retval .= COM_startBlock($LANG12[22], '',
                       COM_getBlockTemplate('_msg_block', 'header'))
                . $LANG12[23]
                . COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'))
                . submissionform('links');
        $retval = COM_createHTMLDocument($retval);

        return $retval;
    }

    $A['cid'] = addslashes($A['cid']);
    // Remove any autotags the user doesn't have permission to use
    $A['description'] = PLG_replaceTags($A['description'], '', true);
    $A['description'] = addslashes(htmlspecialchars(COM_checkWords($A['description'])));
    $A['title'] = addslashes(strip_tags(COM_checkWords($A['title'])));
    $A['url'] = addslashes(COM_sanitizeUrl($A['url']));
    $A['lid'] = addslashes(COM_makeSid());

    COM_updateSpeedlimit('submit');
    if (COM_isAnonUser()) {
        $owner_id = 1; // anonymous user
    } else {
        $owner_id = $_USER['uid'];
    }

    if (($_LI_CONF['linksubmission'] == 1) && !SEC_hasRights('links.submit')) {
        $result = DB_save($_TABLES['linksubmission'],
                    'lid,cid,url,description,title,date,owner_id',
                    "{$A['lid']},'{$A['cid']}','{$A['url']}','{$A['description']}','{$A['title']}',NOW(),$owner_id");

        if ($_LI_CONF['notification'] == 1) {
            LINKS_sendNotification($_TABLES['linksubmission'], $A);
        }

        $retval = COM_refresh($_CONF['site_url']
                              . '/index.php?msg=1&amp;plugin=links');

    } else { // add link directly

        if (SEC_hasRights('links.submit')) {
            $A['group_id'] = SEC_getFeatureGroup('links.submit');
        } else {
            $A['group_id'] = DB_getItem($_TABLES['groups'], 'grp_id',
                                        "grp_name = 'All Users'");
        }
        SEC_setDefaultPermissions($A, $_LI_CONF['default_permissions']);

        $result = DB_save($_TABLES['links'],
                    'lid,cid,url,description,title,date,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',
                    "{$A['lid']},'{$A['cid']}','{$A['url']}','{$A['description']}','{$A['title']}',NOW(),$owner_id,{$A['group_id']},{$A['perm_owner']},{$A['perm_group']},{$A['perm_members']},{$A['perm_anon']}");

        PLG_itemSaved($A['lid'], 'links');

        if ($_LI_CONF['notification'] == 1) {
            LINKS_sendNotification($_TABLES['links'], $A);
        }
        COM_rdfUpToDateCheck('links', $A['cid'], $A['lid']);

        $retval = COM_refresh($_CONF['site_url']
                              . '/index.php?msg=4&amp;plugin=links');
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
function LINKS_sendNotification ($table, $A)
{
    global $_CONF, $_TABLES, $LANG_LINKS, $LANG_LINKS_SUBMIT, $LANG08;

    $title = stripslashes ($A['title']);
    $description = PLG_replaceTags( stripslashes($A['description']) );

    $mailbody = "$LANG_LINKS_SUBMIT[8]: $title\n"
              . "$LANG_LINKS_SUBMIT[9]: <{$A['url']}>\n"
              . "$LANG_LINKS_SUBMIT[3]: {$A['category']}\n\n"
              . $description . "\n\n";
    if ($table == $_TABLES['linksubmission']) {
        $mailbody .= "$LANG_LINKS[10] <{$_CONF['site_admin_url']}/moderation.php>\n\n";
    } else {
        $mailbody .= "$LANG_LINKS[114] <{$_CONF['site_url']}/links/index.php?category=" . rawurlencode ($A['category']) . ">\n\n";
    }
    $mailsubject = $_CONF['site_name'] . ' ' . $LANG_LINKS_SUBMIT[11];

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
}

/**
* Returns the URL of the plugin's icon
*
* @return   string      URL of the icon
*
*/
function plugin_geticon_links ()
{
    global $_CONF;

    return $_CONF['site_url'] . '/links/images/links.png';
}

function plugin_getListField_links($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_ACCESS, $LANG_LINKS_ADMIN;

    $retval = '';

    $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
    if ($access > 0) {
        switch($fieldname) {
            case 'edit':
                if ($access == 3) {
                    $retval = COM_createLink(
                        $icon_arr['edit'],
                        "{$_CONF['site_admin_url']}/plugins/links/index.php?mode=edit&amp;lid={$A['lid']}"
                    );
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
                $retval = COM_createLink(stripslashes($A['title']), $A['url']);
                break;
            case 'dovalidate';
                $retval = links_validateUrl($A['url']);
                break;
            case 'beforevalidate';
                $retval = $LANG_LINKS_ADMIN[57];
                break;
            case 'category':
                if (isset($A['indent'])) {
                    $indent = ($A['indent'] - 1) * 20;
                } else {
                    $indent = 0;
                }
                $cat = COM_createLink($A['category'],
                        "{$_CONF['site_url']}/links/index.php?category="
                        . rawurlencode($A['cid']));
                $retval = "<span style=\"padding-left:{$indent}px;\">$cat</span>";
                break;
                break;
            default:
                $retval = $fieldvalue;
                break;
        }
    }

    return $retval;
}

function plugin_getListField_categories($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $_TABLES, $LANG_ACCESS, $LANG_LINKS_ADMIN;

    $retval = '';

    $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
    if ($access > 0) {
        switch($fieldname) {
            case 'edit':
                if ($access == 3) {
                    $retval = COM_createLink(
                        $icon_arr['edit'],
                        "{$_CONF['site_admin_url']}/plugins/links/category.php?mode=edit&amp;cid=" . rawurlencode($A['cid'])
                    );
                }
                break;
            case 'access':
                if ($access == 3) {
                   $retval = $LANG_ACCESS['edit'];
                } else {
                   $retval = $LANG_ACCESS['readonly'];
                }
                break;
            case 'category':
                $indent = ($A['indent'] - 1) * 20;
                $cat = COM_createLink($A['category'],
                        "{$_CONF['site_url']}/links/index.php?category="
                        . rawurlencode($A['cid']));
                $retval = "<span style=\"padding-left:{$indent}px;\">$cat</span>";
                break;
            case 'addchild';
                if ($access == 3) {
                    $retval = COM_createLink(
                        $icon_arr['addchild'],
                        "{$_CONF['site_admin_url']}/plugins/links/category.php?mode=edit&amp;pid=" . rawurlencode($A['cid'])
                    );
                }
                break;
            case 'tid';
                if ($A['tid'] == 'all') {
                    $retval = $LANG_LINKS_ADMIN[35];
                } else {
                    $retval = DB_getItem($_TABLES['topics'], 'topic',
                                         "tid = '{$A['tid']}'");
                }
                if (empty($retval)) {
                    $retval = $A['tid'];
                }
                break;
            default:
                $retval = $fieldvalue;
                break;
        }
    }

    return $retval;
}


function links_validateUrl($url)
{
    global $LANG_LINKS_STATUS;

    require_once 'HTTP/Request.php';

    $retval = '';

    $req = new HTTP_Request($url);
    $req->setMethod(HTTP_REQUEST_METHOD_HEAD);
    $req->addHeader('User-Agent', 'Geeklog/' . VERSION);

    $response = $req->sendRequest();
    if (PEAR::isError($response)) {
        $retval = $response->getMessage();
    } else {
        $status_code = $req->getResponseCode();
        if (isset($LANG_LINKS_STATUS[$status_code])) {
            $retval = $status_code . ": " . $LANG_LINKS_STATUS[$status_code];
        } else {
            $retval = $LANG_LINKS_STATUS[999];
        }
    }

    return $retval;
}

/**
* Set template variables
*
* @param    string  $templatename   name of template, e.g. 'header'
* @param    ref     $template       reference of actual template
* @return   void
*
* Note: A plugin should use its name as a prefix for the names of its
* template variables, e.g. 'links_xxx' and 'lang_links_xxx'.
* 'button_links' is an exception, as such a variable existed for header.thtml
* in Geeklog 1.3.11 and earlier, where the Links section was an integral part
* of Geeklog. It is added here for backward-compatibility.
*
*/
function plugin_templatesetvars_links ($templatename, &$template)
{
    global $LANG_LINKS;

    if (($templatename == 'header') || ($templatename == 'footer')) {
        $template->set_var ('button_links', $LANG_LINKS[14]);
    }
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
function plugin_autouninstall_links ()
{
    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array('links','linksubmission','linkcategories'),
        /* give the full name of the group, as in the db */
        'groups' => array('Links Admin'),
        /* give the full name of the feature, as in the db */
        'features' => array('links.edit', 
                            'links.moderate', 
                            'links.submit', 
                            'config.links.tab_public', 
                            'config.links.tab_admin', 
                            'config.links.tab_permissions', 
                            'config.links.tab_cpermissions', 
                            'config.links.tab_autotag_permissions'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array('phpblock_topic_categories', 'phpblock_topic_links'),
        /* give all vars with their name */
        'vars'=> array()
    );
    return $out;
}

// +--------------------------------------------------------------------------+
// | Category HTML functions                                                  |
// | Functions for building select boxes and breadcrumb trails etc.           |
// +--------------------------------------------------------------------------+

/*
* Build selection list
*
* @param    int     $access access permissions (3 = read/edit, 2 = read only)
* @param    string  $sel    current selection
* @return   string          HTML for select list
*
*/
function links_select_box($access, $sel = '')
{
    global $_CONF, $LANG_LINKS, $_LI_CONF;

    // set root value
    $menu = '<option value="' . $_LI_CONF['root'] . '">' . $LANG_LINKS['root']
          . '</option>';

    // get option values
    $list = links_select_box_recursive($menu, $_LI_CONF['root'], $sel,
                                       '&nbsp;&nbsp;', $access);

    // return list of options
    return $list;
}


/*
* Build recursive tree
*/
function links_select_box_recursive (&$menu, $cid, $sel, $indent, $access)
{
    global $_CONF, $_TABLES;

    $cat = addslashes($cid);
    $sql = "SELECT cid,category
            FROM {$_TABLES['linkcategories']}
            WHERE (pid='{$cat}') " . COM_getPermSQL('AND', 0, $access) . "
            ORDER BY category";
    $query = DB_query($sql);
    while (list($cid, $category) = DB_fetchArray($query)) {
        // set selected item
        if ($cid == $sel) {
            // yes, selected
            $menu .= '<option value="' . htmlspecialchars($cid)
                  . '" selected="selected">' . $indent . $category
                  . '</option>';
        } else {
            // no, not selected
            $menu .= '<option value="' . htmlspecialchars($cid) . '">'
                  . $indent . $category . '</option>';
        }
        // Check and see if this category has any sub categories
        if (DB_count($_TABLES['linkcategories'], 'pid', addslashes($cid)) > 0) {
            // yes, call self
            $dum = links_select_box_recursive ($menu, $cid, $sel,
                        $indent . '&nbsp;&nbsp;', $access);
        }
   }

   return $menu;
}


/*
* Build breadcrumb trail
*
* Breadcrumb trail does not use the "root" category in the database: the top
* level category is set from the language file using $LANG_LINKS['root']
*/
function links_breadcrumbs($root, $cid)
{
    global $_CONF, $_TABLES, $LANG_LINKS;

    $breadcrumb = '';
    $separator  = ' &gt; ';

    $cat = addslashes($cid);
    $c = $cid;
    $pid = '';
    if ($root != $cid) {
        while ($pid != $root) {
            $parent = DB_query("SELECT cid,pid,category FROM {$_TABLES['linkcategories']} WHERE cid='{$cat}'");
            $A = DB_fetchArray($parent);
            if ($cid != $c) {
                $content = stripslashes($A['category']);
                $url = $_CONF['site_url'] . '/links/index.php?category='
                                          . rawurlencode($A['cid']);
                $breadcrumb = COM_createLink($content, $url) . $separator
                            . $breadcrumb;
            } else {
                $breadcrumb = '<b>' . $A['category'] . '</b>' . $breadcrumb;
            }
            $pid = $A['pid'];
            $c = $A['pid'];
            $cat = addslashes($c);
        }
    }

    $url = $_CONF['site_url'] . '/links/index.php';
    if (empty($breadcrumb)) {
        $breadcrumb = '<b>' . $LANG_LINKS['root'] . '</b>';
    } else {
        $breadcrumb = COM_createLink($LANG_LINKS['root'], $url) . $separator . $breadcrumb;
    }

    $breadcrumb = '<span class="links-breadcrumb">' . $LANG_LINKS[126] . ' '
                . $breadcrumb . '</span>';

    return $breadcrumb;
}



// +--------------------------------------------------------------------------+
// | PHP Block functions                                                      |
// +--------------------------------------------------------------------------+

/**
 * Returns a list of links that belong to categories associated with
 * the current topic
 *
 * Relies on the fact that $topic is set (and sanitized) in lib-common.php
 */
function phpblock_topic_links()
{
    global $_CONF, $_TABLES, $LANG_LINKS, $topic;

    $retval = '';

    if (!empty($topic)) {
        $tid = addslashes($topic);
        $topic_sql = "(c.tid='{$tid}' OR c.tid='" . TOPIC_ALL_OPTION . "') ";
    } else {
        $topic_sql = "(c.tid='" . TOPIC_ALL_OPTION . "') ";
    }        
        
    $result = DB_query("SELECT l.lid, l.title, l.url, c.cid FROM {$_TABLES['links']} AS l LEFT JOIN {$_TABLES['linkcategories']} AS c ON l.cid=c.cid WHERE " . $topic_sql . COM_getPermSQL('AND', 0, 2, 'c'));
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $content = stripslashes($A['title']);
            $url = COM_buildUrl($_CONF['site_url']
                 . '/links/portal.php?what=link&amp;item=' . $A['lid']);
            $retval .= COM_createLink($content, $url,
                                      array('title' => $A['url']))
                    . '<br' . XHTML . '>';
        }
    }

    return $retval;
}


/**
 * Returns a list of categories that are associated with the current topic
 *
 * Relies on the fact that $topic is set (and sanitized) in lib-common.php
 */
function phpblock_topic_categories()
{
    global $_CONF, $_TABLES, $LANG_LINKS, $topic;

    $retval = '';

    if (!empty($topic)) {
        $tid = addslashes($topic);
        $topic_sql = "(tid='{$tid}' OR tid='" . TOPIC_ALL_OPTION . "') ";
    } else {
        $topic_sql = "(tid='" . TOPIC_ALL_OPTION . "') ";
    } 
    

    $result = DB_query("SELECT category, cid FROM {$_TABLES['linkcategories']} WHERE " . $topic_sql . COM_getPermSQL ('AND'));
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $content = stripslashes($A['category']);
            $url = $_CONF['site_url'] . '/links/index.php?category='
                                      . rawurlencode($A['cid']);
            $retval .= COM_createLink($content, $url) . '<br' . XHTML . '>';
        }
    }

    return $retval;
}

/**
* Return information for a link
*
* @param    string  $lid        link ID or '*'
* @param    string  $what       comma-separated list of properties
* @param    int     $uid        user ID or 0 = current user
* @param    array   $options    (reserved for future extensions)
* @return   mixed               string or array of strings with the information
*
*/
function plugin_getiteminfo_links($lid, $what, $uid = 0, $options = array())
{
    global $_CONF, $_TABLES;

    // parse $what to see what we need to pull from the database
    $properties = explode(',', $what);
    $fields = array();
    foreach ($properties as $p) {
        switch ($p) {
        case 'date-modified':
            $fields[] = 'UNIX_TIMESTAMP(date) AS unixdate';
            break;
        case 'description':
        case 'excerpt':
            $fields[] = 'description';
            break;
        case 'id':
            $fields[] = 'lid';
            break;
        case 'title':
            $fields[] = 'title';
            break;
        case 'url':
            if ($lid == '*') {
                // in this case, we need the lid to build the URL
                $fields[] = 'lid';
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
    if ($lid == '*') {
        $where = '';
        $permOp = 'WHERE';
    } else {
        $where = " WHERE lid = '" . addslashes($lid) . "'";
        $permOp = 'AND';
    }
    if ($uid > 0) {
        $permSql = COM_getPermSql($permOp, $uid)
                 . LINKS_getCategorySQL('AND', $uid);
    } else {
        $permSql = COM_getPermSql($permOp) . LINKS_getCategorySQL('AND');
    }
    $sql = "SELECT " . implode(',', $fields)
            . " FROM {$_TABLES['links']}" . $where . $permSql;
    if ($lid != '*') {
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
            case 'date-modified':
                $props['date-modified'] = $A['unixdate'];
                break;
            case 'description':
            case 'excerpt':
                $props[$p] = PLG_replaceTags( stripslashes($A['description']) );
                break;
            case 'id':
                $props['id'] = $A['lid'];
                break;
            case 'title':
                $props['title'] = stripslashes($A['title']);
                break;
            case 'url':
                if (empty($A['lid'])) {
                    $props['url'] = COM_buildUrl($_CONF['site_url']
                            . '/links/portal.php?what=link&amp;item=' . $lid);
                } else {
                    $props['url'] = COM_buildUrl($_CONF['site_url']
                            . '/links/portal.php?what=link&amp;item='
                            . $A['lid']);
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
            if ($lid == '*') {
                if ($value != '') {
                    $mapped[$key] = $value;
                }
            } else {
                $mapped[] = $value;
            }
        }

        if ($lid == '*') {
            $retval[] = $mapped;
        } else {
            $retval = $mapped;
            break;
        }
    }

    if (($lid != '*') && (count($retval) == 1)) {
        $retval = $retval[0];
    }

    return $retval;
}

/**
* Return SQL expression to check for allowed categories.
*
* Creates part of an SQL expression that can be used to only request links
* from categories to which the user has access to.
*
* Note that this function does SQL requests, so you should cache
* the resulting SQL expression if you need it more than once.
*
* @param    string  $type   part of the SQL expr. e.g. 'WHERE', 'AND'
* @param    int     $u_id   user id or 0 = current user
* @param    string  $table  table name if ambiguous (e.g. in JOINs)
* @return   string          SQL expression string (may be empty)
* @see      COM_getTopicSQL
*
*/
function LINKS_getCategorySQL($type = 'WHERE', $u_id = 0, $table = '')
{
    global $_TABLES, $_USER, $_GROUPS;

    $categorysql = ' ' . $type . ' ';

    if (!empty($table)) {
        $table .= '.';
    }

    $UserGroups = array();
    if (($u_id <= 0) || (isset($_USER['uid']) && ($u_id == $_USER['uid']))) {
        if (!COM_isAnonUser()) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }
        $UserGroups = $_GROUPS;
    } else {
        $uid = $u_id;
        $UserGroups = SEC_getUserGroups($uid);
    }

    if (empty($UserGroups)) {
        // this shouldn't really happen, but if it does, handle user
        // like an anonymous user
        $uid = 1;
    }

    if (SEC_inGroup('Root', $uid)) {
        return '';
    }

    $parents = array('root');
    $cids = array();

    do {
        $result = DB_query("SELECT cid FROM {$_TABLES['linkcategories']}"
                           . COM_getPermSQL('WHERE', $uid) . " AND pid IN ('"
                           . implode("','", $parents) . "')");

        $parents = array();
        while ($C = DB_fetchArray($result)) {
            $parents[] = $C['cid'];
            $cids[] = $C['cid'];
        }
    } while (count($parents) > 0);

    if (count($cids) > 0) {
        $categorysql .= "({$table}cid IN ('" . implode("','", $cids) . "'))";
    } else {
        $categorysql .= '0';
    }

    return $categorysql;
}

/**
* Provide URL of a documentation file
*
* @param    string  $file   documentation file being requested, e.g. 'config'
* @return   mixed           URL or false when not available
*
*/
function plugin_getdocumentationurl_links($file)
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
            $docs = 'docs/' . $doclang . '/links.html';
            if (file_exists($_CONF['path_html'] . $docs)) {
                $retval = $_CONF['site_url'] . '/' . $docs;
            } else {
                $retval = $_CONF['site_url'] . '/docs/english/links.html';
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

/**
* Provides text for a Configuration tooltip
*
* @param    string  $id     Id of config value
* @return   mixed           Text to use regular tooltip, NULL to use config 
*                           tooltip hack, or empty string when not available
*
*/
function plugin_getconfigtooltip_links($id)
{   
    // Use config tooltip hack where tooltip is read from the config documentation
    return;
}

/**
* This function is called to inform plugins when a group's information has
* changed or a new group has been created.
*
* @param    int     $grp_id     Group ID
* @param    string  $mode       type of change: 'new', 'edit', or 'delete'
* @return   void
*
*/
function plugin_group_changed_links($grp_id, $mode)
{
    global $_TABLES, $_GROUPS, $_LI_CONF;
    
    if ($mode == 'delete') {
        // Change any deleted group ids to Links Admin if exist, if does not change to root group
        $new_group_id = 0;
        if (isset($_GROUPS['Links Admin'])) {
            $new_group_id = $_GROUPS['Links Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Links Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }    
        
        // Update Link tables with new group id
        $sql = "UPDATE {$_TABLES['links']} SET group_id = $new_group_id WHERE group_id = $grp_id";        
        $result = DB_query($sql);
        
        $sql = "UPDATE {$_TABLES['linkcategories']} SET group_id = $new_group_id WHERE group_id = $grp_id";        
        $result = DB_query($sql);
   }
}

?>
