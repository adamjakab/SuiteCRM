<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

require_once 'include/utils/db_utils.php';

/**
 * Class db_utilsTest
 */
class db_utilsTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function db_convertProvider()
    {
        //array containing all possible types supported by db_convert
        return array(
            array(gmdate('Y-m-d H:i:s'), 'today', array(), 'CURDATE()'),
            array('text', 'left', array(2), 'LEFT(text,2)'),
            array('2015-11-16 19:10:52', 'date_format', array(), 'DATE_FORMAT(2015-11-16 19:10:52,\'%Y-%m-%d\')'),
            array('2015-11-16 19:10:52', 'time_format', array(), '2015-11-16 19:10:52'),
            array('2015-11-16', 'date', array(), '2015-11-16'),
            array('19:10:52', 'time', array(), '19:10:52'),
            array('2015-11-16 19:10:52', 'datetime', array(), '2015-11-16 19:10:52'),
            array(null, 'ifnull', array(0), 'IFNULL(0)'),
            array('value1 ', 'concat', array('value2'), 'CONCAT(value1 ,value2)'),
            array('2015-11-16 19:10:52', 'quarter', array(), 'QUARTER(2015-11-16 19:10:52)'),
            array('value1', 'length', array(), 'LENGTH(value1)'),
            array('2015-11-16 19:32:29', 'month', array(), 'MONTH(2015-11-16 19:32:29)'),
            array('2015-11-16', 'add_date', array('1', 'DAY'), 'DATE_ADD(2015-11-16, INTERVAL 1 DAY)'),
            array('19:10:52',
                  'add_time',
                  array('1', 'HOUR'),
                  'DATE_ADD(19:10:52, INTERVAL + CONCAT(1, \':\', HOUR) HOUR_MINUTE)',
            ),
            array('col', 'avg', array(2), 'avg(col)'),
            array('2015-11-16 19:32:29', 'add_tz_offset', array(), '2015-11-16 19:32:29 + INTERVAL 0 MINUTE'),
        
        );
    }
    
    /**
     * @dataProvider db_convertProvider
     */
    public function testdb_convert($string, $type, $params, $expected)
    {
        //execute the method and test if it returns expected values for all types
        $actual = db_convert($string, $type, $params);
        $this->assertSame($expected, $actual);
    }
    
    public function testdb_concat()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        //execute the method and test if it returns expected values
    
        $table = 'Table1';
        $fields = array('Col1', 'Col2', 'Col3');
        $expected = "LTRIM(RTRIM(CONCAT(IFNULL(Table1.Col1,''),'',IFNULL(Table1.Col2,''),'',IFNULL(Table1.Col3,''))))";
        $actual = db_concat($table, $fields);
        $this->assertSame($expected, $actual);
    }
    
    public function testfrom_db_convert()
    {
        //execute the method and test if it returns expected values
    
        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'date'));
        $this->assertSame('19:32:29', from_db_convert('19:32:29', 'time'));
        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'datetime'));
        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'datetimecombo'));
        $this->assertSame('2015-11-16 19:32:29', from_db_convert('2015-11-16 19:32:29', 'timestamp'));
    }
    
    public function testto_html()
    {
        //execute the method and test if it returns expected values
    
        $string = '';
        $expected = '';
        $actual = to_html($string);
        $this->assertSame($expected, $actual);
    
        $string = "'test'&trial<\">";
        $expected = '&#039;test&#039;&trial&lt;&quot;&gt;';
        $actual = to_html($string);
        $this->assertSame($expected, $actual);
    }
    
    public function testfrom_html()
    {
        $string = '';
        $expected = '';
        $actual = from_html($string);
        $this->assertSame($expected, $actual);
    
        $string = '&#039;test&#039;&trial&lt;&quot;&gt;';
        $expected = "'test'&trial<\">";
        $actual = from_html($string);
        $this->assertSame($expected, $actual);
    }
    
    public function testgetValidDBName()
    {
        $expected = '';
        $actual = getValidDBName('');
        $this->assertSame($expected, $actual);
    
        $expected = 'col';
        $actual = getValidDBName('Col');
        $this->assertSame($expected, $actual);
    }
    
    public function testisValidDBName()
    {
        //valid value
        $expected = true;
        $actual = isValidDBName('suitecrmtest', 'mysql');
        $this->assertSame($expected, $actual);
    
        //invalid value
        $expected = false;
        $actual = isValidDBName('suite/crm.test', 'mysql');
        $this->assertSame($expected, $actual);
    }
}
