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

use library\DataAction;
use tfc\ap\UserIdentity;
use users\library\Identity;

/**
 * Test class file
 * 测试页
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Test.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.system.action.site
 * @since 1.0
 */
class Test extends DataAction
{
	/**
	 * @var boolean 是否验证登录
	 */
	protected $_validLogin = true;

	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		echo 'ID: ', UserIdentity::getId(), '<br/>';
		echo 'Name: ', UserIdentity::getName(), '<br/>';
		echo 'Nick: ', UserIdentity::getNick(), '<br/><br/>';

		echo 'UserId: ', Identity::getUserId(), '<br/>';
		echo 'LoginName: ', Identity::getLoginName(), '<br/>';
		echo 'UserName: ', Identity::getUserName(), '<br/>';
		echo 'GroupIds: ';
		var_dump(Identity::getGroupIds());
		echo '<br/>';
		echo 'AppNames: ';
		var_dump(Identity::getAppNames());
		echo '<br/>';
		var_dump(Identity::getAuthorization());
	}
}
