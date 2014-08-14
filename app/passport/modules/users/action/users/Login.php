<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\users\action\users;

use library;
use tfc\mvc\Mvc;

/**
 * Login class file
 * 用户登录
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Login.php 1 2014-08-08 15:49:14Z huan.song $
 * @package modules.users.action.users
 * @since 1.0
 */
class Login extends library\ShowAction
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		$this->assignSystem();
		$this->assignUrl();
		$this->assignLanguage();

		$viw = Mvc::getView();
		$tplName = $this->getDefaultTplName();

		$viw->display($tplName);
	}
}
