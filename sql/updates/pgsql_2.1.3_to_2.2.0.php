<?php

// Add meta_description and meta_keywords to storysubmission
$_SQL[] = "ALTER TABLE {$_TABLES['storysubmission']} ADD `meta_description` TEXT NULL AFTER `postmode`";
$_SQL[] = "ALTER TABLE {$_TABLES['storysubmission']} ADD `meta_keywords` TEXT NULL AFTER `meta_description`";

/**
 * Upgrade Messages
 */
// None yet
// function upgrade_message220() { }


/**
 * Add new config options
 */
function update_ConfValuesFor220()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';

    // Add switch language redirect option
    $c->add('switchlang_homepage',0,'select',6,28,0,370,TRUE, $me, 28);

    return true;
}

/**
 * Add Theme Admin
 *
 * @return bool
 */
function addThemeAdminFor220()
{
    global $_CONF, $_TABLES;

    $sql1 = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) "
        . "VALUES (NULL, 'Theme Admin', 'Has full access to themes', 1)";
    $sql2 = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_grp_id) VALUES (%d, %d)";
    $sql3 = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) "
        . "VALUES (NULL, 'theme.edit', 'Access to theme settings', 1)";
    $sql4 = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (%d, %d)";

    try {
        DB_beginTransaction();

        // Add Theme Admin to groups
        if (!DB_query($sql1)) {
            throw new \Exception(DB_error());
        }

        // Add Root group to Theme Admin group
        $themeAdminGroupId = DB_insertId();
        $rootGroupId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
        $sql2 = sprintf($sql2, $themeAdminGroupId, $rootGroupId);
        if (!DB_query($sql2)) {
            throw new \Exception(DB_error());
        }

        // Add theme.edit feature
        if (!DB_query($sql3)) {
            throw new \Exception(DB_error());
        }

        // Assign theme.edit feature to Theme Admin
        $themeAdminFeatureId = DB_insertId();
        $sql4 = sprintf($sql4, $themeAdminFeatureId, $themeAdminGroupId);
        if (!DB_query($sql4)) {
            throw new \Exception(DB_error());
        }

        DB_commit();
    } catch (\Exception $e) {
        DB_rollBack();

        return false;
    }

    return true;
}
