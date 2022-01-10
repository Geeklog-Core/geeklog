<?php

use \PHPUnit\Framework\TestCase;

/**
 * Simple tests for lib-mbyte
 */
class libmbyteNoMB extends TestCase
{
    public static function setUpBeforeClass()
    {
        Tst::loadLibrary('mbyte');
        MBYTE_checkEnabled('test-reset');
    }

    protected function setUp()
    {
        global $_CONF;

        $_CONF['path_language'] = Tst::$root . 'language/';
    }

    public function testMBYTE_languageListDefault()
    {
        $dummy = array(
            'afrikaans_utf-8'           => 'Afrikaans',
            'bosnian_utf-8'             => 'Bosnian',
            'bulgarian_utf-8'           => 'Bulgarian',
            'catalan_utf-8'             => 'Catalan',
            'chinese_simplified_utf-8'  => 'Chinese (Simplified)',
            'chinese_traditional_utf-8' => 'Chinese (Traditional)',
            'croatian_utf-8'            => 'Croatian',
            'czech_utf-8'               => 'Czech',
            'danish_utf-8'              => 'Danish',
            'dutch_utf-8'               => 'Dutch',
            'english_utf-8'             => 'English',
            'estonian_utf-8'            => 'Estonian',
            'farsi_utf-8'               => 'Farsi',
            'finnish_utf-8'             => 'Finnish',
            'french_canada_utf-8'       => 'French (Canada)',
            'french_france_utf-8'       => 'French (France)',
            'german_utf-8'              => 'German',
            'german_formal_utf-8'       => 'German (Formal)',
            'hebrew_utf-8'              => 'Hebrew',
            'hellenic_utf-8'            => 'Hellenic',
            'indonesian_utf-8'          => 'Indonesian',
            'italian_utf-8'             => 'Italian',
            'japanese_utf-8'            => 'Japanese',
            'korean_utf-8'              => 'Korean',
            'norwegian_utf-8'           => 'Norwegian',
            'persian_utf-8'             => 'Persian',
            'polish_utf-8'              => 'Polish',
            'portuguese_utf-8'          => 'Portuguese',
            'portuguese_brazil_utf-8'   => 'Portuguese (Brazil)',
            'romanian_utf-8'            => 'Romanian',
            'russian_utf-8'             => 'Russian',
            'serbian_utf-8'             => 'Serbian',
            'slovak_utf-8'              => 'Slovak',
            'slovenian_utf-8'           => 'Slovenian',
            'spanish_utf-8'             => 'Spanish',
            'spanish_argentina_utf-8'   => 'Spanish (Argentina)',
            'swedish_utf-8'             => 'Swedish',
            'turkish_utf-8'             => 'Turkish',
            'ukrainian_utf-8'           => 'Ukrainian',
        );
        $retval = MBYTE_languageList();
        foreach ($dummy as $k => $v) {
            $this->assertEquals($v, $retval[$k], 'Error asserting dummy ' . $v . ' is equal to returned ' . $retval[$k] . '.');
        }
    }

    public function testMBYTE_languageListReturnsNotUtf8WithParameter()
    {
        $dummy = array(
            'afrikaans'         => 'Afrikaans',
            'bosnian'           => 'Bosnian',
            'bulgarian'         => 'Bulgarian',
            'catalan'           => 'Catalan',
            'croatian'          => 'Croatian',
            'czech'             => 'Czech',
            'danish'            => 'Danish',
            'dutch'             => 'Dutch',
            'english'           => 'English',
            'estonian'          => 'Estonian',
            'finnish'           => 'Finnish',
            'french_canada'     => 'French (Canada)',
            'french_france'     => 'French (France)',
            'german'            => 'German',
            'german_formal'     => 'German (Formal)',
            'hellenic'          => 'Hellenic',
            'indonesian'        => 'Indonesian',
            'italian'           => 'Italian',
            'korean'            => 'Korean',
            'norwegian'         => 'Norwegian',
            'polish'            => 'Polish',
            'portuguese'        => 'Portuguese',
            'portuguese_brazil' => 'Portuguese (Brazil)',
            'romanian'          => 'Romanian',
            'russian'           => 'Russian',
            'serbian'           => 'Serbian',
            'slovak'            => 'Slovak',
            'slovenian'         => 'Slovenian',
            'spanish'           => 'Spanish',
            'spanish_argentina' => 'Spanish (Argentina)',
            'swedish'           => 'Swedish',
            'turkish'           => 'Turkish',
            'ukrainian'         => 'Ukrainian',
            'ukrainian_koi8-u'  => 'Ukrainian (KOI8-U)',
        );

        $retval = MBYTE_languageList('other');
        foreach ($dummy as $k => $v) {
            $this->assertEquals($v, $retval[$k], 'Error asserting dummy ' . $v . ' is equal to returned ' . $retval[$k] . '.');
        }
    }

    public function testMBYTE_checkEnabledUtf8()
    {
        global $LANG_CHARSET;
        $LANG_CHARSET = 'utf-8';
        $this->assertFalse(MBYTE_checkEnabled('test', false));
    }

    public function testMBYTE_checkEnabledAlreadySetReturnsFalse()
    {
        $this->assertFalse(MBYTE_checkEnabled('test', false));
    }

    public function testMBYTE_strlen()
    {
        $this->assertEquals(6, MBYTE_strlen('string'));
    }

    public function testMBYTE_substrWhenLengthNull()
    {
        $this->assertEquals('chars.', MBYTE_substr('Ten chars.', 4));
    }

    public function testMBYTE_substrWhenLengthNotNull()
    {
        $this->assertEquals('ch', MBYTE_substr('Ten chars.', 4, 2));
    }

    public function testMBYTE_strposWhenOffsetNull()
    {
        $this->assertEquals(0, MBYTE_strpos('strpos this.', 's'));
    }

    public function testMBYTE_strposWhenoOffsetNotNull()
    {
        $this->assertEquals(5, MBYTE_strpos('strpos this.', 's', 1));
    }

    public function testMBYTE_strtolower()
    {
        $this->assertEquals('lowercase', MBYTE_strtolower('LoWErCaSE'));
    }

    public function testMBYTE_eregiWhenRegsNull()
    {
        $this->assertEquals(3, MBYTE_eregi('pat', 'A pattern'));
    }

    public function testMBYTE_eregiWhenRegsNotNull()
    {
        $dummy[0] = 'Pat';
        $result = MBYTE_eregi('pat', 'Pat my pattern', $regs);
        $this->assertEquals($dummy[0], $regs[0], 'Error asserting that correct pattern was matched.');
        $this->assertEquals(3, $result, 'Error asserting pattern matched was corret length.');
    }

    public function testMBYTE_eregi_replace()
    {
        $this->assertEquals('in my intern', MBYTE_eregi_replace('pat', 'in', 'Pat my pattern'));
    }
}
