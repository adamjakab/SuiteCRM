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
 * Class ViewSugarpdfTest
 */
class ViewSugarpdfTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testViewSugarpdf()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        //execute the method without request parameters and test if it works. it should output some headers and throw headers output exception.
        try
        {
            $view = new ViewSugarpdf();
            $this->assertEmpty("", $view);
        }
        catch(Exception $e)
        {
            $this->assertStringStartsWith('Cannot modify header information', $e->getMessage());
        }
    
        //execute the method with request parameters and test if it works.
        $_REQUEST['sugarpdf'] = 'someValue';
        $view = new ViewSugarpdf();
        $view->module = 'Users';
        $this->assertInstanceOf('ViewSugarpdf', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('sugarpdf', 'type', $view);
        $this->assertAttributeEquals('someValue', 'sugarpdf', $view);
        $this->assertAttributeEquals(null, 'sugarpdfBean', $view);
    }
    
    //Incomplete test. SugarpdfFactory::loadSugarpdf throws fatal error. error needs to be resolved before testing.
    public function testpreDisplay()
    {
        $this->markTestIncomplete('Can Not be implemented');
    }
    
    //Incomplete test.  SugarpdfFactory::loadSugarpdf throws fatal error. error needs to be resolved before testing.
    public function testdisplay()
    {
        $this->markTestIncomplete('Can Not be implemented');
    }
}
