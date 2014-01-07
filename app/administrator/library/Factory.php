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

use tfc\ap\Singleton;
use tfc\mvc\Mvc;
use tfc\saf\DbProxy;

/**
 * Factory class file
 * 对象工厂类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Factory.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Factory
{
	/**
	 * 通过DB配置名获取DB操作对象
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
	 * 获取数据库操作层类
	 * @param string $className
	 * @param string $moduleName
	 * @return koala\Db
	 */
	public static function getDb($className, $moduleName)
	{
		$className = 'modules\\' . $moduleName . '\\db\\' . $className;
		return Singleton::getInstance($className);
	}

	/**
	 * 获取字段信息配置类
	 * @param string $className
	 * @param string $moduleName
	 * @return ui\ElementCollections
	 */
	public static function getElements($className, $moduleName)
	{
		$className = 'modules\\' . $moduleName . '\\elements\\' . $className;
		return Singleton::getInstance($className);
	}

	/**
	 * 获取业务处理层类
	 * @param string $className
	 * @param string $moduleName
	 * @return koala\Model
	 */
	public static function getModel($className, $moduleName)
	{
		$className = 'modules\\' . $moduleName . '\\model\\' . $className;
		return Singleton::getInstance($className);
	}

	/**
	 * 获取页面小组件类
	 * @param string $className
	 * @param string $moduleName
	 * @return ui object
	 */
	public static function getUi($className, $moduleName)
	{
		$skinName = Mvc::getView()->skinName;
		$className = 'modules\\' . $moduleName . '\\ui\\' . $skinName . '\\' . $className;
		return Singleton::getInstance($className);
	}
}
