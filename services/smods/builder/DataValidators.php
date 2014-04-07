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

use slib\BaseData;

/**
 * DataValidators class file
 * 业务层：数据管理类，寄存常量、选项、验证规则
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataValidators.php 1 2014-04-05 22:11:11Z Code Generator $
 * @package smods.builder
 * @since 1.0
 */
class DataValidators extends BaseData
{
	/**
	 * @var string 验证时对比值类型：boolean
	 */
	const OPTION_CATEGORY_BOOLEAN = 'boolean';

	/**
	 * @var string 验证时对比值类型：integer
	 */
	const OPTION_CATEGORY_INTEGER = 'integer';

	/**
	 * @var string 验证时对比值类型：string
	 */
	const OPTION_CATEGORY_STRING = 'string';

	/**
	 * @var string 验证时对比值类型：array
	 */
	const OPTION_CATEGORY_ARRAY = 'array';

	/**
	 * @var string 验证环境：all
	 */
	const WHEN_ALL = 'all';

	/**
	 * @var string 验证环境：create
	 */
	const WHEN_CREATE = 'create';

	/**
	 * @var string 验证环境：modify
	 */
	const WHEN_MODIFY = 'modify';

	/**
	 * 获取“验证时对比值类型”所有选项
	 * @return array
	 */
	public function getOptionCategoryEnum()
	{
		return array(
			self::OPTION_CATEGORY_BOOLEAN => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_OPTION_CATEGORY_BOOLEAN'),
			self::OPTION_CATEGORY_INTEGER => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_OPTION_CATEGORY_INTEGER'),
			self::OPTION_CATEGORY_STRING => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_OPTION_CATEGORY_STRING'),
			self::OPTION_CATEGORY_ARRAY => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_OPTION_CATEGORY_ARRAY'),
		);
	}

	/**
	 * 获取“验证环境”所有选项
	 * @return array
	 */
	public function getWhenEnum()
	{
		return array(
			self::WHEN_ALL => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_WHEN_ALL'),
			self::WHEN_CREATE => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_WHEN_CREATE'),
			self::WHEN_MODIFY => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_WHEN_MODIFY'),
		);
	}

	/**
	 * 获取“验证类名”所有选项
	 * @return array
	 */
	public function getValidatorNameEnum()
	{
		return array(
			'AlphaNum' => 'AlphaNum',
			'Alpha' => 'Alpha',
			'EqualTo' => 'EqualTo',
			'Equal' => 'Equal',
			'Float' => 'Float',
			'InArray' => 'InArray',
			'Integer' => 'Integer',
			'Ip' => 'Ip',
			'Mail' => 'Mail',
			'MaxLength' => 'MaxLength',
			'Max' => 'Max',
			'MinLength' => 'MinLength',
			'Min' => 'Min',
			'NotEmpty' => 'NotEmpty',
			'Numeric' => 'Numeric',
			'Require' => 'Require',
			'Url' => 'Url',
		);
	}

	/**
	 * 获取“出错提示消息”所有选项
	 * @return array
	 */
	public function getMessageEnum()
	{
		return array(
			'AlphaNum' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_ALPHANUM'),
			),
			'Alpha' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_ALPHA'),
			),
			'EqualTo' => array(
				'option_category' => 'string',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_EQUALTO'),
			),
			'Equal' => array(
				'option_category' => 'string',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_EQUAL'),
			),
			'Float' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_FLOAT'),
			),
			'InArray' => array(
				'option_category' => 'array',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_INARRAY'),
			),
			'Integer' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_INTEGER'),
			),
			'Ip' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_IP'),
			),
			'Mail' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_MAIL'),
			),
			'MaxLength' => array(
				'option_category' => 'integer',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_MAXLENGTH'),
			),
			'Max' => array(
				'option_category' => 'integer',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_MAX'),
			),
			'MinLength' => array(
				'option_category' => 'integer',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_MINLENGTH'),
			),
			'Min' => array(
				'option_category' => 'integer',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_MIN'),
			),
			'NotEmpty' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_NOTEMPTY'),
			),
			'Numeric' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_NUMERIC'),
			),
			'Require' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_REQUIRE'),
			),
			'Url' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_ENUM_MESSAGE_URL'),
			)
		);
	}

	/**
	 * 获取“验证类名”验证规则
	 * @return array
	 */
	public function getValidatorNameRule()
	{
		$enum = $this->getValidatorNameEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_VALIDATOR_NAME_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“表单字段ID”验证规则
	 * @return array
	 */
	public function getFieldIdRule()
	{
		return array(
			'Integer' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_FIELD_ID_INTEGER')),
		);
	}

	/**
	 * 获取“验证时对比值类型”验证规则
	 * @return array
	 */
	public function getOptionCategoryRule()
	{
		$enum = $this->getOptionCategoryEnum();
		return array(
			'InArray' => array(
				array_keys($enum), 
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_OPTION_CATEGORY_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“排序”验证规则
	 * @return array
	 */
	public function getSortRule()
	{
		return array(
			'Numeric' => array(true, $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_SORT_NUMERIC')),
		);
	}

	/**
	 * 获取“验证环境”验证规则
	 * @return array
	 */
	public function getWhenRule()
	{
		$enum = $this->getWhenEnum();
		return array(
			'InArray' => array(
				array_keys($enum), 
				sprintf($this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_WHEN_INARRAY'), implode(', ', $enum))
			),
		);
	}

}
