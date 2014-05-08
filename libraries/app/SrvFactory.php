<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace app;

use srv;

/**
 * SrvFactory class file
 * 单例管理类，通过类名获取类的实例，并且保证在一次PHP的运行周期内只创建一次实例
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SrvFactory.php 1 2013-04-05 20:00:06Z huan.song $
 * @package app
 * @since 1.0
 */
class SrvFactory
{
	/**
	 * @var array 用于寄存全局的实例
	 */
	protected static $_instances = array();

	/**
	 * 根据模型和类名获取类的实例，适用于类的构造方法没有参数，如果类的构造方法有参数，不能只通过类名区分不同的类
	 * @param string $className
	 * @param string $modName
	 * @return object
	 */
	public static function getInstance($className, $modName)
	{
		if (!self::has($className, $modName)) {
			$className = 'srv\\' . $modName . '\\mods\\' . $className;
			self::set($className, $modName, new $className());
		}

		return self::get($className, $modName);
	}

	/**
	 * 通过类名获取类的实例
	 * @param string $className
	 * @param string $modName
	 * @return object
	 */
	public static function get($className, $modName)
	{
		if (self::has($className, $modName)) {
			return self::$_instances[$modName][$className];
		}

		return null;
	}

	/**
	 * 设置类名和类的实例
	 * @param string $className
	 * @param string $modName
	 * @param object $instance
	 * @return void
	 */
	public static function set($className, $modName, $instance)
	{
		self::$_instances[$modName][$className] = $instance;
	}

	/**
	 * 通过类名删除类的实例
	 * @param string $className
	 * @param string $modName
	 * @return void
	 */
	public static function remove($className, $modName)
	{
		if (self::has($className, $modName)) {
			unset(self::$_instances[$modName][$className]);
		}
	}

	/**
	 * 通过类名判断类的实例是否已经存在
	 * @param string $className
	 * @param string $modName
	 * @return boolean
	 */
	public static function has($className, $modName)
	{
		return isset(self::$_instances[$modName][$className]);
	}
}
