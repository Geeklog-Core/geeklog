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

    protected function getAction()
    {
        $action = '';

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } elseif (isset($_POST['paction'])) {
            $action = $_POST['paction'];
        }

        return $action;
    }

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

    protected function deleteEntry($entry)
    {
        global $_TABLES;

        if (!empty($entry)) {
            $entry = DB_escapeString($entry);
            DB_query("DELETE FROM {$_TABLES['spamx']} WHERE (name ='{$this->moduleName}' AND value = '{$entry}') LIMIT 1");
        }
    }

    protected function addEntry($entry)
    {
        global $_TABLES;

        if (!empty($entry)) {
            $entry  = str_replace(' ', '', $entry);
            $entry  = DB_escapeString($entry);
            DB_query("INSERT INTO {$_TABLES['spamx']} VALUES ('{$this->moduleName}', '{$entry}', 0)");
        }
    }

    protected function getList($csrfToken)
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $result = DB_query("SELECT value, counter FROM {$_TABLES['spamx']} WHERE (name = '{$this->moduleName}') ORDER BY value");
        $nrows = DB_numRows($result);
        $header_arr = array(
            array(
                'text'  => $LANG_SX00['value'],
                'field' => 'value'
            ),
            array(
                'text'  => $LANG_SX00['counter'],
                'field' => 'count'
            )
        );
        $data_arr = array();

        for ($i = 0; $i < $nrows; $i++) {
            list($e, $c) = DB_fetchArray($result);
            $link = COM_createLink(
                htmlspecialchars($e),
                $_CONF['site_admin_url'] . '/plugins/spamx/index.php?'
                . http_build_query(array(
                    'command'  => $this->command,
                    'action'   => 'delete',
                    'entry'    => $e,
                    CSRF_TOKEN => $csrfToken
                ))
            );
            $data_arr[] = array(
                'value' => $link,
                'count' => ' ' . $c
            );
        }

        return ADMIN_simpleList($fieldfunction, $header_arr, $text_arr, $data_arr, $menu_arr, $options, $form_arr);
    }

    protected function getWidget()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $token = SEC_createToken();
        $display = '<hr' . XHTML . '>' . LB
                 . '<p><b>' . $this->titleText . '</b></p>' . LB
                 . '<p>' . $LANG_SX00['e1'] . '</p>' . LB
                 . $this->getList($token)
                 . '<p>' . $LANG_SX00['e2'] . '</p>' . LB
                 . '<form method="post" action="' . $_CONF['site_admin_url']
                 . '/plugins/spamx/index.php?command=' . $this->command . '">' . LB
                 . '<div><input type="text" size="31" name="pentry"' . XHTML
                 . '>&nbsp;&nbsp;&nbsp;'
                 . '<input type="submit" name="paction" value="'
                 . $LANG_SX00['addentry'] . '"' . XHTML . '>' . LB
                 . '<input type="hidden" name="' . CSRF_TOKEN
                 . '" value="' . $token . '"' . XHTML . '>' . LB
                 . '</div></form>' . LB;

        return $display;
    }

    public function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $action = $this->getAction();
        $entry  = $this->getEntry();

        if (($action === 'delete') && SEC_checkToken()) {
            $this->deleteEntry($entry);
        } else if (($action === $LANG_SX00['addentry']) && SEC_checkToken()) {
            $this->addEntry($entry);
        }

        return $this->getWidget();
    }

    public function link()
    {
        return $this->linkText;
    }
}

?>
