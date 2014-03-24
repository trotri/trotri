<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace slib;

use tfc\ap\ErrorException;
use tfc\util\Language;

/**
 * Model class file
 * 业务层：模型管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Model.php 1 2013-05-18 14:58:59Z huan.song $
 * @package slib
 * @since 1.0
 */
class Model
{
	/**
	 * @var array 寄存所有调用过的模型类实例
	 */
	protected static $_instances = array();

	/**
	 * 获取模型类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @param tfc\util\Language $language
	 * @param integer $tableNum
	 * @return instance of slib\BaseModel
	 */
	public static function getInstance($className, $moduleName, Language $language, $tableNum = -1)
	{
		$namespaceName = self::getNamespaceName($className, $moduleName);
		$insName = $namespaceName . '::' . $language->getType() . '::' . (int) $tableNum;
		if (!isset(self::$_instances[$insName])) {
			self::$_instances[$insName] = self::createInstance($namespaceName, $language, $tableNum);
		}

		return self::$_instances[$insName];
	}

	/**
	 * 创建模型类的实例
	 * @param string $namespaceName
	 * @param tfc\util\Language $language
	 * @param integer $tableNum
	 * @return instance of slib\BaseModel
	 * @throws ErrorException 如果模型类不存在，抛出异常
	 * @throws ErrorException 如果获取的模型类实例不是slib\BaseModel类的子类，抛出异常
	 */
	public static function createInstance($namespaceName, Language $language, $tableNum = -1)
	{
		if (!class_exists($namespaceName)) {
			throw new ErrorException(sprintf(
				'Model is unable to find the requested namespace name "%s".', $namespaceName
			));
		}

		$instance = new $namespaceName($language, $tableNum);
		if (!$instance instanceof BaseModel) {
			throw new ErrorException(sprintf(
				'Model Class "%s" is not instanceof slib\BaseModel.', $namespaceName
			));
		}

		return $instance;
	}

	/**
	 * 获取模型类名
	 * @param string $className
	 * @param string $moduleName
	 * @return string
	 */
	public static function getNamespaceName($className, $moduleName)
	{
		$className = 'Mod' . ucfirst(strtolower(trim($className)));
		$moduleName = strtolower(trim($moduleName));
		return 'smods\\' . $moduleName . '\\' . $className;
	}

	/**
	 * 获取所有寄存的模型类实例
	 * @return array
	 */
	public static function getInstances()
	{
		return self::$_instances;
	}
}
