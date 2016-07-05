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
 * Class vCalTest
 */
class vCalTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testvCal()
    {
        //execute the contructor and check for the Object type and  attributes
        $vcal = new vCal();
    
        $this->assertInstanceOf('vCal', $vcal);
        $this->assertInstanceOf('SugarBean', $vcal);
    
        $this->assertAttributeEquals('vcals', 'table_name', $vcal);
        $this->assertAttributeEquals('vCals', 'module_dir', $vcal);
        $this->assertAttributeEquals('vCal', 'object_name', $vcal);
    
        $this->assertAttributeEquals(true, 'new_schema', $vcal);
        $this->assertAttributeEquals(false, 'tracker_visibility', $vcal);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $vcal);
    }
    
    public function testget_summary_text()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $vcal = new vCal();
    
        //test without setting name
        $this->assertEquals(null, $vcal->get_summary_text());
    
        //test with name set
        $vcal->name = 'test';
        $this->assertEquals('', $vcal->get_summary_text());
    }
    
    public function testfill_in_additional_list_fields()
    {
        $vcal = new vCal();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $vcal->fill_in_additional_list_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation');
    }
    
    public function testfill_in_additional_detail_fields()
    {
        $vcal = new vCal();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $vcal->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation');
    }
    
    public function testget_list_view_data()
    {
        $vcal = new vCal();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $vcal->get_list_view_data();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation');
    }
    
    public function testget_freebusy_lines_cache()
    {
        $vcal = new vCal();
        $user_bean = new User('1');
    
        $expectedStart =
            "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//SugarCRM//SugarCRM Calendar//EN\r\nBEGIN:VFREEBUSY\r\nORGANIZER;CN= :VFREEBUSY\r\n";
        $expectedEnd = "END:VFREEBUSY\r\nEND:VCALENDAR\r\n";
    
        $result = $vcal->get_freebusy_lines_cache($user_bean);
    
        $this->assertStringStartsWith($expectedStart, $result);
        $this->assertStringEndsWith($expectedEnd, $result);
    }
    
    public function testcreate_sugar_freebusy()
    {
        global $locale, $timedate;
    
        $vcal = new vCal();
        $user_bean = new User('1');
    
        $now_date_time = $timedate->getNow(true);
        $start_date_time = $now_date_time->get('yesterday');
        $end_date_time = $now_date_time->get('tomorrow');
    
        $result = $vcal->create_sugar_freebusy($user_bean, $start_date_time, $end_date_time);
        $this->assertGreaterThanOrEqual(0, strlen($result));
    }
    
    public function testget_vcal_freebusy()
    {
        $vcal = new vCal();
        $user_focus = new User('1');
    
        $expectedStart =
            "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//SugarCRM//SugarCRM Calendar//EN\r\nBEGIN:VFREEBUSY\r\nORGANIZER;CN= :VFREEBUSY\r\n";
        $expectedEnd = "END:VFREEBUSY\r\nEND:VCALENDAR\r\n";
    
        $result = $vcal->get_vcal_freebusy($user_focus);
    
        $this->assertStringStartsWith($expectedStart, $result);
        $this->assertStringEndsWith($expectedEnd, $result);
    }
    
    public function testcache_sugar_vcal()
    {
        $vcal = new vCal();
        $user_focus = new User('1');
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $vcal->cache_sugar_vcal($user_focus);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testcache_sugar_vcal_freebusy()
    {
        $vcal = new vCal();
        $user_focus = new User('1');
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $vcal->cache_sugar_vcal_freebusy($user_focus);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testfold_ical_lines()
    {
    
        //test with short strings
        $result = vCal::fold_ical_lines('testkey', 'testvalue');
        $this->assertEquals('testkey:testvalue', $result);
    
        //test with longer strings
        $expected =
            "testkey11111111111111111111111111111111111111111111111111111111111111111111\r\n	11111111111111111111111111111111:testvalue11111111111111111111111111111111\r\n	11111111111111111111111111111111111111111111111111111111111111111111";
        $result = vCal::fold_ical_lines('testkey' . str_repeat('1', 100), 'testvalue' . str_repeat('1', 100));
        $this->assertEquals();
    }
    
    public function testcreate_ical_array_from_string()
    {
        $iCalString =
            "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//SugarCRM//SugarCRM Calendar//EN\r\nBEGIN:VFREEBUSY\r\nORGANIZER;CN= :VFREEBUSY\r\nDTSTART:2016-01-09 00:00:00\r\nDTEND:2016-03-09 00:00:00\r\nDTSTAMP:2016-01-10 11:07:15\r\nEND:VFREEBUSY\r\nEND:VCALENDAR\r\n";
        $expected = array(
            array('BEGIN', 'VCALENDAR'),
            array('VERSION', '2.0'),
            array('PRODID', '-//SugarCRM//SugarCRM Calendar//EN'),
            array('BEGIN', 'VFREEBUSY'),
            array('ORGANIZER;CN= ', 'VFREEBUSY'),
            array('DTSTART', '2016-01-09 00:00:00'),
            array('DTEND', '2016-03-09 00:00:00'),
            array('DTSTAMP', '2016-01-10 11:07:15'),
            array('END', 'VFREEBUSY'),
            array('END', 'VCALENDAR'),
        );
        $actual = vCal::create_ical_array_from_string($iCalString);
        $this->assertSame($expected, $actual);
    }
    
    public function testcreate_ical_string_from_array()
    {
        $expected =
            "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//SugarCRM//SugarCRM Calendar//EN\r\nBEGIN:VFREEBUSY\r\nORGANIZER;CN= :VFREEBUSY\r\nDTSTART:2016-01-09 00:00:00\r\nDTEND:2016-03-09 00:00:00\r\nDTSTAMP:2016-01-10 11:07:15\r\nEND:VFREEBUSY\r\nEND:VCALENDAR\r\n";
        $iCalArray = array(
            array('BEGIN', 'VCALENDAR'),
            array('VERSION', '2.0'),
            array('PRODID', '-//SugarCRM//SugarCRM Calendar//EN'),
            array('BEGIN', 'VFREEBUSY'),
            array('ORGANIZER;CN= ', 'VFREEBUSY'),
            array('DTSTART', '2016-01-09 00:00:00'),
            array('DTEND', '2016-03-09 00:00:00'),
            array('DTSTAMP', '2016-01-10 11:07:15'),
            array('END', 'VFREEBUSY'),
            array('END', 'VCALENDAR'),
        );
        $actual = vCal::create_ical_string_from_array($iCalArray);
        $this->assertSame($expected, $actual);
    }
    
    public function testescape_ical_chars()
    {
        $this->assertSame('', vCal::escape_ical_chars(''));
        $this->assertSame('\;\,', vCal::escape_ical_chars(';,'));
    }
    
    public function testunescape_ical_chars()
    {
        $this->assertSame('', vCal::unescape_ical_chars(''));
        $this->assertSame('; , \\', vCal::unescape_ical_chars('\\; \\, \\\\'));
    }
    
    public function testget_ical_event()
    {
        $user = new User(1);
        $meeting = new Meeting();
    
        $meeting->id = 1;
        $meeting->date_start = '2016-02-11 17:30:00';
        $meeting->date_end = '2016-02-11 17:30:00';
        $meeting->name = 'test';
        $meeting->location = 'test location';
        $meeting->description = 'test description';
    
        $expectedStart =
            "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//SugarCRM//SugarCRM Calendar//EN\r\nBEGIN:VEVENT\r\nUID:1\r\nORGANIZED;CN=:\r\nDTSTART:20160211T173000Z\r\nDTEND:20160211T173000Z\r\n";
        $expectedEnd =
            "\r\nSUMMARY:test\r\nLOCATION:test location\r\nDESCRIPTION:test description\r\nEND:VEVENT\r\nEND:VCALENDAR\r\n";
        
        $result = vCal::get_ical_event($meeting, $user);
    
        $this->assertStringStartsWith($expectedStart, $result);
        $this->assertStringEndsWith($expectedEnd, $result);
    }
}
