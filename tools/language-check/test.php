<?php
require __DIR__ . '/check.php';

$reference = <<<'LANG'
<?php
$LANG = array(
    'missing' => 'Missing text',
    'empty' => 'Some text',
    'format' => 'Number %d, name %s',
    'same' => 'Untranslated message',
    'escaped' => 'Don\'t change',
    'nested' => array('Label' => 1),
    'dynamic' => "Hello {$user['name']}",
);
$LANG_confignames['Core'] = array('test' => 'Test');
LANG;
$translation = <<<'LANG'
<?php
$LANG = array(
    'empty' => '',
    'format' => 'Nombre %s, nom %s',
    'same' => 'Untranslated message',
    'escaped' => 'Ne pas changer',
    'nested' => array('Etiquette' => 1),
    'dynamic' => "Bonjour {$user['name']}",
    'obsolete' => 'Old',
    'obsolete' => 'Old again',
);
$LANG_confignames['Core'] = array('test' => 'Essai');
LANG;
$actual = lc_compare($reference, $translation, true);
$expected = array(
    'DUPLICATE $LANG[obsolete]', 'MISSING $LANG[missing]',
    'EMPTY $LANG[empty]', 'PLACEHOLDERS $LANG[format]',
    'IDENTICAL $LANG[same]', 'OBSOLETE $LANG[obsolete]',
);
sort($actual);
sort($expected);
if ($actual !== $expected) {
    print_r($actual);
    exit(1);
}
if (lc_placeholders('%s %d') !== lc_placeholders('%2$d %1$s')) {
    exit(1);
}
if (lc_placeholders('%s %d') === lc_placeholders('%d %s')) {
    exit(1);
}
echo "PASS: language checker fixtures\n";
