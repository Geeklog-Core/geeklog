<?php

namespace Geeklog;

use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\TwoFactorAuthException;

class TwoFactorAuthentication
{
    // Number of digits of two factor auth code
    const NUM_DIGITS = 6;

    // Number of bits of a secret associated with a user
    const NUM_BITS_OF_SECRET = 160;

    // Image dimensions for QR code
    const QR_CODE_SIZE = 200;

    // Number of digits of each backup code
    const NUM_DIGITS_OF_BACKUP_CODE = 8;

    // Number of backup codes in database
    const NUM_BACKUP_CODES = 10;

    /**
     * Flag to show whether two factor auth is enabled for the current user
     *
     * @var bool
     */
    private $isEnabled = false;

    /**
     * User ID
     *
     * @var int
     */
    private $uid = 0;

    /**
     * @var TwoFactorAuth
     */
    private $tfa;

    /**
     * TwoFactorAuthentication constructor.
     *
     * @param  int $uid User ID
     */
    public function __construct($uid)
    {
        global $_CONF;

        $uid = (int) $uid;
        $this->isEnabled = ($uid > 1) && !COM_isAnonUser() &&
            isset($_CONF['enable_twofactorauth']) && $_CONF['enable_twofactorauth'];

        $this->uid = $uid;
    }

    /**
     * Return if two factor auth is enabled for the current user
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Check if two factor auth is enabled for the current user
     *
     * @throws \LogicException
     */
    private function checkEnabled()
    {
        if (!$this->isEnabled) {
            throw new \LogicException('Two factor auth is disabled for the current user.');
        }
    }

    /**
     * Return the only object of two factor auth class
     *
     * @return TwoFactorAuth
     */
    private function getTFAObject()
    {
        if (empty($this->tfa)) {
            $this->tfa = new TwoFactorAuth('Geeklog', self::NUM_DIGITS);
        }

        return $this->tfa;
    }

    /**
     * Return a secret code associated with the current user
     *
     * @return string
     */
    public function loadSecretFromDatabase()
    {
        global $_TABLES;
        static $secret = null;

        $this->checkEnabled();

        // Check for cached secret
        if ($secret === null) {
            $secret = DB_getItem($_TABLES['users'], 'twofactorauth_secret', "uid = {$this->uid}");
        }

        return $secret;
    }

    /**
     * Create and return a secret
     *
     * @return string
     */
    public function createSecret()
    {
        global $_TABLES;

        $this->checkEnabled();

        try {
            do {
                $secret = $this->getTFAObject()
                    ->createSecret(self::QR_CODE_SIZE);
                $done = (DB_count($_TABLES['users'], 'twofactorauth_secret', DB_escapeString($secret)) == 0);
            } while (!$done);
        } catch (TwoFactorAuthException $e) {
            COM_errorLog(__METHOD__ . ': ' . $e->getMessage());
            $secret = null;
        }

        return $secret;
    }

    /**
     * Save a secret to database
     *
     * @param  string $secret
     * @return bool   true on success, false otherwise
     */
    public function saveSecretToDatabase($secret)
    {
        global $_TABLES;

        $this->checkEnabled();

        if (!empty($secret)) {
            $escapedSecret = DB_escapeString($secret);
            $sql = "UPDATE {$_TABLES['users']} SET twofactorauth_secret = '{$escapedSecret}' "
                . "WHERE (uid = {$this->uid})";
            DB_query($sql);

            return (DB_error() == '');
        } else {
            return false;
        }
    }

    /**
     * Return QR code as a data URI
     *
     * @param  string $secret
     * @param  string $email
     * @return string
     */
    public function getQRCodeImageAsDataURI($secret, $email)
    {
        $this->checkEnabled();

        try {
            return $this->getTFAObject()
                ->getQRCodeImageAsDataUri($email, $secret, self::QR_CODE_SIZE);
        } catch (TwoFactorAuthException $e) {
            return null;
        }
    }

    /**
     * Return backup codes stored in database
     *
     * @return array of string
     */
    public function getBackupCodesFromDatabase()
    {
        global $_TABLES;

        $this->checkEnabled();

        $retval = array();
        $sql = "SELECT code FROM {$_TABLES['backup_codes']} "
            . "WHERE (uid = {$this->uid}) AND (is_used = 0) "
            . "ORDER BY code";
        $result = DB_query($sql);

        if (!DB_error()) {
            while (($A = DB_fetchArray($result, false)) !== false) {
                $retval[] = $A['code'];
            }
        }

        return $retval;
    }

    /**
     * Invalidate all the backup codes in database
     */
    public function invalidateBackupCodes()
    {
        global $_TABLES;

        //$this->checkEnabled();
        $sql = "UPDATE {$_TABLES['backup_codes']} SET is_used = 1 "
            . "WHERE (uid = {$this->uid})";
        DB_query($sql);
    }

    /**
     * Create backup codes and save them into database
     *
     * @return array of string
     * @throws TwoFactorAuthException
     */
    public function createBackupCodes()
    {
        global $_TABLES;

        $this->checkEnabled();

        $this->invalidateBackupCodes();
        $retval = array();
        $tfa = $this->getTFAObject();

        // RobThree\TwoFactorAuth::createSecret uses 5 bits for each byte
        $bitsForBackupCode = self::NUM_DIGITS_OF_BACKUP_CODE * 5;

        for ($i = 0; $i < self::NUM_BACKUP_CODES; $i++) {
            do {
                $code = $tfa->createSecret($bitsForBackupCode);
                $done = (DB_count($_TABLES['backup_codes'], 'code', $code) == 0);
            } while (!$done);

            $escapedCode = DB_escapeString($code);
            $sql = "INSERT INTO {$_TABLES['backup_codes']} (code, uid, is_used) "
                . "VALUES ('{$escapedCode}', {$this->uid}, 0)";
            DB_query($sql);
            $retval[] = $code;
        }

        return $retval;
    }

    /**
     * Authenticate the user
     *
     * @param  string $code
     * @return bool
     */
    public function authenticate($code)
    {
        $this->checkEnabled();

        $code = preg_replace('/[^0-9A-Z]/', '', $code);

        switch (strlen($code)) {
            case self::NUM_DIGITS:
                $code = preg_replace('/[^0-9]/', '', $code);
                $secret = $this->loadSecretFromDatabase();
                $retval = empty($secret)
                    ? false
                    : $this->getTFAObject()->verifyCode($secret, $code);
                break;

            case self::NUM_DIGITS_OF_BACKUP_CODE:
                $retval = $this->authenticateWithBackupCode($code);
                break;

            default:
                $retval = false;
                break;
        }

        return $retval;
    }

    /**
     * Authenticate the user with backup code
     *
     * @param $code
     * @return bool
     */
    public function authenticateWithBackupCode($code)
    {
        global $_TABLES;

        $code = DB_escapeString($code);
        $sql1 = "SELECT is_used FROM {$_TABLES['backup_codes']} "
            . "WHERE (code = '{$code}') AND (uid = {$this->uid})";
        $result = DB_query($sql1);

        if (DB_error() || (DB_numRows($result) == 0)) {
            return false;
        }

        $A = DB_fetchArray($result, false);
        if ($A['is_used'] == 1) {
            // This backup code is already used
            return false;
        }

        // Invalidate the code
        $sql2 = "UPDATE {$_TABLES['backup_codes']} SET is_used = 1 "
            . "WHERE (code = '{$code}') AND (uid = {$this->uid}) ";
        DB_query($sql2);

        return true;
    }
}
