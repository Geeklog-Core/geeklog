<?php

/**
 * Abstract class for Admin Duties for Spam comments
 *
 * @author     Tom Willett  tomw AT pigstye DOT net
 * @package    Spam-X
 * @subpackage Modules
 * @abstract
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
     * @param    string $name
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
        $action = Geeklog\Input::get('action', '');

        if (empty($action)) {
            $action = Geeklog\Input::post('paction', '');

            if (empty($action) && isset($_POST['delbutton_x'], $_POST['delbutton_y'])) {
                $action = 'mass_delete';
            }
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
        $entry = Geeklog\Input::fGet('entry', '');

        if (empty($entry)) {
            $entry = Geeklog\Input::fPost('pentry', '');
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
     * @param    string $entry
     * @param    bool   $spaces
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
     * @param    string $str
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
     * @param    string $fieldName
     * @param    string $fieldValue
     * @param    array  $A
     * @param    array  $iconArr
     * @return   string
     */
    public function fieldFunction($fieldName, $fieldValue, $A, $iconArr)
    {
        global $_CONF;

        $retval = $fieldValue;

        if ($fieldName === 'id') {
            $tcc = COM_newTemplate($_CONF['path_layout'] . 'controls');
            $tcc->set_file('common', 'common.thtml');
            $tcc->set_block('common', 'type-checkbox'); 
            $tcc->set_var('name', 'delitem[]');
            $tcc->set_var('value', $this->escape($fieldValue));
            $retval = $tcc->finish($tcc->parse('common', 'type-checkbox'));               
        } elseif ($fieldName === 'value') {
            $retval = COM_createLink(
                $this->escape($fieldValue),
                $_CONF['site_admin_url'] . '/plugins/spamx/index.php?'
                . http_build_query(array(
                    'command'  => $this->command,
                    'action'   => 'delete',
                    'entry'    => $fieldValue,
                    CSRF_TOKEN => $this->csrfToken,
                ))
            );

        } elseif ($fieldName === 'regdate') {
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
        
        $tcc = COM_newTemplate($_CONF['path_layout'] . 'controls');
        $tcc->set_file('common', 'common.thtml');
        $tcc->set_block('common', 'type-checkbox'); 
        $tcc->set_var('name', 'chk_selectall');
        $tcc->set_var('title', $LANG01[126]);
        $tcc->set_var('onclick', 'caItems(this.form);');
        $select_checkbox = $tcc->finish($tcc->parse('common', 'type-checkbox'));               
        
        $header_arr = array(
            array(
                'text'  => $select_checkbox,
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
                    CSRF_TOKEN => $this->csrfToken,
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

        $filter = '';
        $extra = '';
        $options = '';

        $form_arr = array(
            'bottom' => '<input type="image" name="delbutton" alt="delbutton" src="'
                . $_CONF['layout_url'] . '/images/deleteitem.' . $_IMAGE_TYPE
                . '" title="' . $LANG01[124] . '" onclick="return confirm(\''
                . $LANG01[125] . '\');"' . XHTML . '>',
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
     * @note     this method is overridden in EditHeader class, since it requires
     *           two input fields.
     */
    protected function getWidget()
    {
        global $_CONF, $_TABLES, $LANG_SX00;
        
        $template = COM_newTemplate(CTL_plugin_templatePath('spamx'));
        $template->set_file('baseadmin_widget', 'baseadmin_widget.thtml');
        $template->set_var('lang_msg_delete', $LANG_SX00['e1']);
        $template->set_var('items_list', $this->getList());
        $template->set_var('lang_msg_add', $LANG_SX00['e2']);
        $template->set_var('spamx_command', $this->command);
        $template->set_var('lang_add_entry', $LANG_SX00['addentry']);
        $template->set_var('gltoken_name', CSRF_TOKEN);
        $this->csrfToken = SEC_createToken();        
        $template->set_var('gltoken', $this->csrfToken);
        
        $display = $template->finish($template->parse('output', 'baseadmin_widget'));        

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
        $entry = $this->getEntry();

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
                        $this->deleteSelectedEntries(Geeklog\Input::post('delitem'));
                    }

                    break;
            }
        }

        return $this->getWidget();
    }
}
