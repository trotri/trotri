<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\elements;

use tfc\saf\Text;
use ui\ElementCollections;
use library\BuilderFactory;

/**
 * Types class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Types.php 1 2014-01-07 18:07:20Z huan.song $
 * @package modules.builder.elements
 * @since 1.0
 */
class Types extends ElementCollections
{
	/**
	 * @var string category：text
	 */
	const CATEGORY_TEXT = 'text';

	/**
	 * @var string category：option
	 */
	const CATEGORY_OPTION = 'option';

	/**
	 * @var string category：button
	 */
	const CATEGORY_BUTTON = 'button';

	/**
	 * @var ui\bootstrap\Components 页面小组件类
	 */
	public $uiComponents = null;

	/**
	 * 构造方法：初始化页面小组件类
	 */
	public function __construct()
	{
		$this->uiComponents = BuilderFactory::getUi('Types');
	}

	/**
	 * (non-PHPdoc)
	 * @see ui.ElementCollections::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
		);

		return $output;
	}

	/**
	 * 获取“主键ID”配置
	 * @param integer $type
	 * @return array
	 */
	public function getTypeId($type)
	{
		$output = array();
		$name = 'type_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_ID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_ID_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“类型名，单行文本、多行文本、密码、开关选项卡、提交按钮等”配置
	 * @param integer $type
	 * @return array
	 */
	public function getTypeName($type)
	{
		$output = array();
		$name = 'type_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_LABEL'),
				'callback' => array($this->uiComponents, 'getTypeNameUrl')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_MINLENGTH')),
				'MaxLength' => array(50, Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“表单类型名，HTML：text、password、button、radio等；用户自定义：ckeditor、datetime等”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFormType($type)
	{
		$output = array();
		$name = 'form_type';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(false, Text::_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“表字段类型，INT、VARCHAR、CHAR、TEXT等”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFieldType($type)
	{
		$output = array();
		$name = 'field_type';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(false, Text::_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“所属分类，text：文本类、option：选项类、button：按钮类”配置
	 * @param integer $type
	 * @return array
	 */
	public function getCategory($type)
	{
		$output = array();
		$options = array(
			self::CATEGORY_TEXT => Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_TEXT'),
			self::CATEGORY_OPTION => Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_OPTION'),
			self::CATEGORY_BUTTON => Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_BUTTON'),
		);

		$name = 'category';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_HINT'),
				'options' => $options,
				'value' => self::CATEGORY_TEXT,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_INARRAY')),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“排序”配置
	 * @param integer $type
	 * @return array
	 */
	public function getSort($type)
	{
		$output = array();
		$name = 'sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_SORT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_SORT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(false, Text::_('MOD_BUILDER_BUILDER_TYPES_SORT_NUMERIC')),
			);
		}

		return $output;
	}

}
