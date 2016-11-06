<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | tests.class.php                                                           |
// |                                                                           |
// | Extends PHPUnit interactivity for Geeklog                                   |
// +---------------------------------------------------------------------------+                                                    |
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Sean Clark       - smclark89 AT gmail DOT com                    |
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

class Tests 
{
    /**
    * $_POST data containing names with paths of tests to be run
    *
    */
    public $data;
    
    /**
    * Any errors encountered will be stored here
    *
    */
    public $error=array();    
    
    /*
    * Runs tests, returns console output. Log name is Unix time at time run.
    * @param    array   $data            Test files to run, defaults to $POST
    * @param    int     $JSONresults    Flag if results should be logged to JSON file, default on
    * @param    int     $consoleOutput  Flag if console output should be collected and displayed, default on
    * @param    int     $showLogs          Flag if JSON log should be loaded and displayed after tests are run, default on
    * @return   array   $retval            Formatted PHPUnit console output and JSON results (if requested)
    *
    */
    public function runTests($data = '', $JSONresults = 1, $consoleOutput = 1, $showLogs = 1) { 
        Tst::access(array(2),1);
        $retval = array();        

        $testid = time();
        $today = date("F j, Y, g:i a");
        
        $success = $this->updateMasterLog($testid);        
        $output = array();
        // Test files and collect console output into array

        foreach($data as $k => $file) {
            if($JSONresults == 1) {                
                if(strpos($file, '.php')) {
                    $suffix = '_'.substr($file, strrpos($file, '/')+1, -4);
                } else {
                    $suffix = '_'.substr($file, strrpos($file, '/')+1);
                }
                $switch = '--log-json '.Tst::$tests.'logs/'.$testid.$suffix.'.json ';
            } else {
                $switch = '';
            }
            $output[] = shell_exec('phpunit '.$switch.$file);
        }
 
        if(Tst::access(array(1)) && $consoleOutput == 1) {
            $retval['simple'] = $this->getConsoleOutput($output);
        }
        if(Tst::access(array(1)) && $showLogs == 1) {
            $retval['advanced'] = $this->createTable($this->getJSONResults(1,1,$testid));
        }
        if(!empty($this->error)) {
            $retval['error'] = implode("\n",$this->error);
        }
        return $retval;
    }
    
    /*
    * Collects PHPUnit console output into array
    * @param    array    $output        PHPUnit console output
    * @return   string  $retval        Console output formatted for HTML
    *
    */    
    public function getConsoleOutput($output) {
        $retval = '';
        if(Tst::access(array(1))) {
            foreach($output as $k => $v) {
                $testnum = $k + 1;
                $retval .= '<div class="output"><strong>'.$testnum.'</strong><br /><strong>Results</strong><pre>'.$v.'</pre></div>';
             }
        }            
        return $retval;
    }
    
     /*
    * Parses JSON logs to PHP array
    * @param    string    $test       Test position in log to load (i.e: 1 is last test run),                                                     *    *                                 defaults to 1
    * @param    string    $howMany    How many tests to get results for, defaults to 1
    * @param    string    $testid     (Optional) specific test id to load file for
    * @return   array     $parsedXML  Parsed data from JSON file
    *
    */     
    public function getJSONResults($test = 1, $howMany = 1, $testid = '') {        
        if(Tst::access(array(1,3))) {
            $testentry = array();
            if(empty($testid)) {
                $testentries = $this->readMasterLog($test, $howMany); 
                foreach($testentries as $entry) {
                    $testentry[] = $entry;
                }
            } elseif(!empty($testid)) {
                $testentry['testid'] = $testid;
                $testentry['testtime'] = date("F j, Y, g:i a", $testid);            
            }
            $logs = $this->getFiles($testentry['testid']);
            $parsedJSON = array();
            // We can't use json_decode because of PHPUnit's JSON logging method
            foreach($logs as $log) {
                $file = Tst::$tests.'logs/'.$log;
                $json = file_get_contents($file);
                $ret = true;
                while($ret) {
                    $start = strpos($json, '{');
                    $length = strpos($json, '}')+1;
                    $segment = substr($json, $start, $length);
                    $json = str_replace($segment, '', $json);
                    if(!empty($segment)) {
                        $parsedJSON[] = json_decode($segment, true);
                    } else {
                        $ret = false;
                    }
                }
            }
            // Make into nicely formatted array
            $suites = array();
            foreach($parsedJSON as $test_results) {
                // Get distinct suites into array (i.e: '$suites['calendarclass'] = array(23))
                if($test_results['event'] == 'suiteStart' 
                    && !array_key_exists($test_results['suite'], $suites) 
                    && substr_count($test_results['suite'], 'suite') == 0) {
                    $suites[$test_results['suite']];                    
                } elseif($test_results['event'] == 'test') {
                    // If array is test, put under corresponding suite 
                    // (i.e: $suites['calendarclass'][1] = array(test info))
                    $suites[$test_results['suite']][] = $test_results;
                }
            }
            return $suites;
        }
    }

    /*
    * Creates table from PHP array (parsed JSON)
    * @param    array   $suites    JSON parsed into PHP array                    
    * @return   string  $retval    HTML table showing results
    *
    */
    /*
    * Structured like:
    * $suites => array('calendarClass' => array(23, array(7)( 'event' => 'test',
    *                                                         'suite => 'calendarClass',
    *                                                         'test' => 'test_isRollingModeIsFalse(calendarClass)',
    *                                                         'status' => 'pass',
    *                                                         'time' => 0.00179195404053,
    *                                                         'trace' => array(),
    *                                                         'message' => 'Some message')));
    */
    public function createTable($suites) { 
        if(Tst::access(array(1,3))) {
            $retval = '';
            $info = '';
            $allAnchors = '';
            $allTests = 0;
            $allTime = 0;
            $allFail = 0;
            $allError = 0;
            $allPass = 0;
            // Create tables
            $i=0;
            foreach($suites as $name => $suite) {
                $i++;
                $allAnchors .= '<li><a class="anchor" href="#'.$name.'">'.$name.'</a></li>';
                $retval .= '<table cellspacing="0" class="test_results">
                                  <thead>
                                    <tr>
                                          <th><a name="'.$name.'">'.$name.'</a></th>
                                    </tr>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Status</th>
                                        <th>Time</th>
                                        <th>Message</th>
                                    </tr>
                                  </thead>
                                  <tbody>';
                              
                foreach($suite as $test) {
                    $allTests = $allTests + 1;
                    $allTime = $allTime + $test['time'];
                      static $n = 0;
                      $n++;
                          $retval .= '<tr>
                          <td><div class="width"><strong>'.$n.'</strong> '.wordwrap(
                         substr($test['test'],0,strpos($test['test'],'('.$name.')'))
                         , 47, "<br />\n", true).'</div></td>';
                          if($test['status'] == 'fail') {
                              $allFail = $allFail + 1;
                              $retval .= '<td class="test_fail"/>';
                          } elseif($test['status'] == 'error') {
                              $allError = $allError + 1;
                              $retval .= '<td class="test_error"/>';
                          } else {
                              $allPass = $allPass + 1;
                              $retval .= '<td class="test_pass"/>';
                          }
                          $retval .= '
                          <td>'.$test['time'].'</td>
                          <td>'.wordwrap($test['message'], 47, "<br />\n", true).'</td>
                          </tr>';
                  }
                $retval .= '</tbody></table>';
            }
            $info .= '<div id="about" class="output">
                        <table>
                            <thead>Test information</thead>
                            <tbody>
                                <tr><td class="def">Time</td><td>'.$allTime.'</td></tr>
                                <tr><td class="def">Tests run</td><td>'.$allTests.'</td></tr>
                                <tr><td class="test_pass">Pass</td><td>'.$allPass.'</td></tr>
                                <tr><td class="test_fail">Failures</td><td>'.$allFail.'</td></tr>
                                <tr><td class="test_error">Errors</td><td>'.$allError.'</td></tr>
                        </table>
                    </div>
                    <div id="anchors" class="output">
                        <table>
                            <thead>Test classes</thead>
                            <tbody>
                                <ol> 
                                    '.$allAnchors.'
                                </ol>
                            </tbody>
                        </table>
                    </div>
                    <div id="clear"></div>';
                        
            $retval = $info.$retval;
        }
        
        return $retval;
    }
    
    /*
    * Gets filenames containing prefix
    * @param    int     $prefix      Find files containing this prefix (i.e: testid)
    * @return    array   $ret        Files that had prefix
    *
    */
    public function getFiles($prefix = '') {
        $ret = array();
        if($this->getFileDir('logs', 'dir')) {            
            if($handle = opendir(Tst::$tests.'logs')) {
                // Loop over directory
                while (false !== ($file = readdir($handle))) {
                    if(substr($file, 0, 1) != '.' && $file != 'masterlog.txt') { 
                    // Keep filenames of '.' out
                        if(!empty($prefix) && substr_count($file, $prefix) != 0) {
                            $ret[] = $file;
                        } elseif (empty($prefix)) { // Return all files
                            $ret[] = $file;
                        }
                    }
                }            
                closedir($handle);
            }    
        }
        if(empty($ret)) {
            $this->error[] = 'getFiles: There were no log files to read, possible error running tests. Ensure PHPUnit is functioning correctly, and your folder permissions allow this testpackage and PHPUnit to write logs.';
        }

        return $ret;
    }
    
    /*
    * Checks if directory exists if no directory creates it, 
    * if no file, returns false
    * @param    string    $search    Directory or file to look for
    * @param    string    $type        Type (file or dir) from /testpackage
    * @return   bool      $ret        If directory or file exists or creation was successful
    *
    */
    public function getFileDir($search, $type) {
        $path = Tst::$tests.$search;
        if($type == 'dir') {            
            if(is_dir($path)) {
                $ret = true;
            } else {
                $ret = mkdir($path, 0700);
    
            }                    
        } elseif($type == 'file') {
            $ret = file_exists($path);
        }        
        return $ret;
    }

    /*
    * Updates master log of tests run with last-run test, creates dir and file if not exist
    * @param    int     $testid    Test ID to add to log
    * @param    string  $today    Date to write with test
    * @return   bool    $ret    Whether the update was successful or not
    *
    */
    public function updateMasterLog($testid = '', $today = '') {
        $ret = '';
        if(Tst::access(array(2))) {
            $path = Tst::$tests.'logs/';
            if(empty($testid)) {
                    $testid = time();
                }
            if(empty($today)) {
                $today = date("F j, Y, g:i a");
            }
            if(!is_dir($path)) {
                mkdir($path, 0700);
            }
            $ret = $this->writeMasterLog($path, $testid, $today);
        }
        return $ret;
    }
    
    /*
    * Writes test to master log in format Date, TestId (the result of time())
    * @param     path    Path to masterlog.txt
    * @param    int     $testid    Test ID to add to log
    * @param    string  $today    Date to write with test
    * @return    bool    $ret    If write was successful
    */
    public function writeMasterLog($path, $testid, $today) {
        $ret = '';
        if(Tst::access(array(2))) {
            $file = "masterlog.txt";
            $handle = fopen($path.$file, 'a');
            if(!handle) {
                $this->error[] = 'writeMasterLog: There was a problem opening master log.';
            }
            $entry = "$testid - $today\n";
            $ret = fwrite($handle, $entry);
            fclose($handle);
            $var = $this->readMasterLog();
            if($var[0] == ' - ') {
                exit('There was an error writing to the master log.');
            }
        }
        return $ret;
    }
    
    /*
    * Deletes test logs from masterlog and folder
    * @param    array   $tests        Test ID to add to log
    * @return   bool    $ret        If write was successful
    */
    public function deleteLogs($tests) {
        $ret = '';
        if(Tst::access(array(2))) {
            $file = "masterlog.txt";
            $path = Tst::$tests.'logs/';
            // Read log into array and remove entries selected       
            $entries = file($path.'masterlog.txt', FILE_IGNORE_NEW_LINES);
            
            foreach($tests as $testid) {
                $key = array_search($testid.' - '.date("F j, Y, g:i a", $testid), $entries);
                unset($entries[$key]);
            }
            
            // Write edited array back into log
            $handle = fopen($path.$file, 'w');
            if(!handle) {
                $this->error[] = 'deleteLogs: There was a problem opening masterlog.txt.';
            }
            foreach($entries as $entry) {
                   $string .= $entry."\n";
            }
            $ret = fwrite($handle, $string);
            fclose($handle);
            
            // Remove logs from logs folder
            $logFiles = $this->getFiles();        
            foreach($logFiles as $logFile) {
                foreach($tests as $testid) {
                    if(substr_count($logFile, $testid) != 0) {
                        unlink($path.$logFile);
                    }
                }
            }
        }
        return $ret;
    }
    
    /*
    * Reads master logs into list for GUI
    * @param    int     $offset        Test position to begin returning at
    *                                (defaults to last test in log)
    * @param    int     $howMany    How many tests to return (defaults to 1)
    * @return   array   $ret        Formatted HTML list
    *
    */
    public function displayLogList($offset = 1, $howMany = 1) {
        $ret = array();
        if(Tst::access(array(1))) {
            $logs = array();
            $offset = '-'.$offset;
            if($this->getFileDir('logs', 'dir')) {
                // Creates masterlog.txt if not exist
                if($this->getFileDir('logs/masterlog.txt', 'file') == false) {
                    fclose(fopen(Tst::$tests.'logs/masterlog.txt',"x"));
                }
                
                $logs = $this->readMasterLog($offset, $howMany);
                    
                foreach($logs as $test) {
                    if($test['testid']) {
                        $ret[] = '<li><input id=\'logs\' type=\'checkbox\' name=\'logs[]\' 
                        value=\''.$test['testid'].'\'>'.$test['testtime'].'</li>';
                    }            
                }
                
                if(empty($ret)) {
                    $ret[] = '<i>There are no logs to display.</i>';
                }
            } else {
                $this->error[] = '<i>displayLogList: There was a problem creating directory or masterlog.txt.</i>';
            }
        }
        return $ret;
    }
    
    /*
    * Reads and returns test information from master log. Can return by position, or
    * return by testid.
    * @param    int     $offset        Which test to return (defaults to last test in log)
    * @param    int     $howMany       How many tests to return (defaults to 1)
    * @return   array   $ret           Array of tests (testID and time run)
    *
    */
    public function readMasterLog($offset = 1, $howMany = 1) {
        $ret = array();
        if(Tst::access(array(1))) {
            $path = Tst::$tests.'logs/';        
            $arr = file($path.'masterlog.txt', FILE_IGNORE_NEW_LINES);
            $arrSize = count($arr);
            $i = 0;
            while($i < $howMany && $i < $arrSize) {
                $test = array_slice($arr, $offset - $i);
                $testid = substr($test[0], 0, 10);
                   $ret[] = array(
                    'testid' => $testid,
                    'testtime' => date("F j, Y, g:i a", $testid));
                $i++;
            }
        }
        return $ret;        
    }    
}

?>
