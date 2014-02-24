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

/**
 * BuilderFactory class file
 * Builder模块对象工厂类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BuilderFactory.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class BuilderFactory
{
	/**
	 * @var string 当前模块名
	 */
	const MODULE_NAME = 'builder';

	/**
	 * 获取数据库操作层类
	 * @param string $className
	 * @return tdo\Db
	 */
	public static function getDb($className)
	{
		return Factory::getDb($className, self::MODULE_NAME);
	}

	/**
	 * 获取业务处理层类
	 * @param string $className
	 * @return tdo\Model
	 */
	public static function getModel($className)
	{
		return Factory::getModel($className, self::MODULE_NAME);
	}
}
