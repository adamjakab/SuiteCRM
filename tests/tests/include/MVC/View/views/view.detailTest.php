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
 * Class ViewDetailTest
 */
class ViewDetailTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testViewDetail()
    {
        //execute the contructor and check for the Object type and type attribute
        $view = new ViewDetail();
        $this->assertInstanceOf('ViewDetail', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
    }
    
    public function testpreDisplay()
    {
        //execute the method with required attributes preset, it will initialize the dv(detail view) attribute. 
        $view = new ViewDetail();
        $view->module = 'Users';
        $view->bean = new User();
        $view->ss = new Sugar_Smarty();
        $view->preDisplay();
        $this->assertInstanceOf('DetailView2', $view->dv);
        $this->asserttrue(is_array($view->dv->defs));
    
        //execute the method again for a different module with required attributes preset, it will initialize the dv(detail view) attribute.
        $view = new ViewDetail();
        $view->module = 'Meetings';
        $view->bean = new Meeting();
        $view->ss = new Sugar_Smarty();
        $view->preDisplay();
        $this->assertInstanceOf('DetailView2', $view->dv);
        $this->asserttrue(is_array($view->dv->defs));
    }
    
    public function testdisplay()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        //execute the method with essential parameters set. it should return some html.
        $view = new ViewDetail();
        $view->module = 'Users';
        $view->bean = new User();
        $view->bean->id = 1;
        $view->ss = new Sugar_Smarty();
        $view->preDisplay();
    
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
    }
}
