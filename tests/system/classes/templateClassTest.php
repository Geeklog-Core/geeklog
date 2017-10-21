<?php

use \PHPUnit\Framework\TestCase as TestCase;

/**
 * Simple tests for the Template class
 */
class templateClass extends TestCase
{
    /**
     * @var Template
     */
    private $tp;

    protected function setUp()
    {
        global $_CONF, $TEMPLATE_OPTIONS, $_DEVICE;

        $_CONF['language'] = Tst::LANGUAGE;
        $_CONF['theme'] = Tst::THEME;
        $_CONF['path_data'] = Tst::$root . 'data/';
        $_CONF['path_themes'] = Tst::$public . 'layout/';
        $_CONF['path_layout'] = $_CONF['path_themes'] . $_CONF['theme'] . '/';
        $_CONF['cache_templates'] = true;
        $_CONF['cache_mobile'] = true;
        $_CONF['site_url'] = 'http://www.example.com';
        $_CONF['site_admin_url'] = $_CONF['site_url'] . '/admin';
        $_CONF['layout_url'] = $_CONF['site_url'] . '/layout';
        $_CONF['cache_templates'] = false;

        require_once $_CONF['path_system'] . 'classes/mobiledetect/Mobile_Detect.php';
        $_DEVICE = new Mobile_Detect();

        // Reset Template Options so they do not include default vars
        $TEMPLATE_OPTIONS = array(
            'path_cache'          => $_CONF['path_data'] . 'layout_cache/',   // location of template cache
            'path_prefixes'       => array(                               // used to strip directories off file names. Order is important here.
                $_CONF['path_themes'],  // this is not path_layout. When stripping directories, you want files in different themes to end up in different directories.
                $_CONF['path'],
                '/'                     // this entry must always exist and must always be last
            ),
            'incl_phpself_header' => true,          // set this to true if your template cache exists within your web server's docroot.
            'cache_by_language'   => true,            // create cache directories for each language. Takes extra space but moves all $LANG variable text directly into the cached file
            'cache_for_mobile'    => $_CONF['cache_mobile'],  // create cache directories for mobile devices. Non mobile devices uses regular directory. If disabled mobile uses regular cache files. Takes extra space
            'default_vars'        => array(),
            'hook'                => array(),
        );

        $this->tp = new Template(Tst::$tests . 'files/templates');
    }

    /***
     * Helper function: strip all linefeed characters (CR + LF) from a string.
     * Just in case our reference files are converted to the native linefeed of
     * the platform we're running on (Unix LF vs. Windows CR+LF).
     */
    private function strip_linefeeds($line)
    {
        return str_replace(array("\015", "\012"), '', $line);
    }

    public function testGetVarDefault()
    {
        $tp2 = new Template;
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testSetVar()
    {
        $tp2 = new Template;
        $tp2->set_var('test', 'test42');
        $this->assertEquals("test42", $tp2->get_var('test'));
    }

    public function testSetVarHash()
    {
        $tp2 = new Template;
        $hash = array('test' => 'test41');
        $tp2->set_var($hash);
        $this->assertEquals("test41", $tp2->get_var('test'));
    }

    public function testSetVarHashMultiple()
    {
        $tp2 = new Template;
        $hash = array('test1' => 'test43', 'test2' => 'test42');
        $tp2->set_var($hash);
        $this->assertEquals("test43", $tp2->get_var('test1'));
        $this->assertEquals("test42", $tp2->get_var('test2'));
    }

    public function testSetVarAppend()
    {
        $tp2 = new Template;
        $tp2->set_var('test', 'test42');
        $this->assertEquals("test42", $tp2->get_var('test'));
        $tp2->set_var('test', '42test', true);
        $this->assertEquals("test4242test", $tp2->get_var('test'));
    }

    public function testSetVarHashAppend()
    {
        $tp2 = new Template;
        $hash = array('test' => 'test41');
        $tp2->set_var($hash);
        $hash2 = array('test' => '41test');
        $tp2->set_var($hash2, '', true);
        $this->assertEquals("test4141test", $tp2->get_var('test'));
    }

    public function testClearVar()
    {
        $tp2 = new Template;
        $tp2->set_var('test', 'test42');
        $this->assertEquals("test42", $tp2->get_var('test'));
        $tp2->clear_var('test');
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testClearVarNotExist()
    {
        $tp2 = new Template;
        $tp2->clear_var('doesnotexist');
        $this->assertEquals("", $tp2->get_var('doesnotexist'));
    }

    public function testClearVarHash()
    {
        $tp2 = new Template;
        $hash = array('test' => 'test43');
        $tp2->set_var($hash);
        $this->assertEquals("test43", $tp2->get_var('test'));
        $tp2->clear_var('test');
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testClearVarHash2()
    {
        $tp2 = new Template;
        $hash = array('test' => 'test43');
        $tp2->set_var($hash);
        $this->assertEquals("test43", $tp2->get_var('test'));
        $hash2 = array('test');
        $tp2->clear_var($hash2);
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testClearVarHashNotExist()
    {
        $tp2 = new Template;
        $hash = array('doesnotexist');
        $tp2->clear_var($hash);
        $this->assertEquals("", $tp2->get_var('doesnotexist'));
    }

    public function testClearVarHashMultiple()
    {
        $tp2 = new Template;
        $hash = array('test1' => 'test41', 'test2' => 'test42');
        $tp2->set_var($hash);
        $this->assertEquals("test41", $tp2->get_var('test1'));
        $this->assertEquals("test42", $tp2->get_var('test2'));
        $hash2 = array('test1', 'test2');
        $tp2->clear_var($hash2);
        $this->assertEquals("", $tp2->get_var('test1'));
        $this->assertEquals("", $tp2->get_var('test2'));
    }

    public function testUnsetVar()
    {
        $tp2 = new Template;
        $tp2->set_var('test', 'test42');
        $this->assertEquals("test42", $tp2->get_var('test'));
        $tp2->unset_var('test');
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testUnsetVarNotExist()
    {
        $tp2 = new Template;
        $tp2->unset_var('doesnotexist');
        $this->assertEquals("", $tp2->get_var('doesnotexist'));
    }

    public function testUnsetVarHash()
    {
        $tp2 = new Template;
        $hash = array('test' => 'test43');
        $tp2->set_var($hash);
        $this->assertEquals("test43", $tp2->get_var('test'));
        $tp2->unset_var('test');
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testUnsetVarHash2()
    {
        $tp2 = new Template;
        $hash = array('test' => 'test43');
        $tp2->set_var($hash);
        $this->assertEquals("test43", $tp2->get_var('test'));
        $hash2 = array('test');
        $tp2->unset_var($hash2);
        $this->assertEquals("", $tp2->get_var('test'));
    }

    public function testUnsetVarHashNotExist()
    {
        $tp2 = new Template;
        $hash = array('doesnotexist');
        $tp2->unset_var($hash);
        $this->assertEquals("", $tp2->get_var('doesnotexist'));
    }

    public function testUnsetVarHashMultiple()
    {
        $tp2 = new Template;
        $hash = array('test1' => 'test41', 'test2' => 'test42');
        $tp2->set_var($hash);
        $this->assertEquals("test41", $tp2->get_var('test1'));
        $this->assertEquals("test42", $tp2->get_var('test2'));
        $hash2 = array('test1', 'test2');
        $tp2->unset_var($hash2);
        $this->assertEquals("", $tp2->get_var('test1'));
        $this->assertEquals("", $tp2->get_var('test2'));
    }

    public function testSetRoot()
    {
        $tp2 = new Template;
        $this->assertTrue($tp2->set_root('.'));
    }

    public function testSetRootTestpackageFiles()
    {
        $this->assertTrue($this->tp->set_root(Tst::$tests . 'files/templates'));
    }

    public function testSetRootInConstructors()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertEquals(Tst::$tests . 'files/templates', $tp2->getRoot()[0]);
    }

    public function testSetFile()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
    }

    public function testSetFileEmpty()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        // we don't want the error handler to kick in, so:
        $tp2->halt_on_error = 'no';

        $this->assertFalse($tp2->set_file('testfile', ''));
    }

    public function testSetFileNotExist()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        // we don't want the error handler to kick in, so:
        $tp2->halt_on_error = 'no';
        // somewhat odd behavior: if halt_on_error is disabled, set_file()
        // returns with true, even though the file does not exist           
        $this->assertTrue($tp2->set_file('missing', 'doesnotexist.thtml'));
    }

    public function testSetFileMultiple()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $files = array(
            'testfile1' => 'replace1.thtml',
            'testfile2' => 'replace2.thtml',
        );
        $this->assertTrue($tp2->set_file($files));
    }

    public function testSetFileMultipleEmpty()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        // we don't want the error handler to kick in, so:
        $tp2->halt_on_error = 'no';
        $files = array(
            'testfile1' => 'replace1.thtml',
            'testfile2' => '',
        );
        $this->assertFalse($tp2->set_file($files));
    }

    public function testGetVars()
    {
        global $TEMPLATE_OPTIONS;

        // Reset Template Options so they do not include default vars
        $TEMPLATE_OPTIONS = array('default_vars' => array());

        $tp2 = new Template;
        $hash = array('test2' => 'test43', 'test1' => 'test42');
        $tp2->set_var($hash);
        $vars = $tp2->get_vars();
        $this->assertEquals($hash, $vars);
    }

    public function testGetVarMultiple()
    {
        $tp2 = new Template;
        $hash = array('test2' => 'test43', 'test1' => 'test42');
        $tp2->set_var($hash);
        $vars = array('test1', 'test2');
        $values = $tp2->get_var($vars);
        $this->assertEquals($hash, $values);
    }

    public function testGetVarMultipleUndefined()
    {
        $tp2 = new Template;
        $hash = array('test2' => 'test43', 'test1' => 'test42');
        $tp2->set_var($hash);
        $vars = array('test1', 'test3'); // 'test3' should be undefined
        $values = $tp2->get_var($vars);
        $expected = array('test1' => 'test42', 'test3' => '');
        $this->assertEquals($expected, $values);
    }

    public function testParse()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
        $tp2->set_var('test', 'replaced');
        $replaced = $tp2->parse('myform', 'testfile');
        $replaced = $this->strip_linefeeds($replaced);
        $this->assertEquals('<p>replaced</p>', $replaced);
        $now = $tp2->get_var('myform');
        $now = $this->strip_linefeeds($now);
        $this->assertEquals('<p>replaced</p>', $now);
    }

    public function testParseAppend()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
        $tp2->set_var('test', 'replaced');
        $replaced = $tp2->parse('myform', 'testfile');
        $replaced = $this->strip_linefeeds($replaced);
        $this->assertEquals('<p>replaced</p>', $replaced);
        $now = $tp2->get_var('myform');
        $now = $this->strip_linefeeds($now);
        $this->assertEquals('<p>replaced</p>', $now);

        $tp2->set_var('test', 'appended');
        $appended = $tp2->parse('myform', 'testfile', true);
        $appended = $this->strip_linefeeds($appended);
        $this->assertEquals('<p>appended</p>', $appended);

        $all = $tp2->get_var('myform');
        $all = $this->strip_linefeeds($all);
        $this->assertEquals('<p>replaced</p><p>appended</p>', $all);
    }

    // * DEPRECATED: The function get_undefined doesn't really work any more. 
    //See template class for more information
    /*
    public function testGetUndefined() {
        global $TEMPLATE_OPTIONS;
        
        // Reset Template Options so they do not include default vars
        $TEMPLATE_OPTIONS = array('default_vars' => array());
        
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
        $undef = $tp2->get_undefined('testfile');
        $expected = array('test' => 'test'); // a hash of varname/varname pairs
        $this->assertEquals($expected, $undef);
    }
    */

    public function testGetUndefinedLoadError()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        // we don't want the error handler to kick in, so:
        $tp2->halt_on_error = 'no';
        $this->assertTrue($tp2->set_file('testfile', 'doesnotexist.thtml'));
        $this->assertFalse($tp2->get_undefined('testfile'));
    }

    public function testGetUndefinedUnknownVariable()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
        $this->assertFalse($tp2->get_undefined('doesnotexist'));
    }

    public function testFinishKeep()
    {
        global $TEMPLATE_OPTIONS;

        // Reset Template Options so they do not include default vars
        $TEMPLATE_OPTIONS['default_vars'] = array();

        $tp2 = new Template(Tst::$tests . 'files/templates');
        $tp2->set_unknowns('keep');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $this->assertEquals('<p>replaced:{test2}</p>', $parsed);
        $finished = $tp2->finish($parsed);
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:{test2}</p>', $finished);
    }

    public function testFinishRemove()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $tp2->set_unknowns('remove');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->finish($parsed);
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:</p>', $finished);
    }

    public function testFinishComment()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $tp2->set_unknowns('comment');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->finish($parsed);
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:<!-- Template variable test2 undefined --></p>', $finished);
    }

    public function testFinishDefault()
    {
        // default is "remove", so same result as testFinishRemove above
        $tp2 = new Template(Tst::$tests . 'files/templates');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->finish($parsed);
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:</p>', $finished);
    }

    public function testFinishCtorKeep()
    {
        // set 'keep' in the c'tor
        $tp2 = new Template(Tst::$tests . 'files/templates', 'keep');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->finish($parsed);
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:{test2}</p>', $finished);
    }

    public function testFinishCtorComment()
    {
        // set 'keep' in the c'tor
        $tp2 = new Template(Tst::$tests . 'files/templates', 'comment');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->finish($parsed);
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:<!-- Template variable test2 undefined --></p>', $finished);
    }

    public function testGetKeep()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $tp2->set_unknowns('keep');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->get('myform');
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:{test2}</p>', $finished);
    }

    public function testGetRemove()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $tp2->set_unknowns('remove');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->get('myform');
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:</p>', $finished);
    }

    public function testGetComment()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $tp2->set_unknowns('comment');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->get('myform');
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:<!-- Template variable test2 undefined --></p>', $finished);
    }

    public function testGetDefault()
    {
        // default is "remove", so same result as testGetRemove above
        $tp2 = new Template(Tst::$tests . 'files/templates');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->get('myform');
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:</p>', $finished);
    }

    public function testGetCtorKeep()
    {
        // set 'keep' in the c'tor
        $tp2 = new Template(Tst::$tests . 'files/templates', 'keep');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->get('myform');
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:{test2}</p>', $finished);
    }

    public function testGetCtorComment()
    {
        // set 'keep' in the c'tor
        $tp2 = new Template(Tst::$tests . 'files/templates', 'comment');

        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'replaced');
        $parsed = $tp2->parse('myform', 'testfile');
        $parsed = $this->strip_linefeeds($parsed);

        $finished = $tp2->get('myform');
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<p>replaced:<!-- Template variable test2 undefined --></p>', $finished);
    }

    public function testNestedTemplates()
    {
        // typical Geeklog use case: nested templates
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file(array(
            'menu'     => 'menu.thtml',
            'menuitem' => 'menuitem.thtml',
        )));

        // first menu entry
        $tp2->set_var('itemtext', 'Text 1');
        $parsed = $tp2->parse('menu_elements', 'menuitem', true);
        $parsed = $this->strip_linefeeds($parsed);
        $this->assertEquals('<span>Text 1</span>', $parsed);

        // second menu entry
        $tp2->set_var('itemtext', 'Text 2');
        $parsed = $tp2->parse('menu_elements', 'menuitem', true);
        $parsed = $this->strip_linefeeds($parsed);
        $this->assertEquals('<span>Text 2</span>', $parsed);

        // finished menu
        $parsed = $tp2->parse('parsed', 'menu');
        $parsed = $this->strip_linefeeds($parsed);
        $this->assertEquals('<div><span>Text 1</span><span>Text 2</span></div>',
            $parsed);
        $finished = $tp2->finish($parsed);
        $finished = $this->strip_linefeeds($finished);
        $this->assertEquals('<div><span>Text 1</span><span>Text 2</span></div>',
            $finished);
    }

    // thanks to http://ontosys.com/php/templates.html for explaining blocks ...

    public function testSetBlock()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file(array('blocks' => 'blocks.thtml')));
        $tp2->set_var('title', 'My Title');

        // 'header' is the first block in blocks.thtml
        $this->assertTrue($tp2->set_block('blocks', 'header'));
        $parsed = $tp2->parse('parsed', 'header');
        $parsed = $this->strip_linefeeds($parsed);
        $this->assertEquals('<html><head><title>My Title</title></head><body><h1>My Title</h1>', $parsed);
    }

    public function testSetBlockSecondBlock()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file(array('blocks' => 'blocks.thtml')));
        $tp2->set_var('year', '2010');

        // 'footer' is the second block in blocks.thtml
        $this->assertTrue($tp2->set_block('blocks', 'footer'));
        $parsed = $tp2->parse('parsed', 'footer');
        $parsed = $this->strip_linefeeds($parsed);
        $this->assertEquals('<p>(C) 2010 me</p></body></html>', $parsed);
    }

    public function testSetBlockNotExist()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file(array('blocks' => 'blocks.thtml')));

        // Even if it does not exist it will always return true since blocks
        // processed else where now.
        // there is no block 'body' in blocks.thtml
        $this->assertTrue($tp2->set_block('blocks', 'body'));
    }

    function testSubst()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace1.thtml'));
        $tp2->set_var('test', 'My Test');
        $sub = $tp2->subst('testfile');
        $sub = $this->strip_linefeeds($sub);
        $this->assertEquals('<p>My Test</p>', $sub);
    }

    function testSubstNotFinished()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertTrue($tp2->set_file('testfile', 'replace2.thtml'));
        $tp2->set_var('test1', 'My Test');
        $sub = $tp2->subst('testfile');
        $sub = $this->strip_linefeeds($sub);

        // subst() does not apply the finish rules, so we get back the {test2}
        //$this->assertEquals('<p>My Test:{test2}</p>', $sub);
        // process is done else where now so {test2} variable is not present in this output
        $this->assertEquals('<p>My Test:</p>', $sub);
    }

    function testSetUnknowns()
    {
        $tp2 = new Template;
        $tp2->set_unknowns('keep');
        // there should be a getter method for this ...
        $this->assertEquals('keep', $tp2->getUnknowns());
    }

    function testSetUnknownsDefault()
    {
        $tp2 = new Template;
        // default is 'remove'
        $this->assertEquals('remove', $tp2->getUnknowns());
    }

    // tests for private methods ----------------------------------------------

    public function testFilenameRelative()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertEquals(Tst::$tests . 'files/templates/replace1.thtml',
            $tp2->filename('replace1.thtml'));
    }

    public function testFilenameAbsolute()
    {
        $tp2 = new Template(Tst::$tests . 'files/templates');
        $this->assertEquals(Tst::$tests . 'files/templates/replace1.thtml',
            $tp2->filename(Tst::$tests . 'files/templates/replace1.thtml'));
    }

    public function testHalt()
    {
        // silly halt() test, for completeness
        $tp2 = new Template;
        $tp2->halt_on_error = 'no';
        $this->assertEquals(null, $tp2->halt("This won't stop me!"));
        $this->assertEquals("This won't stop me!", $tp2->last_error);
    }
}
