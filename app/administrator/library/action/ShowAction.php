<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library\action;

use tfc\ap\Ap;
use tfc\ap\Registry;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use tfc\saf\Log;
use tfc\util\String;
use library\BaseAction;
use library\ErrorNo;

/**
 * ShowAction abstract class file
 * ShowAction基类，数据展示类Action
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ShowAction.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library.action
 * @since 1.0
 */
abstract class ShowAction extends BaseAction
{
	/**
	 * @var string 页面首次渲染的布局名
	 */
	public $layoutName = 'column2';

	/**
	 * 展示页面，输出数据
	 * @param array $data
	 * @param string $tplName
	 * @return void
	 */
	public function render(array $data = array(), $tplName = null)
	{
		$this->assignSystem();
		$this->assignUrl();
		$this->assignLanguage();

		$viw = Mvc::getView();
		$viw->addLayoutName('layouts' . DS . $this->layoutName);
		if ($tplName === null) {
			$tplName = $this->getDefaultTplName();
		}

		if (!isset($data['err_no']) || $data['err_no'] === ErrorNo::SUCCESS_NUM) {
			$data['err_no'] = Ap::getRequest()->getInteger('err_no', ErrorNo::SUCCESS_NUM);
			$data['err_msg'] = String::escapeXss(Ap::getRequest()->getString('err_msg'));
		}

		$viw->render($tplName, $data);
	}

	/**
	 * 将常用数据设置到模板变量中
	 * @return void
	 */
	public function assignSystem()
	{
		$viw = Mvc::getView();

		$viw->assign('app',        APP_NAME);
		$viw->assign('module',     Mvc::$module);
		$viw->assign('controller', Mvc::$controller);
		$viw->assign('action',     Mvc::$action);
		$viw->assign('sidebar',    Mvc::$module . '/' . Mvc::$controller . '_sidebar');
		$viw->assign('log_id',     Log::getId());

		if (($wfBackTrace = Registry::get('warning_backtrace')) !== null) {
			$viw->assign('warning_backtrace', $wfBackTrace);
		}
	}

	/**
	 * 将链接信息设置到模板变量中
	 * @return void
	 */
	public function assignUrl()
	{
		$req = Ap::getRequest();
		$viw = Mvc::getView();

		$baseUrl    = $req->getBaseUrl();
		$basePath   = $req->getBasePath();
		$scriptUrl  = $req->getScriptUrl();
		$requestUri = $req->getRequestUri();
		$staticUrl  = $baseUrl . '/static/' . APP_NAME . '/' . $viw->skinName;

		$viw->assign('root_url',    $baseUrl . '/..');
		$viw->assign('base_path',   $basePath);
		$viw->assign('base_url',    $baseUrl);
		$viw->assign('script_url',  $scriptUrl);
		$viw->assign('request_uri', $requestUri);
		$viw->assign('static_url',  $staticUrl);
		$viw->assign('js_url',      $staticUrl . '/js');
		$viw->assign('css_url',     $staticUrl . '/css');
		$viw->assign('imgs_url',    $staticUrl . '/imgs');
	}

	/**
	 * 将公共的语言包和当前模块的语言包设置到模板变量中
	 * @return void
	 */
	public function assignLanguage()
	{
		$viw = Mvc::getView();

		Text::_('CFG_SYSTEM__');
		Text::_('MOD_' . strtoupper(Mvc::$module) . '__');

		$strings = Text::getStrings();
		$viw->assign($strings);
	}

	/**
	 * 获取默认的模版名
	 * @return string
	 */
	public function getDefaultTplName()
	{
		return Mvc::$module . DS . Mvc::$controller . '_' . Mvc::$action;
	}
}
