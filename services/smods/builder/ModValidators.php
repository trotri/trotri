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
 * ModValidators class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModValidators.php 1 2014-04-05 22:11:11Z Code Generator $
 * @package smods.builder
 * @since 1.0
 */
class ModValidators extends BaseModel
{
	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param tfc\util\Language $language
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct(Language $language, $tableNum = -1)
	{
		$db = new DbValidators($tableNum);
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
		$fieldId = isset($params['field_id']) ? (int) $params['field_id'] : 0;
		$params = array();
		if ($fieldId > 0) {
			$params['field_id'] = $fieldId;
		}

		return $this->findAllByAttributes($params, $order, $limit, $offset);
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
			'validator_name',
			'field_id',
			'option_category',
			'sort',
			'when',
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
			'validator_name' => 'trim',
			'field_id' => 'intval',
			'options' => 'trim',
			'option_category' => 'trim',
			'message' => 'trim',
			'sort' => 'intval',
			'when' => 'trim',
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
