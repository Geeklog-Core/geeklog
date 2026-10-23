<?php
/**
 * Focused regression guard for #1162.
 * Run: php tests/article-recent-comment-1162.php
 *
 * Checks that the production guard exists and exercises both query-result
 * branches in isolation. Full Geeklog rendering still requires integration tests.
 */
$source = file_get_contents(dirname(__DIR__) . '/system/lib-article.php');
$required = array(
    '$C = ($result !== false) ? DB_fetchArray($result) : false;',
    'if (is_array($C)) {',
    '$article->set_var(\'comments_with_count\', $comments_with_count);',
    '$recent_comment_anchortag = COM_createLink($comments_with_count, $postCommentUrl);',
);
foreach ($required as $fragment) {
    if ($source === false || strpos($source, $fragment) === false) {
        fwrite(STDERR, "Missing #1162 regression guard: " . $fragment . "\n");
        exit(1);
    }
}
function recentCommentRow($queryResult, $row) {
    return ($queryResult !== false) ? $row : false;
}
$cases = array(
    array(false, array('day' => 123), false),
    array(true, false, false),
    array(true, array('day' => 123), true),
);
foreach ($cases as $case) {
    $C = recentCommentRow($case[0], $case[1]);
    if (is_array($C) !== $case[2]) {
        fwrite(STDERR, "Recent comment row classification failed\n");
        exit(1);
    }
}
echo "OK: #1162 source guard and row-classification scenarios passed\n";
