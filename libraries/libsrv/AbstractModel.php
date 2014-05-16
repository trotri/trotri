<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace libsrv;

use tfc\ap\Application;
use tfc\ap\ErrorException;
use tfc\saf\Log;
use tdo\AbstractDb;

/**
 * AbstractModel abstract class file
 * 业务层：模型基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: AbstractModel.php 1 2013-05-18 14:58:59Z huan.song $
 * @package libsrv
 * @since 1.0
 */
abstract class AbstractModel extends Application
{
	/**
	 * @var string 业务名
	 */
	protected $_srvName = '';

	/**
	 * @var string 模型类名
	 */
	protected $_className = '';

	/**
	 * @var libsrv\FormProcessor 表单数据处理类
	 */
	protected $_formProcessor = null;

	/**
	 * @var tdo\AbstractDb 数据库操作类
	 */
	protected $_db = null;

	/**
	 * 构造方法：初始化表名
	 * @param string $tableName
	 */
	public function __construct($tableName = '')
	{
		list($this->_srvName, , $this->_className) = explode('\\', get_class($this));
	}

	/**
	 * 获取表单数据处理类
	 * @return instance of libsrv\FormProcessor
	 */
	public function getFormProcessor()
	{
		if ($this->_formProcessor === null) {
			$this->setFormProcessor();
		}

		return $this->_formProcessor;
	}

	/**
	 * 设置表单数据处理类
	 * @param libsrv\FormProcessor $fp
	 * @return instance of tdo\AbstractDb
	 * @throws ErrorException 如果表单数据处理类类不存在，抛出异常
	 * @throws ErrorException 如果获取的实例不是libsrv\FormProcessor类的子类，抛出异常
	 */
	public function setFormProcessor(FormProcessor $fp = null)
	{
		if ($fp === null) {
			$className = $this->getSrvName() . '\\models\\Fp' . $this->getClassName();
			if (!class_exists($className)) {
				throw new ErrorException(sprintf(
					'AbstractModel is unable to find the FormProcessor class "%s".', $className
				));
			}

			$fp = new $className($this);
			if (!$fp instanceof FormProcessor) {
				throw new ErrorException(sprintf(
					'AbstractModel FormProcessor class "%s" is not instanceof libsrv\FormProcessor.', $className
				));
			}
		}

		$this->_formProcessor = $fp;
		return $this;
	}

	/**
	 * 获取所有的错误信息
	 * @param boolean $justOne
	 * @return array
	 */
	public function getErrors($justOne = true)
	{
		return $this->getFp()->getErrors($justOne);
	}

	/**
	 * 清理正整数数据，如果为负数则返回false
	 * @param integer|array $value
	 * @return mixed
	 */
	public function cleanPositiveInteger($value)
	{
		$result = Clean::positiveInteger($value);
		if ($result === false) {
			$isArr = is_array($value);
			Log::warning(sprintf(
				'AbstractModel cleanPositiveInteger ARGS Error, "%s" "%s" must be greater than 0',
				($isArr ? 'PKs' : 'PK'), ($isArr ? serialize($value) : $value)
			));
		}

		return $result;
	}

	/**
	 * 获取数据库操作类
	 * @return instance of tdo\AbstractDb
	 */
	public function getDb()
	{
		if ($this->_db === null) {
			$this->setDb();
		}

		return $this->_db;
	}

	/**
	 * 设置数据库操作类
	 * @param tdo\AbstractDb $db
	 * @return instance of libsrv\AbstractModel
	 * @throws ErrorException 如果DB类不存在，抛出异常
	 * @throws ErrorException 如果获取的实例不是tdo\AbstractDb类的子类，抛出异常
	 */
	public function setDb(AbstractDb $db = null)
	{
		if ($db === null) {
			$className = $this->getSrvName() . '\\db\\' . $this->getClassName();
			if (!class_exists($className)) {
				throw new ErrorException(sprintf(
					'AbstractModel is unable to find the DB class "%s".', $className
				));
			}

			$db = new $className();
			if (!$db instanceof AbstractDb) {
				throw new ErrorException(sprintf(
					'AbstractModel DB class "%s" is not instanceof tdo\AbstractDb.', $className
				));
			}
		}

		$this->_db = $db;
		return $this;
	}

	/**
	 * 获取业务名
	 * @return string
	 */
	public function getSrvName()
	{
		return $this->_srvName;
	}

	/**
	 * 获取模型类名
	 * @return string
	 */
	public function getClassName()
	{
		return $this->_className;
	}
}
