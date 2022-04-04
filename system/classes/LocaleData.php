<?php

namespace Geeklog;

use ValueError;

class LocaleData
{
    /**
     * @var array[]
     * @note When you add a new language file to, or delete an existing language file from, $_CONF['path_language'],
     *       you have to update this array.
     */
    private static $data = [
        'chinese_simplified' => [
            'native'   => '简体中文',
            'english'  => 'Chinese Simplified',
            'iso639-1' => 'zh-Hans',
            'locale'   => 'zh_CN',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8'],
        ],

        'chinese_traditional' => [
            'native'   => '繁體中文',
            'english'  => 'Chinese Traditional',
            'iso639-1' => 'zh-Hans',
            'locale'   => 'zh_TW',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8'],
        ],

        'english' => [
            'native'   => 'English',
            'english'  => 'English',
            'iso639-1' => 'en',
            'locale'   => 'en',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'french_canada' => [
            'native'   => 'Français canadien',
            'english'  => 'French (Canada)',
            'iso639-1' => 'fr',
            'locale'   => 'fr_CA',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'french_france' => [
            'native'   => 'Français',
            'english'  => 'French (France)',
            'iso639-1' => 'fr',
            'locale'   => 'fr_FR',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'german_formal' => [
            'native'   => 'Deutsche',
            'english'  => 'German (Formal)',
            'iso639-1' => 'de',
            'locale'   => 'de_DE',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-15'],
        ],

        'german' => [
            'native'   => 'Deutsche',
            'english'  => 'German',
            'iso639-1' => 'de',
            'locale'   => 'de_DE',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-15'],
        ],

        'hebrew' => [
            'native'   => 'עברית',
            'english'  => 'Hebrew',
            'iso639-1' => 'he',
            'locale'   => 'iw_IL',
            'dir'      => 'rtl',
            'encoding' => ['UTF-8'],
        ],

        'japanese' => [
            'native'   => '日本語',
            'english'  => 'Japanese',
            'iso639-1' => 'ja',
            'locale'   => 'ja_JP',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8'],
        ],

        'persian' => [
            'native'   => 'فارسی',
            'english'  => 'Persian',
            'iso639-1' => 'fa',
            'locale'   => 'fa_IR',
            'dir'      => 'rtl',
            'encoding' => ['UTF-8'],
        ],

        'russian' => [
            'native'   => 'Русский язык',
            'english'  => 'Russian',
            'iso639-1' => 'ru',
            'locale'   => 'ru_RU',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'windows-1251'],
        ],

        'spanish_argentina' => [
            'native'   => 'Castellano',
            'english'  => 'Spanish (Argentina)',
            'iso639-1' => 'es',
            'locale'   => 'es_AR',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'spanish' => [
            'native'   => 'Español',
            'english'  => 'Spanish (Spain)',
            'iso639-1' => 'es',
            'locale'   => 'es_ES',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],
    ];

    /**
     * Return if the language name given is supported by Geeklog
     *
     * @param  string  $languageName
     * @return bool
     */
    public static function isLanguageSupported($languageName)
    {
        $languageName = strtolower($languageName);
        $languageName = str_replace('_utf-8', '', $languageName);

        return array_key_exists($languageName, self::$data);
    }

    /**
     * Return an array of dropdowns to select a language
     *
     * @param  string  $baseDir                  the directory where we look for language files, e.g.
     *                                           $_CONF['path_language']
     * @param  string  $defaultCharset           the default charset of your site, e.g. $_CONF['default_charset']
     * @param  bool    $isMultiLanguage          true in case of a multi-language site
     * @param  array   $acceptableLanguageFiles  a list of languages to be accepted in multi-language mode
     * @return array                             an array of ['language_file_name' => 'language name']
     * @note   This function is supposed to display only language files in selection dropdowns that are utf-8
     */
    public function getLanguageList($baseDir, $defaultCharset = 'UTF-8', $isMultiLanguage = false, array $acceptableLanguageFiles = [])
    {
        $retval = [];

        $baseDir = rtrim($baseDir, '/\\') . DIRECTORY_SEPARATOR;
        $isUtf8 = (strcasecmp($defaultCharset, 'utf-8') === 0);
        clearstatcache();

        foreach (self::$data as $key => $value) {
            foreach ($value['encoding'] as $encoding) {
                $langFile = '';
                $langText = '';

                if (strcasecmp('UTF-8', $encoding) === 0) {
                    if ($isUtf8) {
                        $langFile = $key . '_utf-8.php';
                        $langText = $value['native'] . ' (' . $value['english'] . ')';
                    }
                } else {
                    if (!$isUtf8) {
                        $langFile = $key . '.php';

                        try {
                            $langText = @mb_convert_encoding(
                                $value['native'] . ' (' . $value['english'] . ')',
                                $defaultCharset,
                                'UTF-8'
                            );

                            if ($langText === false) {
                                $langText = $value['english'];
                            }
                        } catch (ValueError $e) {
                            $langText = $value['english'];
                        }
                    }
                }

                if (($langFile !== '') && is_readable($baseDir . $langFile)) {
                    $langFile = str_ireplace('.php', '', $langFile);

                    if ($isMultiLanguage) {
                        if (in_array($langFile, $acceptableLanguageFiles)) {
                            $retval[$langFile] = $langText;
                        }
                    } else {
                        $retval[$langFile] = $langText;
                    }
                }
            }
        }

        asort($retval);

        return $retval;
    }
}
