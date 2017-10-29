<?php
/**
*   Geeklog Database Backup Class.
*   Based on the Wordpress wp-db-backup plugin by Austin Matzko
*   http://www.ilfilosofo.com/
*
*   @author     Lee Garner <lee@leegarner.com>
*   @copyright  Copyright (c) 2010-2014 Lee Garner <lee@leegarner.com>
*   @package    lglib
*   @version    0.0.1
*   @license    http://opensource.org/licenses/gpl-2.0.php
*               GNU Public License v2 or later
*   @filesource
*/


/**
*   Class for backup
*   @package lglib
*/
class dbBackup
{
    /** Backup filename, resulting from backup fucntion.  May be false.
    *   @var mixed */
    private $backup_file = '';

    /** Backup filename.  Static, created from configured values.
    *   @var string */
    private $backup_filename;

    /** Flag to indicate whether GZip is to be used.
    *   @var boolean */
    private $gzip = false;

    /** Flag to indicate if the backup is running from cron.
    *   @var boolean */
    private $fromCron = false;

    /** File pointer to backup file
    *   @var mixed */
    private $fp;

    private $tablenames;
    private $exclusions;


    /**
    *   Constructor.
    *   Normally just instantiated.  If it's used from cron, then call
    *   $DB = new dbBackup(true);
    */
    public function __construct($fromCron = false)
    {
        global $_CONF, $_TABLES;

        $this->setGZip(true);
        $this->fromCron = $fromCron ? true : false;
        $this->backup_dir = $_CONF['backup_path'];

    }   // dbBackup()

    /**
    *   Set the backup filename
    *   Intended to be used when running via ajax - the current backup filename
    *   generated with getBackupFilename is stored by the JS and passed to
    *   subsequent calls.
    *
    *   @return none
    */
    public function setBackupFilename($filename)
    {
        $this->backup_filename = $filename;
    }

    /**
    *   Get the backup filename
    *   Generates appropriate filename based on configurations settings
    *
    *   @return string - the filename (no path).
    */
    public function getBackupFilename()
    {
        global $_CONF;

        // Create the backup filename
        $table_prefix = empty($_CONF['dbdump_filename_prefix']) ?
            'geeklog_db_backup_' : $_CONF['dbdump_filename_prefix'] . '_';
        $datum = date("Y_m_d_H_i_s");
        $this->backup_filename = $table_prefix . $datum . '.sql';
        if ($this->gzip) $this->backup_filename .= '.gz';

        return $this->backup_filename;

    }

    /**
    *   Builds the list of tables to backup
    *   Generates the internal array of tables to backup, including only
    *   tables defined in the $_TABLES array and excluding any tables listed
    *   in the exclusion array
    *
    *   @return array - array of table names
    */
    public function getTableList()
    {
        global $_TABLES, $_VARS;

        // Get all tables in the database
        $mysql_tables = array();
        $res = DB_query('SHOW TABLES');
        while ($A = DB_fetchArray($res)) {
            $mysql_tables[] = $A[0];
        }
        // Get only tables that exist and are listed in $_TABLES
        $this->tablenames = array_intersect($mysql_tables, $_TABLES);

        // Get exclusions and remove from backup list
        $this->exclusions = @unserialize($_VARS['_dbback_exclude']);
        if (!is_array($this->exclusions))
            $this->exclusions = array($this->exclusions);
        $this->tablenames = array_diff($this->tablenames, $this->exclusions);

        return $this->tablenames;

    }


    /**
    *   Execute a database backup
    *   Intended to be called from the constructor when requested via url
    *
    *   @return boolean True on success, False on failure
    */
    public function perform_backup()
    {

        $this->getBackupFilename();
        $this->getTableList();

        $this->backup_file = $this->backupDB();
        if (false !== $this->backup_file) {
            $this->Purge();
            return true;
        } else {
            return false;
        }
    }


    /**
    *   Save the time of this backup, if running from cron
    */
    public function save_backup_time()
    {
        global $_TABLES;

        $backup_time = time();
        DB_query("INSERT INTO {$_TABLES['vars']}
                (name, value) VALUES ('db_backup_lastrun', '$backup_time')
                ON DUPLICATE KEY
                    UPDATE value='$backup_time'");
    }


    /**
     * Add backquotes to tables and db-names in
     * SQL queries. Taken from phpMyAdmin.
     */
    private function backquote($a_name)
    {
        if (!empty($a_name) && $a_name != '*') {
            if (is_array($a_name)) {
                $result = array();
                foreach ($a_name as $key => $val) {
                    $result[$key] = '`' . $val . '`';
                }
                return $result;
            } else {
                return '`' . $a_name . '`';
            }
        } else {
            return $a_name;
        }
    }


    /**
    *   Open the backup file for writing, using gzip if appropriate
    *
    *   Note: This function will prepend the backup directory, so only pass
    *         the filename.
    *
    *   @param  string  $filename   Filename to open
    *   @param  string  $mode       File mode, default = write
    */
    public function open($filename, $mode='w')
    {
        if (is_writable($this->backup_dir)) {

            if ($this->gzip)
                $this->fp = @gzopen($this->backup_dir.$filename, $mode);
            else
                $this->fp = @fopen($this->backup_dir.$filename, $mode);

            if(!$this->fp) {
                COM_errorLog('Could not open the backup file for writing! (' .
                    $this->backup_dir . $this->backup_filename . ')');
                return false;
            }
        } else {
            $this->error('The backup directory is not writeable ('.$this->backup_dir.')');
            return false;
        }
        return true;
    }


    /**
    *   Close the backup file
    */
    public function close()
    {
        if ($this->gzip) {
            gzclose($this->fp);
        } else {
            fclose($this->fp);
        }
    }


    /**
     * Write to the backup file
     * @param string $query_line the line to write
     * @return null
     */
    private function stow($query_line)
    {
        if ($this->gzip) {
            if (!@gzwrite($this->fp, $query_line))
                $this->error('There was an error writing a line to the backup script:' . '  ' . $query_line);
        } else {
            if (false === @fwrite($this->fp, $query_line))
                $this->error('There was an error writing a line to the backup script:' . '  ' . $query_line);
        }
    }


    /**
    *   Logs any error messages
    *   @param array $args
    *   @return bool
    */
    private function error($msg)
    {
        $backtrace = debug_backtrace();
        $method = $backtrace[1]['class'].'::'.$backtrace[1]['function'];
        COM_errorLog($method . ' - ' . $msg);
    }


    /**
     * Taken partially from phpMyAdmin and partially from
     * Alain Wolf, Zurich - Switzerland
     * Website: http://restkultur.ch/personal/wolf/scripts/db_backup/

     * Modified by Scott Merrill (http://www.skippy.net/)
     * to use the WordPress $wpdb object
     * @param string $table
     * @return void
     */
    public function backupTable($table, $structonly=false, $start = 0)
    {
        global $_TABLES;

        $recordCounter = $start;
        $timerStart    = time();
        $sessionCounter = 0;
        $timeout        = 30;

        $maxExecutionTime = @ini_get("max_execution_time");
        $timeout = min($maxExecutionTime,30);
        $timeout -= -10; // buffer
        if ( $timeout < 0 ) {
            $timeout = min($maxExecutionTime,30);
        }
        if ( $timeout > 10 ) $timeout = 10;

        // open the backup file in append mode
        if ( $this->open($this->backup_filename,'a') === false ) {
            return array(-2,$sessionCounter, $recordCounter);
        }

        // Save the backquoted table name, gets used a lot
        $db_tablename = $this->backquote($table);

        // Get the table structure
        $res = DB_query("DESCRIBE $table");
        $table_structure = array();
        while ($A =DB_fetchArray($res, false)) {
            $table_structure[] = $A;
        }
        if (empty($table_structure)) {
            $this->error('Error getting table details: ' . $table);
            return array(-2,$sessionCounter, $recordCounter);
        }

        if ( $start == 0 ) {
            // Create the SQL statements
            $this->stow("# --------------------------------------------------------\n");
            $this->stow("# Table: $table\n");
            $this->stow("# --------------------------------------------------------\n");

            // Add SQL statement to drop existing table
            $this->stow("\n\n");
            $this->stow("#\n");
            $this->stow("# Delete any existing table $db_tablename\n");
            $this->stow("#\n");
            $this->stow("\n");
            $this->stow("DROP TABLE IF EXISTS $db_tablename;\n");

            // Table structure
            // Comment in SQL-file
            $this->stow("\n\n");
            $this->stow("#\n");
            $this->stow("# Table structure of table $db_tablename\n");
            $this->stow("#\n");
            $this->stow("\n");

            $res = DB_query("SHOW CREATE TABLE $table");
            if (!$res) {
                $err_msg = 'Error with SHOW CREATE TABLE for ' . $table;
                $this->error($err_msg);
                $this->stow("#\n# $err_msg\n#\n");
            }

            $create_table = DB_fetchArray($res);

            $create_table = str_replace('0000-00-00 00:00:00','1000-01-01 00:00:00.000000',$create_table);

            $this->stow($create_table[1] . ' ;');

            // If only backing up the structure, return now
            if ($structonly) {
                $this->stow("\n");
                $this->stow("\n");
                $this->close();
                return array(0,0,0);
            }
            // Comment in SQL-file
            $this->stow("\n\n");
            $this->stow("#\n");
            $this->stow("# Data contents of table $db_tablename\n");
            $this->stow("#\n");
        }

        $defs = array();
        $ints = array();
        foreach ($table_structure as $struct) {
            if ( (0 === strpos($struct['Type'], 'tinyint')) ||
                    (0 === strpos(strtolower($struct['Type']), 'smallint')) ||
                    (0 === strpos(strtolower($struct['Type']), 'mediumint')) ||
                    (0 === strpos(strtolower($struct['Type']), 'int')) ||
                    (0 === strpos(strtolower($struct['Type']), 'timestamp')) ||
                    (0 === strpos(strtolower($struct['Type']), 'time')) ||
                    (0 === strpos(strtolower($struct['Type']), 'bigint')) ) {
                $defs[strtolower($struct['Field'])] = (null === $struct['Default']) ? 'NULL' : $struct['Default'];
                $ints[strtolower($struct['Field'])] = "1";
            }
        }

        $sql = "SELECT * FROM $table LIMIT 18446744073709551610 OFFSET " . $start;
        $res = DB_query($sql);
        $table_data = array();
        $insert = "INSERT INTO {$db_tablename} VALUES (";

        while ($A = DB_fetchArray($res, false)) {
            //    \x08\\x09, not required
            $search = array("\x00", "\x0a", "\x0d", "\x1a");
            $replace = array('\0', '\n', '\r', '\Z');
            $values = array();
            foreach ($A as $key => $value) {
                if (isset($ints[strtolower($key)]) && $ints[strtolower($key)]) {
                    // make sure there are no blank spots in the insert syntax,
                    // yet try to avoid quotation marks around integers
                    $value = (null === $value || '' === $value) ?
                            $defs[strtolower($key)] : $value;
                    $values[] = ( '' === $value ) ? "''" : $value;
                } else {
                    $values[] = "'" . str_replace($search, $replace, DB_escapeString($value)) . "'";
                }
            }
            $this->stow(" \n" . $insert . implode(', ', $values) . ');');
            $recordCounter++;
            $checkTimer = time();
            $elapsedTime = $checkTimer - $timerStart;
            if ( $elapsedTime > $timeout || $sessionCounter > 10000 ) {
                $this->close();
                return array(1,$sessionCounter, $recordCounter);
            }
            $sessionCounter++;
        }

        // Create footer/closing comment in SQL-file
        $this->stow("\n");
        $this->stow("#\n");
        $this->stow("# End of data contents of table $db_tablename\n");
        $this->stow("# --------------------------------------------------------\n");
        $this->stow("\n");

        $this->close();

        return array(-1,$sessionCounter, $recordCounter);

    }   // end backupTable()


    public function initBackup()
    {
        global $_TABLES, $_CONF, $_DB_host, $_DB_name;

        if ( $this->open($this->backup_filename) === false ) {
            return false;
        }

        //Begin new backup of MySql
        $this->stow("# Geeklog MySQL database backup\n");
        $this->stow("#\n");
        $this->stow('# Generated: ' . date('l j. F Y H:i T') .  "\n");
        $this->stow("# Hostname: $_DB_host\n");
        $this->stow("# Database: $_DB_name\n");
        $this->stow("# --------------------------------------------------------\n");

        $this->close();

        return true;

    }

    /**
    *   Actually performs the backup.
    *   Creates the backup file, saves the file pointer, then cycles
    *   through all the tables and calls backupTable() for each.
    *
    *   @return mixed   False on failure, name of backup file on success.
    */
    private function backupDB()
    {
        global $_TABLES, $_CONF;

        if ( $this->initBackup() === false ) {
            return false;
        }

        foreach ($this->tablenames as $key=>$table) {
            if (isset($_CONF['dbdump_tables_only']) && $_CONF['dbdump_tables_only']) {
                $this->backupTable($table,true);
            } else {
                $this->backupTable($table);
            }
        }

        $this->completeBackup();

        return $this->backup_filename;

    }   // backupDB()

    public function completeBackup()
    {
        if ( $this->open($this->backup_filename,'a') === false ) {
            return false;
        }

        $this->stow("#\n");
        $this->stow("# Database Backup Finished.\n");
        $this->stow("#\n");
        $this->close();

        return true;
    }

    /**
    *   Send an email with attachments.
    *   This is a verbatim copy of COM_mail(), but with the $attachments
    *   paramater added and 3 extra lines of code near the end.
    *
    *   @param  string  $to         Receiver's email address
    *   @param  string  $from       Sender's email address
    *   @param  string  $subject    Message Subject
    *   @param  string  $message    Message Body
    *   @param  boolean $html       True for HTML message, False for Text
    *   @param  integer $priority   Message priority value
    *   @param  string  $cc         Other recipients
    *   @param  string  $altBody    Alt. body (text)
    *   @param  array   $attachments    Array of attachments
    *   @return boolean             True on success, False on Failure
    */
    private function SendMail(
        $to,
        $subject,
        $message,
        $from = '',
        $html = false,
        $priority = 0,
        $cc = '',
        $altBody = '',
        $attachments = array()
    ) {
        $options = array();

        if (!empty($cc)) {
            $options['cc'] = $cc;
        }

        return COM_mail($to, $subject, $message, $from, $html, $priority, $options, $attachments);
    }


    /**
    *   Deliver a backup file.
    *   Originally had the option of "http" or "smtp", but for Geeklog
    *   only "smtp" is needed.  Files can be downloaded at any time via
    *   the backup admin interface.
    */
    private function deliver_backup($filename = '')
    {
        global $_VARS, $_CONF;

        if ($filename == '' || !filename) return false;
        $diskfile = $this->backup_dir . $filename;
        $recipient = $_VARS['_dbback_sendto'];
        if (!file_exists($diskfile)) {
            COM_errorLog("dbBackup: File $diskfile does not exist");
            return false;
        }
        if (!COM_isEmail($recipient)) {
            COM_errorLog("$recipient is not a valid email address");
            return false;
        }
        $message = sprintf("Attached to this email is\n   %s\n   Size:%s kilobytes\n", $filename, round(filesize($diskfile)/1024));
        $status = $this->SendMail(
                $recipient,
                $_CONF['site_name'] . ' ' . 'Database Backup',
                $message, '', false, 0, '', '',
                array($diskfile) );
        return $status;
    }


    /**
    *   Run a backup from cron.
    *   E-mails the backup file to the configured address, if any.
    *
    *   @return boolean Status from deliver_backup, or false on backup failure.
    */
    public function cron_backup()
    {
        $backup_file = $this->backupDB();
        $this->save_backup_time();
        if (false !== $backup_file) {
            $this->Purge();     // Remove old files
            return $this->deliver_backup($backup_file);
        } else {
            return false;
        }
    }


    /**
    *   Determine whether gzip is available, and configured.
    *   Sets $this->gzip to indicate whether gzip should be used.
    *
    *   @param  boolean $val    False to disable, True to enable if available.
    */
    function setGZip($val=true)
    {
        global $_CONF;

        switch ($val) {
        case false:
            $this->gzip = false;
            break;
        case true:
            if (isset($_CONF['dbdump_gzip']) && $_CONF['dbdump_gzip']) {
                $this->gzip = function_exists('gzopen') ? true : false;
            } else {
                $this->gzip = false;
            }
            break;
        }
    }


    /**
    *   Purge old files.
    *   Removes older files, keeping the requested number.
    *
    *   @param  integer $files  Number to keep, 0 to use configured value.
    */
    public function Purge($files = 0)
    {
        global $_CONF;

        if ( !isset($_CONF['dbdump_max_files'])) $_CONF['dbdump_max_files'] = 5;

        if ($files == 0) {
            $files = (int)$_CONF['dbdump_max_files'];
        }
        if ($files == 0) return;

        $backups = array();
        $fd = opendir($this->backup_dir);
        $index = 0;
        while ((false !== ($file = @readdir($fd)))) {
            if ($file <> '.' && $file <> '..' && $file <> 'CVS' &&
                    preg_match('/\.sql(\.gz)?$/i', $file)) {
                $index++;
                clearstatcache();
                $backups[] = $file;
            }
        }

        // Sort ascending by filename, which includes timestamp
        sort($backups);
        $count = count($backups);       // How many we have
        $topurge = $count - $files;     // How many to delete
        if ($topurge <= 0) return;
        for ($i = 0; $i < $topurge; $i++) {
            unlink($this->backup_dir . $backups[$i]);
        }
    }

}   // class dbBackup
