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
    private $data = [
        'afrikaans' => [
            'native'   => 'Afrikaans',
            'english'  => 'Afrikaans',
            'iso639-1' => 'af',
            'locale'   => 'af_ZA',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'bosnian' => [
            'native'   => 'Bosanski jezik',
            'english'  => 'Bosnian',
            'iso639-1' => 'bs',
            'locale'   => 'bs',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-2'],
        ],

        'bulgarian' => [
            'native'   => 'български език',
            'english'  => 'Bulgarian',
            'iso639-1' => 'bg',
            'locale'   => 'bg_BG',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'Windows-1251'],
        ],

        'catalan' => [
            'native'   => 'Català',
            'english'  => 'Catalan',
            'iso639-1' => 'ca',
            'locale'   => 'ca_ES',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

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

        'croatian' => [
            'native'   => 'Hrvatski',
            'english'  => 'Croatian',
            'iso639-1' => 'hr',
            'locale'   => 'hr_HR',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-2'],
        ],

        'czech' => [
            'native'   => 'Čeština',
            'english'  => 'Czech',
            'iso639-1' => 'cs',
            'locale'   => 'cs_CZ',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-2'],
        ],

        'danish' => [
            'native'   => 'Dansk',
            'english'  => 'Danish',
            'iso639-1' => 'da',
            'locale'   => 'da_DK',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'dutch' => [
            'native'   => 'Nederlands',
            'english'  => 'Dutch',
            'iso639-1' => 'nl',
            'locale'   => 'nl_NL',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'english' => [
            'native'   => 'English',
            'english'  => 'English',
            'iso639-1' => 'en',
            'locale'   => 'en',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'estonian' => [
            'native'   => 'Eesti keel',
            'english'  => 'Estonian',
            'iso639-1' => 'et',
            'locale'   => 'et_EE',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'finnish' => [
            'native'   => 'Suomen kieli',
            'english'  => 'Finnish',
            'iso639-1' => 'fi',
            'locale'   => 'fi_FI',
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

        'hellenic' => [
            'native'   => 'Ελληνικά',
            'english'  => 'Greek',
            'iso639-1' => 'el',
            'locale'   => 'el_GR',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-7'],
        ],

        'indonesian' => [
            'native'   => 'Bahasa Indonesia',
            'english'  => 'Indonesian',
            'iso639-1' => 'id',
            'locale'   => 'in_ID',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'italian' => [
            'native'   => 'Italiano',
            'english'  => 'Italian',
            'iso639-1' => 'it',
            'locale'   => 'it_IT',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'japanese' => [
            'native'   => '日本語',
            'english'  => 'Japanese',
            'iso639-1' => 'ja',
            'locale'   => 'ja_JP',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8'],
        ],

        'korean' => [
            'native'   => '한국어',
            'english'  => 'Korean',
            'iso639-1' => 'ko',
            'locale'   => 'ko_KR',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'EUC-KR'],
        ],

        'norwegian' => [
            'native'   => 'Norsk',
            'english'  => 'Norwegian',
            'iso639-1' => 'no',
            'locale'   => 'no_NO',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'persian' => [
            'native'   => 'فارسی',
            'english'  => 'Persian',
            'iso639-1' => 'fa',
            'locale'   => 'fa_IR',
            'dir'      => 'rtl',
            'encoding' => ['UTF-8'],
        ],

        'polish' => [
            'native'   => 'Język polski',
            'english'  => 'Polish',
            'iso639-1' => 'pl',
            'locale'   => 'pl_PL',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-2'],
        ],

        'portuguese_brazil' => [
            'native'   => 'Português do Brasil',
            'english'  => 'Portuguese (Brazil)',
            'iso639-1' => 'pt',
            'locale'   => 'pt_BR',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'portuguese' => [
            'native'   => 'Português',
            'english'  => 'Portuguese (Portugal)',
            'iso639-1' => 'pt',
            'locale'   => 'pt_PT',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'romanian' => [
            'native'   => 'Limba română',
            'english'  => 'Romanian',
            'iso639-1' => 'ro',
            'locale'   => 'ro_RO',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-2'],
        ],

        'russian' => [
            'native'   => 'Русский язык',
            'english'  => 'Russian',
            'iso639-1' => 'ru',
            'locale'   => 'ru_RU',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'windows-1251'],
        ],

        'serbian' => [
            'native'   => 'Српски',
            'english'  => 'Serbian',
            'iso639-1' => 'sr',
            'locale'   => 'sr_CS',   // sr_BA?
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-2'],
        ],

        'slovak' => [
            'native'   => 'Slovenčina',
            'english'  => 'Slovak',
            'iso639-1' => 'sk',
            'locale'   => 'sk_SK',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-2'],
        ],

        'slovenian' => [
            'native'   => 'Slovenščina',
            'english'  => 'Slovenian',
            'iso639-1' => 'sl',
            'locale'   => 'sl_SI',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'Windows-1250'],    // 'Windows-1250' is not supported by mb_convert_encoding
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

        'swedish' => [
            'native'   => 'Svenska',
            'english'  => 'Swedish',
            'iso639-1' => 'sv',
            'locale'   => 'sv_SE',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-1'],
        ],

        'turkish' => [
            'native'   => 'Türkçe',
            'english'  => 'Turkish',
            'iso639-1' => 'tr',
            'locale'   => 'tr_TR',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'ISO-8859-9'],
        ],

        'ukrainian' => [
            'native'   => 'українська мова',
            'english'  => 'Ukrainian',
            'iso639-1' => 'uk',
            'locale'   => 'uk_UA',
            'dir'      => 'ltr',
            'encoding' => ['UTF-8', 'Windows-1251', 'KOI8-U'],
        ],
    ];

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

        foreach ($this->data as $key => $value) {
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
