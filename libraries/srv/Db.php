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
use tfc\saf\AbstractDb;
use tfc\saf\DbProxy;

/**
 * Db abstract class file
 * 业务层：数据库操作基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Db.php 1 2013-05-18 14:58:59Z huan.song $
 * @package srv
 * @since 1.0
 */
abstract class Db extends AbstractDb
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = null;

	/**
	 * @var instance of tdo\CommandBuilder
	 */
	protected $_commandBuilder = null;

	/**
	 * 构造方法：重写父类构造方法
	 */
	public function __construct()
	{
	}

	/**
	 * 验证字段必须存在
	 * @param array $params
	 * @return boolean
	 */
	public function required(array $params)
	{
		$num = func_num_args();
		if ($num < 2) {
			return true;
		}

		$args = func_get_args();
		unset($args[0]);

		foreach ($args as $columnName) {
			if (!is_string($columnName)) {
				continue;
			}

			if (!isset($params[$columnName])) {
				return false;
			}
		}

		return true;
	}

	/**
	 * 获取数据库代理操作类
	 * @return tfc\saf\DbProxy
	 */
	public function getDbProxy()
	{
		if ($this->_dbProxy === null) {
			$clusterName = $this->getClusterName();
			$className = 'tfc\\saf\\DbProxy::' . $clusterName;
			if (($dbProxy = Singleton::get($className)) === null) {
				$dbProxy = new DbProxy($clusterName);
				Singleton::set($className, $dbProxy);
			}

			$this->_dbProxy = $dbProxy;
		}

		return $this->_dbProxy;
	}

	/**
	 * 获取创建简单的执行命令类
	 * @return tdo\CommandBuilder
	 */
	public function getCommandBuilder()
	{
		if ($this->_commandBuilder === null) {
			$this->_commandBuilder = Singleton::getInstance('tdo\\CommandBuilder');
		}

		return $this->_commandBuilder;
	}

	/**
	 * 获取数据库配置名
	 * @return string
	 */
	public function getClusterName()
	{
		return $this->_clusterName;
	}
}
