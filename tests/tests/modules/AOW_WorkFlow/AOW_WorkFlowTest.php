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

/**
 * Class AOW_WorkFlowTest
 */
class AOW_WorkFlowTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOW_WorkFlow()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $aowWorkFlow = new AOW_WorkFlow();
        $this->assertInstanceOf('AOW_WorkFlow', $aowWorkFlow);
        $this->assertInstanceOf('Basic', $aowWorkFlow);
        $this->assertInstanceOf('SugarBean', $aowWorkFlow);
    
        $this->assertAttributeEquals('AOW_WorkFlow', 'module_dir', $aowWorkFlow);
        $this->assertAttributeEquals('AOW_WorkFlow', 'object_name', $aowWorkFlow);
        $this->assertAttributeEquals('aow_workflow', 'table_name', $aowWorkFlow);
        $this->assertAttributeEquals(true, 'new_schema', $aowWorkFlow);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aowWorkFlow);
        $this->assertAttributeEquals(false, 'importable', $aowWorkFlow);
    }
    
    public function testbean_implements()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aowWorkFlow = new AOW_WorkFlow();
        $this->assertEquals(false, $aowWorkFlow->bean_implements('')); //test with blank value
        $this->assertEquals(false, $aowWorkFlow->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $aowWorkFlow->bean_implements('ACL')); //test with valid value
    }
    
    public function testsave()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        $aowWorkFlow->name = 'test';
        $aowWorkFlow->flow_module = 'test';
    
        $aowWorkFlow->save();
    
        //test for record ID to verify that record is saved
        $this->assertTrue(isset($aowWorkFlow->id));
        $this->assertEquals(36, strlen($aowWorkFlow->id));
    
        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aowWorkFlow->mark_deleted($aowWorkFlow->id);
        $result = $aowWorkFlow->retrieve($aowWorkFlow->id);
        $this->assertEquals(null, $result);
    }
    
    public function testload_flow_beans()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $aowWorkFlow->load_flow_beans();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testrun_flows()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        $result = $aowWorkFlow->run_flows();
        $this->assertTrue($result);
    }
    
    public function testrun_flow()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $aowWorkFlow->run_flow();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testrun_bean_flows()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        //test with different modules. it always returns true
    
        $result = $aowWorkFlow->run_bean_flows(new AOS_Quotes());
        $this->assertTrue($result);
    
        $result = $aowWorkFlow->run_bean_flows(new Call());
        $this->assertTrue($result);
    }
    
    public function testget_flow_beans()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        //test for AOS_Quotes. it will return null as no test data is available
        $aowWorkFlow->flow_module = 'AOS_Quotes';
        $result = $aowWorkFlow->get_flow_beans();
        $this->assertEquals(null, $result);
    }
    
    public function testbuild_flow_query_join()
    {
        $aowWorkFlow = new AOW_WorkFlow();
        $query = array();
    
        //test without type param
        $result = $aowWorkFlow->build_flow_query_join('aos_products_quotes', new AOS_Quotes(), '', array());
        $this->assertSame(array(), $result);
    
        //test with type custom
        $expected = array('join' => array('c' => 'LEFT JOIN calls_cstm c ON calls.id = c.id_c '));
        $result = $aowWorkFlow->build_flow_query_join('c', new Call(), 'custom', array());
        $this->assertSame($expected, $result);
    
        //test with type relationship
        $expected = array(
            'join'   => array('aos_products_quotes' => "LEFT JOIN aos_products_quotes aos_products_quotes ON aos_quotes.id=aos_products_quotes.parent_id AND aos_products_quotes.deleted=0\n\n"),
            'select' => array("aos_products_quotes.id AS 'aos_products_quotes_id'"),
        );
        $result = $aowWorkFlow->build_flow_query_join('aos_products_quotes', new AOS_Quotes(), 'relationship', array());
        $this->assertSame($expected, $result);
    }
    
    public function testbuild_flow_query_where()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        //test without presetting required object attributes
        $expected = array();
        $query = $aowWorkFlow->build_flow_query_where();
        $this->assertSame($expected, $query);
    
        //test with module required attributes set
        $aowWorkFlow->id = '1';
        $aowWorkFlow->flow_module = 'Calls';
        $expected = array(
            'where' => array('NOT EXISTS (SELECT * FROM aow_processed WHERE aow_processed.aow_workflow_id=\'1\' AND aow_processed.parent_id=calls.id AND aow_processed.status = \'Complete\' AND aow_processed.deleted = 0)',
                             'calls.deleted = 0 ',
            ),
        );
        $query = $aowWorkFlow->build_flow_query_where();
        $this->assertSame($expected, $query);
    
        //test with flow_run_on and multiple_runs attributes set
        $expected = array(
            'where' => array('calls.date_entered > \'\'', 'calls.deleted = 0 '),
        );
        $aowWorkFlow->flow_run_on = 'New_Records';
        $aowWorkFlow->multiple_runs = 1;
        $query = $aowWorkFlow->build_flow_query_where();
        $this->assertSame($expected, $query);
    }
    
    public function testbuild_query_where()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        //populate required values
        $call = new Call();
        $aowCondition = new AOW_Condition();
        $aowCondition->name = 'test';
        $aowCondition->module_path = base64_encode(serialize(array('')));
        $aowCondition->field = 'name';
        $aowCondition->value = 'testval';
    
        //test with contains operator
        $aowCondition->operator = 'Contains';
        $aowCondition->value_type = 'Value';
        $expected = array(
            'where' => array(".name LIKE CONCAT('%', 'testval' ,'%')"),
        );
        $query = $aowWorkFlow->build_query_where($aowCondition, $call);
        $this->assertEquals($expected, $query);
    
        //test for starts with operator
        $aowCondition->operator = 'Starts_With';
        $aowCondition->value_type = 'Value';
    
        $expected = array(
            'where' => array(".name LIKE CONCAT('testval' ,'%')"),
        );
        $query = $aowWorkFlow->build_query_where($aowCondition, $call);
        $this->assertEquals($expected, $query);
    
        //test for Equal_To operator
        $aowCondition->operator = 'Equal_To';
        $aowCondition->value_type = 'Value';
    
        $expected = array(
            'where' => array(".name = 'testval'"),
        );
        $query = $aowWorkFlow->build_query_where($aowCondition, $call);
        $this->assertEquals($expected, $query);
    
        //test with value type Date
        $aowCondition->operator = 'Equal_To';
        $aowCondition->value_type = 'Date';
    
        $expected = array(
            'where' => array('.name = DATE_ADD(calls., INTERVAL   )'),
        );
    
        $query = $aowWorkFlow->build_query_where($aowCondition, $call);
        $this->assertEquals($expected, $query);
    
        //test with value type Field
        $aowCondition->operator = 'Equal_To';
        $aowCondition->value_type = 'Field';
    
        $expected = array(
            'where' => array('.name = calls.testval'),
        );
    
        $query = $aowWorkFlow->build_query_where($aowCondition, $call);
        $this->assertEquals($expected, $query);
    }
    
    public function testcheck_valid_bean()
    {
        $aowWorkFlow = new AOW_WorkFlow();
        $aowWorkFlow->flow_run_on = 'New_Records';
    
        $aosQuotes = new AOS_Quotes();
    
        $result = $aowWorkFlow->check_valid_bean($aosQuotes);
        $this->assertTrue($result);
    }
    
    public function testcompare_condition()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        //execute the method and verify that it returns valid values for all operators
    
        $this->assertTrue($aowWorkFlow->compare_condition(1, 1));
        $this->assertTrue($aowWorkFlow->compare_condition(1, 2, 'Not_Equal_To'));
        $this->assertTrue($aowWorkFlow->compare_condition(2, 1, 'Greater_Than'));
        $this->assertTrue($aowWorkFlow->compare_condition(1, 2, 'Less_Than'));
        $this->assertTrue($aowWorkFlow->compare_condition(5, 4, 'Greater_Than_or_Equal_To'));
        $this->assertTrue($aowWorkFlow->compare_condition(2, 3, 'Less_Than_or_Equal_To'));
        $this->assertTrue($aowWorkFlow->compare_condition('', '', 'is_null'));
        $this->assertTrue($aowWorkFlow->compare_condition('test2', array('test1', 'test2'), 'One_of'));
        $this->assertTrue($aowWorkFlow->compare_condition('test', array('test1', 'test2'), 'Not_One_of'));
    
        //These do not return bool but 'strpos' result
        //$this->assertNotFalse($aowWorkFlow->compare_condition('test1', 'test', 'Contains'));
        $this->assertEquals(0, $aowWorkFlow->compare_condition('test1', 'test', 'Contains'));
    
        //$this->assertNotFalse($aowWorkFlow->compare_condition('test1', 'test', 'Starts_With'));
        $this->assertEquals(0, $aowWorkFlow->compare_condition('test1', 'test', 'Starts_With'));
    
        //$this->assertNotFalse($aowWorkFlow->compare_condition('test1', '1', 'Ends_With'));
        $this->assertEquals(4, $aowWorkFlow->compare_condition('test1', '1', 'Ends_With'));
    }
    
    public function testcheck_in_group()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        //test with two different modules
        $this->assertFalse($aowWorkFlow->check_in_group(1, 'Users', 1));
        $this->assertFalse($aowWorkFlow->check_in_group(1, 'Calls', 1));
    }
    
    public function testrun_actions()
    {
        $aowWorkFlow = new AOW_WorkFlow();
    
        //prepare the required objects and variables
        $aowWorkFlow->id = 1;
    
        $call = new Call();
        $call->id = 1;
    
        //execute the method and verify if it creates records in processed table
        $result = $aowWorkFlow->run_actions($call);
    
        //test for a entry in AOW_Processed table.
        $processed = new AOW_Processed();
        $processed->retrieve_by_string_fields(array('aow_workflow_id' => 1, 'parent_id' => 1));
    
        //test for record ID to verify that record is saved
        $this->assertTrue(isset($processed->id));
        $this->assertEquals(36, strlen($processed->id));
    
        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $processed->mark_deleted($processed->id);
        $result = $processed->retrieve($processed->id);
        $this->assertEquals(null, $result);
    }
}
