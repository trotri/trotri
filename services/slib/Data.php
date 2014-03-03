<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace slib;

use tfc\ap\ErrorException;

/**
 * Data class file
 * 业务层：数据寄存器管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Data.php 1 2013-03-29 16:48:06Z huan.song $
 * @package slib
 * @since 1.0
 */
class Data
{
	/**
	 * @var array 寄存所有调用过的数据寄存器类实例
	 */
	protected static $_instances = array();

	/**
	 * 获取数据管理类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @param slib\Language $language
	 * @return instance of slib\BaseData
	 */
	public static function getInstance($className, $moduleName, Language $language)
	{
		$namespaceName = self::getNamespaceName($className, $moduleName);
		$insName = $namespaceName . '::' . $language->getType();
		if (!isset(self::$_instances[$insName])) {
			self::$_instances[$insName] = self::createInstance($namespaceName, $language);
		}

		return self::$_instances[$insName];
	}

	/**
	 * 创建数据管理类的实例
	 * @param string $namespaceName
	 * @param slib\Language $language
	 * @return instance of slib\BaseData
	 * @throws ErrorException 如果数据管理类不存在，抛出异常
	 * @throws ErrorException 如果获取的数据管理类实例不是slib\BaseData类的子类，抛出异常
	 */
	public static function createInstance($namespaceName, Language $language)
	{
		if (!class_exists($namespaceName)) {
			throw new ErrorException(sprintf(
				'Data is unable to find the requested namespace name "%s".', $namespaceName
			));
		}

		$instance = new $namespaceName($language);
		if (!$instance instanceof BaseData) {
			throw new ErrorException(sprintf(
				'Data Class "%s" is not instanceof slib\BaseData.', $namespaceName
			));
		}

		return $instance;
	}

	/**
	 * 获取数据管理类名
	 * @param string $className
	 * @param string $moduleName
	 * @return string
	 */
	public static function getNamespaceName($className, $moduleName)
	{
		$className = 'Data' . ucfirst(strtolower(trim($className)));
		$moduleName = strtolower(trim($moduleName));
		return 'smods\\' . $moduleName . '\\' . $className;
	}

	/**
	 * 获取所有寄存的数据管理类实例
	 * @return array
	 */
	public static function getInstances()
	{
		return self::$_instances;
	}
}
