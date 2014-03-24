<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\builder;

use tfc\util\Language;
use slib\BaseModel;
use slib\Data;
use slib\ErrorNo;
use slib\Service;

/**
 * ModGroups class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModGroups.php 1 2014-01-19 13:18:49Z huan.song $
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
	public function search(array $params = array(), $order = '', $limit = 0, $offset = 0)
	{
		$builderId = isset($params['builder_id']) ? (int) $params['builder_id'] : 0;
		$params = array();
		if ($builderId > 0) {
			$params['builder_id'] = $builderId;
		}

		$ret = $this->findAllByAttributes($params, $order, $limit, $offset);
		return $ret;
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
	 * 通过group_id获取group_name值
	 * @param integer $value
	 * @return string
	 */
	public function getGroupNameByGroupId($value)
	{
		$value = (int) $value;
		$ret = $this->getByPk('group_name', $value);
		$groupName = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['group_name'];
		return $groupName;
	}

	/**
	 * 通过group_id获取builder_id值
	 * @param integer $value
	 * @return string
	 */
	public function getBuilderIdByGroupId($value)
	{
		$value = (int) $value;
		$ret = $this->getByPk('builder_id', $value);
		$builderId = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['builder_id'];
		return $builderId;
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
		$data = Data::getInstance('groups', 'builder', $this->getLanguage());
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
			'sort' => 'intval',
		);

		$ret = $this->_clean($rules, $attributes);
		return $ret;
	}
}
