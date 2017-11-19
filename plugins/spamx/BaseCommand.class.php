<?php

/**
 * Basic Command Abstract class
 *
 * @author     Tom Willett  tomw AT pigstye DOT net
 * @package    Spam-X
 * @subpackage Modules
 */
abstract class BaseCommand
{
    const REGX_DELIMITER = '#';

    protected $result = PLG_SPAM_ACTION_NONE;   // Result of execute command
    protected $actionCode = PLG_SPAM_ACTION_NONE;   // Action code

    /**
     * Callback function to change a string of decimals into a character
     *
     * @param  string $str
     * @return string
     */
    protected function callbackDecimal($str)
    {
        return chr($str);
    }

    /**
     * Callback function to change a string of hexes into a character
     *
     * @param  string $str
     * @return string
     */
    protected function callbackHex($str)
    {
        return chr('0x' . $str);
    }

    /**
     * Here we do the work
     *
     * @param  string $comment
     * @param  string $permanentLink (since GL 2.2.0)
     * @param  string $commentType (since GL 2.2.0)
     * @param  string $commentAuthor (since GL 2.2.0)
     * @param  string $commentAuthorEmail (since GL 2.2.0)
     * @param  string $commentAuthorURL (since GL 2.2.0)
     * @return int    either PLG_SPAM_NOT_FOUND, PLG_SPAM_FOUND or PLG_SPAM_UNSURE
     * @note As for valid value for $commentType, see system/classes/Akismet.php
     */
    abstract public function execute(
        $comment, $permanentLink, $commentType = Geeklog\Akismet::COMMENT_TYPE_COMMENT,
                                     $commentAuthor = null, $commentAuthorEmail = null, $commentAuthorURL = null);

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
     * @param    int $uid
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
     * @param    string $name  plugin name
     * @param    string $value data
     **/
    protected function updateStat($name, $value)
    {
        global $_TABLES;

        $name = DB_escapeString($name);
        $value = DB_escapeString($value);
        $timestamp = DB_escapeString(date('Y-m-d H:i:s'));

        $sql = "UPDATE {$_TABLES['spamx']} "
            . "SET counter = counter + 1, regdate = '{$timestamp}' "
            . "WHERE name='{$name}' AND value='{$value}' ";
        DB_query($sql, 1);
    }

    /**
     * Prepare regular expression
     *
     * @param  string $str
     * @param  string $delimiter
     * @param  bool   $caseSensitive
     * @return string
     */
    protected function prepareRegularExpression($str, $delimiter = self::REGX_DELIMITER, $caseSensitive = false)
    {
        $str = preg_quote($str, $delimiter);
        $str = $delimiter . $str . $delimiter;

        if (!$caseSensitive) {
            $str .= 'i';
        }

        return $str;
    }
}
