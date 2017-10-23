<?php

use \PHPUnit\Framework\TestCase;

/**
 * Simple tests for plugin.class.php
 */
class SearchCriteriaClass extends TestCase
{
    /**
     * @var SearchCriteria
     */
    private $s;

    protected function setUp()
    {
        $this->s = new SearchCriteria('createVirus', 'unleashZombies');
    }

    public function testSearchCriteriaConstructorSetsDefaults()
    {
        $this->assertEquals(
            'createVirus',
            $this->s->getName(),
            'Error asserting dummy pluginName was equal to class property pluginName.'
        );
        $this->assertEquals(
            'unleashZombies',
            $this->s->getLabel(),
            'Error asserting dummy pluginLabel was equal to class property pluginLabel.'
        );
        $this->assertEquals(
            3,
            $this->s->getRank(),
            'Error asserting dummy rank was equal to class property rank.'
        );
        $this->assertEquals(
            false,
            $this->s->isURLRewrite(),
            'Error asserting dummy urlRewrite was equal to class property urlRewrite.'
        );
        $this->assertEquals(
            true,
            $this->s->isAppendQuery(),
            'Error asserting dummy appendQuery was equal to class property appendQuery.'
        );
    }

    public function testSetSQL()
    {
        $this->s->setSQL('SELECT * FROM dummy');
        $this->assertEquals('SELECT * FROM dummy', $this->s->getSQL());
    }

    public function testSetFTSQL()
    {
        global $_DB_dbms;

        $_DB_dbms = 'mysql';
        $this->s->setFTSQL('SELECT * FROM dummy');
        $this->assertEquals('SELECT * FROM dummy', $this->s->getFtSQL());
    }

    public function testSetRank()
    {
        $this->s->setRank(4);
        $this->assertEquals(4, $this->s->getRank());
    }

    public function testSetURLRewriteEnable()
    {
        $this->s->setURLRewrite(true);
        $this->assertTrue($this->s->isURLRewrite());
    }

    public function testSetAppendQuery()
    {
        $this->s->setAppendQuery(false);
        $this->assertFalse($this->s->isAppendQuery());
    }

    public function testGetSQLReturnDefault()
    {
        $this->assertEquals('', $this->s->getSQL());
    }

    public function testGetSQLReturnDefinedValue()
    {
        $dummy = 'SELECT * FROM dummy';
        $this->s->setSQL($dummy);
        $this->assertEquals($dummy, $this->s->getSQL());
    }

    // reach inside?
    public function testGetFTSQLWhen_FtsqlIsNotEmptyAndIsStringAndDb_dbmsIsMysql()
    {
        $GLOBALS['_DB_dbms'] = 'mysql';
        $dummy = 'SELECT * FROM dummy';
        $this->s->setFtSQL($dummy);
        $this->assertEquals($dummy, $this->s->getFTSQL());
    }

    public function testGetFTSQLWhen_FtsqlIsArray()
    {
        $dummy = array('SELECT * FROM dummy', 'SELECT * FROM dummy2');
        $this->s->setFtSQL($dummy);

        foreach ($this->s->getFTSQL() as $k => $v) {
            $this->assertEquals($v, $dummy[$k]);
        }
    }

    public function testGetFTSQLEqualsBlankWhen_FtsqlIsNotString()
    {
        $this->s->setFtSQL(1);
        $this->assertEquals('', $this->s->getFTSQL());
    }

    public function testGetFTSQLEqualsBlankWhen_FtsqlIsBlank()
    {
        $this->s->setFtSQL('');
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
        $this->assertEquals(false, $this->s->isURLRewrite());
    }

    public function testAppendQueryEnable()
    {
        $this->assertEquals(true, $this->s->isAppendQuery());
    }

    public function testBuildSearchSQLWithKeyTypeAllAndTitles()
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

    public function testBuildSearchSQLWithKeyTypeAnyAndWithoutTitles()
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

        if (strpos($query, ' ') !== false) {
            $ftWords['mysql'] = '"' . $query . '"';
        } else {
            $ftWords['mysql'] = $query;
        }

        $ftSql['mysql'] = $sql . "AND MATCH(coltitle) AGAINST ('{$ftWords['mysql']}' IN BOOLEAN MODE)";
        $dSql = "$sql" . "AND ((coltitle LIKE '%word1 word2%')) ";

        $dummy = array($dSql, $ftSql);

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
        $dSql = "$sql AND ((coltitle1 LIKE '%word1 word2%' OR coltitle2 LIKE '%word1 word2%')) ";

        if (strpos($query, ' ') !== false) {
            $ftWords['mysql'] = '"' . $query . '"';
        } else {
            $ftWords['mysql'] = $query;
        }

        $ftSql['mysql'] = "$sql AND MATCH(coltitle1,coltitle2) AGAINST ('{$ftWords['mysql']}' IN BOOLEAN MODE)";
        $dummy = array($dSql, $ftSql);

        $arr = $this->s->buildSearchSQL('', 'word1 word2', $columns, 'A bit of SQL ');

        $this->assertEquals($dummy[0], $arr[0],
            'Error asserting that dummy and actual SQL match.');
        $this->assertEquals($dummy[1]['mysql'], $arr[1]['mysql'],
            'Error asserting that $dummy[1][mysql] and $arr[1][mysql] are equal.');
    }
}
