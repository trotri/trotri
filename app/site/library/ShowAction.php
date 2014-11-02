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
use tfc\mvc\Mvc;
use tfc\saf\Text;
use tfc\auth\Identity;
use system\services\Options;

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
	protected $_validLogin = false;

	/**
	 * (non-PHPdoc)
	 * @see \libapp\ShowAction::_init()
	 */
	protected function _init()
	{
		parent::_init();
		$this->_isLogin();
	}

	/**
	 * 将常用数据设置到模板变量中
	 * @return void
	 */
	public function assignSystem()
	{
		parent::assignSystem();
		$viw = Mvc::getView();

		$viw->assign('urlHelper', UrlHelper::getInstance());
		$viw->assign('sidebar', Mvc::$module . '/' . Mvc::$action . '_' . 'sidebar');
		$viw->assign('system_site_name', Options::getSiteName());

		if (!isset($viw->system_meta_title)) {
			$viw->assign('system_meta_title', Options::getMetaTitle());
		}

		if (!isset($viw->system_meta_keywords)) {
			$viw->assign('system_meta_keywords', Options::getMetaKeywords());
		}

		if (!isset($viw->system_meta_description)) {
			$viw->assign('system_meta_description', Options::getMetaDescription());
		}

		$viw->assign('system_powerby', Options::getPowerby());
		$viw->assign('system_stat_code', Options::getStatCode());
	}

	/**
	 * 将公共的语言包和当前模块的语言包设置到模板变量中
	 * @return void
	 */
	public function assignLanguage()
	{
		$viw = Mvc::getView();

		Text::_('CFG_SYSTEM__');

		$strings = Text::getStrings();
		$viw->assign($strings);
	}

	/**
	 * 获取默认的模板名
	 * @return string
	 */
	public function getDefaultTplName()
	{
		return Mvc::$module . DS . Mvc::$action;
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

		if (Identity::isLogin()) {
			return ;
		}

		$this->toLogin();
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
		$this->forward('err404', 'show', 'system', array(
			'http_referer' => Mvc::getView()->getUrlManager()->getUrl(Mvc::$action, Mvc::$controller, Mvc::$module)
		));
	}

	/**
	 * 页面重定向到403页面
	 * @return void
	 */
	public function err403()
	{
		$this->forward('err403', 'show', 'system', array(
			'http_referer' => Mvc::getView()->getUrlManager()->getUrl(Mvc::$action, Mvc::$controller, Mvc::$module)
		));
	}

	/**
	 * 页面重定向到500页面
	 * @return void
	 */
	public function err500()
	{
		$this->forward('err500', 'show', 'system', array(
			'http_referer' => Mvc::getView()->getUrlManager()->getUrl(Mvc::$action, Mvc::$controller, Mvc::$module)
		));
	}

}
