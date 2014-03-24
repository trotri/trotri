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

/**
 * ModValidators class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModValidators.php 1 2014-01-20 15:58:15Z huan.song $
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

		$ret = $this->findAllByAttributes($params, $order, $limit, $offset);
		return $ret;
	}

	/**
	 * 通过validator_id获取field_id值
	 * @param integer $value
	 * @return string
	 */
	public function getFieldIdByValidatorId($value)
	{
		$value = (int) $value;
		$ret = $this->getByPk('field_id', $value);
		$fieldId = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? 0 : $ret['field_id'];
		return $fieldId;
	}

	/**
	 * 通过validator_id获取validator_name值
	 * @param integer $value
	 * @return string
	 */
	public function getValidatorNameByValidatorId($value)
	{
		$value = (int) $value;
		$ret = $this->getByPk('validator_name', $value);
		$validatorName = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['validator_name'];
		return $validatorName;
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
		$data = Data::getInstance('validators', 'builder', $this->getLanguage());
		$rules = $data->getRules(array(	
			'validator_name',
			'field_id',
			'option_category',
			'sort',
			'when'
		));

		return $this->filterRun($rules, $attributes, $required);
	}
}
