<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace helper;

use tfc\ap\Ap;
use tfc\ap\ErrorException;
use tfc\ap\Singleton;
use tfc\mvc\Mvc;
use tfc\util\Paginator;
use tfc\saf\DbProxy;
use tfc\saf\Cfg;

/**
 * Util class file
 * 常用工具类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Util.php 1 2013-05-18 14:58:59Z huan.song $
 * @package helper
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
		self::forward(Mvc::$action, '', '', $params, $message, $delay);
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
     * 通过路由类型，在URL后拼接QueryString参数
     * @param string $url
     * @param array $params
     * @return string
     */
	public static function applyParams($url, array $params = array())
	{
		return self::getUrlManager()->applyParams($url, $params);
	}

	/**
	 * 通过路由类型，获取URL
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
	 * 获取当前链接
	 * @return string
	 */
	public static function getRequestUri()
	{
		return Ap::getRequest()->getRequestUri();
	}

	/**
     * 获取URL管理类
     * @return tfc\mvc\UrlManager
     */
    public static function getUrlManager()
    {
        return Singleton::getInstance('tfc\\mvc\\UrlManager');
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
	 * 获取字段信息配置类，包括表格、表单、验证规则、选项
	 * @param string $className
	 * @param string $moduleName
	 * @return ui\ElementCollections
	 */
	public static function getElements($className, $moduleName)
	{
		$className = 'modules\\' . strtolower($moduleName) . '\\elements\\' . $className;
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
	 * 获取当前的页码
	 * @return integer
	 */
	public static function getCurrPage()
	{
		try {
			$pageVar = Cfg::getApp('page_var', 'paginator');
		}
		catch (ErrorException $e) {
			$pageVar = Paginator::DEFAULT_PAGE_VAR;
		}

		$currPage = (int) Ap::getRequest()->getParam($pageVar, 0);
		$currPage = max($currPage, 1);
		return $currPage;
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
