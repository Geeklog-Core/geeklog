<?php

/**
 * Tests for lib-common
 */
class libCommonTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        Tst::createSiteConfigFile();
        require_once Tst::$public . 'lib-common.php';
    }

    protected function tearDown()
    {
        parent::tearDown();
        Tst::removeSiteConfigFile();
    }

    public function testGetBlockTemplateEmptyBlocknameWithHeader()
    {
        $this->assertEquals('blockheader.thtml', COM_getBlockTemplate('user_block', 'header'));
    }

    public function testGetBlockTemplateEmptyBlocknameWithOther()
    {
        $this->assertEquals('blockfooter.thtml', COM_getBlockTemplate('user_block', 'rand'));
    }

    public function testGetBlockTemplateWithBlocknamePositionSpecificNoOverride()
    {
        global $_BLOCK_TEMPLATE;
        $_BLOCK_TEMPLATE['_test_block'] = 'testblock.thtml,testblock.thtml';
        $this->assertEquals('testblock.thtml', COM_getBlockTemplate('_test_block', 'header', 'right'));
    }

    public function testGetBlockTemplateWithBlocknamePositionSpecificRequestOverride()
    {
        global $_BLOCK_TEMPLATE;
        $_BLOCK_TEMPLATE['_test_block'] = 'blockheader.thtml,blockfooter.thtml';
        $this->assertEquals('blockheader-right.thtml', COM_getBlockTemplate('_test_block', 'header', 'right'));
    }

    public function testGetBlockTemplateWithBlocknamePositionSpecificBlock()
    {
        global $_BLOCK_TEMPLATE;
        $_BLOCK_TEMPLATE['_test_block'] = 'blockheader-right.thtml,blockfooter-right.thtml';
        $this->assertEquals('blockheader-right.thtml', COM_getBlockTemplate('_test_block', 'header', 'right'));
    }

    public function testGetThemesNotAllowed()
    {
        global $_CONF;

        $_CONF['allow_user_themes'] = 0;
        $arr = COM_getThemes();
        $this->assertEquals('professional', $arr[1]);
    }

    public function testGetThemesNotAllowedAll()
    {
        global $_CONF;

        $_CONF['allow_user_themes'] = 1;
        $arr = COM_getThemes();
        $this->assertEquals('professional', $arr[1]);
    }

    public function testRenderMenu()
    {
        // Line 571
        // Come back to this after understand functions called inside


        //global $_CONF;

        //$header = new Template('c:/xampplite/htdocs/geeklog/public_html/layout/professional/');
        //$header->set_file(array('contribute', 'search', 'stats', 'directory', 'plugins'));
        //$plugin_menu = PLG_getMenuItems();        
        //COM_renderMenu($header, $plugin_menu);
        //$this->assertEquals(1, $_CONF['menu_elements']);
        $this->markTestIncomplete(
            'This test has not been implemented yet.');
    }

    public function testDebug()
    {
        // Line 1799
        $dummy = array('Letter 1' => 'a', 'Letter 2' => 'b');

        $retval = '<ul><pre><p>---- DEBUG ----</p>';
        foreach ($dummy as $k => $v) {
            $retval .= sprintf("<li>%13s [%s]</li>\n", $k, $v);
        }
        $retval .= '<p>---------------</p></pre></ul>';

        $compare = COM_debug($dummy);
        $this->assertEquals($retval, $compare, "Error asserting $output matched $compare");
    }

    public function testRefresh()
    {
        // Line 2794
        $url = 'http://localhost/';
        $dummy = "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
        $this->assertEquals($dummy, COM_refresh($url));
    }

    public function testCheckWordsNoReplace()
    {
        // Line 2823    
        $message = COM_checkWords('Clean');
        $this->assertEquals('Clean', $message);
    }

    public function testCheckWordsWithReplaceExactMatch1()
    {
        // Line 2823        
        $message = COM_checkWords('cock');
        $this->assertEquals('*censored*', $message);
    }

    public function testCheckWordsWithReplaceWordBeginning()
    {
        // Line 2823        
        $message = COM_checkWords('cockblock');
        $this->assertEquals('*censored*block', $message);
    }

    public function testCheckWordsWithReplaceWordFragment()
    {
        // Line 2823        
        $message = COM_checkWords('Peacocks');
        $this->assertEquals('Pea*censored*s', $message);
    }

    public function testKillJsWithJs()
    {
        // Line 2876
        $this->assertEquals(' inblur=', COM_killJs(' onblur='));
    }

    public function testKillJsWithoutJs()
    {
        // Line 2876
        $this->assertEquals('onBlur', COM_killJs('onBlur'));
    }

    public function testHandleCode()
    {
        // Line 2890
        $this->assertEquals('&amp;a&#92;b&lt;c&gt;d&#91;e&#93;', COM_handleCode('&a\\b<c>d[e]'));
    }

    public function testCheckHTMLWithBothCodeTags()
    {
        // Line 2896
        $this->assertEquals('<pre><code>&lt;!-- string --&gt;&#36;var&#92;n&#92;</code></pre>',
            COM_checkHTML('<!-- string -->[cODe]<!-- string -->$var\\\n\\\[/coDE]'));
    }

    public function testCheckHTMLMissingLastCodeTag()
    {
        // Line 2923
        $this->assertEquals('<pre><code>&lt;!-- string --&gt;&#36;var&#92;n&#92;</code></pre>',
            COM_checkHTML('<!-- string -->[Code]<!-- string -->$var\\\\n\\\\'));
    }

    public function testCheckHTMLWithBothRawTags()
    {
        // Line 2923
        $this->assertEquals('<!--raw--><span class="raw">&lt;!-- string --&gt;&#36;var&#92;n&#92;</span><!--/raw-->',
            COM_checkHTML('<!-- string -->[RAw]<!-- string -->$var\\\n\\\[/RaW]'));
    }

    public function testCheckHTMLMissingLastRawTag()
    {
        // Line 2923
        $this->assertEquals('<!--raw--><span class="raw">&lt;!-- string --&gt;&#36;var&#92;n&#92;</span><!--/raw-->',
            COM_checkHTML('<!-- string -->[RAw]<!-- string -->$var\\\n\\\\'));
    }

    public function testCheckHTMLWithBothCodeTagsAndCONFSkip_html_filter_for_rootEquals0()
    {
        // Line 2923
        global $_CONF, $_GROUPS;
        $_CONF['skip_html_filter_for_root'] = 1;
        $_GROUPS['Root'] = 'Root';
        $this->assertEquals('<!-- string --><pre><code>&lt;!-- string --&gt;&amp;#36;var&amp;#092;n&amp;#092;</code></pre>',
            COM_checkHTML('<!-- string -->[cODe]<!-- string -->$var\\\n\\\\[/coDE]'));
    }

    public function testCheckHTMLMissingLastCodeTagCONFSkip_html_filter_for_rootEquals0()
    {
        // Line 2923
        global $_CONF, $_GROUPS;
        $_CONF['skip_html_filter_for_root'] = 1;
        $_GROUPS['Root'] = 'Root';
        $this->assertEquals('<!-- string --><pre><code>&lt;!-- string --&gt;&amp;#36;var&amp;#092;n&amp;#092;</code></pre>',
            COM_checkHTML('<!-- string -->[Code]<!-- string -->$var\\\n\\\\'));
    }

    public function testCheckHTMLWithBothRawTagsCONFSkip_html_filter_for_rootEquals0()
    {
        // Line 2923
        global $_CONF, $_GROUPS;
        $_CONF['skip_html_filter_for_root'] = 1;
        $_GROUPS['Root'] = 'Root';
        $this->assertEquals('<!-- string -->[raw2]&lt;!-- string --&gt;&amp;#36;var&amp;#092;n&amp;#092;[/raw2]',
            COM_checkHTML('<!-- string -->[RAw]<!-- string -->$var\\\n\\\[/RaW]'));
    }

    public function testCheckHTMLMissingLastRawTagCONFSkip_html_filter_for_rootEquals0()
    {
        // Line 2923
        global $_CONF, $_GROUPS;
        $_CONF['skip_html_filter_for_root'] = 1;
        $_GROUPS['Root'] = 'Root';
        $this->assertEquals('<!-- string -->[raw2]&lt;!-- string --&gt;&amp;#36;var&amp;#092;n&amp;#092;[/raw2]',
            COM_checkHTML('<!-- string -->[RAw]<!-- string -->$var\\\n\\\\'));
    }

    public function testUndoSpecialChars()
    {
        // Line 3048
        $encoded = '&#36;a&#123;b&#125;c&gt;d&lt;e&quot;f&nbsp;g&amp;h';
        $decoded = '$a{b}c>d<e"f g&h';
        $this->assertEquals($decoded, COM_undoSpecialChars($encoded));
    }

    public function testMakesidDoesNotDuplicateAndIsInteger()
    {
        // Line 3073
        $dummysid = date('YmdHis');
        $dummysid .= rand(0, 999);
        $this->assertNotEquals($dummysid, COM_makesid(), 'Error asserting return value is unique.');
        $this->assertType(string, COM_makesid(), 'Error asserting return type was string.');
    }

    public function testIsMailReturnsTrueForValidEmails()
    {
        // Line 3090
        // Commented emails should be valid,
        // but fail PEAR isValidInetAddress validation.
        $validemails = array(
            "dclo@us.ibm.com",
            //"abc\\@def@example.com",
            //"abc\\\\@example.com",
            //"Fred\\ Bloggs@example.com",
            //"Joe.\\\\Blow@example.com",
            //"\"Abc@def\"@example.com",
            //"\"Fred Bloggs\"@example.com",
            "customer/department=shipping@example.com",
            "\$A12345@example.com",
            "!def!xyz%abc@example.com",
            "_somename@example.com",
            "user+mailbox@example.com",
            "peter.piper@example.com",
            //"Doug\\ \\\"Ace\\\"\\ Lovell@example.com",
            //"\"Doug \\\"Ace\\\" L.\"@example.com"
        );
        foreach ($validemails as $k => $email) {
            $this->assertTrue(COM_isEmail($email), 'Error asserting ' . $email . ' is valid email');
        }
    }

    public function testIsEmailReturnFalseForInvalidEmails()
    {
        // Line 3075
        // Commented emails should be invalid, 
        // but pass PEAR isValidInetAddress validation.
        $invalidemails = array(
            "abc@def@example.com",
            "abc\\\\@def@example.com",
            "abc\\@example.com",
            "@example.com",
            "doug@",
            "\"qu@example.com",
            "ote\"@example.com",
            //".dot@example.com",
            //"dot.@example.com",
            //"two..dot@example.com",
            "\"Doug \"Ace\" L.\"@example.com",
            "Doug\\ \\\"Ace\\\"\\ L\\.@example.com",
            "hello world@example.com",
            "gatsby@f.sc.ot.t.f.i.tzg.era.l.d.");
        foreach ($invalidemails as $k => $invalid) {
            $this->assertFalse(COM_isEmail($invalid), 'Error asserting ' . $invalid . ' is an invalid email');
        }
    }

    public function testEmailEscape()
    {
        // Line 3090
        $email = 'johndoe@domain.com';

        $scenario['CUSTOM_emailEscape'] = function_exists('CUSTOM_emailEscape');
        $scenario['iconv_mime_encode'] = function_exists('iconv_mime_encode');
        $scenario['preg_match'] = preg_match('/[^0-9a-z\-\.,:;\?! ]/i', $email);

        foreach ($scenario as $function => $exists) {
            $escapedEmail = '=?iso-8859-1?B?am9obmRvZUBkb21haW4uY29t?=';
            if ($exists) {
                $this->assertEquals($escapedEmail, COM_emailEscape($email), 'Error tested using ' . $function);
            }
        }
    }

    public function testFormatEmailAddressUTF8()
    {
        // Line 3133
        $email = COM_formatEmailAddress('John\\ Doe', 'john.doe@example.com');
        $formattedEmail = '=?iso-8859-1?B?Sm9oblwgRG9l?= <john.doe@example.com>';
        $this->assertEquals($formattedEmail, $email);
    }

    public function testFormatEmailAddress()
    {
        // Line 3133
        $email = COM_formatEmailAddress('John Doe', 'john.doe@example.com');
        $formattedEmail = 'John Doe <john.doe@example.com>';
        $this->assertEquals($formattedEmail, $email);
    }

    public function testShowMessageFromParameter()
    {
        // Line 4527
        $_GET['msg'] = 6;
        $msg = COM_showMessageFromParameter();
        $this->assertTrue(!empty($msg));
    }

    public function testCreateWithHttpUrl()
    {
        $url = 'http://www.example.com/image.png';
        $fixture = '<img src="' . $url . '" alt="">';
        $this->assertEquals($fixture, COM_createImage($url));
    }

    /**
     * @link http://project.geeklog.net/tracking/view.php?id=881
     */

    public function testCreateWithHttpsUrl()
    {
        $url = 'https://www.example.com/image.png';
        $alt = 'An image';
        $attr = array('id' => 'anImage');

        $result = '<img src="' . $url . '" id="anImage" alt="An image">';

        $this->assertEquals($result, COM_createImage($url, $alt, $attr));
    }

    public function testCreateWithoutUrl()
    {
        global $_CONF;

        $image = '/image.png';
        $url = $_CONF['layout_url'] . $image;
        $fixture = '<img src="' . $url . '" alt="">';
        $this->assertFalse(empty($_CONF['layout_url']));
        $this->assertEquals($fixture, COM_createImage($url));
    }
}
