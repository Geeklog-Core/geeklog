<?php

error_reporting(E_ALL);

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

$_TABLES = array();

foreach (array(
    'routes', 'cookiecodes', 'dateformats', 'maillist',
    'vars', 'commentedits', 'comments', 'users',
    'commentnotifications', 'commentsubmissions',
    'stories', 'staticpage', 'polltopics', 'likes'
) as $name) {
    $_TABLES[$name] = 'test_' . $name;
}

$existingTables = array();

function DB_checkTableExists($table)
{
    global $existingTables, $_TABLES;

    if (!isset($_TABLES[$table])) {
        throw new RuntimeException(
            'Invalid logical table key: ' . $table
        );
    }

    return in_array($table, $existingTables, true);
}

function checkResult($condition, $label)
{
    global $passed;

    if (!$condition) {
        throw new RuntimeException('FAIL: ' . $label);
    }

    ++$passed;
    echo 'OK: ' . $label . "\n";
}

$passed = 0;

$staticpages = isset($argv[1]) ? $argv[1] === '1' : true;
$polls = isset($argv[2]) ? $argv[2] === '1' : true;

$existingTables = array();

if ($staticpages) {
    $existingTables[] = 'staticpage';
}

if ($polls) {
    $existingTables[] = 'polltopics';
}

echo 'Staticpages: ' . ($staticpages ? 'YES' : 'NO') . "\n";
echo 'Polls: ' . ($polls ? 'YES' : 'NO') . "\n";

$_SQL = array();

require dirname(__DIR__)
    . '/sql/updates/mysql_2.2.1_to_2.2.2.php';

$sql = implode("\n", $_SQL);

checkResult(
    (strpos($sql, 'test_staticpage') !== false) === $staticpages,
    'Conditional Staticpages cleanup'
);

checkResult(
    (strpos($sql, 'test_polltopics') !== false) === $polls,
    'Conditional Polls cleanup'
);

checkResult(
    strpos($sql, 'WHERE NOT EXISTS') !== false,
    'Duplicate route protection'
);

foreach (array(
    'cookiecodes', 'dateformats', 'maillist'
) as $table) {
    checkResult(
        strpos(
            $sql,
            'DROP TABLE IF EXISTS test_' . $table
        ) !== false,
        'Safe drop: ' . $table
    );
}

echo "\nTOTAL: $passed/6 checks passed\n";
