<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | language.class.php                                                        |
// |                                                                           |
// | Geeklog language administration page.                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2019      by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO         - mystralkk AT gmail DOT come                  |
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

use Geeklog\Input;

/**
 * Class Language
 */
class Language
{
    // The lifespan of a security token in seconds
    const SEC_TOKEN_LIFESPAN = 1200; // 20 * 60

    /**
     * @var bool
     */
    private static $isInitialized = false;

    /**
     * @var array of ['id', 'var_name', 'language', 'name', 'Value']
     */
    private static $data = array();

    /**
     * Initialize the Language class
     */
    public static function init()
    {
        global $_TABLES;

        if (self::$isInitialized) {
            return;
        }

        // Cache data in database into memory
        $sql = "SELECT * FROM {$_TABLES['language_items']} ORDER BY id";
        $result = DB_query($sql);

        if (!DB_error()) {
            while (($A = DB_fetchArray($result, false)) !== false) {
                if (!array_key_exists($A['var_name'], self::$data)) {
                    self::$data[$A['var_name']] = array();
                }
                if (!array_key_exists($A['language'], self::$data[$A['var_name']])) {
                    self::$data[$A['var_name']][$A['language']] = array();
                }

                self::$data[$A['var_name']][$A['language']][$A['name']] = $A['value'];
            }
        }

        self::$isInitialized = true;
    }

    /**
     * Apply overrides to the given language arrays
     *
     * This method should be called just after you have included a language file
     *
     * @param array $varNames
     */
    public static function override(array $varNames)
    {
        $language = COM_getLanguage();

        foreach ($varNames as $varName) {
            if (!isset($GLOBALS[$varName])) {
                continue;
            } else {
                $varIsArray = is_array($GLOBALS[$varName]);
            }

            if (isset(self::$data[$varName], self::$data[$varName][$language])) {
                if ($varIsArray) {
                    foreach (self::$data[$varName][$language] as $name => $value) {
                        $GLOBALS[$varName][$name] = $value;
                    }
                } else {
                    $GLOBALS[$varName] = self::$data[$varName][$language][$varName];
                }
            }
        }
    }

    /**
     * Check for access rights
     */
    public static function checkAccessRights()
    {
        global $MESSAGE, $_USER;

        if (!SEC_hasRights('language.edit')) {
            $content = COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
            $display = COM_createHTMLDocument($content, array('pagetitle' => $MESSAGE[30]));
            COM_accessLog("User {$_USER['username']} tried to illegally access the language administration screen.");
            COM_output($display);
            exit;
        }
    }

    /**
     * Check security token
     */
    private static function checkSecurityToken()
    {
        global $_CONF, $_USER;

        if (!SEC_checkToken()) {
            $uid = $_USER['uid'];
            COM_accessLog("User {$_USER['username']} tried to illegally delete user {$uid} and failed CSRF checks.");
            COM_redirect($_CONF['site_admin_url'] . '/index.php');
        }
    }

    /**
     * Return an array of an empty record
     *
     * @return array
     */
    private static function getEmptyRecord()
    {
        return array(
            'id'       => 0,
            'var_name' => '',
            'language' => COM_getLanguage(),
            'name'     => '',
            'value'    => '',
        );
    }

    /**
     * Show editor
     *
     * @param array $A
     */
    public static function adminShowEditor(array $A = array())
    {
        global $_CONF, $LANG_ADMIN, $LANG_LANG, $MESSAGE, $_TABLES;

        self::checkAccessRights();

        $id = Input::fGet('id', Input::fPost('id', 0));
        $id = intval($id, 10);

        if ($id < 1) {
            $id = 0;
        }

        if ($id === 0) {
            $A = self::getEmptyRecord();
        } elseif (count($A) === 0) {
            $sql = "SELECT * FROM {$_TABLES['language_items']} WHERE id = {$id} ";
            $resultSet = DB_query($sql);

            if (DB_numRows($resultSet) == 1) {
                $A = DB_fetchArray($resultSet, false);
            } else {
                $id = 0;
                $A = self::getEmptyRecord();
            }
        } else {
            $id = $A['id'];
        }

        // Get UI language options
        $languageOptions = '';
        $currentLanguage = COM_getLanguage();

        foreach (glob($_CONF['path_language'] . '*.php') as $language) {
            $language = basename($language);
            $language = str_replace('.php', '', $language);
            $isCurrent = ($language === $currentLanguage) ? ' selected="selected"' : '';
            $languageOptions .= "<option{$isCurrent}>{$language}</option>" . PHP_EOL;
        }

        $isNew = ($id === 0);
        $allow_delete = !$isNew;

        $token = SEC_createToken(self::SEC_TOKEN_LIFESPAN);
        $content = COM_startBlock(
            $LANG_LANG['language_editor'], '', COM_getBlockTemplate('_admin_block', 'header')
        );
        $content .= SEC_getTokenExpiryNotice($token);

        $editor = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/language'));
        $editor->set_file('language_editor', 'language_editor.thtml');
        $editor->set_var(array(
            'id'                   => $A['id'],
            'id_to_display'        => ($isNew ? 'N/A' : $A['id']),
            'var_name'             => $A['var_name'],
            'language'             => $A['language'],
            'language_options'     => $languageOptions,
            'name'                 => $A['name'],
            'value'                => $A['value'],
            'site_admin_url'       => $_CONF['site_admin_url'],
            'allow_delete'         => $allow_delete,
            'lang_language_editor' => $LANG_LANG['language_editor'],
            'lang_id'              => $LANG_LANG['id'],
            'lang_var_name'        => $LANG_LANG['var_name'],
            'lang_var_name_tip'    => COM_getTooltip('', $LANG_LANG['var_name_tip'], '', 'help'),
            'lang_language'        => $LANG_LANG['language'],
            'lang_name'            => $LANG_LANG['name'],
            'lang_name_tip'        => COM_getTooltip('', $LANG_LANG['name_tip'], '', 'help'),
            'lang_value'           => $LANG_LANG['value'],
            'lang_save'            => $LANG_ADMIN['save'],
            'lang_delete'          => $LANG_ADMIN['delete'],
            'lang_cancel'          => $LANG_ADMIN['cancel'],
            'confirm_message'      => $MESSAGE[76],
            'token_name'           => CSRF_TOKEN,
            'token_value'          => $token,
        ));

        $editor->parse('output', 'language_editor');
        $content .= $editor->finish($editor->get_var('output'));
        $content .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
        $display = COM_createHTMLDocument($content, array('pagetitle' => 'Language Items'));
        COM_output($display);
    }

    /**
     * Field function for self::adminShowList
     *
     * @param  string $fieldName
     * @param  mixed  $fieldValue
     * @param  array  $A
     * @param  array  $icons
     * @return mixed
     */
    public static function fieldFunction($fieldName, $fieldValue, array $A, array $icons)
    {
        global $_CONF, $LANG_ADMIN;

        switch ($fieldName) {
            case 'id':
                $fieldValue = '<a href="'
                    . $_CONF['site_admin_url'] . '/language.php?mode=edit&amp;id='
                    . $fieldValue . '" title="' . $LANG_ADMIN['edit'] . '">' . $icons['edit'] . '</a>';
                break;    
                
            case 'value':
                $fieldValue = COM_truncate(htmlspecialchars($fieldValue), 50, '...');
                break;
        }

        return $fieldValue;
    }

    /**
     * Show a list of language items
     */
    public static function adminShowList()
    {
        global $_CONF, $_IMAGE_TYPE, $LANG_ADMIN, $LANG_LANG, $_TABLES;

        self::checkAccessRights();

        $menuArray = array(
            array(
                'url'  => $_CONF['site_admin_url'] . '/language.php?mode=edit&amp;id=0',
                'text' => $LANG_ADMIN['create_new'],
            ),
            array(
                'url'  => $_CONF['site_admin_url'],
                'text' => $LANG_ADMIN['admin_home'],
            ),
        );

        $content = COM_startBlock(
            $LANG_LANG['language_manager'], '', COM_getBlockTemplate('_admin_block', 'header')
        );
        $content .= ADMIN_createMenu(
            $menuArray,
            $LANG_LANG['new_language_msg'],
            $_CONF['layout_url'] . '/images/icons/language.' . $_IMAGE_TYPE
        );
        $content .= COM_showMessageFromParameter();

        $headerArray = array(
            array(
                'text'  => $LANG_ADMIN['edit'],
                'sort'  => true,
                'field' => 'id',
            ),
            array(
                'text'  => $LANG_LANG['var_name'],
                'sort'  => true,
                'field' => 'var_name',
            ),
            array(
                'text'  => $LANG_LANG['language'],
                'sort'  => true,
                'field' => 'language',
            ),
            array(
                'text'  => $LANG_LANG['name'],
                'sort'  => true,
                'field' => 'name',
            ),
            array(
                'text'  => $LANG_LANG['value'],
                'sort'  => true,
                'field' => 'value',
            ),
        );
        $textArray = array(
            'has_extras' => true,
            'form_url'   => $_CONF['site_admin_url'] . '/language.php',
        );
        $queryArray = array(
            'sql'         => "SELECT * FROM {$_TABLES['language_items']} WHERE 1=1",
            'query_group' => 'id, var_name, language, name, value ',
            'query_fields'   => array('var_name', 'language', 'name', 'value'),
        );
        $defaultSortArray = array(
            'direction' => 'ASC',
            'field'     => 'id',
        );
        $filter = '';
        $extra = '';
        $options = array(
            'chkdelete' => true,
            'chkfield'  => 'id',
        );
        $formArray = array(
            'bottom' => '<input type="hidden" name="' . CSRF_TOKEN
                . '" value="' . SEC_createToken(self::SEC_TOKEN_LIFESPAN) . '"' . XHTML . '>',
        );
        $pageNavUrl = '';
        $content .= ADMIN_list(
            'language_items', __CLASS__ . '::fieldFunction', $headerArray, $textArray,
            $queryArray, $defaultSortArray, $filter, $extra, $options, $formArray, true, $pageNavUrl
        );
        $content .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
        $display = COM_createHTMLDocument($content, array('pagetitle' => $LANG_LANG['language_editor']));
        COM_output($display);
    }

    /**
     * Save language items into database
     */
    public static function adminSave()
    {
        global $_CONF, $_TABLES;

        self::checkAccessRights();
        self::checkSecurityToken();

        $id = Input::fPost('id', 0);
        $id = intval($id, 10);
        $varName = trim(Input::fPost('var_name', ''));
        $language = Input::fPost('language', '');
        $name = trim(Input::fPost('name', ''));
        $value = COM_stripslashes(Input::Post('value', ''));

        if (($id >= 0) && !empty($varName) && !empty($language)) {
            $varName = DB_escapeString($varName);
            $language = DB_escapeString($language);
            $name = DB_escapeString($name);
            $value = DB_escapeString($value);

            if ($id === 0) {
                $sql = "INSERT INTO {$_TABLES['language_items']} (var_name, language, name, value) "
                    . "VALUES ('{$varName}', '{$language}', '{$name}', '{$value}')";
            } else {
                $sql = "UPDATE {$_TABLES['language_items']} SET var_name = '{$varName}', "
                    . "language = '{$language}', name = '{$name}', value = '{$value}' "
                    . "WHERE id = {$id} ";
            }

            DB_query($sql);
            $redirect = $_CONF['site_admin_url'] . '/language.php?msg=131';
            header('Location: ' . $redirect);
            exit;
        } else {
            $A = array(
                'id'       => $id,
                'var_name' => $varName,
                'language' => $language,
                'name'     => $name,
                'value'    => $value,
            );
            self::adminShowEditor($A);
            exit;
        }
    }

    /**
     * Delete language item
     */
    public static function adminDelete()
    {
        global $_CONF, $_TABLES;

        self::checkAccessRights();
        self::checkSecurityToken();

        $id = Input::fPost('id', 0);
        $id = intval($id, 10);
        $redirect = $_CONF['site_admin_url'] . '/language.php';

        if ($id > 0) {
            $sql = "DELETE FROM {$_TABLES['language_items']} WHERE (id = {$id}) ";
            DB_query($sql);
            $redirect .= '?msg=130';
        }

        header('Location: ' . $redirect);
    }

    /**
     * Delete language items
     */
    public static function adminMassDelete()
    {
        global $_CONF, $_TABLES;

        self::checkAccessRights();
        self::checkSecurityToken();

        $ids = Input::fPost('delitem', array());

        if (!is_array($ids)) {
            $ids = (array) $ids;
        }

        if (count($ids) === 0) {
            self::adminShowList();
        } else {
            foreach ($ids as &$id) {
                $id = intval($id, 10);
            }
            unset($id);

            $sql = "DELETE FROM {$_TABLES['language_items']} "
                . " WHERE (id IN (" . implode(',', $ids) . ")) ";
            DB_query($sql);
            $redirect = $_CONF['site_admin_url'] . '/language.php?msg=130';
            header('Location: ' . $redirect);
        }
    }
}
