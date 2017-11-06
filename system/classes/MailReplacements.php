<?php

namespace Geeklog;

/**
 * Class MailReplacements
 *
 * @package Geeklog
 */
class MailReplacements implements \Swift_Plugins_Decorator_Replacements
{
    /**
     * Return replacements for a given email address
     *
     * @param  string $address
     * @return array
     */
    public function getReplacementsFor($address)
    {
        global $_CONF, $_TABLES;

        $retval = array();
        $address = DB_escapeString($address);
        $sql = <<<SQL
          SELECT u.*, i.location, i.lastgranted, i.lastlogin FROM {$_TABLES['users']} AS u 
            LEFT JOIN {$_TABLES['userinfo']} AS i 
              ON u.uid = i.uid
            WHERE u.email = '{$address}' 
SQL;
        $resultSet = DB_query($sql);

        if (!DB_error()) {
            $A = DB_fetchArray($resultSet, false);

            if (is_array($A) && (count($A) > 0)) {
                $retval = array(
                    // From DB
                    '{uid}'           => $A['uid'],
                    '{username}'      => $A['username'],
                    '{fullname}'      => $A['fullname'],
                    '{email}'         => $A['email'],
                    '{homepage}'      => $A['homepage'],
                    '{theme}'         => $A['theme'],
                    '{language}'      => $A['language'],
                    '{location}'      => $A['location'],
                    '{lastgranted}'   => $A['lastgranted'],
                    '{lastlogin}'     => $A['lastlogin'],

                    // From $_CONF
                    '{site_url}'      => $_CONF['site_url'],
                    '{site_name}'     => $_CONF['site_name'],
                    '{site_slogan}'   => $_CONF['site_slogan'],
                    '{owner_name}'    => $_CONF['owner_name'],
                    '{copyrightyear}' => (isset($_CONF['copyrightyear']) ? $_CONF['copyrightyear'] : date('Y')),
                    '{site_mail}'     => $_CONF['site_mail'],
                    '{noreply_mail}'  => $_CONF['noreply_mail'],
                );
            }
        }

        return $retval;
    }
}
