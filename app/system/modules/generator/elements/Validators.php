<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\elements;

use tfc\ap\Ap;
use tfc\saf\Text;
use ui\ElementCollections;
use library\GeneratorFactory;

/**
 * Validators class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Validators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.elements
 * @since 1.0
 */
class Validators extends ElementCollections
{
	/**
	 * @var string 验证时对比值类型：布尔型
	 */
	const OPTION_CATEGORY_BOOLEAN = 'boolean';

	/**
	 * @var string 验证时对比值类型：整型
	 */
	const OPTION_CATEGORY_INTEGER = 'integer';

	/**
	 * @var string 验证时对比值类型：字符串型
	 */
	const OPTION_CATEGORY_STRING = 'string';

	/**
	 * @var string 验证时对比值类型：数组型
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
	 * @var ui\bootstrap object 页面小组件类
	 */
	public $uiComponents = null;

	/**
	 * 构造方法：初始化页面小组件类
	 */
	public function __construct()
	{
		$this->uiComponents = GeneratorFactory::getUi('Validators');
	}

	/**
	 * 获取“字段验证ID”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getValidatorId($type)
	{
		$output = array();

		$name = 'validator_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => 'ID'
			);
		}

		return $output;
	}

	/**
	 * 获取“验证类名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getValidatorName($type)
	{
		$output = array();

		$validators = array(
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

		$name = 'validator_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_VALIDATOR_NAME_LABEL'),
				'callback' => array($this->uiComponents, 'getValidatorNameUrl')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'select',
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_VALIDATOR_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_VALIDATOR_NAME_HINT'),
				'options' => $validators,
				'value' => 'Integer',
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($validators),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_VALIDATOR_NAME_INARRAY'), implode(', ', $validators))
				)
			);
		}

		return $output;
	}

	/**
	 * 获取“表单字段ID”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFieldId($type)
	{
		$output = array();

		$name = 'field_id';
		$fieldId = Ap::getRequest()->getInteger('field_id');

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FIELD_NAME_LABEL'),
				'callback' => array($this->uiComponents, 'getFieldNameByFieldId')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'hidden',
				'value' => $fieldId
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Integer' => array(true, Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_FIELD_ID_INTEGER'))
			);
		}

		return $output;
	}

	/**
	 * 获取“字段名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFieldName($type)
	{
		$output = array();

		$name = 'field_name';
		$fieldId = Ap::getRequest()->getInteger('field_id');

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FIELD_NAME_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$fieldName = GeneratorFactory::getModel('Fields')->getFieldNameByFieldId($fieldId);
			$output = array(
				'type' => 'string',
				'label' => Text::_('MOD_GENERATOR_FIELDS_FIELD_NAME_LABEL'),
				'value' => $fieldName
			);
		}

		return $output;
	}

	/**
	 * 获取“验证时对比值，可以是布尔类型、整型、字符型、数组序列化”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getOptions($type)
	{
		$output = array();

		$name = 'options';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_OPTIONS_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_OPTIONS_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“验证时对比值类型”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getOptionCategory($type)
	{
		$output = array();

		$optionCategories = array(
			self::OPTION_CATEGORY_STRING => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_OPTION_CATEGORY_STRING_LABEL'),
			self::OPTION_CATEGORY_INTEGER => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_OPTION_CATEGORY_INTEGER_LABEL'),
			self::OPTION_CATEGORY_ARRAY => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_OPTION_CATEGORY_ARRAY_LABEL'),
			self::OPTION_CATEGORY_BOOLEAN => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_OPTION_CATEGORY_BOOLEAN_LABEL'),
		);

		$name = 'option_category';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_OPTION_CATEGORY_LABEL'),
				'callback' => array($this->uiComponents, 'getOptionCategoryLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'radio',
				'value' => self::OPTION_CATEGORY_STRING,
				'options' => $optionCategories,
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_OPTION_CATEGORY_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($optionCategories),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_OPTION_CATEGORY_INARRAY'), implode(', ', $optionCategories))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $optionCategories;
		}

		return $output;
	}

	/**
	 * 获取“出错提示消息”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getMessage($type)
	{
		$output = array();

		$name = 'message';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_MESSAGE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_MESSAGE_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“排序”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getSort($type)
	{
		$output = array();

		$name = 'sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_SORT_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_SORT_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_SORT_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_SORT_NUMERIC'))
			);
		}

		return $output;
	}

	/**
	 * 获取“验证环境，任意时候验证、只在新增数据时验证、只在更新数据时验证”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getWhen($type)
	{
		$output = array();

		$whens = array(
			self::WHEN_ALL => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_WHEN_ALL_LABEL'),
			self::WHEN_CREATE => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_WHEN_CREATE_LABEL'),
			self::WHEN_MODIFY => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_WHEN_MODIFY_LABEL'),
		);

		$name = 'when';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_WHEN_LABEL'),
				'callback' => array($this->uiComponents, 'getWhenLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'radio',
				'value' => self::WHEN_ALL,
				'options' => $whens,
				'label' => Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_WHEN_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($whens),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_VALIDATORS_WHEN_INARRAY'), implode(', ', $whens))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $whens;
		}

		return $output;
	}
}
