<?php
/**
 * Trotri Base Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace base;

use tfc\ap\Singleton;
use tfc\saf\DbProxy;

/**
 * Util class file
 * 常用小工具集
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Util.php 1 2013-05-18 14:58:59Z huan.song $
 * @package base
 * @since 1.0
 */
class Util
{
	/**
	 * 通过DB配置名获取DB操作类
	 * @param string $clusterName
	 * @return instance of tfc\saf\DbProxy
	 */
	public function getDbProxy($clusterName)
	{
		$className = 'tfc\saf\DbProxy::' . $clusterName;
		if (($instance = Singleton::get($className)) === null) {
			$instance = new DbProxy($clusterName);
			Singleton::set($className, $instance);
		}

		return $instance;
	}

	/**
	 * 获取表单管理类
	 * @param string $className
	 * @param string $moduleName
	 * @return instance of form
	 */
	public function getForm($className, $moduleName)
	{
		$className = 'modules\\' . strtolower($moduleName) . '\\form\\' . $className;
		return Singleton::getInstance($className);
	}

	/**
	 * 获取业务层类
	 * @param string $className
	 * @param string $moduleName
	 * @return instance of model
	 */
	public function getModel($className, $moduleName)
	{
		$className = 'modules\\' . strtolower($moduleName) . '\\model\\' . $className;
		return Singleton::getInstance($className);
	}

	/**
	 * 获取数据库层类
	 * @param string $className
	 * @param string $moduleName
	 * @return instance of db
	 */
	public function getDb($className, $moduleName)
	{
		$className = 'modules\\' . strtolower($moduleName) . '\\db\\' . $className;
		return Singleton::getInstance($className);
	}

	/**
	 * 获取当前时间，包含年月日时分秒
	 * @return string
	 */
	public function getNowTime()
	{
		return date('Y-m-d H:i:s');
	}
}
