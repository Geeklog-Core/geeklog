<?php

/**
 * File: EditHeader.Admin.class.php
 * This is the Edit HTTP Header Module for the Geeklog Spam-X plugin
 * Copyright (C) 2005-2017 by the following authors:
 * Author    Dirk Haun <dirk AT haun-online DOT de>
 * based on the works of Tom Willett <tomw AT pigstye DOT net>
 * Licensed under GNU General Public License
 *
 * @package    Spam-X
 * @subpackage Modules
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// Include Abstract Base Class
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';

/**
 * HTTP Header Editor
 *
 * @package Spam-X
 */
class EditHeader extends BaseAdmin
{
    public function __construct()
    {
        global $LANG_SX00;

        $this->moduleName = 'HTTPHeader';
        $this->command = 'EditHeader';
        $this->titleText = $LANG_SX00['headerblack'];
        $this->linkText = $LANG_SX00['edit_http_header_blacklist'];
    }

    /**
     * Return HTML widget
     *
     * @return string
     */
    protected function getWidget()
    {
        global $_CONF, $LANG_SX00;

        $template = COM_newTemplate(CTL_plugin_templatePath('spamx'));
        $template->set_file('editheader_widget', 'editheader_widget.thtml');
        $template->set_var('lang_msg_delete', $LANG_SX00['e1']);
        $template->set_var('items_list', $this->getList());
        $template->set_var('lang_msg_add', $LANG_SX00['e2']);
        $template->set_var('spamx_command', $this->command);
        $template->set_var('lang_add_entry', $LANG_SX00['addentry']);
        $template->set_var('gltoken_name', CSRF_TOKEN);
        $this->csrfToken = SEC_createToken();        
        $template->set_var('gltoken', $this->csrfToken);
        
        $display = $template->finish($template->parse('output', 'editheader_widget'));          
        
        return $display;
    }

    /**
     * Return HTML widget
     *
     * @return string
     */
    public function display()
    {
        global $LANG_SX00;

        $action = $this->getAction();
        $entry = $this->getEntry();

        if (($action === 'delete') && SEC_checkToken()) {
            $this->deleteEntry($entry);
        } elseif (($action === $LANG_SX00['addentry']) && SEC_checkToken()) {
            $entry = '';
            $name = Geeklog\Input::fRequest('header-name');
            $n = explode(':', $name);
            $name = $n[0];
            $value = Geeklog\Input::request('header-value');

            if (!empty($name) && !empty($value)) {
                $entry = $name . ': ' . $value;
            }

            $this->addEntry($entry);
        }

        return $this->getWidget();
    }
}
