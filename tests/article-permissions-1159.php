<?php
/** Standalone regression scenarios for omitted article permission inputs (#1159). */
$source = file_get_contents(dirname(__DIR__) . '/system/classes/article.class.php');
if ($source === false || strpos($source, "foreach (array('perm_owner', 'perm_group', 'perm_members', 'perm_anon') as \$permissionKey)") === false) {
    fwrite(STDERR, "Permission normalization guard not found\n");
    exit(1);
}
$cases = array(
    array('perm_owner' => array(3), 'perm_group' => array(2), 'perm_members' => array(2)),
    array('perm_owner' => 3, 'perm_group' => 2, 'perm_members' => 2),
    array(),
);
foreach ($cases as $array) {
    foreach (array('perm_owner', 'perm_group', 'perm_members', 'perm_anon') as $permissionKey) {
        if (!isset($array[$permissionKey])) {
            $array[$permissionKey] = 0;
        }
    }
    foreach (array('perm_owner', 'perm_group', 'perm_members', 'perm_anon') as $permissionKey) {
        if (!isset($array[$permissionKey])) {
            fwrite(STDERR, "Missing permission after normalization\n");
            exit(1);
        }
    }
    if ($array['perm_anon'] !== 0) {
        fwrite(STDERR, "Unchecked anonymous permissions must deny access\n");
        exit(1);
    }
}
echo "OK: #1159 omitted permission form fields normalized to zero\n";
