<?php

/**
 * file:  Import.Admin.class.php
 * MTBlacklist refresh module
 *
 * Updates Sites MT Blacklist via Master MT Blacklist rss feed
 *
 * Copyright (C) 2004-2009 by the following authors:
 * Author      Tom Willett     tomw AT pigstye DOT net
 * Author      Dirk Haun       dirk AT haun-online DOT de
 *
 * Licensed under GNU General Public License
 *
 * Based on MT-Blacklist Updater by
 * Cheah Chu Yeow (http://blog.codefront.net/)
 *
 * @package Spam-X
 * @subpackage Modules
 */

if (strpos(strtolower($_SERVER['PHP_SELF']), 'Import.Admin.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Base Class
*/
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';

/**
* MTBlacklist Import
*
* @package Spam-X
*
*/
class Import extends BaseAdmin {
    /**
     * Constructor
     */
    function display()
    {
        global $_TABLES;

        if (DB_count($_TABLES['spamx'], 'name', 'MTBlacklist') > 0) {
            $display = $this->_update_blacklist();
        } else {
            $display = $this->_initial_import();
        }

        return $display;
    }

    function link()
    {
        global $_TABLES, $LANG_SX00;

        if (DB_count($_TABLES['spamx'], 'name', 'MTBlacklist') > 0) {
            $display = $LANG_SX00['uMTlist'];
        } else {
            $display = $LANG_SX00['initial_import'];
        }

        return $display;
    }

    /**
     * Update MT Blacklist from RSS feed
     */
    function _update_blacklist()
    {
        global $_CONF, $_TABLES, $LANG_SX00, $_SPX_CONF;

        require_once $_CONF['path'] . 'plugins/spamx/magpierss/rss_fetch.inc';
        require_once $_CONF['path'] . 'plugins/spamx/magpierss/rss_utils.inc';

        if (!defined('MAGPIE_USER_AGENT')) {
            define('MAGPIE_USER_AGENT', 'Geeklog/' . VERSION);
        }
        $rss = fetch_rss($_SPX_CONF['rss_url']);
        if ($rss === false) {
            if (strpos($_SPX_CONF['rss_url'], 'jayallen.org') === false) {
                return '<p>An error occured when updating MT Blacklist</p>';
            } else {
                $url = COM_createLink('discontinued', 'http://www.geeklog.net/article.php/mt-blacklist-discontinued');
                return '<p>Please note that MT-Blacklist has been $url and will not be updated any more.</p>';
            }
        }

        // entries to add and delete, according to the blacklist changes feed
        $to_add = array();
        $to_delete = array();

        foreach ($rss->items as $item) {
            // time this entry was published (currently unused)
            // $published_time = parse_w3cdtf( $item['dc']['date'] );
            $entry = substr($item['description'], 0, -3); // blacklist entry
            $subject = $item['dc']['subject']; // indicates addition or deletion

            // is this an addition or a deletion?
            $dbentry = addslashes($entry);
            if (strpos($subject, 'addition') !== false) {
                // save it to database
                $result = DB_query("SELECT name FROM {$_TABLES['spamx']} WHERE name = 'MTBlacklist' AND value = '$dbentry'");
                $nrows = DB_numRows($result);
                if ($nrows < 1) {
                    DB_query("INSERT INTO {$_TABLES['spamx']} VALUES ('MTBlacklist', '$dbentry')");
                    $to_add[] = $entry;
                }
            } else if (strpos($subject, 'deletion') !== false) {
                // delete it from database
                $result = DB_query("SELECT name FROM {$_TABLES['spamx']} WHERE name = 'MTBlacklist' AND value = '$dbentry'");
                $nrows = DB_numRows($result);
                if ($nrows >= 1) {
                    DB_delete($_TABLES['spamx'], array('name', 'value'),
                                                 array('MTBlacklist', $dbentry));
                    $to_delete[] = $entry;
                }
            }
        }
        $display = '<hr' . XHTML . '><p><b>' . $LANG_SX00['entriesadded'] . '</b></p><ul>';
        foreach ($to_add as $e) {
            $display .= "<li>$e</li>";
        }
        $display .= '</ul><p><b>' . $LANG_SX00['entriesdeleted'] . '</b></p><ul>';
        foreach ($to_delete as $e) {
            $display .= "<li>$e</li>";
        }
        $display .= '</ul>';
        SPAMX_log($LANG_SX00['uMTlist'] . $LANG_SX00['uMTlist2'] . count($to_add) . $LANG_SX00['uMTlist3'] . count($to_delete) . $LANG_SX00['entries']);

        return $display;
    }

    /**
     * Initial import of the MT Blacklist
     */
    function _initial_import()
    {
        global $_CONF, $_TABLES, $LANG_SX00, $_SPX_CONF;

        if (ini_get('allow_url_fopen')) {
            $blacklist = file($_SPX_CONF['mtblacklist_url']);
            $count = $this->_do_import($blacklist);

            if ($count > 0) {
                $display = sprintf($LANG_SX00['import_success'], $count);
                SPAMX_log($LANG_SX00['uMTlist'] . $LANG_SX00['uMTlist2']
                          . $count . $LANG_SX00['uMTlist3'] . '0'
                          . $LANG_SX00['entries']);
            } else {
                $display = $LANG_SX00['import_failure'];
            }
        } else { // read blacklist from local file
            $fromfile = $_CONF['path_data'] . 'blacklist.txt';

            if (file_exists($fromfile)) {
                $blacklist = file($fromfile);
                $count = $this->_do_import($blacklist);

                if ($count > 0) {
                    $display = sprintf($LANG_SX00['import_success'], $count);
                    SPAMX_log($LANG_SX00['uMTlist'] . $LANG_SX00['uMTlist2']
                              . $count . $LANG_SX00['uMTlist3'] . '0'
                              . $LANG_SX00['entries']);
                } else {
                    $display = $LANG_SX00['import_failure'];
                }
            } else {
                $display = sprintf($LANG_SX00['allow_url_fopen'],
                        $_CONF['path_data']);
                $display .= '<p>'. COM_createLink($_SPX_CONF['mtblacklist_url'],
                        $_SPX_CONF['mtblacklist_url']);
            }
        }

        // Import Personal Blacklist for existing users.
        $fromfile = $_CONF['path_html'] . 'spamx/blacklist.php';
        if (file_exists($fromfile)) {
            require_once $fromfile;
            $count = $this->_do_importp($SPAMX_BLACKLIST);
            $display .= $LANG_SX00['initial_Pimport'];
            if ($count > 0) {
                $display .= sprintf($LANG_SX00['import_success'], $count);
                SPAMX_log($LANG_SX00['uPlist'] . $LANG_SX00['uMTlist2']
                          . $count . $LANG_SX00['uMTlist3'] . '0'
                          . $LANG_SX00['entries']);
            } else {
                $display .= $LANG_SX00['import_failure'];
            }
        }

        return $display;
    }

    /**
     * Import the blacklist
     *
     * @param array $lines The blacklist
     * @return int number of lines imported
     */
    function _do_import($lines)
    {
        global $_TABLES;

        $count = 0;
        foreach ($lines as $line) {
            $l = explode('#', $line);
            $entry = addslashes(trim($l[0]));
            if (!empty($entry)) {
                DB_query("INSERT INTO {$_TABLES['spamx']} VALUE ('MTBlacklist', '$entry')");
                $count++;
            }
        }

        return $count;
    }

    /**
     * Import personal blacklist
     *
     * @param array $lines The blacklist
     * @return int number of lines imported
     */
    function _do_importp($lines)
    {
        global $_TABLES;

        $count = 0;
        foreach ($lines as $entry) {
            if (!empty($entry)) {
                $entry = addslashes($entry);
                DB_query("INSERT INTO {$_TABLES['spamx']} VALUES ('Personal', '$entry')");
                $count++;
            }
        }

        return $count;
    }
}

?>
