<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

/**
 * BuilderFactory class file
 * Builder模块对象工厂类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BuilderFactory.php 1 2013-03-29 16:48:06Z huan.song $
 * @package library
 * @since 1.0
 */
class BuilderFactory
{
	/**
	 * 获取模型类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @param integer $tableNum
	 * @return instance of slib\BaseModel
	 */
	public static function getModel($className, $tableNum = -1)
	{
		return Factory::getModel($className, $moduleName, $tableNum);
	}

	/**
	 * 获取数据管理类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @return instance of slib\BaseData
	 */
	public static function getData($className)
	{
		
	}

	/**
	 * 获取列表页数据配置类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @return instance
	 */
	public static function getTableElement($className)
	{
		
	}

	/**
	 * 获取表单页数据配置类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @return instance
	 */
	public static function getFormElement($className)
	{
		
	}
}
