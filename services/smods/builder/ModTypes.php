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
 * ModTypes class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModTypes.php 1 2014-04-04 13:49:20Z Code Generator $
 * @package smods.builder
 * @since 1.0
 */
class ModTypes extends BaseModel
{
	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param tfc\util\Language $language
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct(Language $language, $tableNum = -1)
	{
		$db = new DbTypes($tableNum);
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
		return $this->findAllByAttributes(array(), $order, $limit, $offset);
	}

	/**
	 * 获取所有的Types值
	 * @return array
	 */
	public function getTypes()
	{
		$ret = $this->findPairsByAttributes(array('type_id', 'type_name'), array(), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return array();
		}

		return $ret['data'];
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
			'type_name',
			'form_type',
			'field_type',
			'category',
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
			'type_name' => 'trim',
			'form_type' => 'trim',
			'field_type' => 'trim',
			'category' => 'trim',
			'sort' => 'intval',
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
