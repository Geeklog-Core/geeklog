<?php
/**
 * Standalone regression test for issue #1255.
 *
 * Run: php tests/profile_visibility_policy.php
 *
 * We extract only the pure policy function so this script can exercise the
 * authorization logic without bootstrapping Geeklog or a database.
 */
$source = file_get_contents(__DIR__ . '/../system/lib-user.php');
$start = strpos($source, 'function USER_canViewProfile(');
if ($start === false) {
    fwrite(STDERR, "Missing profile visibility policy\n");
    exit(1);
}
$open = strpos($source, '{', $start);
$depth = 0;
$end = false;
for ($i = $open, $length = strlen($source); $i < $length; $i++) {
    if ($source[$i] === '{') {
        $depth++;
    } elseif ($source[$i] === '}') {
        $depth--;
        if ($depth === 0) {
            $end = $i + 1;
            break;
        }
    }
}
if ($end === false) {
    fwrite(STDERR, "Incomplete profile visibility policy\n");
    exit(1);
}
eval(substr($source, $start, $end - $start));
$_CONF = array();
$_USER = array('uid' => 1);
$administrator = false;
function COM_isAnonUser()
{
    global $_USER;
    return (int) $_USER['uid'] === 1;
}
function SEC_hasRights($feature)
{
    global $administrator;
    return $feature === 'user.edit' && $administrator;
}
function policy_check($expected, $target, $description)
{
    $actual = USER_canViewProfile($target);
    if ($actual !== $expected) {
        fwrite(STDERR, 'FAIL: ' . $description . PHP_EOL);
        exit(1);
    }
}
policy_check(true, 3, 'missing configuration retains public default');
$_CONF['profile_visibility'] = 0;
policy_check(true, 3, 'public allows anonymous visitor');
$_USER['uid'] = 2;
policy_check(true, 3, 'public allows another signed-in member');
$_CONF['profile_visibility'] = 1;
$_USER['uid'] = 1;
policy_check(false, 3, 'registered mode denies anonymous');
$_USER['uid'] = 2;
policy_check(true, 3, 'registered mode permits authenticated visitors');
$_CONF['profile_visibility'] = 2;
$_USER['uid'] = 1;
policy_check(false, 3, 'private denies anonymous');
$_USER['uid'] = 3;
policy_check(true, 3, 'private permits the owner');
$_USER['uid'] = 2;
policy_check(false, 3, 'private denies unrelated member');
$administrator = true;
policy_check(true, 3, 'private permits user administrator');
$administrator = false;
$_CONF['profile_visibility'] = 99;
policy_check(false, 3, 'invalid setting fails closed');
if (strpos($source, 'if (!USER_canViewProfile((int) $uid))') === false) {
    fwrite(STDERR, "Common profile renderer is not protected\n");
    exit(1);
}
$users = file_get_contents(__DIR__ . '/../public_html/users.php');
foreach (array("case 'profile':", "case 'user':") as $route) {
    if (strpos($users, $route) === false) {
        fwrite(STDERR, 'Missing route ' . $route . PHP_EOL);
        exit(1);
    }
}
echo "PASS: profile visibility policy and shared Core profile routing\n";
