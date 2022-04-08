<?php

namespace Geeklog\Test;

use PHPUnit\Framework\TestCase;
use Plugin;

/**
 * Simple tests for plugin.class.php
 */
class PluginClassTest extends TestCase
{
    /**
     * @var Plugin
     */
    private $p;

    protected function setUp(): void
    {
        $this->p = new Plugin;
    }

    public function testConstructorPlugin()
    {
        $dummy = array(
            'adminlabel'         => '',
            'adminurl'           => '',
            'plugin_image'       => '',
            'num_submissions'    => 0,
            'plugin_name'        => '',
            'searchlabel'        => '',
            'searchheading'      => array(),
            'num_searchresults'  => 0,
            'searchresults'      => array(),
            'num_itemssearched'  => 0,
            'num_searchheadings' => 0,
            'submissionlabel'    => '',
            'submissionhelpfile' => '',
            'getsubmissionssql'  => '',
            'submissionheading'  => array(),
            'supports_paging'    => false,
        );

        foreach ($dummy as $k => $v) {
            ob_start();
            var_dump($v);
            $vForPrint = ob_get_clean();
            $this->assertEquals($v, $this->p->$k, "Failed asserting that variable '{$k}' was '{$vForPrint}'");
        }
    }

    public function testResetAlsoTestedInConstructor()
    {
        $dummy = array(
            'adminlabel'         => '',
            'adminurl'           => '',
            'plugin_image'       => '',
            'num_submissions'    => 0,
            'plugin_name'        => '',
            'searchlabel'        => '',
            'searchheading'      => array(),
            'num_searchresults'  => 0,
            'searchresults'      => array(),
            'num_itemssearched'  => 0,
            'num_searchheadings' => 0,
            'submissionlabel'    => '',
            'submissionhelpfile' => '',
            'getsubmissionssql'  => '',
            'submissionheading'  => array(),
            'supports_paging'    => false);

        $this->p->reset();

        foreach ($dummy as $k => $v) {
            ob_start();
            var_dump($v);
            $vForPrint = ob_get_clean();
            $this->assertEquals($v, $this->p->$k, "Failed asserting that variable '{$k}' was '{$vForPrint}'");
        }
    }

    public function testAddSearchHeadingSetsNum_Searchheadings()
    {
        $this->p->addSearchHeading('Dummy');
        $this->assertEquals(1, $this->p->num_searchheadings);
    }

    public function testAddSearchHeadingSetsSearcheading()
    {
        $this->p->addSearchHeading('Dummy');
        $this->assertEquals('Dummy', $this->p->searchheading[$this->p->num_searchheadings]);
    }

    public function testAddSearchHeadingSetsAdditionalSearcheading()
    {
        $this->p->addSearchHeading('Dummy');
        $this->assertEquals('Dummy', $this->p->searchheading[$this->p->num_searchheadings],
            'Setting first heading failed');
        $this->p->addSearchHeading('Dummy2');
        $this->assertEquals('Dummy2', $this->p->searchheading[$this->p->num_searchheadings],
            'Setting additional heading failed');
    }

    public function testAddSearchResults()
    {
        $dummy = array('Item1, Item2, Item3', 'Item4, Item5, Item6', 'Item7, Item8');
        $this->p->addSearchResult('Item1, Item2, Item3');
        $this->p->addSearchResult('Item4, Item5, Item6');
        $this->p->addSearchResult('Item7, Item8');
        foreach ($dummy as $k => $v) {
            $this->assertEquals($v, $this->p->searchresults[$k],
                'There was a problem adding the ' . $k . ' set of results.');
        }
    }

    public function testAddSubmissionHeadingAddsHeading()
    {
        $this->p->num_submissions = 2;
        $this->p->addSubmissionHeading('header');
        $this->assertEquals('header', $this->p->submissionheading[2]);
    }

    public function testAddSubmissionHeadingIncrementsNum_Submissions()
    {
        $this->p->num_submissions = 2;
        $this->p->addSubmissionHeading('header');
        $this->assertEquals(3, $this->p->num_submissions);
    }

    public function testAddSubmissionHeadingAtDefaultAddsHeading()
    {
        $this->p->addSubmissionHeading('header');
        $this->assertEquals('header', $this->p->submissionheading[0]);
    }

    public function testAddSubmissionHeadingAtDefaultIncrementsNum_Submissions()
    {
        $this->p->addSubmissionHeading('header');
        $this->assertEquals(1, $this->p->num_submissions);
    }

    public function testSetExpandedSearchSupportReturnsFalseWithoutBooleanParam()
    {
        $this->p->setExpandedSearchSupport(1);
        $this->assertFalse($this->p->_expandedSearchSupport);
    }

    public function testSetExpandedSearchSupportReturnsFalse()
    {
        $this->p->setExpandedSearchSupport(false);
        $this->assertFalse($this->p->_expandedSearchSupport);
    }

    public function testSetExpandedSearchSupportReturnsTrue()
    {
        $this->p->setExpandedSearchSupport(true);
        $this->assertTrue($this->p->_expandedSearchSupport);
    }

    public function testSupportsExpandedSearchReturnsFalseOnDefault()
    {
        $this->assertFalse($this->p->supportsExpandedSearch());
    }

    public function testSupportsExpandedSearchReturnsTrueWhenDefined()
    {
        $this->p->_expandedSearchSupport = true;
        $this->assertTrue($this->p->supportsExpandedSearch());
    }
}
