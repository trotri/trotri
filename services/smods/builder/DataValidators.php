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

use slib\BaseData;

/**
 * DataValidators class file
 * 业务层：数据管理类，寄存常量、选项、验证规则
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataValidators.php 1 2014-01-18 14:19:29Z huan.song $
 * @package smods.builder
 * @since 1.0
 */
class DataValidators extends BaseData
{
	/**
	 * @var string 验证时对比值类型：布尔类型
	 */
	const OPTION_CATEGORY_BOOLEAN = 'boolean';

	/**
	 * @var string 验证时对比值类型：整型
	 */
	const OPTION_CATEGORY_INTEGER = 'integer';

	/**
	 * @var string 验证时对比值类型：字符型
	 */
	const OPTION_CATEGORY_STRING = 'string';

	/**
	 * @var string 验证时对比值类型：数组序列化
	 */
	const OPTION_CATEGORY_ARRAY = 'array';

	/**
	 * @var string 验证环境：任意时候验证
	 */
	const WHEN_ALL = 'all';

	/**
	 * @var string 验证环境：只在新增数据时验证
	 */
	const WHEN_CREATE = 'create';

	/**
	 * @var string 验证环境：只在编辑数据时验证
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
	 * 获取“验证环境，任意时候验证、只在新增数据时验证、只在编辑数据时验证”所有选项
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
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_ALPHANUM_LABEL'),
			),
			'Alpha' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_ALPHA_LABEL'),
			),
			'EqualTo' => array(
				'option_category' => 'string',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_EQUALTO_LABEL'),
			),
			'Equal' => array(
				'option_category' => 'string',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_EQUAL_LABEL'),
			),
			'Float' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_FLOAT_LABEL'),
			),
			'InArray' => array(
				'option_category' => 'array',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_INARRAY_LABEL'),
			),
			'Integer' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_INTEGER_LABEL'),
			),
			'Ip' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_IP_LABEL'),
			),
			'Mail' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_MAIL_LABEL'),
			),
			'MaxLength' => array(
				'option_category' => 'integer',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_MAXLENGTH_LABEL'),
			),
			'Max' => array(
				'option_category' => 'integer',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_MAX_LABEL'),
			),
			'MinLength' => array(
				'option_category' => 'integer',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_MINLENGTH_LABEL'),
			),
			'Min' => array(
				'option_category' => 'integer',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_MIN_LABEL'),
			),
			'NotEmpty' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_NOTEMPTY_LABEL'),
			),
			'Numeric' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_NUMERIC_LABEL'),
			),
			'Require' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_REQUIRE_LABEL'),
			),
			'Url' => array(
				'option_category' => 'boolean',
				'message' => $this->_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_URL_LABEL'),
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
	 * 获取“验证环境，任意时候验证、只在新增数据时验证、只在编辑数据时验证”验证规则
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
