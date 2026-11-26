<?php
// Standalone, read-only language audit. Compatible with PHP 5.6+.

function lc_text($token)
{
    return is_array($token) ? $token[1] : $token;
}

function lc_literal($token)
{
    if (!is_array($token)) {
        return null;
    }
    if ($token[0] === T_LNUMBER) {
        return (string) (int) $token[1];
    }
    if ($token[0] !== T_CONSTANT_ENCAPSED_STRING) {
        return null;
    }
    $value = substr($token[1], 1, -1);
    return $token[1][0] === "'" ? str_replace(array("\\\\", "\\'"), array("\\", "'"), $value) : stripcslashes($value);
}

// Read direct array members without executing language files (frequently
// containing runtime variables). Nested/dynamic values are not compared.
function lc_extract($source)
{
    $tokens = array_values(array_filter(token_get_all($source), function ($t) {
        return !is_array($t) || !in_array($t[0], array(T_WHITESPACE, T_COMMENT, T_DOC_COMMENT), true);
    }));
    $entries = array();
    $duplicates = array();
    $count = count($tokens);
    for ($i = 0; $i < $count; ++$i) {
        if (!is_array($tokens[$i]) || $tokens[$i][0] !== T_VARIABLE) {
            continue;
        }
        $name = $tokens[$i][1];
        $j = $i + 1;
        while (isset($tokens[$j + 2]) && $tokens[$j] === '[' && $tokens[$j + 2] === ']') {
            $key = lc_literal($tokens[$j + 1]);
            if ($key === null) {
                break;
            }
            $name .= '[' . $key . ']';
            $j += 3;
        }
        if (!isset($tokens[$j + 1]) || $tokens[$j] !== '=') {
            continue;
        }
        ++$j;
        if (is_array($tokens[$j]) && $tokens[$j][0] === T_ARRAY && isset($tokens[$j + 1]) && $tokens[$j + 1] === '(') {
            ++$j;
        } elseif ($tokens[$j] !== '[') {
            continue;
        }
        $depth = 1;
        $part = array();
        $next = 0;
        for (++$j; $j < $count; ++$j) {
            $t = $tokens[$j];
            $end = ($depth === 1 && ($t === ')' || $t === ']'));
            if ($end || ($depth === 1 && $t === ',')) {
                if (count($part)) {
                    $key = (string) $next;
                    $value = $part;
                    if (isset($part[1]) && is_array($part[1]) && $part[1][0] === T_DOUBLE_ARROW) {
                        $key = lc_literal($part[0]);
                        $value = array_slice($part, 2);
                    }
                    if ($key !== null) {
                        if (ctype_digit($key)) {
                            $next = max($next, (int) $key + 1);
                        }
                        $path = $name . '[' . $key . ']';
                        if (array_key_exists($path, $entries)) {
                            $duplicates[] = $path;
                        }
                        $entries[$path] = count($value) === 1 ? lc_literal($value[0]) : null;
                    }
                }
                $part = array();
                if ($end) {
                    break;
                }
                continue;
            }
            if (in_array($t, array('(', '[', '{'), true) ||
                (is_array($t) && in_array($t[0], array(T_CURLY_OPEN, T_DOLLAR_OPEN_CURLY_BRACES), true))) {
                ++$depth;
            } elseif (in_array($t, array(')', ']', '}'), true)) {
                --$depth;
            }
            $part[] = $t;
        }
        $i = $j;
    }
    return array($entries, $duplicates);
}

function lc_placeholders($text)
{
    preg_match_all('/%%|%(?:([1-9][0-9]*)\$)?[-+0-9.\x27 ]*[bcdeEfFgGosuxX]|\{[0-9]+\}/', $text, $matches);
    $result = array();
    $position = 0;
    foreach ($matches[0] as $match) {
        if ($match === '%%') {
            continue;
        }
        if ($match[0] === '{') {
            $result[] = $match;
        } else {
            $index = preg_match('/^%([1-9][0-9]*)\$/', $match, $m) ? (int) $m[1] : ++$position;
            $result[] = $index . ':' . substr($match, -1);
        }
    }
    sort($result);
    return $result;
}

function lc_compare($reference, $translation, $identical = false)
{
    list($expected) = lc_extract($reference);
    list($actual, $duplicates) = lc_extract($translation);
    $findings = array();
    foreach ($duplicates as $key) {
        $findings[] = 'DUPLICATE ' . $key;
    }
    foreach ($expected as $key => $value) {
        if (!array_key_exists($key, $actual)) {
            $findings[] = 'MISSING ' . $key;
        } elseif ($value !== null && $actual[$key] !== null) {
            if (trim($value) !== '' && trim($actual[$key]) === '') {
                $findings[] = 'EMPTY ' . $key;
            }
            if (lc_placeholders($value) !== lc_placeholders($actual[$key])) {
                $findings[] = 'PLACEHOLDERS ' . $key;
            }
            if ($identical && $value === $actual[$key] && preg_match('/[a-zA-Z]{3,}\s+[a-zA-Z]{3,}/', $value)) {
                $findings[] = 'IDENTICAL ' . $key;
            }
        }
    }
    foreach (array_diff_key($actual, $expected) as $key => $value) {
        $findings[] = 'OBSOLETE ' . $key;
    }
    return $findings;
}

function lc_run($root, $identical)
{
    $directories = array_merge(array($root . '/language'), glob($root . '/plugins/*/language', GLOB_ONLYDIR));
    $files = 0;
    $total = 0;
    $fatal = 0;
    foreach ($directories as $directory) {
        foreach (glob($directory . '/*.php') as $file) {
            $basename = basename($file);
            $utf8 = substr($basename, -10) === '_utf-8.php';
            $ref = $directory . '/' . ($utf8 ? 'english_utf-8.php' : 'english.php');
            ++$files;
            $source = file_get_contents($file);
            $findings = array();
            $output = array();
            $status = 0;
            exec(escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($file) . ' 2>&1', $output, $status);
            if ($status !== 0) {
                $findings[] = 'SYNTAX ' . implode(' ', $output);
                ++$fatal;
            }
            if ($utf8 && preg_match('//u', $source) !== 1) {
                $findings[] = 'INVALID UTF-8';
                ++$fatal;
            }
            if (!is_file($ref)) {
                $findings[] = 'NO ENGLISH REFERENCE';
            } elseif ($file !== $ref && $status === 0) {
                $findings = array_merge($findings, lc_compare(file_get_contents($ref), $source, $identical));
            } elseif ($status === 0) {
                list(, $duplicates) = lc_extract($source);
                foreach ($duplicates as $key) {
                    $findings[] = 'DUPLICATE ' . $key;
                }
            }
            $total += count($findings);
            echo substr($file, strlen($root) + 1) . ': ' . count($findings) . ' findings' . PHP_EOL;
            foreach ($findings as $finding) {
                echo '  ' . $finding . PHP_EOL;
            }
        }
    }
    echo "TOTAL: $files files, $total findings, $fatal syntax/encoding errors" . PHP_EOL;
    return $fatal;
}

if (realpath($_SERVER['SCRIPT_FILENAME']) === __FILE__) {
    if (in_array('--help', $argv, true)) {
        echo "Usage: php tools/language-check/check.php --all [--identical] [--strict]\n";
        exit(0);
    }
    $errors = lc_run(dirname(dirname(__DIR__)), in_array('--identical', $argv, true));
    exit(in_array('--strict', $argv, true) && $errors ? 1 : 0);
}
