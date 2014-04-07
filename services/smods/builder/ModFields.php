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
 * ModFields class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModFields.php 1 2014-04-05 00:37:20Z Code Generator $
 * @package smods.builder
 * @since 1.0
 */
class ModFields extends BaseModel
{
	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param tfc\util\Language $language
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct(Language $language, $tableNum = -1)
	{
		$db = new DbFields($tableNum);
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
		if ($builderId > 0) {
			$params['builder_id'] = $builderId;
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
			'field_name',
			'column_auto_increment',
			'column_unsigned',
			'column_comment',
			'builder_id',
			'type_id',
			'sort',
			'html_label',
			'form_required',
			'form_modifiable',
			'index_show',
			'index_sort',
			'form_create_show',
			'form_create_sort',
			'form_modify_show',
			'form_modify_sort',
			'form_search_show',
			'form_search_sort',
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
			'field_name' => 'trim',
			'column_length' => 'trim',
			'column_auto_increment' => 'trim',
			'column_unsigned' => 'trim',
			'column_comment' => 'trim',
			'builder_id' => 'intval',
			'group_id' => 'intval',
			'type_id' => 'intval',
			// 'sort' => 'intval',
			'html_label' => 'trim',
			'form_prompt' => 'trim',
			'form_required' => 'trim',
			'form_modifiable' => 'trim',
			'index_show' => 'trim',
			'index_sort' => 'intval',
			'form_create_show' => 'trim',
			'form_create_sort' => 'intval',
			'form_modify_show' => 'trim',
			'form_modify_sort' => 'intval',
			'form_search_show' => 'trim',
			'form_search_sort' => 'intval',
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
