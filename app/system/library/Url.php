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

use tfc\ap\Ap;
use tfc\ap\Singleton;

/**
 * Url class file
 * Url管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Url.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Url
{
	/**
	 * @var instance of tfc\mvc\UrlManager
	 */
	protected static $urlManager = null;

	/**
	 * 页面重定向到当前页面链接
	 * @param array $params
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public static function refresh($params = array(), $message = '', $delay = 0)
	{
		$url = self::applyParams(self::getRequestUri(), $params);
		self::redirect($url, $message, $delay);
	}

	/**
	 * 页面重定向到上一个页面链接
	 * @param array $params
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public static function referer($params = array(), $message = '', $delay = 0)
	{
		$url = self::applyParams((string) self::getReferer(), $params);
		self::redirect($url, $message, $delay);
	}

	/**
	 * 页面重定向到指定的路由
	 * @param string $action
	 * @param string $controller
	 * @param string $module
	 * @param array $params
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public static function forward($action = '', $controller = '', $module = '', array $params = array(), $message = '', $delay = 0)
	{
		$url = self::getUrl($action, $controller, $module, $params);
		self::redirect($url, $message, $delay);
	}

	/**
	 * 页面重定向到指定的链接
	 * @param string $url
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public static function redirect($url, $message = '', $delay = 0)
	{
		Ap::getResponse()->redirect($url, $message, $delay);
		exit;
	}

	/**
	 * 获取当前页面链接
	 * @return string
	 */
	public static function getRequestUri()
	{
		return self::getUrlManager()->getRequestUri();
	}

	/**
	 * 获取上一个页面链接
	 * @return string
	 */
	public static function getReferer()
	{
		$referer = Ap::getRequest()->getParam('http_referer', false);
		if (is_string($referer)) {
			return $referer;
		}

		return Ap::getRequest()->getServer('HTTP_REFERER', false);
	}

	/**
	 * 获取当前脚本的路径
	 * @return string
	 */
	public function getScriptUrl()
	{
		return self::getUrlManager()->getScriptUrl();
	}

	/**
	 * 获取URL
	 * 如果指定了Action，但没指定Controller，则Controller默认为当前Controller
	 * 如果指定了Controller，但没指定Module，则Module默认为当前Module
	 * @param string $action
	 * @param string $controller
	 * @param string $module
	 * @param array $params
	 * @return string
	 */
	public static function getUrl($action = '', $controller = '', $module = '', array $params = array())
	{
		return self::getUrlManager()->getUrl($action, $controller, $module, $params);
	}

	/**
	 * 在URL后拼接该路由的QueryString参数
	 * @param string $url
	 * @param string $action
	 * @param string $controller
	 * @param string $module
	 * @param array $params
	 * @return string
	 */
	public static function applyQueryString($url, $action = '', $controller = '', $module = '', array $params = array())
	{
		return self::getUrlManager()->applyQueryString($url, $action, $controller, $module, $params);
	}

	/**
	 * 在URL后拼接QueryString参数
	 * @param string $url
	 * @param array $params
	 * @return string
	 */
	public static function applyParams($url, array $params = array())
	{
		return self::getUrlManager()->applyParams($url, $params);
	}

	/**
	 * 获取URL管理类
	 * @return tfc\mvc\UrlManager
	 */
	public static function getUrlManager()
	{
		if (self::$urlManager === null) {
			self::$urlManager = Singleton::getInstance('tfc\\mvc\\UrlManager');
		}

		return self::$urlManager;
	}
}
