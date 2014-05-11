<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv;

/**
 * Factory class file
 * 模型类单例管理，通过类名获取类的实例，并且保证在一次PHP的运行周期内只创建一次实例
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Factory.php 1 2013-04-05 20:00:06Z huan.song $
 * @package srv
 * @since 1.0
 */
class Factory
{
	/**
	 * @var array 用于寄存全局的实例
	 */
	protected static $_instances = array();

	/**
	 * 根据模型和类名获取类的实例，适用于类的构造方法没有参数，如果类的构造方法有参数，不能只通过类名区分不同的类
	 * @param string $modName
	 * @param string $srvName
	 * @return instance of srv\Model
	 */
	public static function getInstance($modName, $srvName)
	{
		if (!self::has($modName, $srvName)) {
			$className = $srvName . '\\models\\' . $modName;
			self::set($modName, $srvName, new $className());
		}

		return self::get($modName, $srvName);
	}

	/**
	 * 通过类名获取类的实例
	 * @param string $modName
	 * @param string $srvName
	 * @return instance of srv\Model
	 */
	public static function get($modName, $srvName)
	{
		if (self::has($modName, $srvName)) {
			return self::$_instances[$srvName][$modName];
		}

		return null;
	}

	/**
	 * 设置类名和类的实例
	 * @param string $modName
	 * @param string $srvName
	 * @param srv\Model $instance
	 * @return void
	 */
	public static function set($modName, $srvName, Model $instance)
	{
		self::$_instances[$srvName][$modName] = $instance;
	}

	/**
	 * 通过类名删除类的实例
	 * @param string $modName
	 * @param string $srvName
	 * @return void
	 */
	public static function remove($modName, $srvName)
	{
		if (self::has($modName, $srvName)) {
			unset(self::$_instances[$srvName][$modName]);
		}
	}

	/**
	 * 通过类名判断类的实例是否已经存在
	 * @param string $modName
	 * @param string $srvName
	 * @return boolean
	 */
	public static function has($modName, $srvName)
	{
		return isset(self::$_instances[$srvName][$modName]);
	}
}
