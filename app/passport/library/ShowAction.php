<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use libapp;
use tfc\ap\UserIdentity;
use tfc\mvc\Mvc;
use tid\Role;
use users\library\Identity;

/**
 * ShowAction abstract class file
 * ShowAction基类，用于展示数据，加载模板
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ShowAction.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
abstract class ShowAction extends libapp\ShowAction
{
	/**
	 * @var boolean 是否验证登录，默认验证
	 */
	protected $_validLogin = true;

	/**
	 * @var boolean 是否验证身份授权，默认验证
	 */
	protected $_validAuth = true;

	/**
	 * @var integer 允许的权限
	 */
	protected $_power = Role::SELECT;

	/**
	 * (non-PHPdoc)
	 * @see \libapp\ShowAction::_init()
	 */
	protected function _init()
	{
		parent::_init();
		$this->_isLogin();
		$this->_isAuth();
	}

	/**
	 * 检查用户是否登录，如果没有登录，跳转到登录页面
	 * @return void
	 */
	protected function _isLogin()
	{
		if (!$this->_validLogin) {
			return ;
		}

		if (UserIdentity::isLogin()) {
			return ;
		}

		$this->toLogin();
	}

	/**
	 * 检查用户身份授权，如果没有授权，跳转到403页面
	 * @return void
	 */
	protected function _isAuth()
	{
		if (!$this->_validAuth) {
			return ;
		}

		if (!$this->_validLogin) {
			return ;
		}

		$auth = Identity::getAuthorization();
		if ($auth->isAllowed(APP_NAME, Mvc::$module, Mvc::$controller, $this->_power)) {
			return ;
		}

		$this->err403();
	}

	/**
	 * 页面重定向到登录页面
	 * @return void
	 */
	public function toLogin()
	{
		$this->forward('login', 'account', 'users');
	}

	/**
	 * 页面重定向到404页面
	 * @return void
	 */
	public function err404()
	{
		$this->forward('err404', 'site', 'system', array(
			'http_referer' => Mvc::getView()->getUrlManager()->getUrl(Mvc::$action, Mvc::$controller, Mvc::$module)
		));
	}

	/**
	 * 页面重定向到403页面
	 * @return void
	 */
	public function err403()
	{
		$this->forward('err403', 'site', 'system', array(
			'http_referer' => Mvc::getView()->getUrlManager()->getUrl(Mvc::$action, Mvc::$controller, Mvc::$module)
		));
	}

}
