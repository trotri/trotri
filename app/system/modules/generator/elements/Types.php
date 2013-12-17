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
 * Types class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Types.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.elements
 * @since 1.0
 */
class Types extends ElementCollections
{
	/**
	 * @var string 所属分类：文本类
	 */
	const CATEGORY_TEXT = 'text';

	/**
	 * @var string 所属分类：选项类
	 */
	const CATEGORY_OPTION = 'option';

	/**
	 * @var string 所属分类：button
	 */
	const CATEGORY_BUTTON = 'button';

	/**
	 * @var ui\bootstrap object 页面小组件类
	 */
	public $uiComponents = null;

	/**
	 * 构造方法：初始化页面小组件类
	 */
	public function __construct()
	{
		$this->uiComponents = GeneratorFactory::getUi('Types');
	}

	/**
	 * 获取“字段类型ID”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTypeId($type)
	{
		$output = array();

		$name = 'type_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => 'ID'
			);
		}

		return $output;
	}

	/**
	 * 获取“类型名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTypeName($type)
	{
		$output = array();

		$name = 'type_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_TYPES_TYPE_NAME_LABEL'),
				'callback' => array($this->uiComponents, 'getTypeNameUrl')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_TYPES_TYPE_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_TYPES_TYPE_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'MinLength' => array(2, Text::_('MOD_GENERATOR_TYPES_TYPE_NAME_MINLENGTH')),
				'MaxLength' => array(50, Text::_('MOD_GENERATOR_TYPES_TYPE_NAME_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“表单类型名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFormType($type)
	{
		$output = array();

		$name = 'form_type';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_TYPES_FORM_TYPE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_TYPES_FORM_TYPE_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_TYPES_FORM_TYPE_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'AlphaNum' => array(true, Text::_('MOD_GENERATOR_TYPES_FORM_TYPE_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_TYPES_FORM_TYPE_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_TYPES_FORM_TYPE_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“表单类型名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFieldType($type)
	{
		$output = array();

		$name = 'field_type';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_TYPES_FIELD_TYPE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_TYPES_FIELD_TYPE_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_TYPES_FIELD_TYPE_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'AlphaNum' => array(true, Text::_('MOD_GENERATOR_TYPES_FIELD_TYPE_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_TYPES_FIELD_TYPE_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_TYPES_FIELD_TYPE_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“所属分类”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getCategory($type)
	{
		$output = array();

		$categories = array(
			self::CATEGORY_TEXT => Text::_('MOD_GENERATOR_TYPES_CATEGORY_TEXT'),
			self::CATEGORY_BUTTON => Text::_('MOD_GENERATOR_TYPES_CATEGORY_BUTTON'),
			self::CATEGORY_OPTION => Text::_('MOD_GENERATOR_TYPES_CATEGORY_OPTION')
		);

		$name = 'category';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_TYPES_CATEGORY_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'radio',
				'value' => self::CATEGORY_TEXT,
				'options' => $categories,
				'label' => Text::_('MOD_GENERATOR_TYPES_CATEGORY_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($categories),
					sprintf(Text::_('MOD_GENERATOR_TYPES_CATEGORY_INARRAY'), implode(', ', $categories))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $categories;
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
				'label' => Text::_('MOD_GENERATOR_TYPES_SORT_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_TYPES_SORT_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_TYPES_SORT_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_GENERATOR_TYPES_SORT_NUMERIC'))
			);
		}

		return $output;
	}
}
