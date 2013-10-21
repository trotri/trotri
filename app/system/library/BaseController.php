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

use tfc\mvc\Controller;
use tfc\ap\UserIdentity;
use tfc\ap\Ap;
use tfc\ap\Singleton;
use tfc\ap\Registry;
use tfc\mvc\Mvc;
use tfc\saf\Log;
use tfc\saf\Cfg;

/**
 * BaseController abstract class file
 * Controller基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseController.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
abstract class BaseController extends Controller
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
		$this->assignUser();

		$view = Mvc::getView();
		$view->addLayoutName('layouts' . DS . $this->layoutName);
		if ($tplName === null) {
			$tplName = $this->getDefaultTplName();
		}

		if (!isset($data['err_no']) || $data['err_no'] === ErrorNo::SUCCESS_NUM) {
			$data['err_no'] = Ap::getRequest()->getInteger('err_no', ErrorNo::SUCCESS_NUM);
			$data['err_msg'] = Ap::getRequest()->getString('err_msg');
		}

		$view->render($tplName, $data);
	}

	/**
	 * 将配置参数和常用数据设置到模板变量中
	 * @return void
	 */
	public function assignSystem()
	{
		$view = Mvc::getView();
		$view->viewDirectory = DIR_APP_VIEWS;

		$config = Cfg::getApp('view');
		isset($config['skin_name']) || $view->skinName = $config['skin_name'];
		isset($config['charset']) || $view->charset = $config['charset'];
		isset($config['tpl_extension']) || $view->tplExtension = $config['tpl_extension'];
		isset($config['version']) || $view->version = $config['version'];

		$view->assign('app', 		APP_NAME);
		$view->assign('module', 	Mvc::$module);
		$view->assign('controller', Mvc::$controller);
		$view->assign('action', 	Mvc::$action);
		$view->assign('sidebar', 	Mvc::$module . '/' . Mvc::$controller . '_sidebar');
		$view->assign('log_id', 	Log::getId());
		$view->assign('util', 		Singleton::getInstance('library\\Util'));
		if (($wfBackTrace = Registry::get('warning_backtrace')) !== null) {
			$view->assign('warning_backtrace', $wfBackTrace);
		}
	}

	/**
	 * 将链接信息设置到模板变量中
	 * @return void
	 */
	public function assignUrl()
	{
		$view = Mvc::getView();

		$baseUrl   = Ap::getRequest()->getBaseUrl();
		$basePath  = Ap::getRequest()->getBasePath();
		$scriptUrl = Ap::getRequest()->getScriptUrl();
		$staticUrl = $baseUrl . '/static/' . APP_NAME . '/' . $view->skinName;

		$view->assign('root_url',   $baseUrl . '/..');
		$view->assign('base_path',  $basePath);
		$view->assign('base_url',   $baseUrl);
		$view->assign('script_url', $scriptUrl);
		$view->assign('static_url', $staticUrl);
		$view->assign('js_url',     $staticUrl . '/js');
		$view->assign('css_url',    $staticUrl . '/css');
		$view->assign('imgs_url',   $staticUrl . '/imgs');
	}

	/**
	 * 将用户信息设置到模板变量中
	 * @return void
	 */
	public function assignUser()
	{
		$view = Mvc::getView();
		$view->assign('user_id', UserIdentity::getId());
		$view->assign('name', UserIdentity::getName());
	}

	/**
	 * 获取默认的模版名
	 * @return string
	 */
	public function getDefaultTplName()
	{
		return Mvc::$module . DS . Mvc::$controller . '_' . Mvc::$action;
	}

	/**
	 * Json方式输出数据，如果项目不是Utf-8编码，需要重写此方法，转换编码格式
	 * @param mixed $data
	 * @return void
	 */
	public function display($data)
	{
		$data = $this->getViewData($data);
		echo json_encode($data);
	}

	/**
	 * 获取Ajax方式输出数据，规范化输出数据的格式
	 * 默认添加的输出内容：log_id (integer)
	 * @param mixed $data
	 * @return array
	 * @throws ErrorException 如果输出数据时数组，但是不包含err_no、err_msg、data或者data不是数组，抛出异常
	 */
	public function getViewData($data)
	{
		if (is_array($data)) {
			if (!isset($data['err_no'])) {
				$data['err_no'] = ErrorNo::SUCCESS_NUM;
			}

			if (!isset($data['err_msg'])) {
				$data['err_msg'] = '';
			}
		}
		else {
			$data = array(
				'err_no' => ErrorNo::SUCCESS_NUM,
				'err_msg' => '',
				'data' => $data,
			);
		}

		$data['log_id'] = Log::getId();
		return $data;
	}

	/**
	 * 检查用户是否登录，如果没有登录，跳转到登录页面
	 * @return boolean
	 */
	public function isLogin()
	{
		if (!UserIdentity::isLogin()) {
			$params = array(
				'continue' => Ap::getRequest()->getRequestUri(),
			);
			Util::forward('login', 'show', 'admin', $params);
			return false;
		}

		return true;
	}
}
