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

use base;
use tfc\ap\Ap;
use tfc\mvc\Mvc;

/**
 * Util class file
 * 常用工具类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Util.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library
 * @since 1.0
 */
class Util extends base\Util
{
	/**
	 * 页面重定向到当前的Action
	 * @param array $params
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public function refresh($params = array(), $message = '', $delay = 0)
	{
		self::forward('', '', '', $params, $message, $delay);
	}

	/**
	 * 页面重定向到指定的Action
	 * @param string $action
	 * @param string $controller
	 * @param string $module
	 * @param array $params
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public function forward($action = '', $controller = '', $module = '', array $params = array(), $message = '', $delay = 0)
	{
		$url = self::getUrl($action, $controller, $module, $params);
		Ap::getResponse()->redirect($url, $message, $delay);
		exit;
	}

	/**
	 * 通过Params获取当前Url
	 * @param array $params
	 * @return string
	 */
	public function getUrlByAct(array $params = array())
	{
		return self::getUrlByCtrl('', $params);
	}

	/**
	 * 通过Action、Params获取当前控制器Url
	 * @param string $action
	 * @param array $params
	 * @return string
	 */
	public function getUrlByCtrl($action = '', array $params = array())
	{
		return self::getUrlByMod($action, '', $params);
	}

	/**
	 * 通过Action、Controller、Params获取当前模型的Url
	 * @param string $action
	 * @param string $controller
	 * @param array $params
	 * @return string
	 */
	public function getUrlByMod($action = '', $controller = '', array $params = array())
	{
		return self::getUrl($action, $controller, '', $params);
	}

	/**
	 * 通过Action、Controller、Module、Params获取Url
	 * @param string $action
	 * @param string $controller
	 * @param string $module
	 * @param array $params
	 * @return string
	 */
	public function getUrl($action = '', $controller = '', $module = '', array $params = array())
	{
		$url = Ap::getRequest()->getScriptUrl();

		if (($module = trim((string) $module)) === '') {
			$module = Mvc::$module;
		}

		if (($controller = trim((string) $controller)) === '') {
			$controller = Mvc::$controller;
		}

		if (($action = trim((string) $action)) === '') {
			$action = Mvc::$action;
		}

		$url .= '?r=' . $module . '/' . $controller . '/' . $action;
		foreach ($params as $key => $value) {
			$url .= '&' . $key . '=' . urlencode($value);
		}

		return $url;
	}
}
