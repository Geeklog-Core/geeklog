<?php
###############################################################################
# /admin/index.php
# This is the admin index page that does nothing more that login you in.
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################
//
// $Id: index.php,v 1.9 2006/10/01 19:13:37 dhaun Exp $

/**
* Geeklog common function library
*/
require_once '../lib-common.php';

/**
* Security check to ensure user even belongs on this page
*/
require_once 'auth.inc.php';

// MAIN
if (isset ($_GET['mode']) && ($_GET['mode'] == 'logout')) {
    print COM_refresh($_CONF['site_url'] . '/users.php?mode=logout');
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

// this defines the amount of icons displayed next to another in the CC-block
define ('ICONS_PER_ROW', 6);

/**
* Display a reminder to execute the security check script
*
* @return   string      HTML for security reminder (or empty string)
*/
function security_check_reminder()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $MESSAGE;

    $retval = '';

    if (!SEC_inGroup ('Root')) {
        return $retval;
    }

    $done = DB_getItem ($_TABLES['vars'], 'value', "name = 'security_check'");
    if ($done != 1) {
        $retval .= COM_showMessage(92);
    }

    return $retval;
}

/**
* Renders an entry (icon) for the "Command and Control" center
*
* @param    template    $template   template to use
* @param    string      $url        URL the entry links to
* @param    string      $image      URL of the icon
* @param    string      $label      text to use under the icon
* @return   string                  HTML for rendered item
*
*/
function render_cc_item(&$template, $url = '', $image = '', $label = '')
{
    if (! empty($url)) {
        $template->set_var('page_url', $url);
        $template->set_var('page_image', $image);
        $template->set_var('option_label', $label);
        $template->set_var('cell_width', ((int)(100 / ICONS_PER_ROW)) . '%');

        return $template->parse('cc_main_options', 'ccitem', false);
    }

    return '';
}

/**
* Prints the command & control block at the top
*
* @param    string  $token  CSRF token
* @return   string          HTML for the C&C block
*
*/
function commandcontrol($token)
{
    global $_CONF, $_CONF_FT, $_TABLES, $LANG01, $LANG29, $LANG_LOGVIEW, $LANG_ENVCHECK, $_IMAGE_TYPE, $_DB_dbms;

    $retval = '';

    $admin_templates = COM_newTemplate($_CONF['path_layout'] . 'admin');
    $admin_templates->set_file (array ('cc'     => 'commandcontrol.thtml'));
    $blocks = array('ccgroup', 'ccrow', 'ccitem');
    foreach ($blocks as $block) {
        $admin_templates->set_block('cc', $block);
    }       

    $retval .= COM_startBlock ('Geeklog ' . VERSION . ' -- ' . $LANG29[34], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));
    
    
    // Get any plugin items
    $plugins = PLG_getCCOptions ();
    $cc_core = array();
    $cc_plugins = array();
    $cc_tools = array();
    $cc_users = array();
    for ($i = 0; $i < count ($plugins); $i++) {
        $cur_plugin = current ($plugins);

        $item = array('condition' => SEC_hasRights('story.edit'),
                        'url' => $cur_plugin->adminurl,
                        'lang' => $cur_plugin->adminlabel, 'image' => $cur_plugin->plugin_image);        
        
        switch ($cur_plugin->admingroup) {
            case 'core':
                $cc_core[] = $item;
                break;
                
            case 'tools':
                $cc_tools[] = $item;
                break;

            case 'users':
                $cc_users[] = $item;
                break;                
                
            default:
                $cc_plugins[] = $item;
                break;
        }
        next ($plugins);
    }
    
    // Command & Control Group Layout
    $ccgroups = array('core', 'plugins', 'tools', 'users');
    foreach ($ccgroups as $ccgroup) {
        // Clear a few things before starting group
        $admin_templates->clear_var ('cc_rows');
        $cc_arr = array();
        $items = array();
        
        $admin_templates->set_var('lang_group', $LANG29[$ccgroup]);
        $admin_templates->set_var('cc_icon_width', floor(100/ICONS_PER_ROW));

        switch ($ccgroup) {
            // Core - Blocks, Content Syndication, Stories, Topics, Submissions, Trackbacks
            case 'core':
                $showTrackbackIcon = (($_CONF['trackback_enabled'] ||
                                      $_CONF['pingback_enabled'] || $_CONF['ping_enabled'])
                                     && SEC_hasRights('story.ping'));
                
                $cc_arr = array(
                    array('condition' => SEC_hasRights('topic.edit'),
                        'url' => $_CONF['site_admin_url'] . '/topic.php',
                        'lang' => $LANG01[13], 'image' => $_CONF['layout_url'] . '/images/icons/topic.' . $_IMAGE_TYPE),
                    array('condition' => SEC_hasRights('block.edit'),
                        'url' => $_CONF['site_admin_url'] . '/block.php',
                        'lang' => $LANG01[12], 'image' => $_CONF['layout_url'] . '/images/icons/block.' . $_IMAGE_TYPE),
                    array('condition' => SEC_hasRights('story.edit'),
                        'url' => $_CONF['site_admin_url'] . '/story.php',
                        'lang' => $LANG01[11], 'image' =>  $_CONF['layout_url'] . '/images/icons/story.' . $_IMAGE_TYPE),
                    array('condition' => SEC_hasModerationAccess(),
                        'url' => $_CONF['site_admin_url'] . '/moderation.php',
                        'lang' => $LANG01[10], 'image' =>  $_CONF['layout_url'] . '/images/icons/moderation.' . $_IMAGE_TYPE),
                    array('condition' => SEC_hasRights ('syndication.edit'),
                        'url' => $_CONF['site_admin_url'] . '/syndication.php',
                        'lang' => $LANG01[38], 'image' => $_CONF['layout_url'] . '/images/icons/syndication.' . $_IMAGE_TYPE),
                    array('condition' => $showTrackbackIcon,
                        'url' => $_CONF['site_admin_url'] . '/trackback.php',
                        'lang' => $LANG01[116], 'image' => $_CONF['layout_url'] . '/images/icons/trackback.' . $_IMAGE_TYPE),
                );

                // Merge any items that belong to this group from plugins
                $cc_arr = array_merge($cc_arr, $cc_core);
                break;
                
            // Plugins - All ungrouped plugins
            case 'plugins':
                $cc_arr = $cc_plugins;
                break;
            
            // Tools - Db backups, Clear cache, Log Viewer, GL Version Test, Plugins, Configuration, Documentation, SPAM-X Plugin                
            case 'tools':
                $docsUrl = $_CONF['site_url'] . '/docs/english/index.html';
                if ($_CONF['link_documentation'] == 1) {
                    $doclang = COM_getLanguageName();
                    $docs = 'docs/' . $doclang . '/index.html';
                    if (file_exists($_CONF['path_html'] . $docs)) {
                        $docsUrl = $_CONF['site_url'] . '/' . $docs;
                    }
                }
                $showClearCacheIcon = ($_CONF['cache_templates'] && SEC_inGroup('Root'));
                
                $cc_arr = array(
                    array('condition' => SEC_hasRights($_CONF_FT, 'OR'),
                        'url'=>$_CONF['site_admin_url'] . '/configuration.php',
                        'lang' => $LANG01[129], 'image' => $_CONF['layout_url'] . '/images/icons/configuration.' . $_IMAGE_TYPE),
                    array('condition' => ($_CONF['link_documentation'] == 1),
                        'url' => $docsUrl,
                        'lang' => $LANG01[113], 'image' => $_CONF['layout_url'] . '/images/icons/docs.' . $_IMAGE_TYPE),
                    array('condition' => (SEC_inGroup ('Root') &&
                                          ($_CONF['link_versionchecker'] == 1)),
                        'url' => 'http://www.geeklog.net/versionchecker.php?version='
                                 . VERSION,
                        'lang' => $LANG01[107], 'image' => $_CONF['layout_url'] . '/images/icons/versioncheck.' . $_IMAGE_TYPE),
                    array('condition' => SEC_hasRights('plugin.edit'),
                        'url' => $_CONF['site_admin_url'] . '/plugins.php',
                        'lang' => $LANG01[98], 'image' => $_CONF['layout_url'] . '/images/icons/plugins.' . $_IMAGE_TYPE),
                    array('condition' => ($_CONF['allow_mysqldump'] == 1) &&
                                            ($_DB_dbms == 'mysql') && SEC_inGroup('Root'),
                        'url' => $_CONF['site_admin_url'] . '/database.php',
                        'lang' => $LANG01[103], 'image' => $_CONF['layout_url'] . '/images/icons/database.' . $_IMAGE_TYPE),
                    array('condition' => $showClearCacheIcon,
                        'url' => $_CONF['site_admin_url'] . '/clearctl.php',
                        'lang' => $LANG01['ctl'], 'image' => $_CONF['layout_url'] . '/images/icons/ctl.' . $_IMAGE_TYPE),
                    array('condition' => SEC_inGroup('Root'),
                        'url' => $_CONF['site_admin_url'] . '/envcheck.php',
                        'lang' => $LANG_ENVCHECK['env_check'], 'image' => $_CONF['layout_url'] . '/images/icons/envcheck.' . $_IMAGE_TYPE),
                    array('condition' => SEC_inGroup('Root'),
                        'url' => $_CONF['site_admin_url'] . '/logviewer.php',
                        'lang' => $LANG_LOGVIEW['log_viewer'], 'image' => $_CONF['layout_url'] . '/images/icons/log_viewer.' . $_IMAGE_TYPE),
                    array('condition' => true,
                        'url' =>$_CONF['site_url'] . '/users.php?mode=logout',
                        'lang' => $LANG01[35], 'image' => $_CONF['layout_url'] . '/images/icons/logout.' . $_IMAGE_TYPE) 
                );
                
                // Merge any items that belong to this group from plugins
                $cc_arr = array_merge($cc_arr, $cc_tools);
                break;
            
            // Users - Groups, Users, Mail Users                
            case 'users':
                $cc_arr = array(
                    array('condition' => SEC_hasRights('group.edit'),
                        'url' => $_CONF['site_admin_url'] . '/group.php',
                        'lang' => $LANG01[96], 'image' => $_CONF['layout_url'] . '/images/icons/group.' . $_IMAGE_TYPE),
                    array('condition' => SEC_hasRights('user.edit'),
                        'url' => $_CONF['site_admin_url'] . '/user.php',
                        'lang' => $LANG01[17], 'image' => $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE),
                    array('condition' => SEC_hasRights('user.mail'),
                        'url' => $_CONF['site_admin_url'] . '/mail.php',
                        'lang' => $LANG01[105], 'image' => $_CONF['layout_url'] . '/images/icons/mail.' . $_IMAGE_TYPE)
                );                
                // Merge any items that belong to this group from plugins
                $cc_arr = array_merge($cc_arr, $cc_users);
                
                break;
        }
        
        for ($i = 0; $i < count ($cc_arr); $i++) {
            if ($cc_arr[$i]['condition']) {
                $item = render_cc_item ($admin_templates, $cc_arr[$i]['url'],
                        $cc_arr[$i]['image'], $cc_arr[$i]['lang']);
                $items[$cc_arr[$i]['lang']] = $item;
            }
        }

        if( $_CONF['sort_admin'] ) {
            uksort( $items, 'strcasecmp' );
        }        
        
        if (!empty($items)) {
            reset($items);
            $cols = 0;
            $cc_main_options = '';
            foreach ($items as $key => $val) {
                $cc_main_options .= $val . LB;
                $cols++;
                if ($cols == ICONS_PER_ROW) {
                    $admin_templates->set_var('cc_main_options', $cc_main_options);
                    $admin_templates->parse ('cc_rows', 'ccrow', true);
                    $admin_templates->clear_var ('cc_main_options');
                    $cc_main_options = '';
                    $cols = 0;
                }
            }
        
            if($cols > 0) {
                // "flush out" any unrendered entries
                $admin_templates->set_var('cc_main_options', $cc_main_options);
                $admin_templates->parse ('cc_rows', 'ccrow', true);
                $admin_templates->clear_var ('cc_main_options');
            }    
            
            $admin_templates->parse ('cc_groups', 'ccgroup', true);
        }

    }
    
    
    $retval .= $admin_templates->finish($admin_templates->parse('output','cc'));

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;    
}


$display = COM_showMessageFromParameter()
         .  security_check_reminder()
         .  commandcontrol(SEC_createToken());

$display = COM_createHTMLDocument($display, array('pagetitle' => $LANG29[34]));

COM_output($display);

?>
