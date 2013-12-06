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
 * GeneratorFactory class file
 * Generator模块对象工厂类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GeneratorFactory.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class GeneratorFactory
{
	/**
	 * @var string 当前模块名
	 */
	const MODULE_NAME = 'generator';

	/**
	 * 数据库操作层对象
	 * @param string $className
	 * @return koala\Db
	 */
	public static function getDb($className)
	{
		return Factory::getDb($className, self::MODULE_NAME);
	}

	/**
	 * 获取字段信息配置对象，包括表格、表单、验证规则、选项
	 * @param string $className
	 * @return ui\ElementCollections
	 */
	public static function getElements($className)
	{
		return Factory::getElements($className, self::MODULE_NAME);
	}

	/**
	 * 获取业务处理层对象
	 * @param string $className
	 * @return koala\Model
	 */
	public static function getModel($className)
	{
		return Factory::getModel($className, self::MODULE_NAME);
	}

	/**
	 * 通过配置中的skin_name，获取对应的页面小组件类
	 * @param string $className
	 * @return ui object
	 */
	public static function getUi($className)
	{
		return Factory::getUi($className, self::MODULE_NAME);
	}
}
