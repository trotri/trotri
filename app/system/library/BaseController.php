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

use tfc\util\Paginator;

use tfc\ap\ErrorException;

use tfc\saf\Cfg;

use tfc\ap\Ap;
use tfc\ap\Registry;
use tfc\mvc\Mvc;
use tfc\mvc\Controller;
use tfc\util\String;
use tfc\saf\Log;
use tfc\saf\Text;

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
		$this->assignLanguage();

		$view = Mvc::getView();
		$view->addLayoutName('layouts' . DS . $this->layoutName);
		if ($tplName === null) {
			$tplName = $this->getDefaultTplName();
		}

		if (!isset($data['err_no']) || $data['err_no'] === ErrorNo::SUCCESS_NUM) {
			$data['err_no'] = Ap::getRequest()->getInteger('err_no', ErrorNo::SUCCESS_NUM);
			$data['err_msg'] = String::escapeXss(Ap::getRequest()->getString('err_msg'));
		}

		if (($referer = Url::getReferer()) !== false) {
			$data['http_referer'] = $referer;
		}

		$view->render($tplName, $data);
	}

	/**
	 * 将常用数据设置到模板变量中
	 * @return void
	 */
	public function assignSystem()
	{
		$view = Mvc::getView();

		$view->assign('app', 		APP_NAME);
		$view->assign('module', 	Mvc::$module);
		$view->assign('controller', Mvc::$controller);
		$view->assign('action', 	Mvc::$action);
		$view->assign('sidebar', 	Mvc::$module . '/' . Mvc::$controller . '_sidebar');
		$view->assign('log_id', 	Log::getId());

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
		$req = Ap::getRequest();

		$baseUrl    = $req->getBaseUrl();
		$basePath   = $req->getBasePath();
		$scriptUrl  = $req->getScriptUrl();
		$requestUri = $req->getRequestUri();
		$staticUrl  = $baseUrl . '/static/' . APP_NAME . '/' . $view->skinName;

		$view->assign('root_url',    $baseUrl . '/..');
		$view->assign('base_path',   $basePath);
		$view->assign('base_url',    $baseUrl);
		$view->assign('script_url',  $scriptUrl);
		$view->assign('request_uri', $requestUri);
		$view->assign('static_url',  $staticUrl);
		$view->assign('js_url',      $staticUrl . '/js');
		$view->assign('css_url',     $staticUrl . '/css');
		$view->assign('imgs_url',    $staticUrl . '/imgs');
	}

	/**
	 * 将公共的语言包和当前模块的语言包设置到模板变量中
	 * @return void
	 */
	public function assignLanguage()
	{
		$view = Mvc::getView();

		Text::_('CFG_SYSTEM__');
		Text::_('MOD_' . strtoupper(Mvc::$module) . '__');

		$strings = Text::getStrings();
		$view->assign($strings);
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
	 * @see getViewData
	 */
	public function display($data)
	{
		$data = $this->getViewData($data);
		echo json_encode($data);
	}

	/**
	 * 获取Ajax方式输出数据，规范化输出数据的格式
	 * 默认添加的输出内容：log_id (integer)
	 * <pre>
	 * 一.参数是字符串：
	 * $data = 'trotri';
	 * 返回值：
	 * $ret = array (
	 *     'err_no' => 0,
	 *     'err_msg' => '',
 	 *     'data' => 'trotri',
 	 *     'log_id' => 2000010
	 * );
	 *
	 * 二.参数是数组，但是没有指定err_no和err_msg：
	 * $data = array (
	 *     'user_id' => 1,
	 *     'user_name' => 'trotri'
	 * );
	 * 或
	 * $data = array (
	 *     'extra' => '', // 这个值将被丢弃
	 *     'data' => array (
	 *         'user_id' => 1,
	 *         'user_name' => 'trotri'
	 *     )
	 * );
	 * 返回值：
	 * $ret = array (
	 *     'err_no' => 0,
	 *     'err_msg' => '',
	 *     'data' => array (
	 *         'user_id' => 1,
	 *         'user_name' => 'trotri',
	 *     ),
	 *     'log_id' => 2000010
	 * );
	 *
	 * 三.参数是数组，并且已经指定err_no和err_msg：
	 * $data = array (
	 *     'err_no' => 1001,
	 *     'err_msg' => 'Login Failed',
	 *     'user_id' => 1,
	 *     'user_name' => 'trotri'
	 * );
	 * 或
	 * $data = array (
	 *     'err_no' => 1001,
	 *     'err_msg' => 'Login Failed',
	 *     'extra' => '', // 这个值将被丢弃
	 *     'data' => array (
	 *         'user_id' => 1,
	 *         'user_name' => 'trotri'
	 *     )
	 * );
	 * 返回值：
	 * $ret = array (
	 *     'err_no' => 1001,
	 *     'err_msg' => 'Login Failed',
	 *     'data' => array (
	 *         'user_id' => 1,
	 *         'user_name' => 'trotri'
	 *     ),
	 *     'log_id' => 2000010
	 * );
	 * </pre>
	 * @param mixed $data
	 * @return array
	 */
	public function getViewData($data)
	{
		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = '';
		if (is_array($data)) {
			if (isset($data['err_no'])) {
				$errNo = (int) $data['err_no'];
				unset($data['err_no']);
			}

			if (isset($data['err_msg'])) {
				$errMsg = $data['err_msg'];
				unset($data['err_msg']);
			}

			if (isset($data['data'])) {
				$data = $data['data'];
			}
		}

		$ret = array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => $data,
			'log_id' => Log::getId()
		);

		return $ret;
	}

	/**
	 * 获取当前页码
	 * @return integer
	 */
	public function getCurrPage()
	{
		try {
			$pageVar = Cfg::getApp('page_var', 'paginator');
		}
		catch (ErrorException $e) {
			$pageVar = Paginator::DEFAULT_PAGE_VAR;
		}

		return Ap::getRequest()->getInteger($pageVar);
	}

	/**
	 * 获取当前表单提交方式
	 * @return string
	 */
	public function getSubmitType()
	{
		$submitTypes = array(
			'save', 'save_close', 'save_new'
		);

		$submitType = Ap::getRequest()->getTrim('submit_type');
		if (in_array($submitType, $haystack)) {
			
		}		
	}
}
