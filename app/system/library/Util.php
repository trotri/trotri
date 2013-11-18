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
use tfc\mvc\Mvc;
use tfc\saf\DbProxy;

/**
 * Util class file
 * 常用工具类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Util.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library
 * @since 1.0
 */
class Util
{
	/**
	 * 页面重定向到当前的Action
	 * @param array $params
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public static function refresh($params = array(), $message = '', $delay = 0)
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
	public static function forward($action = '', $controller = '', $module = '', array $params = array(), $message = '', $delay = 0)
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
	public static function getActUrl(array $params = array())
	{
		return self::getCtrlUrl('', $params);
	}

	/**
	 * 通过Action、Params获取当前控制器Url
	 * @param string $action
	 * @param array $params
	 * @return string
	 */
	public static function getCtrlUrl($action = '', array $params = array())
	{
		return self::getModUrl($action, '', $params);
	}

	/**
	 * 通过Action、Controller、Params获取当前模型的Url
	 * @param string $action
	 * @param string $controller
	 * @param array $params
	 * @return string
	 */
	public static function getModUrl($action = '', $controller = '', array $params = array())
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
	public static function getUrl($action = '', $controller = '', $module = '', array $params = array())
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

	/**
	 * 通过DB配置名获取DB操作类
	 * @param string $clusterName
	 * @return tfc\saf\DbProxy
	 */
	public static function getDbProxy($clusterName)
	{
		$className = 'tfc\\saf\\DbProxy::' . $clusterName;
		if (($instance = Singleton::get($className)) === null) {
			$instance = new DbProxy($clusterName);
			Singleton::set($className, $instance);
		}

		return $instance;
	}

	/**
	 * 获取业务辅助类
	 * @param string $className
	 * @param string $moduleName
	 * @return koala\widgets\ElementCollections
	 */
	public static function getHelper($className, $moduleName)
	{
		$className = 'modules\\' . strtolower($moduleName) . '\\helper\\' . $className;
		return Singleton::getInstance($className);
	}

	/**
	 * 获取业务层类
	 * @param string $className
	 * @param string $moduleName
	 * @return koala\Model
	 */
	public static function getModel($className, $moduleName)
	{
		$className = 'modules\\' . strtolower($moduleName) . '\\model\\' . $className;
		return Singleton::getInstance($className);
	}

	/**
	 * 获取数据库层类
	 * @param string $className
	 * @param string $moduleName
	 * @return koala\Db
	 */
	public static function getDb($className, $moduleName)
	{
		$className = 'modules\\' . strtolower($moduleName) . '\\db\\' . $className;
		return Singleton::getInstance($className);
	}

	/**
	 * 获取当前时间，包含年月日时分秒
	 * @return string
	 */
	public static function getNowTime()
	{
		return date('Y-m-d H:i:s');
	}
}
