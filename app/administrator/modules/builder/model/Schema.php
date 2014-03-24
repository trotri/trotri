<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\model;

use tdo\Metadata;

use tfc\ap\Singleton;
use tfc\saf\DbProxy;
use slib\Constant;
use library\Model;

/**
 * Schema class file
 * 数据库表概要
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Schema.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Schema extends Model
{
	/**
	 * @var instance of tdo\Metadata
	 */
	protected $_metadata = null;

	/**
	 * 构造方法：初始化MySQL表结构分析类
	 */
	public function __construct()
	{
		$this->_metadata = new Metadata($this->getDbProxy());
	}

	/**
     * 获取数据库中所有表名，如果$value不为null，通过LIKE匹配$value指定的表名
     * @param string|null $value
     * @return array
     */
	public function getTableNames($value = null)
	{
		$tableNames = $this->_metadata->getTableNames($value);

		$tblPrefix = $this->getDbProxy()->getTblprefix();
		$tblPrefixLen = strlen($tblPrefix);

		$ret = array();
		foreach ($tableNames as $tableName) {
			$ret[] = substr($tableName, $tblPrefixLen);
		}

		return $ret;
	}

	/**
	 * 获取DbProxy
	 * @return tfc\saf\DbProxy
	 */
	public function getDbProxy()
	{
		$clusterName = Constant::DB_CLUSTER;
		$className = 'tfc\\saf\\DbProxy::' . $clusterName;
		if (($dbProxy = Singleton::get($className)) === null) {
			$dbProxy = new DbProxy($clusterName);
			Singleton::set($className, $dbProxy);
		}

		return $dbProxy;
	}
}
