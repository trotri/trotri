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

use tfc\ap\Singleton;
use tfc\saf\DbProxy;

/**
 * Db abstract class file
 * 业务层：数据库操作基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseDb.php 1 2013-05-18 14:58:59Z huan.song $
 * @package app
 * @since 1.0
 */
abstract class Db
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = null;

	/**
	 * @var instance of tfc\saf\DbProxy
	 */
	protected $_dbProxy = null;

	/**
	 * 获取数据库操作类
	 * @return tfc\saf\DbProxy
	 */
	public function getDbProxy()
	{
		if ($this->_dbProxy === null) {
			$className = 'tfc\\saf\\DbProxy::' . $this->_clusterName;
			if (($this->_dbProxy = Singleton::get($className)) === null) {
				$this->_dbProxy = new DbProxy($this->_clusterName);
				Singleton::set($className, $this->_dbProxy);
			}
		}

		return $this->_dbProxy;
	}

	/**
	 * 获取创建简单的执行命令类
	 * @return tdo\CommandBuilder
	 */
	public function getCommandBuilder()
	{
		return Singleton::getInstance('tdo\\CommandBuilder');
	}
}
