<?php

/**
 * Abstract class for Admin Duties for Spam comments
 * 
 * @author Tom Willett	tomw AT pigstye DOT net 
 *
 * @package Spam-X
 * @subpackage Modules
 * @abstract
 *
 */
abstract class BaseAdmin
{
    protected $moduleName;
    protected $command;
    protected $titleText;
    protected $linkText;
    protected $csrfToken;

    /**
    * Getter method for protected properties
    *
    * @param    string    $name
    * @return   string
    */
    public function __get($name)
    {
        if (in_array($name, array('moduleName', 'command', 'titleText', 'linkText'))) {
            return $this->$name;
        } else {
            return null;
        }
    }

    /**
    * Returns the action the user posted
    *
    * @return    string
    */
    protected function getAction()
    {
        $action = '';

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else if (isset($_POST['paction'])) {
            $action = $_POST['paction'];
        } else if (isset($_POST['delbutton_x']) && isset($_POST['delbutton_y'])) {
            $action = 'mass_delete';
        }

        return $action;
    }

    /**
    * Returns the entry the user posted
    *
    * @return    string
    */
    protected function getEntry()
    {
        $entry = '';

        if (isset($_GET['entry'])) {
            $entry = COM_stripslashes($_GET['entry']);
        } elseif (isset($_POST['pentry'])) {
            $entry = COM_stripslashes($_POST['pentry']);
        }

        return $entry;
    }

    /**
    * Removes an entry from database
    *
    * @return    boolean    true = success, false = otherwise
    */
    protected function deleteEntry($entry)
    {
        global $_TABLES;

        $retval = true;

        if (!empty($entry)) {
            $entry = DB_escapeString($entry);
            $retval = DB_query("DELETE FROM {$_TABLES['spamx']} WHERE (name ='{$this->moduleName}' AND value = '{$entry}')");
        }

        return $retval;
    }

    /**
    * Removes all entries the user selected from database
    *
    * @return    boolean    true = success, false = otherwise
    */
    protected function deleteSelectedEntries(array $entries)
    {
        $retval = true;

        if (count($entries) > 0) {
            foreach ($entries as $entry) {
                $retval = $retval && $this->deleteEntry($entry);
            }
        }

        return $retval;
    }

    /**
    * Adds an entry to database
    *
    * @param    string    $entry
    * @param    string    $spaces
    * @return   boolean   true = success, false = otherwise
    */
    protected function addEntry($entry, $spaces = false)
    {
        global $_TABLES;

        $retval = true;

        if (!empty($entry)) {
            if (!$spaces) {
                $entry = str_replace(' ', '', $entry);
            }
            $entry = DB_escapeString($entry);
            $count = DB_getItem(
                $_TABLES['spamx'],
                "COUNT(*)",
                "name ='" . DB_escapeString($this->moduleName)
                    . "' AND value = '" . $entry . "'"
            );

            // Lets the user add a unique record only
            if ($count == 0) {
                $timestamp = DB_escapeString(date('Y-m-d H:i:s'));
                $retval = DB_query("INSERT INTO {$_TABLES['spamx']} VALUES ('{$this->moduleName}', '{$entry}', 0, '$timestamp')");
            }
        }

        return $retval;
    }

    /**
    * Escapes a string so as to be safely displayed
    *
    * @param    string    $str
    * @return   string
    */
    public function escape($str)
    {
        static $charset = null;

        if ($charset === null) {
            $charset = COM_getCharset();
        }

        return htmlspecialchars($str, ENT_QUOTES, $charset);
    }

    /**
    * Callback function for ADMIN_list
    *
    * @param    string    $fieldName
    * @param    string    $fieldValue
    * @param    array     $A
    * @param    array     $iconArr
    * @return   string
    */
    public function fieldFunction($fieldName, $fieldValue, $A, $iconArr)
    {
        global $_CONF;

        $retval = $fieldValue;

        if ($fieldName === 'id') {
            $retval = '<input type="checkbox" name="delitem[]" value="'
                    . $this->escape($fieldValue) . '"' . XHTML . '>';
        } else if ($fieldName === 'value') {
            $retval = COM_createLink(
                $this->escape($fieldValue),
                $_CONF['site_admin_url'] . '/plugins/spamx/index.php?'
                . http_build_query(array(
                    'command'  => $this->command,
                    'action'   => 'delete',
                    'entry'    => $fieldValue,
                    CSRF_TOKEN => $this->csrfToken
                ))
            );

        } else if ($fieldName === 'regdate') {
            // Does nothing for now
        }

        return $retval;
    }

    /**
    * Returns a list of data
    *
    * @return   string
    */
    protected function getList()
    {
        global $_CONF, $_TABLES, $_IMAGE_TYPE, $LANG01, $LANG33, $LANG_SX00;

        $fieldfunction = array($this, 'fieldFunction');
        $header_arr = array(
            array(
                'text'  => '<input type="checkbox" name="chk_selectall" title="' . $LANG01[126] . '" onclick="caItems(this.form);"' . XHTML . '>',
                'field' => 'id',
                'sort'  => false,
            ),
            array(
                'text'  => $LANG_SX00['value'],
                'field' => 'value',
                'sort'  => true,
            ),
            array(
                'text'  => $LANG_SX00['counter'],
                'field' => 'counter',
                'sort'  => true,
            ),
            array(
                'text'  => $LANG33[30],
                'field' => 'regdate',
                'sort'  => true,
            ),
        );

        $text_arr = array(
            'form_url'   => $_CONF['site_admin_url'] . '/plugins/spamx/index.php?'
                . http_build_query(array(
                    'command'  => $this->command,
                    CSRF_TOKEN => $this->csrfToken
                )),
            'has_extras' => true,
            'title'      => $this->titleText,
        );

        $query_arr = array(
            'sql'          => "SELECT value AS id, value, counter, regdate FROM {$_TABLES['spamx']} WHERE (name = '{$this->moduleName}') ",
            'query_fields' => array('value', 'counter', 'regdate'),
        );

        $defsort_arr = array(
            'field'     => 'regdate',
            'direction' => 'DESC',
        );

        $filter  = '';
        $extra   = '';
        $options = '';

        $form_arr = array(
            'bottom' => '<input type="image" name="delbutton" alt="delbutton" src="'
                . $_CONF['layout_url'] . '/images/deleteitem.' . $_IMAGE_TYPE
                . '" title="' . $LANG01[124] . '" onclick="return confirm(\''
                . $LANG01[125] . '\');"' . XHTML . '>'
        );

        $showsearch = true;
        $pagenavurl = '';

        return ADMIN_list('Spam-X', $fieldfunction, $header_arr, $text_arr,
            $query_arr, $defsort_arr, $filter, $extra, $options, $form_arr,
            $showsearch, $pagenavurl);
    }

    /**
    * Returns a widget to be displayed for each command
    *
    * @return   string
    * @note     this method is overriden in EditHeader class, since it requires
    *           two input fields.
    */
    protected function getWidget()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $this->csrfToken = SEC_createToken();
        $display = '<hr' . XHTML . '>' . LB
                 . '<p>' . $LANG_SX00['e1'] . '</p>' . LB
                 . $this->getList()
                 . '<p>' . $LANG_SX00['e2'] . '</p>' . LB
                 . '<form method="post" action="' . $_CONF['site_admin_url']
                 . '/plugins/spamx/index.php?command=' . $this->command . '">' . LB
                 . '<div><input type="text" size="31" name="pentry"' . XHTML
                 . '>&nbsp;&nbsp;&nbsp;'
                 . '<input type="submit" name="paction" value="'
                 . $LANG_SX00['addentry'] . '"' . XHTML . '>' . LB
                 . '<input type="hidden" name="' . CSRF_TOKEN
                 . '" value="' . $this->csrfToken . '"' . XHTML . '>' . LB
                 . '</div></form>' . LB;

        return $display;
    }

    /**
    * Public interface for executing a command and showing data
    *
    * @return   string
    */
    public function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $action = $this->getAction();
        $entry  = $this->getEntry();

        if (!empty($action) && SEC_checkToken()) {
            switch ($action) {
                case 'delete':
                    $this->deleteEntry($entry);
                    break;

                case $LANG_SX00['addentry']:
                    $this->addEntry($entry);
                    break;

                case 'mass_delete':
                    if (isset($_POST['delitem'])) {
                        $this->deleteSelectedEntries($_POST['delitem']);
                    }

                    break;
            }
        }

        return $this->getWidget();
    }
}

?>
