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
use tdo\Db;

/**
 * BaseDb abstract class file
 * 业务层：数据库操作基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseDb.php 1 2013-05-18 14:58:59Z huan.song $
 * @package slib
 * @since 1.0
 */
abstract class BaseDb extends Db
{
	/**
	 * 构造方法：初始化表名
	 * @param string $tableName
	 * @param integer $tableNum 用于分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct($tableName, $tableNum = -1)
	{
		if (($tableNum = (int) $tableNum) >= 0) {
			$tableName .= '_' . $tableNum;
		}

		$clusterName = Constant::DB_CLUSTER;
		$className = 'tfc\\saf\\DbProxy::' . $clusterName;
		if (($dbProxy = Singleton::get($className)) === null) {
			$dbProxy = new DbProxy($clusterName);
			Singleton::set($className, $dbProxy);
		}

		parent::__construct($tableName, $dbProxy);
	}
}
