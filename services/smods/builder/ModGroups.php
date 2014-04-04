<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\builder;

use tfc\util\Language;
use slib\BaseModel;
use slib\Data;
use slib\ErrorNo;

/**
 * ModGroups class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModGroups.php 1 2014-04-04 14:53:06Z Code Generator $
 * @package smods.builder
 * @since 1.0
 */
class ModGroups extends BaseModel
{
	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param tfc\util\Language $language
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct(Language $language, $tableNum = -1)
	{
		$db = new DbGroups($tableNum);
		parent::__construct($db, $language);
	}

	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(array $params = array(), $order = 'sort', $limit = 0, $offset = 0)
	{
		$builderId = isset($params['builder_id']) ? (int) $params['builder_id'] : 0;
		$params = array();
		if ($builderId >= 0) {
			$params['builder_id'] = $builderId;
		}

		return $this->findAllByAttributes($params, $order, $limit, $offset);
	}

	/**
	 * 通过builder_id获取所有的Groups
	 * @param integer $value
	 * @param boolean $joinDafault
	 * @return array
	 */
	public function getGroupsByBuilderId($value, $joinDafault = false)
	{
		$default = array();
		$groups = array();

		if ($joinDafault) {
			$ret = $this->findPairsByAttributes(array('group_id', 'prompt'), array('builder_id' => 0), 'sort');
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$default = $ret['data'];
			}
		}

		$ret = $this->findPairsByAttributes(array('group_id', 'prompt'), array('builder_id' => (int) $value), 'sort');
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$groups = $ret['data'];
		}

		$ret = $default + $groups;
		return $ret;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		return $this->autoInsert($params);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		return $this->autoUpdateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::validate()
	 */
	public function validate(array $attributes = array(), $required = false, $opType = '')
	{
		$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
		$rules = $data->getRules(array(
			'group_name',
			'prompt',
			'builder_id',
			'sort',
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
			'group_name' => 'trim',
			'prompt' => 'trim',
			'builder_id' => 'intval',
			// 'sort' => 'intval',
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
