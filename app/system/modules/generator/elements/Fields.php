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

use tfc\saf\Text;
use ui\ElementCollections;
use library\GeneratorFactory;

/**
 * Fields class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Fields.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.elements
 * @since 1.0
 */
class Fields extends ElementCollections
{
	/**
	 * @var string 是否自动递增：是
	 */
	const COLUMN_AUTO_INCREMENT_Y = 'y';

	/**
	 * @var string 是否自动递增：否
	 */
	const COLUMN_AUTO_INCREMENT_N = 'n';

	/**
	 * @var string 是否无符号：是
	 */
	const COLUMN_UNSIGNED_Y = 'y';

	/**
	 * @var string 是否无符号：否
	 */
	const COLUMN_UNSIGNED_N = 'n';

	/**
	 * @var string 表单是否必填：是
	 */
	const FORM_REQUIRED_Y = 'y';

	/**
	 * @var string 表单是否必填：否
	 */
	const FORM_REQUIRED_N = 'n';

	/**
	 * @var string 编辑表单中是否允许输入：是
	 */
	const FORM_MODIFIABLE_Y = 'y';

	/**
	 * @var string 编辑表单中是否允许输入：否
	 */
	const FORM_MODIFIABLE_N = 'n';

	/**
	 * @var string 是否在列表中展示：是
	 */
	const INDEX_SHOW_Y = 'y';

	/**
	 * @var string 是否在列表中展示：否
	 */
	const INDEX_SHOW_N = 'n';

	/**
	 * @var string 是否在新增表单中展示：是
	 */
	const FORM_CREATE_SHOW_Y = 'y';

	/**
	 * @var string 是否在新增表单中展示：否
	 */
	const FORM_CREATE_SHOW_N = 'n';

	/**
	 * @var string 是否在编辑表单中展示：是
	 */
	const FORM_MODIFY_SHOW_Y = 'y';

	/**
	 * @var string 是否在编辑表单中展示：否
	 */
	const FORM_MODIFY_SHOW_N = 'n';

	/**
	 * @var string 是否在查询表单中展示：是
	 */
	const FORM_SEARCH_SHOW_Y = 'y';

	/**
	 * @var string 是否在查询表单中展示：否
	 */
	const FORM_SEARCH_SHOW_N = 'n';

	/**
	 * @var ui\bootstrap object 页面小组件类
	 */
	public $uiComponents = null;

	/**
	 * 构造方法：初始化页面小组件类
	 */
	public function __construct()
	{
		$this->uiComponents = GeneratorFactory::getUi('Fields');
	}

	/**
	 * (non-PHPdoc)
	 * @see ui.ElementCollections::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
			'view' => array(
				'tid' => 'view',
				'prompt' => Text::_('MOD_GENERATOR_FIELDS_VIEWTAB_VIEW_PROMPT')
			),
		);

		return $output;
	}

	/**
	 * 获取“字段ID”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFieldId($type)
	{
		$output = array();

		$name = 'field_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => 'ID'
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

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FIELD_NAME_LABEL'),
				'callback' => array($this->uiComponents, 'getFieldNameUrl')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_FIELDS_FIELD_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_FIELDS_FIELD_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'AlphaNum' => array(true, Text::_('MOD_GENERATOR_FIELDS_FIELD_NAME_ALPHANUM')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_FIELDS_FIELD_NAME_MINLENGTH')),
				'MaxLength' => array(50, Text::_('MOD_GENERATOR_FIELDS_FIELD_NAME_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“DB字段长度”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getColumnLength($type)
	{
		$output = array();

		$name = 'column_length';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_COLUMN_LENGTH_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_FIELDS_COLUMN_LENGTH_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_FIELDS_COLUMN_LENGTH_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				
			);
		}

		return $output;
	}

	/**
	 * 获取“是否自动递增”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getColumnAutoIncrement($type)
	{
		$output = array();

		$columnAutoIncrements = array(
			self::COLUMN_AUTO_INCREMENT_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::COLUMN_AUTO_INCREMENT_N => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);

		$name = 'column_auto_increment';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_COLUMN_AUTO_INCREMENT_LABEL'),
				'callback' => array($this->uiComponents, 'getColumnAutoIncrementLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'switch',
				'value' => self::COLUMN_AUTO_INCREMENT_N,
				'options' => $columnAutoIncrements,
				'label' => Text::_('MOD_GENERATOR_FIELDS_COLUMN_AUTO_INCREMENT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($columnAutoIncrements),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_COLUMN_AUTO_INCREMENT_INARRAY'), implode(', ', $columnAutoIncrements))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $columnAutoIncrements;
		}

		return $output;
	}

	/**
	 * 获取“是否无符号”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getColumnUnsigned($type)
	{
		$output = array();
	
		$columnUnsigneds = array(
			self::COLUMN_UNSIGNED_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::COLUMN_UNSIGNED_N => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);

		$name = 'column_unsigned';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_COLUMN_UNSIGNED_LABEL'),
				'callback' => array($this->uiComponents, 'getColumnUnsignedLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'switch',
				'value' => self::COLUMN_UNSIGNED_N,
				'options' => $columnUnsigneds,
				'label' => Text::_('MOD_GENERATOR_FIELDS_COLUMN_UNSIGNED_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($columnUnsigneds),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_COLUMN_UNSIGNED_INARRAY'), implode(', ', $columnUnsigneds))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $columnUnsigneds;
		}

		return $output;
	}

	/**
	 * 获取“DB字段描述”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getColumnComment($type)
	{
		$output = array();

		$name = 'column_comment';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_COLUMN_COMMENT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_FIELDS_COLUMN_COMMENT_LABEL'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'NotEmpty' => array(true, Text::_('MOD_GENERATOR_FIELDS_COLUMN_COMMENT_NOTEMPTY'))
			);
		}

		return $output;
	}

	/**
	 * 获取“生成代码ID”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getGeneratorId($type)
	{
		$output = array();

		$name = 'generator_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_GENERATOR_ID_LABEL'),
				'callback' => array($this->uiComponents, 'getGeneratorNameByGeneratorId')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$generatorId = GeneratorFactory::getModel('Fields')->getGeneratorId();
			$output = array(
				'type' => 'hidden',
				'label' => Text::_('MOD_GENERATOR_FIELDS_GENERATOR_ID_LABEL'),
				'value' => $generatorId
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Integer' => array(true, Text::_('MOD_GENERATOR_FIELDS_GENERATOR_ID_INTEGER'))
			);
		}

		return $output;
	}

	/**
	 * 获取“生成代码名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getGeneratorName($type)
	{
		$output = array();

		$name = 'generator_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_GENERATOR_NAME_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$generatorId = GeneratorFactory::getModel('Fields')->getGeneratorId();
			$generatorName = GeneratorFactory::getModel('Generators')->getGeneratorNameByGeneratorId($generatorId);
			$output = array(
				'type' => 'string',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_GENERATOR_NAME_LABEL'),
				'value' => $generatorName
			);
		}

		return $output;
	}

	/**
	 * 获取“表单字段组ID”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getGroupId($type)
	{
		$output = array();

		$generatorId = GeneratorFactory::getModel('Fields')->getGeneratorId();
		$groups = GeneratorFactory::getModel('groups')->getGroupsByGeneratorId($generatorId, true);

		$name = 'group_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_GROUP_ID_LABEL'),
				'callback' => array($this->uiComponents, 'getGroupNameByGroupId')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'select',
				'label' => Text::_('MOD_GENERATOR_FIELDS_GROUP_ID_LABEL'),
				'options' => $groups
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($groups),
					Text::_('MOD_GENERATOR_FIELDS_GROUP_ID_INARRAY')
				)
			);
		}

		return $output;
	}

	/**
	 * 获取“字段类型ID”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTypeId($type)
	{
		$output = array();

		$types = GeneratorFactory::getModel('types')->getTypes();

		$name = 'type_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_TYPE_ID_LABEL'),
				'callback' => array($this->uiComponents, 'getTypeNameByTypeId')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'select',
				'label' => Text::_('MOD_GENERATOR_FIELDS_TYPE_ID_LABEL'),
				'options' => $types,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($types),
					Text::_('MOD_GENERATOR_FIELDS_TYPE_ID_INARRAY')
				)
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
				'label' => Text::_('MOD_GENERATOR_FIELDS_SORT_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_FIELDS_SORT_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_FIELDS_SORT_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_GENERATOR_FIELDS_SORT_NUMERIC'))
			);
		}

		return $output;
	}

	/**
	 * 获取“HTML：Table和Form显示名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getHtmlLabel($type)
	{
		$output = array();

		$name = 'html_label';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_HTML_LABEL_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_FIELDS_HTML_LABEL_LABEL'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'NotEmpty' => array(true, Text::_('MOD_GENERATOR_FIELDS_HTML_LABEL_NOTEMPTY'))
			);
		}

		return $output;
	}

	/**
	 * 获取“表单提示”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFormPrompt($type)
	{
		$output = array();

		$name = 'form_prompt';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_PROMPT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_PROMPT_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“表单是否必填”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFormRequired($type)
	{
		$output = array();

		$formRequireds = array(
			self::FORM_REQUIRED_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_REQUIRED_N => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);

		$name = 'form_required';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_REQUIRED_LABEL'),
				'callback' => array($this->uiComponents, 'getFormRequiredLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'value' => self::FORM_REQUIRED_N,
				'options' => $formRequireds,
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_REQUIRED_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($formRequireds),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_FORM_REQUIRED_INARRAY'), implode(', ', $formRequireds))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $formRequireds;
		}

		return $output;
	}

	/**
	 * 获取“编辑表单中是否允许输入”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFormModifiable($type)
	{
		$output = array();

		$formModifiables = array(
			self::FORM_MODIFIABLE_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_MODIFIABLE_N => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);

		$name = 'form_modifiable';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_MODIFIABLE_LABEL'),
				'callback' => array($this->uiComponents, 'getFormModifiableLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'value' => self::FORM_MODIFIABLE_N,
				'options' => $formModifiables,
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_MODIFIABLE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($formModifiables),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_FORM_MODIFIABLE_INARRAY'), implode(', ', $formModifiables))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $formModifiables;
		}

		return $output;
	}

	/**
	 * 获取“是否在列表中展示”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getIndexShow($type)
	{
		$output = array();

		$indexShows = array(
			self::INDEX_SHOW_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::INDEX_SHOW_N => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);

		$name = 'index_show';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_INDEX_SHOW_LABEL'),
				'callback' => array($this->uiComponents, 'getIndexShowLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'value' => self::INDEX_SHOW_N,
				'options' => $indexShows,
				'label' => Text::_('MOD_GENERATOR_FIELDS_INDEX_SHOW_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($indexShows),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_INDEX_SHOW_INARRAY'), implode(', ', $indexShows))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $indexShows;
		}

		return $output;
	}

	/**
	 * 获取“在列表中排序”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getIndexSort($type)
	{
		$output = array();

		$name = 'index_sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_INDEX_SORT_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'value' => 0,
				'label' => Text::_('MOD_GENERATOR_FIELDS_INDEX_SORT_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_FIELDS_INDEX_SORT_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_GENERATOR_FIELDS_INDEX_SORT_NUMERIC'))
			);
		}

		return $output;
	}

	/**
	 * 获取“是否在新增表单中展示”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFormCreateShow($type)
	{
		$output = array();

		$formCreateShows = array(
			self::FORM_CREATE_SHOW_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_CREATE_SHOW_N => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);

		$name = 'form_create_show';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_CREATE_SHOW_LABEL'),
				'callback' => array($this->uiComponents, 'getFormCreateShowLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'value' => self::FORM_CREATE_SHOW_N,
				'options' => $formCreateShows,
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_CREATE_SHOW_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($formCreateShows),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_FORM_CREATE_SHOW_INARRAY'), implode(', ', $formCreateShows))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $formCreateShows;
		}

		return $output;
	}

	/**
	 * 获取“在新增表单中排序”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFormCreateSort($type)
	{
		$output = array();

		$name = 'form_create_sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_CREATE_SORT_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'value' => 0,
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_CREATE_SORT_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_FIELDS_FORM_CREATE_SORT_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_GENERATOR_FIELDS_FORM_CREATE_SORT_NUMERIC'))
			);
		}

		return $output;
	}

	/**
	 * 获取“是否在编辑表单中展示”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFormModifyShow($type)
	{
		$output = array();

		$formModifyShows = array(
			self::FORM_MODIFY_SHOW_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_MODIFY_SHOW_N => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);

		$name = 'form_modify_show';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_MODIFY_SHOW_LABEL'),
				'callback' => array($this->uiComponents, 'getFormModifyShowLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'value' => self::FORM_MODIFY_SHOW_N,
				'options' => $formModifyShows,
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_MODIFY_SHOW_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($formModifyShows),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_FORM_MODIFY_SHOW_INARRAY'), implode(', ', $formModifyShows))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $formModifyShows;
		}

		return $output;
	}

	/**
	 * 获取“在编辑表单中排序”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFormModifySort($type)
	{
		$output = array();

		$name = 'form_modify_sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_MODIFY_SORT_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'value' => 0,
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_MODIFY_SORT_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_FIELDS_FORM_MODIFY_SORT_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_GENERATOR_FIELDS_FORM_MODIFY_SORT_NUMERIC'))
			);
		}

		return $output;
	}

	/**
	 * 获取“是否在查询表单中展示”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFormSearchShow($type)
	{
		$output = array();

		$formSearchShows = array(
			self::FORM_SEARCH_SHOW_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_SEARCH_SHOW_N => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);

		$name = 'form_search_show';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_SEARCH_SHOW_LABEL'),
				'callback' => array($this->uiComponents, 'getFormSearchShowLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'value' => self::FORM_SEARCH_SHOW_N,
				'options' => $formSearchShows,
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_SEARCH_SHOW_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($formSearchShows),
					sprintf(Text::_('MOD_GENERATOR_FIELDS_FORM_SEARCH_SHOW_INARRAY'), implode(', ', $formSearchShows))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $formSearchShows;
		}

		return $output;
	}

	/**
	 * 获取“在查询表单中排序”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getFormSearchSort($type)
	{
		$output = array();

		$name = 'form_search_sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_SEARCH_SORT_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'value' => 0,
				'label' => Text::_('MOD_GENERATOR_FIELDS_FORM_SEARCH_SORT_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_FIELDS_FORM_SEARCH_SORT_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_GENERATOR_FIELDS_FORM_SEARCH_SORT_NUMERIC'))
			);
		}

		return $output;
	}
}
