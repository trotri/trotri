<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\action\show;

use tfc\ap\Ap;
use tfc\mvc\Mvc;
use library\action\ViewAction;
use library\Model;

/**
 * UsersLogin class file
 * 用户登录
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UsersLogin.php 1 2014-04-15 14:43:50Z Code Generator $
 * @package modules.ucenter.action.show
 * @since 1.0
 */
class UsersLogin extends ViewAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$this->assignSystem();
		$this->assignUrl();
		$this->assignLanguage();

		$req = Ap::getRequest();
		$ret = array();

		$loginName = $req->getTrim('login_name');
		$password = $req->getTrim('password');
		$rememberMe = (boolean) $req->getParam('remember_me');

		if ($loginName !== '' && $password !== '') {
			$mod = Model::getInstance('Users');
			$ret = $mod->login($loginName, $password, $rememberMe);
		}

		$viw = Mvc::getView();
		$tplName = $this->getDefaultTplName();

		$viw->assign($ret);
		$viw->display($tplName);
	}
}
