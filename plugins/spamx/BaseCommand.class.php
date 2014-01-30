<?php

/**
 * Basic Command Abstract class
 * 
 * @author Tom Willett	tomw AT pigstye DOT net 
 *
 * @package Spam-X
 * @subpackage Modules
 *
 */
abstract class BaseCommand
{
    protected $result     = PLG_SPAM_ACTION_NONE;	// Result of execute command
    protected $actionCode = PLG_SPAM_ACTION_NONE;	// Action code

    abstract public function execute($comment);

    /**
    * Returns one of the result codes defined in "lib-plugins.php"
    *
    * @return    int
    */
    public function getResult()
    {
        return $this->result;
    }

    /**
    * Returns one of the action codes defined in "lib-plugins.php"
    *
    * @return    int
    */
    public function getActionCode()
    {
        return $this->actionCode;
    }

    /**
    * Returns the id of the current user
    *
    * @return    int
    */
    protected function getUid()
    {
        global $_USER;

        if (isset($_USER['uid']) && ($_USER['uid'] > 1)) {
            $uid = (int) $_USER['uid'];
        } else {
            $uid = 1;
        }

        return $uid;
    }

    /**
    * Disables a specified user
    *
    * @param    int    $uid
    **/
    protected function disableUser($uid)
    {
        global $_TABLES, $_USER;

        $this->result = PLG_SPAM_ACTION_DELETE;
        DB_change($_TABLES['users'], 'status', USER_ACCOUNT_DISABLED,
                  'uid', $uid);
        SPAMX_log("User {$_USER['username']} banned for profile spam.");
    }

    /**
    * Updates statistics of an spamx entry
    *
    * @param    string    $name    plugin name
    * @param    string    $value   data
    **/
    protected function updateStat($name, $value)
    {
        global $_TABLES;

        $name      = DB_escapeString($name);
        $value     = DB_escapeString($value);
        $timestamp = DB_escapeString(date('Y-m-d H:i:s'));

        $sql = "UPDATE {$_TABLES['spamx']} "
             . "SET counter = counter + 1, regdate = '{$timestamp}' "
             . "WHERE name='{$name}' AND value='{$value}' ";
        DB_query($sql, 1);
    }
}

?>
