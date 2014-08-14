<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use libapp;
use libsrv\Service;
use libsrv\AbstractService;
use libsrv\Clean;

/**
 * BaseModel abstract class file
 * 模型基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseModel.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library
 * @since 1.0
 */
abstract class BaseModel extends libapp\BaseModel
{
	/**
	 * @var srv\srvname\services\Types 业务处理类
	 */
	protected $_service = null;

	/**
	 * @var string 业务名
	 */
	protected $_srvName = '';

	/**
	 * @var string 模型类名
	 */
	protected $_className = '';

	/**
	 * (non-PHPdoc)
	 * @see \libapp\Elements::_init()
	 */
	protected function _init()
	{
		list(, $moduleName, , $className) = explode('\\', get_class($this));
		if ($this->_srvName === '') {
			$this->_srvName = $moduleName;
		}

		if ($this->_className === '') {
			$this->_className = $className;
		}
	}

	/**
	 * 查询数据列表
	 * @param libsrv\AbstractService $object
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(AbstractService $object, array $params = array(), $order = '', $limit = null, $offset = null)
	{
		if ($limit === null) {
			$limit = libapp\PageHelper::getListRows();
		}

		if ($offset === null) {
			$offset = libapp\PageHelper::getFirstRow();
		}

		$ret = $this->callFetchMethod($object, 'findAllByAttributes', array($params, $order, $limit, $offset, 'SQL_CALC_FOUND_ROWS'));
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$data = $ret['data']['rows'];
		unset($ret['data']['rows']);

		$ret['paginator'] = $ret['data'];
		$ret['data'] = $data;

		return $ret;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
		$ret = $this->callFetchMethod($this->getService(), 'findByPk', array($value));
		return $ret;
	}

	/**
	 * 通过主键，获取某个列的值
	 * @param string $columnName
	 * @param integer $amcaId
	 * @return mixed
	 */
	public function getByPk($columnName, $amcaId)
	{
		return $this->getService()->getByPk($columnName, $amcaId);
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return array
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$ret = $this->callCreateMethod($this->getService(), 'create', $params, $ignore);
		return $ret;
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $id
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($id, array $params = array())
	{
		$ret = $this->callModifyMethod($this->getService(), 'modifyByPk', $id, $params);
		return $ret;
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $id
	 * @return array
	 */
	public function removeByPk($id)
	{
		$ret = $this->callRemoveMethod($this->getService(), 'removeByPk', $id);
		return $ret;
	}

	/**
	 * 通过主键，编辑多条记录。不支持联合主键
	 * @param array $values
	 * @param array $params
	 * @return integer
	 */
	public function batchModifyByPk(array $values, array $params = array())
	{
		$ret = $this->callModifyMethod($this->getService(), 'batchModifyByPk', $values, $params);
		return $ret;
	}

	/**
	 * 通过主键，删除多条记录。不支持联合主键
	 * @param array $ids
	 * @return array
	 */
	public function batchRemoveByPk(array $ids)
	{
		$ret = $this->callRemoveMethod($this->getService(), 'batchRemoveByPk', $ids);
		return $ret;
	}

	/**
	 * 通过主键，将一条记录移至回收站。不支持联合主键
	 * @param integer $id
	 * @return array
	 */
	public function trashByPk($id)
	{
		$ret = $this->callRemoveMethod($this->getService(), 'trashByPk', $id);
		return $ret;
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $ids
	 * @return array
	 */
	public function batchTrashByPk(array $ids)
	{
		$ret = $this->callRemoveMethod($this->getService(), 'batchTrashByPk', $ids);
		return $ret;
	}

	/**
	 * 通过主键，从回收站还原一条记录
	 * @param integer $pk
	 * @return integer
	 */
	public function restoreByPk($pk)
	{
		$ret = $this->callRestoreMethod($this->getService(), 'restoreByPk', $pk);
		return $ret;
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $ids
	 * @return integer
	 */
	public function batchRestoreByPk(array $ids)
	{
		$ret = $this->callRestoreMethod($this->getService(), 'batchRestoreByPk', $ids);
		return $ret;
	}

	/**
	 * 获取业务处理类
	 * @return instance of srv\srvname\services\Types
	 */
	public function getService()
	{
		if ($this->_service === null) {
			$this->_service = Service::getInstance($this->_className, $this->_srvName);
		}

		return $this->_service;
	}

	/**
	 * 过滤数组（只保留指定的字段）、清理数据并且清除空数据（空字符，负数）
	 * @param array $attributes
	 * @param array $rules
	 * @return void
	 */
	protected function filterCleanEmpty(array &$attributes = array(), array $rules = array())
	{
		$this->filterAttributes($attributes, array_keys($rules));
		$attributes = Clean::rules($rules, $attributes);
		foreach ($rules as $columnName => $funcName) {
			if (!isset($attributes[$columnName])) {
				continue;
			}

			if ($funcName === 'trim' && $attributes[$columnName] === '') {
				unset($attributes[$columnName]);
				continue;
			}

			if ($funcName === 'intval' && $attributes[$columnName] < 0) {
				unset($attributes[$columnName]);
				continue;
			}
		}
	}
}
