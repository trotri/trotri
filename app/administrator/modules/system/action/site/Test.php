<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\system\action\site;

use library\actions;
use users\services\Users;

/**
 * Test class file
 * 测试页
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Test.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.system.action.site
 * @since 1.0
 */
class Test extends actions\View
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		$users = new Users();
		$users->findByPk(1);
		$users->findByPk(1);
		$users->findByPk(1);
		$users->findByPk(1);
		$users->findByPk(1);

		$users->modifyByPk(1, array('sex' => 'f'));

		$users->findByPk(1);
		$users->findByPk(1);
		$users->findByPk(1);
		$users->findByPk(1);
		$users->findByPk(1);
	}
}
