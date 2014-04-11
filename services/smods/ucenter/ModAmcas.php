<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\ucenter;

use tfc\ap\Registry;
use tfc\util\Language;
use slib\BaseModel;
use slib\Data;
use slib\ErrorNo;
use smods\ucenter\validator\UserAmcasAmcaNameUnique;

/**
 * ModAmcas class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModAmcas.php 1 2014-04-06 14:43:06Z Code Generator $
 * @package smods.ucenter
 * @since 1.0
 */
class ModAmcas extends BaseModel
{
	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param tfc\util\Language $language
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct(Language $language, $tableNum = -1)
	{
		$db = new DbAmcas($tableNum);
		parent::__construct($db, $language);
	}

	/**
	 * 获取所有的应用提示
	 * @return array
	 */
	public function getAppPrompts()
	{
		$ret = $this->findPairsByAttributes(array('amca_id', 'prompt'), array('category' => 'app'), 'sort');
		$data = array();
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$data = $ret['data'];
		}

		return $data;
	}

	/**
	 * 通过父ID，获取所有的子事件
	 * @param integer $pid
	 * @return array
	 */
	public function findAllByPid($pid)
	{
		return $this->findAllByAttributes(array('amca_pid' => (int) $pid), 'sort');
	}

	/**
	 * 获取模块和控制器类型数据
	 * @param integer $appId
	 * @return array
	 */
	public function findModCtrls($appId)
	{
		$data = array();

		$ret = $this->findAllByPid($appId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$mods = $ret['data'];
		foreach ($mods as $mRows) {
			$ret = $this->findAllByPid($mRows['amca_id']);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				return $ret;
			}

			$ctrls = $ret['data'];
			$data[] = $mRows;
			foreach ($ctrls as $cRows) {
				$cRows['amca_name'] = ' ---- ' . $cRows['amca_name'];
				$data[] = $cRows;
			}
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => $this->_('ERROR_MSG_SUCCESS_SELECT'),
			'data' => $data
		);
	}

	/**
	 * 递归模式获取所有数据
	 * @return array
	 */
	public function findRecur()
	{
		$amcas = array();

		$ret = $this->findAllByPid(0);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $amcas;
		}

		$apps = $ret['data'];
		foreach ($apps as $app) {
			$ret = $this->findAllByPid($app['amca_id']);
			$app['rows'] = $mods = array();
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$mods = $ret['data'];
			}

			foreach ($mods as $mod) {
				$ret = $this->findAllByPid($app['amca_id']);
				$mod['rows'] = $ctrls = array();
				if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
					$ctrls = $ret['data'];
				}

				foreach ($ctrls as $ctrl) {
					$ret = $this->findAllByPid($app['amca_id']);
					$ctrl['rows'] = $acts = array();
					if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
						$acts = $ret['data'];
					}

					foreach ($acts as $act) {
						$ctrl['rows'][$act['amca_name']] = $act;
					}

					$mod['rows'][$ctrl['amca_name']] = $ctrl;
				}

				$app['rows'][$mod['amca_name']] = $mod;
			}

			$amcas[$app['amca_name']] = $app;
		}

		return $amcas;
	}

	/**
	 * 通过父ID和事件名统计记录数
	 * @param integer $amcaPid
	 * @param string $amcaName
	 * @return integer
	 */
	public function countByPidAndName($amcaPid, $amcaName)
	{
		$ret = $this->countByAttributes(array(
			'amca_pid' => (int) $amcaPid,
			'amca_name' => $amcaName
		));

		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			return $ret['total'];
		}

		return false;
	}

	/**
	 * 通过ID，获取事件名
	 * @param integer $value
	 * @return string
	 */
	public function getAmcaNameById($value)
	{
		return $this->getColById('amca_name', $value);
	}

	/**
	 * 通过ID，获取类型
	 * @param integer $value
	 * @return string
	 */
	public function getCategoryById($value)
	{
		return $this->getColById('category', $value);
	}

	/**
	 * 验证是否是应用类型
	 * @param integer $value
	 * @return boolean
	 */
	public function isApp($value)
	{
		$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
		return ($value === $data::CATEGORY_APP);
	}

	/**
	 * 验证是否是模块类型
	 * @param integer $value
	 * @return boolean
	 */
	public function isMod($value)
	{
		$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
		return ($value === $data::CATEGORY_MOD);
	}

	/**
	 * 验证是否是控制器类型
	 * @param integer $value
	 * @return boolean
	 */
	public function isCtrl($value)
	{
		$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
		return ($value === $data::CATEGORY_CTRL);
	}

	/**
	 * 验证是否是行动类型
	 * @param integer $value
	 * @return boolean
	 */
	public function isAct($value)
	{
		$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
		return ($value === $data::CATEGORY_ACT);
	}

	/**
	 * 新增一条记录，只能新增模块类型
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		if (!isset($params['category'])) {
			$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
			$params['category'] = $data::CATEGORY_MOD;
		}

		return $this->autoInsert($params);
	}

	/**
	 * 通过主键，编辑一条记录，只能编辑模块类型
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		UserAmcasAmcaNameUnique::$id = $value;

		if (!isset($params['category'])) {
			$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
			$params['category'] = $data::CATEGORY_MOD;
		}

		return $this->autoUpdateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::validate()
	 */
	public function validate(array $attributes = array(), $required = false, $opType = '')
	{
		UserAmcasAmcaNameUnique::$object = $this;
		UserAmcasAmcaNameUnique::$opType = $opType;
		UserAmcasAmcaNameUnique::$pid    = isset($attributes['amca_pid']) ? $attributes['amca_pid'] : -1;

		$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
		$rules = $data->getRules(array(
			'amca_pid',
			'amca_name',
			'prompt',
			'sort',
			'category',
		));

		return $this->filterRun($rules, $attributes, $required);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::_cleanPreValidator()
	 */
	protected function _cleanPreValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
			'amca_pid' => 'intval',
			'amca_name' => 'trim',
			'amca_pname' => 'trim',
			'prompt' => 'trim',
			// 'sort' => 'intval',
			'category' => 'trim',
		);

		return $this->_clean($rules, $attributes);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::_cleanPostValidator()
	 */
	protected function _cleanPostValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
		);

		return $this->_clean($rules, $attributes);
	}

}
