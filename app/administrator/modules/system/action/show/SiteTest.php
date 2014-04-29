<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\system\action\show;

use library\BaseAction;
use tid\Role;

/**
 * SiteTest class file
 * 系统管理-Test
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SiteTest.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.system.action.show
 * @since 1.0
 */
class SiteTest extends BaseAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$name = 'public';
		$role = new Role($name);

		echo '<pre>';
		
		$resources = $role->getResources();
		print_r($resources);
		echo '<br/>';
		
		$ret = $role->isDenied('administrator', 'builder', 'fields', Role::SELECT);
		echo '1: '; var_dump($ret);
		echo '<br/>';
		
		$ret = $role->isDenied('administrator', 'builder', 'fields', Role::INSERT);
		echo '2: '; var_dump($ret);
		echo '<br/>';
		
		$ret = $role->isDenied('administrator', 'builder', 'fields', 3);
		echo '3: '; var_dump($ret);
		echo '<br/>';
		
		$ret = $role->isDenied('administrator', 'builder', 'fields', Role::UPDATE);
		echo '4: '; var_dump($ret);
		echo '<br/>';
		
		$ret = $role->isDenied('administrator', 'builder', 'fields', 5);
		echo '5: '; var_dump($ret);
		echo '<br/>';
		
		$ret = $role->isDenied('administrator', 'builder', 'fields', 6);
		echo '6: '; var_dump($ret);
		echo '<br/>';
		
		$ret = $role->isDenied('administrator', 'builder', 'fields', 7);
		echo '7: '; var_dump($ret);
		echo '<br/>';
		
		$ret = $role->isDenied('administrator', 'builder', 'fields', Role::DELETE);
		echo '8: '; var_dump($ret);
		echo '<br/>';
		
		$ret = $role->isDenied('administrator', 'builder', 'fields', 9);
		echo '9: '; var_dump($ret);
		echo '<br/>';

		/*
		$ret = $role->isAllowed('administrator', 'builder', 'fields', 1);
		echo '1: '; var_dump($ret);
		echo '<br/>';

		$ret = $role->isAllowed('administrator', 'builder', 'fields', 2);
		echo '2: '; var_dump($ret);
		echo '<br/>';

		$ret = $role->isAllowed('administrator', 'builder', 'fields', 3);
		echo '3: '; var_dump($ret);
		echo '<br/>';

		$ret = $role->isAllowed('administrator', 'builder', 'fields', 4);
		echo '4: '; var_dump($ret);
		echo '<br/>';

		$ret = $role->isAllowed('administrator', 'builder', 'fields', 5);
		echo '5: '; var_dump($ret);
		echo '<br/>';

		$ret = $role->isAllowed('administrator', 'builder', 'fields', 6);
		echo '6: '; var_dump($ret);
		echo '<br/>';

		$ret = $role->isAllowed('administrator', 'builder', 'fields', 7);
		echo '7: '; var_dump($ret);
		echo '<br/>';
		
		$ret = $role->isAllowed('administrator', 'builder', 'fields', 8);
		echo '8: '; var_dump($ret);
		echo '<br/>';
		
		$ret = $role->isAllowed('administrator', 'builder', 'fields', 9);
		echo '9: '; var_dump($ret);
		echo '<br/>';
		*/

		/*
		$ret = $role->allow('administrator', 'builder', 'fields', "2");
		var_dump($ret);
		echo '<br/>';
		
		
		$ret = $role->allow('administrator', 'builder', 'fields', '4');
		var_dump($ret);
		echo '<br/>';

		
		$ret = $role->allow('administrator', 'builder', 'fields', 1);
		var_dump($ret);
		echo '<br/>';

		$ret = $role->allow('administrator', 'builder', 'fields', 8);
		var_dump($ret);
		echo '<br/>';
		*/

		/*
		$ret = $role->deny('administrator', 'builder', ' ', "2");
		var_dump($ret);
		echo '<br/>';
		
		$ret = $role->deny('administrator', ' ', 'fields', "2");
		var_dump($ret);
		echo '<br/>';
		
		$ret = $role->deny('administrator', 'builder', 'fieldsa', "2");
		var_dump($ret);
		echo '<br/>';
*/
		/*
		$ret = $role->allow('administrator', 'system', 'fields', "2");
		var_dump($ret);
		echo '<br/>';
	
		$ret = $role->allow('administrator', 'system', 'fields', '4');
		var_dump($ret);
		echo '<br/>';
		
		
		$ret = $role->allow('administrator', 'system', 'fields', 1);
		var_dump($ret);
		echo '<br/>';
		
		$ret = $role->allow('administrator', 'system', 'fields', 8);
		var_dump($ret);
		echo '<br/>';
		*/
		
		/*
		$resources = $role->getResources();
		print_r($resources);
		echo '<br/>';
		*/
		
		/*
		$ret = $role->allow('administrator', 'system', 'types', "2");
		var_dump($ret);
		echo '<br/>';
		
		$ret = $role->allow('administrator', 'system', 'types', '4');
		var_dump($ret);
		echo '<br/>';
		
		
		$ret = $role->allow('administrator', 'system', 'types', 1);
		var_dump($ret);
		echo '<br/>';
		
		$ret = $role->allow('administrator', 'system', 'types', 8);
		var_dump($ret);
		echo '<br/>';
		*/
		
		

		/*
		$ret = $role->writeResources();
		var_dump($ret);
		*/

		//$ret = $role->clearResources();
		//var_dump($ret);

		/*
		$ret = $role->deny('administrator', 'system', 'fields', 8);
		var_dump($ret);
		echo '<br/>';
		
		$ret = $role->deny('administrator', 'system', 'fields', 2);
		var_dump($ret);
		echo '<br/>';
		
		$ret = $role->deny('administrator', 'system', 'fields', 3);
		var_dump($ret);
		echo '<br/>';
		
		$ret = $role->deny('administrator', 'system', 'fields', 1);
		var_dump($ret);
		echo '<br/>';
		
		$ret = $role->deny('administrator', 'system', 'fields', 4);
		var_dump($ret);
		echo '<br/>';
		
		$resources = $role->getResources();
		print_r($resources);
		echo '<br/>';
		*/
		

		/*
		$resources = $role->readResources();
		print_r($resources);
		echo '<br/>';
		*/

		/*
		$resources = $role->getResources();
		print_r($resources);
		echo '<br/>';
		*/

		/*
		$ret = $role->isValid(2, true);
		var_dump($ret);
		*/
	}
}
