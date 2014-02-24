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

use tfc\ap\Ap;
use slib\Service;

/**
 * Factory class file
 * 对象工厂类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Factory.php 1 2013-03-29 16:48:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Factory
{
	/**
	 * 获取模型类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @param integer $tableNum
	 * @return instance of slib\BaseModel
	 */
	public static function getModel($className, $moduleName, $tableNum = -1)
	{
		return Service::getModel($className, $moduleName, Ap::getLanguageType(), $tableNum);
	}

	/**
	 * 获取数据管理类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @return instance of slib\BaseData
	 */
	public static function getData($className, $moduleName)
	{
		return Service::getData($className, $moduleName, Ap::getLanguageType());
	}
}
