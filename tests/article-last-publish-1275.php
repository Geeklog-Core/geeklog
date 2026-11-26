<?php
/** Standalone regression test for #1275; runs the production function with DB stubs. */
error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});
$_TABLES = array('stories' => 'stories', 'vars' => 'vars');
function DB_query($sql)
{
    global $queries, $queryResult;
    $queries[] = $sql;
    return count($queries) === 1 ? $queryResult : true;
}
function DB_fetchArray($result)
{
    global $row, $fetches;
    ++$fetches;
    if ($result === false) {
        throw new RuntimeException('Unexpected fetch after failed query');
    }
    return $row;
}
$source = file_get_contents(dirname(__DIR__) . '/system/lib-article.php');
if (!preg_match('/^function STORY_updateLastArticlePublished\(\)\s*\{.*?^\}/ms', $source, $matches)) {
    throw new RuntimeException('Production function not found');
}
eval($matches[0]);
$cases = array(
    array(true, array('date' => '2026-11-26 08:00:00'), '2026-11-26 08:00:00'),
    array(true, false, ''),
    array(true, null, ''),
    array(false, false, null),
);
foreach ($cases as $case) {
    list($queryResult, $row, $expected) = $case;
    $queries = array();
    $fetches = 0;
    STORY_updateLastArticlePublished();
    if (strpos($queries[0], 'draft_flag = 0 AND date <= NOW() AND perm_anon > 0 ORDER BY date DESC LIMIT 1') === false) {
        throw new RuntimeException('Unexpected article selection');
    }
    if ($expected === null) {
        if (count($queries) !== 1 || $fetches !== 0) {
            throw new RuntimeException('Failed query must not update publication date');
        }
    } elseif (count($queries) !== 2 || $fetches !== 1 ||
        $queries[1] !== "UPDATE vars SET value='{$expected}' WHERE name='last_article_publish'") {
        throw new RuntimeException('Incorrect publication date update');
    }
}
echo "OK: #1275 publication date scenarios passed (4 cases)\n";
