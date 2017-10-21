<?php

use \PHPUnit\Framework\TestCase as TestCase;

/**
 * Simple tests for plugin.class.php
 */
class searchcriteriaClass extends TestCase
{
    private $s;

    protected function setUp()
    {
        $this->s = new SearchCriteria('createVirus', 'unleashZombies');
    }

    public function testSearchCriteriaConstructorSetsDefaults()
    {
        $dummy = array(
            '_pluginName'   => 'createVirus',
            '_pluginLabel'  => 'unleashZombies',
            '_rank'         => 3,
            '_url_rewrite'  => false,
            '_append_query' => true);

        foreach ($dummy as $k => $v) {
            $this->assertEquals($v, $this->s->$k,
                'Error asserting dummy ' . $k . ' was equal to class variable ' . $k . '.');
        }
    }

    public function testSetSQL()
    {
        $this->s->setSQL('SELECT * FROM dummy');
        $this->assertEquals('SELECT * FROM dummy', $this->s->_sql);
    }

    public function testSetFTSQL()
    {
        $this->s->setFTSQL('SELECT * FROM dummy');
        $this->assertEquals('SELECT * FROM dummy', $this->s->_ftsql);
    }

    public function testSetRank()
    {
        $this->s->setRank(4);
        $this->assertEquals(4, $this->s->_rank);
    }

    public function testSetURLRewriteEnable()
    {
        $this->s->setURLRewrite(true);
        $this->assertTrue($this->s->_url_rewrite);
    }

    public function testSetAppendQuery()
    {
        $this->s->setAppendQuery(false);
        $this->assertFalse($this->s->_append_query);
    }

    public function testGetSQLReturnDefault()
    {
        $this->assertEquals('', $this->s->getSQL());
    }

    public function testGetSQLReturnDefinedValue()
    {
        $dummy = 'SELECT * FROM dummy';
        $this->s->_sql = $dummy;
        $this->assertEquals($dummy, $this->s->getSQL());
    }

    // reach inside?
    public function testGetFTSQLWhen_FtsqlIsNotEmptyAndIsStringAndDb_dbmsIsMysql()
    {
        $GLOBALS['_DB_dbms'] = 'mysql';
        $dummy = 'SELECT * FROM dummy';
        $this->s->_ftsql = $dummy;
        $this->assertEquals($dummy, $this->s->getFTSQL());
    }


    public function testGetFTSQLWhen_FtsqlIsArray()
    {
        $dummy = array('SELECT * FROM dummy', 'SELECT * FROM dummy2');
        $this->s->_ftsql = $dummy;
        foreach ($this->s->getFTSQL() as $k => $v) {
            $this->assertEquals($v, $dummy[$k]);
        }
    }

    public function testGetFTSQLEqualsBlankWhen_FtsqlIsNotString()
    {
        $this->s->_ftsql = 1;
        $this->assertEquals('', $this->s->getFTSQL());
    }

    public function testGetFTSQLEqualsBlankWhen_FtsqlIsBlank()
    {
        $this->s->_ftsql = '';
        $this->assertEquals('', $this->s->getFTSQL());
    }

    public function testGetFTSQLEqualsBlankWhen_DB_dbmsIsNotMysql()
    {
        $GLOBALS['_DB_dbms'] = 'foo';
        $this->assertEquals('', $this->s->getFTSQL());
    }

    public function testGetNameReturnsPluginName()
    {
        $this->assertEquals('createVirus', $this->s->getName());
    }

    public function testGetLabelReturnsLabel()
    {
        $this->assertEquals('unleashZombies', $this->s->getLabel());
    }

    public function testGetRankReturnsRank()
    {
        $this->assertEquals(3, $this->s->getRank());
    }

    public function testURLRewriteEnable()
    {
        $this->assertEquals(false, $this->s->URLRewriteEnable());
    }

    public function testAppendQueryEnable()
    {
        $this->assertEquals(true, $this->s->AppendQueryEnable());
    }

    public function testBuildSearchSQLWithKeytypeAllAndTitles()
    {
        $_GET['title'] = 'dummy';
        $columns['title'] = 'coltitle';
        $SQL = 'A bit of SQL';
        $dsql = "$SQL AND ((coltitle LIKE '%word1%') AND (coltitle LIKE '%word2%')) ";
        $ftsql['mysql'] = "$SQL AND MATCH(coltitle) AGAINST ('+word1 +word2' IN BOOLEAN MODE)";
        $dummy = array($dsql, $ftsql);
        $arr = $this->s->buildSearchSQL('all', 'word1 word2', $columns, 'A bit of SQL ');
        $this->assertEquals($dummy[0], $arr[0],
            'Error asserting that dummy and actual SQL match.');
        $this->assertEquals($dummy[1]['mysql'], $arr[1]['mysql'],
            'Error asserting that $dummy[1][mysql] and $arr[1][mysql] are equal.');
    }

    public function testBuildSearchSQLWithKeytypeAllAndWithoutTitles()
    {
        $columns = array('coltitle1', 'coltitle2');
        $SQL = 'A bit of SQL';
        $dsql = "$SQL AND ((coltitle1 LIKE '%word1%' OR coltitle2 LIKE '%word1%') AND (coltitle1 LIKE '%word2%' OR coltitle2 LIKE '%word2%')) ";

        $ftwords['mssql'] = '"word1" AND "word2"';
        $ftsql['mysql'] = "$SQL AND MATCH(coltitle1,coltitle2) AGAINST ('+word1 +word2' IN BOOLEAN MODE)";

        $dummy = array($dsql, $ftsql);

        $arr = $this->s->buildSearchSQL('all', 'word1 word2', $columns, 'A bit of SQL ');

        $this->assertEquals($dummy[0], $arr[0],
            'Error asserting that dummy and actual SQL match.');
        $this->assertEquals($dummy[1]['mysql'], $arr[1]['mysql'],
            'Error asserting that $dummy[1][mysql] and $arr[1][mysql] are equal.');
    }

    public function testBuildSearchSQLWithKeytypeAnyAndTitles()
    {
        $_GET['title'] = 'dummy';
        $query = 'word1 word2';
        $columns['title'] = 'coltitle';
        $sql = 'A bit of SQL ';

        $ftwords['mysql'] = $query;

        $dsql = "$sql" . "AND ((coltitle LIKE '%word1%') OR  (coltitle LIKE '%word2%')) ";

        $ftsql['mysql'] = $sql . "AND MATCH(coltitle) AGAINST ('{$ftwords['mysql']}' IN BOOLEAN MODE)";

        $dummy = array($dsql, $ftsql);

        $arr = $this->s->buildSearchSQL('any', 'word1 word2', $columns, 'A bit of SQL ');

        $this->assertEquals($dummy[0], $arr[0],
            'Error asserting that dummy and actual SQL match.');
        $this->assertEquals($dummy[1]['mysql'], $arr[1]['mysql'],
            'Error asserting that $dummy[1][mysql] and $arr[1][mysql] are equal.');
    }

    public function testBuildSearchSQLWithKeytypeAnyAndWithoutTitles()
    {
        $columns = array('coltitle1', 'coltitle2');
        $query = 'word1 word2';
        $sql = 'A bit of SQL';
        $dsql = "$sql AND ((coltitle1 LIKE '%word1%' OR coltitle2 LIKE '%word1%') OR  (coltitle1 LIKE '%word2%' OR coltitle2 LIKE '%word2%')) ";

        $ftwords['mysql'] = $query;
        $ftsql['mysql'] = "$sql AND MATCH(coltitle1,coltitle2) AGAINST ('{$ftwords['mysql']}' IN BOOLEAN MODE)";

        $dummy = array($dsql, $ftsql);

        $arr = $this->s->buildSearchSQL('any', 'word1 word2', $columns, 'A bit of SQL ');

        $this->assertEquals($dummy[0], $arr[0],
            'Error asserting that dummy and actual SQL match.');
        $this->assertEquals($dummy[1]['mysql'], $arr[1]['mysql'],
            'Error asserting that $dummy[1][mysql] and $arr[1][mysql] are equal.');
    }

    public function testBuildSearchSQLWithKeytypeElseAndTitles()
    {
        $_GET['title'] = 'dummy';
        $query = 'word1 word2';
        $columns['title'] = 'coltitle';
        $sql = 'A bit of SQL ';

        $words = array($query);
        $sep = '   ';

        if (strpos($query, ' ') !== false) {
            $ftwords['mysql'] = '"' . $query . '"';
        } else {
            $ftwords['mysql'] = $query;
        }

        $ftsql['mysql'] = $sql . "AND MATCH(coltitle) AGAINST ('{$ftwords['mysql']}' IN BOOLEAN MODE)";
        $dsql = "$sql" . "AND ((coltitle LIKE '%word1 word2%')) ";

        $dummy = array($dsql, $ftsql);

        $arr = $this->s->buildSearchSQL('', 'word1 word2', $columns, 'A bit of SQL ');

        $this->assertEquals($dummy[0], $arr[0],
            'Error asserting that dummy and actual SQL match.');
        $this->assertEquals($dummy[1]['mysql'], $arr[1]['mysql'],
            'Error asserting that $dummy[1][mysql] and $arr[1][mysql] are equal.');
    }

    public function testBuildSearchSQLWithKeytypeElseAndWithoutTitles()
    {
        $columns = array('coltitle1', 'coltitle2');
        $query = 'word1 word2';
        $sql = 'A bit of SQL';
        $dsql = "$sql AND ((coltitle1 LIKE '%word1 word2%' OR coltitle2 LIKE '%word1 word2%')) ";

        $words = array($query);
        $sep = '   ';

        if (strpos($query, ' ') !== false) {
            $ftwords['mysql'] = '"' . $query . '"';
        } else {
            $ftwords['mysql'] = $query;
        }

        $ftsql['mysql'] = "$sql AND MATCH(coltitle1,coltitle2) AGAINST ('{$ftwords['mysql']}' IN BOOLEAN MODE)";
        $dummy = array($dsql, $ftsql);

        $arr = $this->s->buildSearchSQL('', 'word1 word2', $columns, 'A bit of SQL ');

        $this->assertEquals($dummy[0], $arr[0],
            'Error asserting that dummy and actual SQL match.');
        $this->assertEquals($dummy[1]['mysql'], $arr[1]['mysql'],
            'Error asserting that $dummy[1][mysql] and $arr[1][mysql] are equal.');
    }
}
