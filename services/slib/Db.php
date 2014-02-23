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

use tfc\ap\Singleton;
use tfc\saf\DbProxy;
use tdo;

/**
 * Db abstract class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Db.php 1 2013-05-18 14:58:59Z huan.song $
 * @package slib
 * @since 1.0
 */
abstract class Db extends tdo\Db
{
	/**
	 * @var instances of slib\Db
	 */
	protected static $_instances = array();

	/**
	 * 构造方法：初始化表名
	 * @param string $tableName
	 */
	protected function __construct($tableName)
	{
		$clusterName = Constant::DB_CLUSTER;
		$className = 'tfc\\saf\\DbProxy::' . $clusterName;
		if (($dbProxy = Singleton::get($className)) === null) {
			$dbProxy = new DbProxy($clusterName);
			Singleton::set($className, $dbProxy);
		}

		parent::__construct($tableName, $dbProxy);
	}

	/**
	 * 魔术方法：禁止被克隆
	 */
	private function __clone()
	{
	}

	/**
	 * 单例模式：获取本类的实例化对象
	 * @param string $tableName
	 * @return instance of slib\Db
	 */
	public static function getInstance($tableName)
	{
		$tableName = strtolower($tableName);
		if (!isset(self::$_instances[$tableName])) {
			self::$_instances[$tableName] = new self($tableName);
		}

		return self::$_instances[$tableName];
	}

	/**
	 * 获取所有本类的实例化对象
	 * @return instances of slib\Db
	 */
	public static function getInstances()
	{
		return self::$_instances;
	}
}
