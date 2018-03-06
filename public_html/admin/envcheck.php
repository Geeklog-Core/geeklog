<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | envcheck.php                                                              |
// |                                                                           |
// | Geeklog Environment Check.                                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2013 by the following authors:                         |
// |                                                                           |
// | Authors: Mark R. Evans      - mark AT glfusion DOT org                    |
// |          Tom Homer          - tomhomer AT gmail DOT com                   |
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

// Geeklog common function library
require_once '../lib-common.php';

// Security check to ensure user even belongs on this page
require_once 'auth.inc.php';

// Include system library
require_once $_CONF['path_system'] . 'lib-admin.php';

if (!SEC_inGroup('Root')) {
    $content = COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($content, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the hosting environment check screen.");
    COM_output($display);
    exit;
};

function _checkEnvironment()
{
    global $_CONF, $_TABLES, $_PLUGINS, $_SYSTEM, $LANG_ADMIN, $LANG_ENVCHECK, $_SCRIPTS, $_DB_dbms;

    $retval = '';
    $permError = 0;

    $T = new Template($_CONF['path_layout'] . 'admin');
    $T->set_file('page','envcheck.thtml');
    $T->set_block('page', 'status');

    $_SCRIPTS->setJavaScriptLibrary('jquery');
    $javascript = '
    $(document).ready(function(){
      $("#toggle_phpinfo").click(function(){
        $("#panel_phpinfo").toggle();
      });
    });';
    $_SCRIPTS->setJavascript($javascript, true);

    $menu_arr = array (
        array('url'  => $_CONF['site_admin_url'] . '/envcheck.php',
              'text' => $LANG_ENVCHECK['recheck']),
        array('url'  => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home'])
    );

    $retval .= COM_startBlock($LANG_ENVCHECK['hosting_env'], '',
                              COM_getBlockTemplate('_admin_block', 'header'));
    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG_ENVCHECK['php_warning'],
        $_CONF['layout_url'] . '/images/icons/envcheck.png'
    );
    
    // ***********************************************
    // Database Settings Section
    $dbms_error = false;
    if (!empty($_DB_dbms)) {
        $header_arr = array(      // display 'text' and use table field 'field'
            array('text' => $LANG_ENVCHECK['setting'],     'field' => 'settings'),
            array('text' => $LANG_ENVCHECK['current'],     'field' => 'current'),
            array('text' => $LANG_ENVCHECK['recommended'], 'field' => 'recommended'),
            array('text' => $LANG_ENVCHECK['notes'],       'field' => 'notes')
        );
        $text_arr = array(
            'has_menu' => false,
            'title'    => $LANG_ENVCHECK['database_settings'],
            'form_url' => "{$_CONF['site_admin_url']}/envcheck.php"
        );
        $data_arr = array();

        $current = preg_replace('#[^0-9\.]#', '', DB_getVersion());
        if (in_array($_DB_dbms, array('mysql', 'pgsql'))) {
            $recommended = ($_DB_dbms === 'mysql') ? '4.1.2' : '9.1.7';
            $className = version_compare($current, $recommended, '>=') ? 'yes' : 'notok';
            $current = _getStatusTags($T, $className, $current);
            $data_arr[] = array(
                'settings'    => $LANG_ENVCHECK['database_' . $_DB_dbms . '_version'],
                'current'     => $current,
                'recommended' => $recommended . '+',
                'notes'       => $LANG_ENVCHECK['database_' . $_DB_dbms . '_req_version']
            );    
        } else {
            $dbms_error = true;
        }
    } else {
        $dbms_error = true;
    }
    
    if ($dbms_error) {   
        $header_arr = array(      // display 'text' and use table field 'field'
            array('text' => $LANG_ENVCHECK['item'],   'field' => 'item'),
            array('text' => $LANG_ENVCHECK['status'], 'field' => 'status'),
            array('text' => $LANG_ENVCHECK['notes'],  'field' => 'notes')
        );
        $text_arr = array(
            'has_menu' => false,
            'title'    => $LANG_ENVCHECK['database_settings'],
            'form_url' => "{$_CONF['site_admin_url']}/envcheck.php"
        );
        $data_arr = array();

        $data_arr[] = array(
            'item'   => $LANG_ENVCHECK['database_dms'],
            'status' => _getStatusTags($T, 'notok', $LANG_ENVCHECK['not_found']),
            'notes'  => $LANG_ENVCHECK['database_dms_notes']
        );                              
    }

    $admin_list = ADMIN_simpleList('', $header_arr, $text_arr, $data_arr);
    $T->set_var('database_settings_list', $admin_list);
                          
    // ***********************************************
    // PHP Settings Section - First we will validate the general environment.
    $header_arr = array(      // display 'text' and use table field 'field'
        array('text' => $LANG_ENVCHECK['setting'], 'field' => 'settings'),
        array('text' => $LANG_ENVCHECK['current'], 'field' => 'current'),
        array('text' => $LANG_ENVCHECK['recommended'], 'field' => 'recommended'),
        array('text' => $LANG_ENVCHECK['notes'], 'field' => 'notes')

    );
    $text_arr = array('has_menu' => false,
                      'title'    => $LANG_ENVCHECK['php_settings'],
                      'form_url' => "{$_CONF['site_admin_url']}/envcheck.php"
    );
    $data_arr = array();

    $className = (!_phpOutOfDate()) ? 'yes' : 'notok';
    $current = _getStatusTags($T, $className, phpversion());

    $data_arr[] = array(
        'settings'    => $LANG_ENVCHECK['php_version'],
        'current'     => $current,
        'recommended' => '5.3.3+',
        'notes'       => $LANG_ENVCHECK['php_req_version']
    );

    $rg = ini_get('register_globals');
    $className = 'yes';
    $value = $LANG_ENVCHECK['off'];
    if ($rg == 1) {
        $className = 'notok';
        $value = $LANG_ENVCHECK['on'];
    }
    $current = _getStatusTags($T, $className, $value);
    $data_arr[] = array(
        'settings'    => 'register_globals',
        'current'     => $current,
        'recommended' => $LANG_ENVCHECK['off'],
        'notes'       => $LANG_ENVCHECK['register_globals']
    );

    $sm = ini_get('safe_mode');
    $className = 'yes';
    $value = $LANG_ENVCHECK['off'];
    if ($sm == 1) {
        $className = 'notok';
        $value = $LANG_ENVCHECK['on'];
    }
    $current = _getStatusTags($T, $className, $value);
    $data_arr[] = array(
        'settings'    => 'safe_mode',
        'current'     => $current,
        'recommended' => $LANG_ENVCHECK['off'],
        'notes'       => $LANG_ENVCHECK['safe_mode']
    );

    $ob = ini_get('open_basedir');
    if ($ob == '') {
        $open_basedir_restriction = 0;
    } else {
        $open_basedir_restriction = 1;
        $open_basedir_directories = $ob;
    }
    $className = 'notok';
    $value = $LANG_ENVCHECK['enabled'];
    if ($ob == '') {
        $className = 'yes';
        $value = $LANG_ENVCHECK['off'];
    }
    $current = _getStatusTags($T, $className, $value);
    $data_arr[] = array(
        'settings'    => 'open_basedir',
        'current'     => $current,
        'recommended' => $LANG_ENVCHECK['off'],
        'notes'       => $LANG_ENVCHECK['open_basedir']
    );

    $memory_limit = _return_bytes(ini_get('memory_limit'));
    $memory_limit_print = ($memory_limit / 1024) / 1024;
    $className = ($memory_limit < 50331648) ? 'notok' : 'yes';
    $value = $memory_limit_print . 'M';
    $current = _getStatusTags($T, $className, $value);
    $data_arr[] = array(
        'settings'    => 'memory_limit',
        'current'     => $current,
        'recommended' => '48M',
        'notes'       => $LANG_ENVCHECK['memory_limit']
    );

    $fu = ini_get('file_uploads');
    $className = 'notok';
    $value = $LANG_ENVCHECK['off'];
    if ($fu == 1) {
        $className = 'yes';
        $value = $LANG_ENVCHECK['on'];
    }
    $current = _getStatusTags($T, $className, $value);
    $data_arr[] = array(
        'settings'    => 'file_uploads',
        'current'     => $current,
        'recommended' => $LANG_ENVCHECK['on'],
        'notes'       => $LANG_ENVCHECK['file_uploads']
    );

    $upload_limit = _return_bytes(ini_get('upload_max_filesize'));
    $upload_limit_print = ($upload_limit / 1024) / 1024;
    $className = ($upload_limit < 8388608) ? 'notok' : 'yes';
    $value = $upload_limit_print . 'M';
    $current = _getStatusTags($T, $className, $value);
    $data_arr[] = array(
        'settings'    => 'upload_max_filesize',
        'current'     => $current,
        'recommended' => '8M',
        'notes'       => $LANG_ENVCHECK['upload_max_filesize']
    );

    $post_limit = _return_bytes(ini_get('post_max_size'));
    $post_limit_print = ($post_limit / 1024) / 1024;
    $className = ($post_limit < 8388608) ? 'notok' : 'yes';
    $value = $post_limit_print . 'M';
    $current = _getStatusTags($T, $className, $value);
    $data_arr[] = array(
        'settings'    => 'post_max_size',
        'current'     => $current,
        'recommended' => '8M',
        'notes'       => $LANG_ENVCHECK['post_max_size']
    );

    $max_execution_time = ini_get('max_execution_time');
    $className = ($max_execution_time < 30) ? 'notok' : 'yes';
    $value = $max_execution_time . ' secs';
    $current = _getStatusTags($T, $className, $value);
    $data_arr[] = array(
        'settings'    => 'max_execution_time',
        'current'     => $current,
        'recommended' => '30 secs',
        'notes'       => $LANG_ENVCHECK['max_execution_time']
    );

    $admin_list = ADMIN_simpleList('', $header_arr, $text_arr, $data_arr);
    $T->set_var('php_settings_list', $admin_list);
    

    // ***********************************************
    // Libraries
    $header_arr = array(      // display 'text' and use table field 'field'
        array('text' => $LANG_ENVCHECK['item'],   'field' => 'item'),
        array('text' => $LANG_ENVCHECK['status'], 'field' => 'status'),
        array('text' => $LANG_ENVCHECK['notes'],  'field' => 'notes')
    );
    $text_arr = array(
        'has_menu' => false,
        'title'    => $LANG_ENVCHECK['libraries'],
        'form_url' => "{$_CONF['site_admin_url']}/envcheck.php"
    );
    $data_arr = array();

    if (extension_loaded('openssl')) {
        $data_arr[] = array(
            'item'   => $LANG_ENVCHECK['openssl_library'],
            'status' => _getStatusTags($T, 'yes', $LANG_ENVCHECK['ok']),
            'notes'  => $LANG_ENVCHECK['openssl_ok']
        );
    } else {
        $data_arr[] = array(
            'item'   => $LANG_ENVCHECK['openssl_library'],
            'status' => _getStatusTags($T, 'notok', $LANG_ENVCHECK['not_found']),
            'notes'  => $LANG_ENVCHECK['openssl_not_found']
        );
    }

    if ($sm != 1 && $open_basedir_restriction != 1) {
        switch ($_CONF['image_lib']) {
            case 'imagemagick':    // ImageMagick
                if (PHP_OS == "WINNT") {
                    $binary = "/convert.exe";
                    $mogrify = "/mogrify.exe";
                } else {
                    $binary = "/convert";
                    $mogrify = "/mogrify";
                }
                $filePath = str_replace($mogrify, $binary, $_CONF['path_to_mogrify']);
                clearstatcache();
                if (!@file_exists($filePath)) {
                    $data_arr[] = array(
                        'item'   => $LANG_ENVCHECK['imagemagick'],
                        'status' => _getStatusTags($T, 'notok', $LANG_ENVCHECK['not_found']),
                        'notes'  => $LANG_ENVCHECK['im_not_found']
                    );
                } else {
                    $data_arr[] = array(
                        'item'   => $LANG_ENVCHECK['imagemagick'],
                        'status' => _getStatusTags($T, 'yes', $LANG_ENVCHECK['ok']),
                        'notes'  => $LANG_ENVCHECK['im_ok']
                    );
                }
                break;

            case 'gdlib':        // GD Libs
                if ($gdv = gdVersion()) {
                    if ($gdv >= 2) {
                        $data_arr[] = array(
                            'item'   => $LANG_ENVCHECK['gd_lib'],
                            'status' => _getStatusTags($T, 'yes', $LANG_ENVCHECK['ok']),
                            'notes'  => $LANG_ENVCHECK['gd_ok']
                        );
                    } else {
                        $data_arr[] = array(
                            'item'   => $LANG_ENVCHECK['gd_lib'],
                            'status' => _getStatusTags($T, 'yes', $LANG_ENVCHECK['ok']),
                            'notes'  => $LANG_ENVCHECK['gd_v1']
                        );
                    }
                } else {
                    $data_arr[] = array(
                        'item'   => $LANG_ENVCHECK['gd_lib'],
                        'status' => _getStatusTags($T, 'notok', $LANG_ENVCHECK['not_found']),
                        'notes'  => $LANG_ENVCHECK['gd_not_found']
                    );
                }
                break;

            case 'netpbm':    // NetPBM
                if (PHP_OS == "WINNT") {
                    $binary = "/jpegtopnm.exe";
                } else {
                    $binary = "/jpegtopnm";
                }
                clearstatcache();
                if (! @file_exists( $_CONF['path_to_netpbm'] . $binary ) ) {
                    $data_arr[] = array(
                        'item'   => $LANG_ENVCHECK['netpbm'],
                        'status' => _getStatusTags($T, 'notok', $LANG_ENVCHECK['not_found']),
                        'notes'  => $LANG_ENVCHECK['np_not_found']
                    );
                } else {
                    $data_arr[] = array(
                        'item'   => $LANG_ENVCHECK['netpbm'],
                        'status' => _getStatusTags($T, 'yes', $LANG_ENVCHECK['ok']),
                        'notes'  => $LANG_ENVCHECK['np_ok']
                    );
                }
                break;

            default:
                $data_arr[] = array(
                    'item'   => $LANG_ENVCHECK['graphics'],
                    'status' => $LANG_ENVCHECK['not_checked'],
                    'notes'  => $LANG_ENVCHECK['not_used_note']
                );

        }

        /* Left incase we decided to use jhead and/or jpegtran Program in future
        if ($_CONF['jhead_enabled']) {
            if (PHP_OS == "WINNT") {
                $binary = "/jhead.exe";
            } else {
                $binary = "/jhead";
            }
            clearstatcache();
            if (!@file_exists($_CONF['path_to_jhead'] . $binary)) {
                $data_arr[] = array(
                    'item'   => $LANG_ENVCHECK['jhead'],
                    'status' => _getStatusTags($T, 'notok', $LANG_ENVCHECK['not_found']),
                    'notes'  => $LANG_ENVCHECK['jhead_not_found'],
                );
            } else {
                $data_arr[] = array(
                    'item'   => $LANG_ENVCHECK['jhead'],
                    'status' => _getStatusTags($T, 'yes', $LANG_ENVCHECK['ok']),
                    'notes'  => $LANG_ENVCHECK['jhead_ok'],
                );
            }
        }

        if ($_CONF['jpegtrans_enabled']) {
            if (PHP_OS == "WINNT") {
                $binary = "/jpegtran.exe";
            } else {
                $binary = "/jpegtran";
            }
            clearstatcache();
            if (!@file_exists($_CONF['path_to_jpegtrans'] . $binary)) {
                $data_arr[] = array(
                    'item'   => $LANG_ENVCHECK['jpegtran'],
                    'status' => _getStatusTags($T, 'notok', $LANG_ENVCHECK['not_found']),
                    'notes'  => $LANG_ENVCHECK['jpegtran_not_found'],
                );
            } else {
                $data_arr[] = array(
                    'item'   => $LANG_ENVCHECK['jpegtran'],
                    'status' => _getStatusTags($T, 'yes', $LANG_ENVCHECK['ok']),
                    'notes'  => $LANG_ENVCHECK['jpegtran_ok'],
                );
            }
        }
        */

    } else {
        $data_arr[] = array(
            'item'   => $LANG_ENVCHECK['graphics'],
            'status' => $LANG_ENVCHECK['not_checked'],
            'notes'  => $LANG_ENVCHECK['bypass_note']
        );
    }

    $admin_list = ADMIN_simpleList('', $header_arr, $text_arr, $data_arr);
    $T->set_var('graphics_list', $admin_list);

    // ***********************************************
    // Directory / File Permissions
    $header_arr = array(      // display 'text' and use table field 'field'
        array('text' => $LANG_ENVCHECK['location'], 'field' => 'location'),
        array('text' => $LANG_ENVCHECK['status'],   'field' => 'status')
    );
    $text_arr = array(
        'has_menu' => false,
        'title'    => $LANG_ENVCHECK['filesystem_check'],
        'form_url' => "{$_CONF['site_admin_url']}/envcheck.php"
    );
    $data_arr = array();

    // extract syndication storage path
    $feedpath = $_CONF['rdf_file'];
    $pos = strrpos( $feedpath, '/' );
    $feedPath = substr( $feedpath, 0, $pos + 1 );

    $file_list = array(
        $_CONF['path_data'],
        //$_CONF['path_data'] . 'layout_cache/',
        //$_CONF['path_data'] . 'layout_css/',
        $_CONF['path_log'] . '404.log',
        $_CONF['path_log'] . 'access.log',
        $_CONF['path_log'] . 'error.log',
        $_CONF['path_log'] . 'spamx.log',
        $feedPath,
        $_CONF['rdf_file'],
        $_CONF['path_html'] . 'images/articles/',
        $_CONF['path_html'] . 'images/topics/',
        $_CONF['path_html'] . 'images/userphotos/',
        $_CONF['path_html'] . 'images/library/File/',
        $_CONF['path_html'] . 'images/library/Flash/',
        $_CONF['path_html'] . 'images/library/Image/',
        $_CONF['path_html'] . 'images/library/Image/_thumbs/',
        $_CONF['path_html'] . 'images/library/Image/icons/',
        $_CONF['path_html'] . 'images/library/Media/',
        $_CONF['path_html'] . 'images/_thumbs/',
        $_CONF['path_html'] . 'images/_thumbs/articles/',
        $_CONF['path_html'] . 'images/_thumbs/library/Image/',
        $_CONF['path_html'] . 'images/_thumbs/userphotos/',
        $_CONF['path_html'] . 'filemanager/scripts/filemanager.config.json',
    );

/* For Media Gallery Plugin - left in incase add plugin api checks in future
    $mg_file_list = array(
        $_CONF['path'] . 'plugins/mediagallery/tmp/',
        $_MG_CONF['path_mediaobjects'],
        $_MG_CONF['path_mediaobjects'] . 'covers/',
        $_MG_CONF['path_mediaobjects'] . 'orig/',
        $_MG_CONF['path_mediaobjects'] . 'disp/',
        $_MG_CONF['path_mediaobjects'] . 'tn/',
        $_MG_CONF['path_mediaobjects'] . 'orig/0/',
        $_MG_CONF['path_mediaobjects'] . 'disp/0/',
        $_MG_CONF['path_mediaobjects'] . 'tn/0/',
        $_MG_CONF['path_mediaobjects'] . 'orig/1/',
        $_MG_CONF['path_mediaobjects'] . 'disp/1/',
        $_MG_CONF['path_mediaobjects'] . 'tn/1/',
        $_MG_CONF['path_mediaobjects'] . 'orig/2/',
        $_MG_CONF['path_mediaobjects'] . 'disp/2/',
        $_MG_CONF['path_mediaobjects'] . 'tn/2/',
        $_MG_CONF['path_mediaobjects'] . 'orig/3/',
        $_MG_CONF['path_mediaobjects'] . 'disp/3/',
        $_MG_CONF['path_mediaobjects'] . 'tn/3/',
        $_MG_CONF['path_mediaobjects'] . 'orig/4/',
        $_MG_CONF['path_mediaobjects'] . 'disp/4/',
        $_MG_CONF['path_mediaobjects'] . 'tn/4/',
        $_MG_CONF['path_mediaobjects'] . 'orig/5/',
        $_MG_CONF['path_mediaobjects'] . 'disp/5/',
        $_MG_CONF['path_mediaobjects'] . 'tn/5/',
        $_MG_CONF['path_mediaobjects'] . 'orig/6/',
        $_MG_CONF['path_mediaobjects'] . 'disp/6/',
        $_MG_CONF['path_mediaobjects'] . 'tn/6/',
        $_MG_CONF['path_mediaobjects'] . 'orig/7/',
        $_MG_CONF['path_mediaobjects'] . 'disp/7/',
        $_MG_CONF['path_mediaobjects'] . 'tn/7/',
        $_MG_CONF['path_mediaobjects'] . 'orig/8/',
        $_MG_CONF['path_mediaobjects'] . 'disp/8/',
        $_MG_CONF['path_mediaobjects'] . 'tn/8/',
        $_MG_CONF['path_mediaobjects'] . 'orig/9/',
        $_MG_CONF['path_mediaobjects'] . 'disp/9/',
        $_MG_CONF['path_mediaobjects'] . 'tn/9/',
        $_MG_CONF['path_mediaobjects'] . 'orig/a/',
        $_MG_CONF['path_mediaobjects'] . 'disp/a/',
        $_MG_CONF['path_mediaobjects'] . 'tn/a/',
        $_MG_CONF['path_mediaobjects'] . 'orig/b/',
        $_MG_CONF['path_mediaobjects'] . 'disp/b/',
        $_MG_CONF['path_mediaobjects'] . 'tn/b/',
        $_MG_CONF['path_mediaobjects'] . 'orig/c/',
        $_MG_CONF['path_mediaobjects'] . 'disp/c/',
        $_MG_CONF['path_mediaobjects'] . 'tn/c/',
        $_MG_CONF['path_mediaobjects'] . 'orig/d/',
        $_MG_CONF['path_mediaobjects'] . 'disp/d/',
        $_MG_CONF['path_mediaobjects'] . 'tn/d/',
        $_MG_CONF['path_mediaobjects'] . 'orig/e/',
        $_MG_CONF['path_mediaobjects'] . 'disp/e/',
        $_MG_CONF['path_mediaobjects'] . 'tn/e/',
        $_MG_CONF['path_mediaobjects'] . 'orig/f/',
        $_MG_CONF['path_mediaobjects'] . 'disp/f/',
        $_MG_CONF['path_mediaobjects'] . 'tn/f/',
        $_MG_CONF['path_html'] . 'watermarks/',
    );

    $fm_file_list = array(
        $filemgmt_FileStore,
        $filemgmt_FileStore . 'tmp/',
        $filemgmt_SnapStore,
        $filemgmt_SnapStore . 'tmp/',
        $filemgmt_SnapCat,
        $filemgmt_SnapCat . 'tmp/',
    );

    $forum_file_list = array(
        $_FF_CONF['uploadpath'] . '/',
        $_FF_CONF['uploadpath'] . '/tn/',
    );


    if (in_array('mediagallery', $_PLUGINS)) {
        $file_list = array_merge($file_list, $mg_file_list);
    }
    if (in_array('filemgmt', $_PLUGINS)) {
        $file_list = array_merge($file_list, $fm_file_list);
    }
    if (in_array('forum', $_PLUGINS)) {
        $file_list = array_merge($file_list, $forum_file_list);
    }
*/

    foreach ($file_list as $path) {
        $ok = _isWritable($path);
        if (!$ok) {
            $data_arr[] = array(
                'location' => $path,
                'status'   => _getStatusTags($T, 'notwriteable', $LANG_ENVCHECK['not_writable'])
            );
            $permError = 1;
/* --- debug code ---
        } else {
            $data_arr[] = array(
                'location' => $path,
                'status'   => _getStatusTags($T, 'yes', $LANG_ENVCHECK['ok'])
            );
*/
        }
    }

    foreach (array('layout_cache/', 'layout_css/') as $target) {
        // special test to see if we can create a directory under layout_cache...
        $rc = @mkdir($_CONF['path_data'] . $target . 'test/', 0777, true);
        if (!$rc) {
            $data_arr[] = array(
                'location' => $_CONF['path_data'] . $target,
                'status'   => _getStatusTags($T, 'notwriteable', $LANG_ENVCHECK['unable_mkdir'])
            );
            $permError = 1;
            @rmdir($_CONF['path_data'] . $target . 'test/');
        } else {
            $ok = _isWritable($_CONF['path_data'] . $target . 'test/');
            if (!$ok) {
                $data_arr[] = array(
                    'location' => $_CONF['path_data'] . $target,
                    'status'   => _getStatusTags($T, 'notwriteable', $LANG_ENVCHECK['not_writable'])
                );
                $permError = 1;
            }
            @rmdir($_CONF['path_data'] . $target . 'test/');
        }

        // special test to see if existing cache files exist and are writable...
        $rc = _checkCacheDir($T, $_CONF['path_data'] . $target, $data_arr);
        if ($rc > 0) {
            $permError = 1;
        }
    }

    if (!$permError) {
        $data_arr[] = array(
            'location' => $LANG_ENVCHECK['directory_permissions'],
            'status'   => _getStatusTags($T, 'yes', $LANG_ENVCHECK['ok'])
        );
        $data_arr[] = array(
            'location' => $LANG_ENVCHECK['file_permissions'],
            'status'   => _getStatusTags($T, 'yes', $LANG_ENVCHECK['ok'])
        );
    }

    $admin_list = ADMIN_simpleList('', $header_arr, $text_arr, $data_arr);
    $T->set_var('filesystem_list', $admin_list);

    // ***********************************************
    // Current PHP Settings
    $T->set_var(array(
        'lang_current_php_settings' => $LANG_ENVCHECK['current_php_settings'],
        'lang_showhide_phpinfo'     => $LANG_ENVCHECK['showhide_phpinfo'],
    ));
    
   if (!(isset($_CONF['demo_mode']) && $_CONF['demo_mode'])) {
        _phpinfo($T);
    }
    
    $T->parse('output', 'page');
    $retval .= $T->finish($T->get_var('output'));
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

function _getStatusTags(&$T, $className, $value)
{
    $T->set_var('status_class', $className);
    $T->set_var('status_value', $value);

    return $T->parse('result', 'status');
}

/**
 * Returns the PHP version
 *
 * Note: Removes appendices like 'rc1', etc.
 *
 * @return array the 3 separate parts of the PHP version number
 *
 */
function php_v()
{
    $phpv = explode('.', phpversion());
    return array($phpv[0], $phpv[1], (int) $phpv[2]);
}

/**
 * Check if the user's PHP version is supported by Geeklog
 *
 * @return bool True if supported, false if not supported
 *
 */
function _phpOutOfDate()
{
    // Min PHP Version 5.3.3
    
    $phpv = php_v();
    if (($phpv[0] < 5) || (($phpv[0] == 3) && ($phpv[1] < 3))) {
        return true;
    } else {
        return false;
    }
}

function _isWritable($path)
{
    if ($path{strlen($path)-1} == '/')
        return _isWritable($path . uniqid(mt_rand()) . '.tmp');

    if (@file_exists($path)) {
        if (!($f = @fopen($path, 'r+')))
            return false;
        fclose($f);
        return true;
    }

    if (!($f = @fopen($path, 'w')))
        return false;
    @fclose($f);
    @unlink($path);

    return true;
}

function _return_bytes($val) {
    $val = trim($val);
    $last = strtolower(substr($val, -1));
    $val = (int) substr($val, 0, -1);

    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

function _checkCacheDir(&$T, $path, &$data_arr)
{
    global $LANG_ENVCHECK;

    $permError = 0;

    // special test to see if existing cache files exist and are writable...
    if ($dh = @opendir($path)) {
        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..' || $file == '.svn' || $file == 'index.html') {
                continue;
            }
            if (is_dir($path.$file)) {
                $rc = _checkCacheDir($T, $path . $file . '/', $data_arr);
                if ($rc > 0) {
                    $permError = 1;
                }
            } else {
                $ok = _isWritable($path.$file);
                if (!$ok) {
                    $data_arr[] = array(
                        'location' => $path . $file,
                        'status'   => _getStatusTags($T, 'notwriteable', $LANG_ENVCHECK['not_writable'])
                    );
                    $permError = 1;
                }
            }
        }
        closedir($dh);
    }
    return $permError;
}

function gdVersion($user_ver = 0)
{
    if (!extension_loaded('gd')) {
        return;
    }

    static $gd_ver = 0;

    // Just accept the specified setting if it's 1.
    if ($user_ver == 1) {
        $gd_ver = 1;
        return 1;
    }

    // Use the static variable if function was called previously.
    if ($user_ver !=2 && $gd_ver > 0) {
        return $gd_ver;
    }

    // Use the gd_info() function if possible.
    if (function_exists('gd_info')) {
        $ver_info = gd_info();
        preg_match('/\d/', $ver_info['GD Version'], $match);
        $gd_ver = $match[0];
        return $gd_ver;
    }

   // If phpinfo() is disabled use a specified / fail-safe choice...
   if (preg_match('/phpinfo/', ini_get('disable_functions'))) {
        if ($user_ver == 2) {
            $gd_ver = 2;
        } else {
            $gd_ver = 1;
        }
        return $gd_ver;
    }
    // ...otherwise use phpinfo().
    ob_start();
    phpinfo(8);
    $info = ob_get_contents();
    ob_end_clean();
    $info = stristr($info, 'gd version');
    preg_match('/\d/', $info, $match);
    $gd_ver = $match[0];

    return $gd_ver;
}

function _phpinfo(&$T)
{
    ob_start();
    phpinfo();

    preg_match('%<style type="text/css">(.*?)</style>.*?<body>(.*?)</body>%s', ob_get_clean(), $matches);

    # $matches[1]; # Style information
    # $matches[2]; # Body information

    $idName = "panel_phpinfo";
    $style_array = array_map(
        create_function(
            '$i',
            'return "#' . $idName . ' " . preg_replace("/,/", ",#' . $idName . '", $i);'
        ),
        preg_split('/\n/', trim(preg_replace("/\nbody/", "\n", $matches[1])))
    );
    $style = implode(PHP_EOL, $style_array);

    $content = $matches[2];
    $content = preg_replace('/<font/', '<span', $content);
    $content = preg_replace('/<\/font>/', '</span>', $content);
    $content = preg_replace('/<a name=/', '<a id=', $content);
    $content = preg_replace('/<img border="0"/', '<img ', $content);
    $content = preg_replace('/<h2/', '<h3', $content);
    $content = preg_replace('/<\/h2>/', '</h3>', $content);
    $content = preg_replace('/<h1/', '<h2', $content);
    $content = preg_replace('/<\/h1>/', '</h2>', $content);

    $T->set_var('phpinfo_style', $style);
    $T->set_var('phpinfo_content', $content);
}

$content = _checkEnvironment();
$display = COM_createHTMLDocument($content, array('pagetitle' => $LANG_ENVCHECK['env_check']));
COM_output($display);
