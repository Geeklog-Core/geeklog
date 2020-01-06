#!/usr/local/bin/php -q
<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lm.php                                                                    |
// |                                                                           |
// | Update a language file by merging it with english.php                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004-2019 by the following authors:                         |
// |                                                                           |
// | Author:  Dirk Haun         - dirk AT haun-online DOT de                   |
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

$VERSION = $GLOBALS['argv'][1];
define('ROOT', dirname(dirname(dirname(__DIR__))) . '/');

// Prevent PHP from reporting uninitialized variables
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);
error_reporting(-1);

// name of the language file should be passed on the command line
$langfile = $GLOBALS['argv'][2];

if (empty($langfile)) {
    echo "lm.php v{$VERSION}\n";
    echo "This is free software; see the source for copying conditions.\n\n";
    echo "Usage: {$GLOBALS['argv'][0]} langfile.php [module] > new-langfile.php\n\n";
    exit;
}

$module = '';

if (!empty($GLOBALS['argv'][3])) {
    $module = $GLOBALS['argv'][3];
}

$mb = false;

if (strpos($langfile, '_utf-8') !== false) {
    $mb = true;

    if (!function_exists('mb_strpos')) {
        echo "Sorry, this script needs a PHP version that has multibyte support compiled in.\n\n";
        exit;
    } elseif (!function_exists('mb_ereg_replace')) {
        echo "Sorry, this script needs a PHP version with the mb_ereg_replace function compiled in.\n\n";
        exit;
    }

    mb_regex_encoding('UTF-8');
    mb_internal_encoding('UTF-8');
}

define('VERSION', $GLOBALS['argv'][1]); // Geeklog version
define('XHTML', '');
define('TOPIC_ALL_OPTION', 'all');
define('TOPIC_NONE_OPTION', 'none');
define('TOPIC_HOMEONLY_OPTION', 'homeonly');
define('TOPIC_SELECTED_OPTION', 'selectedtopics');
define('TOPIC_ROOT', 'root');

define('RECAPTCHA_NO_SUPPORT', 0);
define('RECAPTCHA_SUPPORT_V2', 1);
define('RECAPTCHA_SUPPORT_V2_INVISIBLE', 2);

// list of all variables accessed in the language file
$_DB_mysqldump_path = '{$_DB_mysqldump_path}';
$_CONF['backup_path'] = '{$_CONF[\'backup_path\']}';
$_CONF['commentspeedlimit'] = '{$_CONF[\'commentspeedlimit\']}';
$_CONF['site_admin_url'] = '{$_CONF[\'site_admin_url\']}';
$_CONF['site_name'] = '{$_CONF[\'site_name\']}';
$_CONF['site_url'] = '{$_CONF[\'site_url\']}';
$_CONF['speedlimit'] = '{$_CONF[\'speedlimit\']}';
$_CONF['invalidloginattempts'] = '{$_CONF[\'invalidloginattempts\']}';
$_CONF['invalidloginmaxtime'] = '{$_CONF[\'invalidloginmaxtime\']}';
$_CONF['theme'] = '{$_CONF[\'theme\']}';
$_CONF['theme_gl_version'] = '{$_CONF[\'theme_gl_version\']}';
$_CONF['min_theme_gl_version'] = '{$_CONF[\'min_theme_gl_version\']}';
$_CONF['theme_site_default'] = '{$_CONF[\'theme_site_default\']}';
$_USER['username'] = '{$_USER[\'username\']}';

$failures = '{$failures}';
$from = '{$from}';
$fromemail = '{$fromemail}';
$qid = '{$qid}';
$shortmsg = '{$shortmsg}';
$successes = '{$successes}';
$topic = '{$topic}';
$type = '{$type}';

// names of constants to be used in the configselect arrays
$config_constants = array(
    'TOPIC_ALL_OPTION', 'TOPIC_HOMEONLY_OPTION', 'TOPIC_SELECTED_OPTION',
);

// load the English language file
if (empty($module)) {
    require_once ROOT . 'language/english.php';
} elseif ($module == 'install') {
    require_once ROOT . 'public_html/admin/install/language/english.php';
} else {
    require_once ROOT . 'plugins/' . $module . '/language/english.php';
}

function separator()
{
    echo "###############################################################################\n";
}

function separatorThin()
{
    echo "// +---------------------------------------------------------------------------+\n";
}

/**
 * My mb-save replacement for some(!) string replacements
 */
function my_str_replace($s1, $s2, $s3)
{
    global $mb;

    if ($mb) {
        return mb_ereg_replace($s1, $s2, $s3);
    } else {
        return str_replace($s1, $s2, $s3);
    }
}

/**
 * My mb-save replacement for some(!) use cases of strpos
 */
function my_strpos($s1, $s2)
{
    global $mb;

    if ($mb) {
        return mb_strpos($s1, $s2);
    } else {
        return strpos($s1, $s2);
    }
}

/**
 * Make <br> and <hr> tags XHTML compliant
 */
function makeXHTML($txt)
{
    global $mb, $module;

    // fix accidentally created <brXHTML> tags in some 1.5.0b1 language files
    $txt = my_str_replace('brXHTML', 'br', $txt);

    if ($mb) {
        $fc = mb_substr($txt, 0, 1);
    } else {
        $fc = substr($txt, 0, 1);
    }

    if ($module !== 'install') {
        $txt = my_str_replace('<br>',
            '<br' . $fc . ' . XHTML . ' . $fc . '>', $txt);
        $txt = my_str_replace('<hr>',
            '<hr' . $fc . ' . XHTML . ' . $fc . '>', $txt);
    }

    return $txt;
}

function prepareText($newText)
{
    global $mb;

    if (my_strpos($newText, '{$') === false) {
        if (my_strpos($newText, '\n') === false) {
            // text contains neither variables nor line feeds,
            // so enclose it in single quotes
            $newText = my_str_replace("'", "\'", $newText);
            $quotedText = "'" . $newText . "'";
        } else {
            // text contains line feeds - enclose in double quotes so
            // they can be interpreted
            $newText = my_str_replace('"', '\"', $newText);
            $quotedText = '"' . $newText . '"';
        }
    } else {
        // text contains variables
        if ($mb) {
            $newText = mb_ereg_replace('\$', '\$', $newText);
            // backslash attack!
            $newText = mb_ereg_replace('\{\\\\\$', '{$', $newText);
            $newText = mb_ereg_replace('"', '\"', $newText);
        } else {
            $newText = str_replace('$', '\$', $newText);
            $newText = str_replace('{\$', '{$', $newText);
            $newText = str_replace('"', '\"', $newText);
        }
        $quotedText = '"' . $newText . '"';
    }

    return $quotedText;
}

/**
 * Merge two language arrays
 * This function does all the work. Any missing text strings are copied
 * over from english.php. Also does some pretty-printing.
 */
function mergeArrays($ENG, $OTHER, $arrayName, $comment = '')
{
    global $mb, $config_constants;

    $numElements = count($ENG);
    $counter = 0;

    if ($comment !== false) {
        separator();
    }
    if (!empty($comment)) {
        $comments = explode("\n", $comment);
        foreach ($comments as $c) {
            echo "# $c\n";
        }
    }
    echo "\n\${$arrayName} = array(\n";

    foreach ($ENG as $key => $txt) {
        $counter++;
        if (is_numeric($key)) {
            echo "    $key => ";
        } else {
            echo "    '$key' => ";
        }

        if (empty($OTHER[$key])) {
            // string does not exist in other language - use English text
            $newText = $txt;
        } else {
            if (isset($ENG[$key]) && empty($ENG[$key])) {
                // string is now empty in English language file - remove it
                $newText = '';
            } else {
                // string exists in other language - keep it
                $newText = $OTHER[$key];
            }
        }

        if (!is_array($newText)) {
            $newText = my_str_replace("\n", '\n', $newText);
        }

        if (is_array($newText)) { // mainly for the config selects
            if (!empty($OTHER[$key]) && (count($ENG[$key]) != count($OTHER[$key]))) {
                // In case there are new entries for a config, merge those
                // into the existing one to keep the translation intact.

                // Note: We can't use array_merge() or "+" since we want to
                // keep the original order intact.
                $newText = array();
                foreach ($ENG[$key] as $eKey => $eValue) {
                    $oKey = array_search($eValue, $OTHER[$key], true);
                    if ($oKey === false) {
                        $newText[$eKey] = $eValue;
                    } else {
                        $newText[$oKey] = $eValue;
                    }
                }
            }

            $quotedText = 'array(';
            foreach ($newText as $nKey => $nTxt) {
                $quotedText .= "'" . my_str_replace("'", "\'", $nKey) . "' => ";

                if ($nTxt === true) {
                    $quotedText .= 'true';
                } elseif ($nTxt === false) {
                    $quotedText .= 'false';
                } elseif (is_numeric($nTxt)) {
                    $quotedText .= $nTxt;
                } elseif (in_array($nTxt, $config_constants)) {
                    $quotedText .= $nTxt;
                } else {
                    $quotedText .= "'" . my_str_replace("'", "\'", $nTxt) . "'";
                }

                $quotedText .= ', ';
            }

            if ($mb) {
                $quotedText = mb_substr($quotedText, 0, -2);
            } else {
                $quotedText = substr($quotedText, 0, -2);
            }
            $quotedText .= ')';

            // hack for this special case ...
            if ($quotedText == "array('True' => 1, 'False' => '')") {
                $quotedText = "array('True' => TRUE, 'False' => FALSE)";
            }

            // ??? $quotedText = mb_ereg_replace("\n", '\n', $quotedtext);
        } else {
            $quotedText = prepareText($newText);
        }

        $quotedText = makeXHTML($quotedText);

        if ($counter != $numElements) {
            $quotedText .= ',';
        }
        echo "$quotedText\n";
    }

    if ($comment === false) {
        echo ");\n";
    } else {
        echo ");\n\n";
    }
}

function mergeString($eng, $other, $name)
{
    global $mb;

    if (empty($other)) {
        $newText = $eng;
    } else {
        $newText = $other;
    }

    $prepareText = prepareText($newText);
    $prepareText = makeXHTML($prepareText);

    echo "\$$name = $prepareText;\n";
}

/**
 * Read the credits / copyright from the other language file.
 * Assumes that it starts and ends with a separator line of # signs.
 */
function readCredits($langfile)
{
    $credits = array();
    $firstComment = false;

    $fh = fopen($langfile, 'r');
    if ($fh !== false) {
        while (true) {
            $line = fgets($fh);
            if ($firstComment) {
                $credits[] = $line;
                if (strstr($line, '#####') !== false) {
                    // end of credits reached
                    break;
                } elseif (strstr($line, '*/') !== false) {
                    // end of credits reached, Spam-X style
                    break;
                } elseif (strstr($line, '+-----') !== false) {
                    $nextLine = fgets($fh);
                    $tst = trim($nextLine);
                    if (empty($tst)) {
                        // end of credits reached, install script style
                        break;
                    } else {
                        $credits[] = $nextLine;
                    }
                }
            } else {
                if (strstr($line, '#####') !== false) {
                    // start of credits
                    $firstComment = true;
                    $credits[] = $line;
                } elseif (strstr($line, '/**') !== false) {
                    // start of credits, Spam-X style
                    $firstComment = true;
                    $credits[] = $line;
                } elseif (strstr($line, '/* Reminder:') !== false) {
                    // start of credits, install script style
                    $firstComment = true;
                    $credits[] = $line;
                }
            }
        }
        fclose($fh);
    }

    // ensure rebranding extends to the credits :)
    $cSize = count($credits);
    for ($i = 0; $i < $cSize; $i++) {
        $credits[$i] = str_replace('GeekLog', 'Geeklog', $credits[$i]);
    }

    return ($credits);
}

/**
 * Strip UTF-8 BOM that lang files could accidentally contain
 *
 * @param  string  $langfile
 */
function stripUtf8Bom($langfile)
{
    if (preg_match('/_utf-8\.php$/i', $langfile)) {
        $content = @file_get_contents($langfile);

        if ($content !== false) {
            $content = str_replace("\xEF\xBB\xBF", '', $content);
            @file_put_contents($langfile, $content);
        }
    }
}

// MAIN
stripUtf8Bom($langfile);
$credits = readCredits($langfile);

// output starts here ...
echo "<?php\n\n";

foreach ($credits as $c) {
    echo "$c"; // Note: line feeds are part of the credits
}

// load the module file which does the rest
if (empty($module)) {
    require_once __DIR__ . '/include/core.inc';
} else {
    require_once __DIR__ . '/include/' . $module . '.inc';
}
