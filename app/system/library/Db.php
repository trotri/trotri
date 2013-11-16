<?php
/**
 * Trotri Base Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use base;

/**
 * Db abstract class file
 * 数据库操作基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Db.php 1 2013-05-18 14:58:59Z huan.song $
 * @package base
 * @since 1.0
 */
abstract class Db extends base\Db
{
	/**
	 * 构造方法：初始化表名和数据库操作类
	 * @param string $tableName
	 */
	public function __construct($tableName)
	{
		$dbProxy = Util::getDbProxy(Constant::DB_CLUSTER);
		parent::__construct($tableName, $dbProxy);
	}
}
