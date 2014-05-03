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

use tfc\ap\Singleton;
use tfc\saf\DbProxy;

/**
 * TableName abstract class file
 * 表名管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TableName.php 1 2013-04-05 01:08:06Z huan.song $
 * @package srv
 * @since 1.0
 */
abstract class TableName
{
	/**
	 * @var string 数据库配置名
	 */
	protected static $_clusterName = null;

	/**
	 * @var string 表前缀
	 */
	protected static $_tblprefix = null;

	/**
	 * @var instance of tfc\saf\DbProxy
	 */
	protected static $_dbProxy = null;

	/**
	 * 获取表前缀
	 * @return string
	 */
	public static function getTblprefix()
	{
		if (self::$_tblprefix === null) {
			self::$_tblprefix = self::getDbProxy()->getTblprefix();
		}

		return self::$_tblprefix;
	}

	/**
	 * 获取数据库操作类
	 * @return tfc\saf\DbProxy
	 */
	public static function getDbProxy()
	{
		if (self::$_dbProxy === null) {
			$clusterName = self::getClusterName();
			$className = 'tfc\\saf\\DbProxy::' . $clusterName;
			if (($dbProxy = Singleton::get($className)) === null) {
				$dbProxy = new DbProxy($clusterName);
				Singleton::set($className, $dbProxy);
			}

			self::$_dbProxy = $dbProxy;
		}

		return self::$_dbProxy;
	}

	/**
	 * 获取数据库配置名
	 * @return string
	 */
	public static function getClusterName()
	{
		return $this->_clusterName;
	}

}
