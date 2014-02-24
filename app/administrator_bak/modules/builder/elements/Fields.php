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
 * Fields class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Fields.php 1 2014-01-19 17:52:00Z huan.song $
 * @package modules.builder.elements
 * @since 1.0
 */
class Fields extends ElementCollections
{
	/**
	 * @var string column_auto_increment：y
	 */
	const COLUMN_AUTO_INCREMENT_Y = 'y';

	/**
	 * @var string column_auto_increment：n
	 */
	const COLUMN_AUTO_INCREMENT_N = 'n';

	/**
	 * @var string column_unsigned：y
	 */
	const COLUMN_UNSIGNED_Y = 'y';

	/**
	 * @var string column_unsigned：n
	 */
	const COLUMN_UNSIGNED_N = 'n';

	/**
	 * @var string form_required：y
	 */
	const FORM_REQUIRED_Y = 'y';

	/**
	 * @var string form_required：n
	 */
	const FORM_REQUIRED_N = 'n';

	/**
	 * @var string form_modifiable：y
	 */
	const FORM_MODIFIABLE_Y = 'y';

	/**
	 * @var string form_modifiable：n
	 */
	const FORM_MODIFIABLE_N = 'n';

	/**
	 * @var string index_show：y
	 */
	const INDEX_SHOW_Y = 'y';

	/**
	 * @var string index_show：n
	 */
	const INDEX_SHOW_N = 'n';

	/**
	 * @var string form_create_show：y
	 */
	const FORM_CREATE_SHOW_Y = 'y';

	/**
	 * @var string form_create_show：n
	 */
	const FORM_CREATE_SHOW_N = 'n';

	/**
	 * @var string form_modify_show：y
	 */
	const FORM_MODIFY_SHOW_Y = 'y';

	/**
	 * @var string form_modify_show：n
	 */
	const FORM_MODIFY_SHOW_N = 'n';

	/**
	 * @var string form_search_show：y
	 */
	const FORM_SEARCH_SHOW_Y = 'y';

	/**
	 * @var string form_search_show：n
	 */
	const FORM_SEARCH_SHOW_N = 'n';

	/**
	 * @var ui\bootstrap\Components 页面小组件类
	 */
	public $uiComponents = null;

	/**
	 * 构造方法：初始化页面小组件类
	 */
	public function __construct()
	{
		$this->uiComponents = BuilderFactory::getUi('Fields');
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
				'prompt' => Text::_('MOD_BUILDER_BUILDER_FIELDS_VIEWTAB_VIEW_PROMPT')
			),
		);

		return $output;
	}

	/**
	 * 获取“主键ID”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFieldId($type)
	{
		$output = array();
		$name = 'field_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_ID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_ID_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“字段名”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFieldName($type)
	{
		$output = array();
		$name = 'field_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_LABEL'),
				'callback' => array($this->uiComponents, 'getFieldNameUrl')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'AlphaNum' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_ALPHANUM')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_MINLENGTH')),
				'MaxLength' => array(50, Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“DB字段长度或用|分隔开的Enum值”配置
	 * @param integer $type
	 * @return array
	 */
	public function getColumnLength($type)
	{
		$output = array();
		$name = 'column_length';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_LENGTH_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_LENGTH_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_LENGTH_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“是否自动递增”配置
	 * @param integer $type
	 * @return array
	 */
	public function getColumnAutoIncrement($type)
	{
		$output = array();
		$options = array(
			self::COLUMN_AUTO_INCREMENT_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::COLUMN_AUTO_INCREMENT_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'column_auto_increment';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_AUTO_INCREMENT_LABEL'),
				'callback' => array($this->uiComponents, 'getColumnAutoIncrementLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_AUTO_INCREMENT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_AUTO_INCREMENT_HINT'),
				'options' => $options,
				'value' => self::COLUMN_AUTO_INCREMENT_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_AUTO_INCREMENT_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“是否无符号”配置
	 * @param integer $type
	 * @return array
	 */
	public function getColumnUnsigned($type)
	{
		$output = array();
		$options = array(
			self::COLUMN_UNSIGNED_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::COLUMN_UNSIGNED_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'column_unsigned';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_UNSIGNED_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_UNSIGNED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_UNSIGNED_HINT'),
				'options' => $options,
				'value' => self::COLUMN_UNSIGNED_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_UNSIGNED_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“DB字段描述”配置
	 * @param integer $type
	 * @return array
	 */
	public function getColumnComment($type)
	{
		$output = array();
		$name = 'column_comment';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_COMMENT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_COMMENT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_COMMENT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'NotEmpty' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_COMMENT_NOTEMPTY')),
			);
		}

		return $output;
	}

	/**
	 * 获取“生成代码ID”配置
	 * @param integer $type
	 * @return array
	 */
	public function getBuilderId($type)
	{
		$output = array();
		$name = 'builder_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_BUILDER_ID_LABEL'),
				'callback' => array($this->uiComponents, 'getBuilderNameByBuilderId')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$builderId = BuilderFactory::getModel('Fields')->getBuilderId();
			$output = array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'value' => $builderId,
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_BUILDER_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_BUILDER_ID_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Integer' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELDS_BUILDER_ID_INTEGER')),
			);
		}

		return $output;
	}

	/**
	 * 获取“生成代码名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getBuilderName($type)
	{
		$output = array();
		$name = 'builder_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$builderId = BuilderFactory::getModel('Fields')->getBuilderId();
			$builderName = BuilderFactory::getModel('Builders')->getBuilderNameByBuilderId($builderId);
			$output = array(
				'type' => 'string',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'value' => $builderName
			);
		}

		return $output;
	}

	/**
	 * 获取“表单字段组ID”配置
	 * @param integer $type
	 * @return array
	 */
	public function getGroupId($type)
	{
		$output = array();
		$builderId = BuilderFactory::getModel('Fields')->getBuilderId();
		$options = BuilderFactory::getModel('Groups')->getGroupsByGroupId($builderId, true);

		$name = 'group_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_GROUP_ID_LABEL'),
				'callback' => array($this->uiComponents, 'getGroupNameByGroupId')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'select',
				'options' => $options,
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_GROUP_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_GROUP_ID_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), Text::_('MOD_BUILDER_BUILDER_FIELDS_GROUP_ID_INARRAY')),
			);
		}

		return $output;
	}

	/**
	 * 获取“字段类型ID”配置
	 * @param integer $type
	 * @return array
	 */
	public function getTypeId($type)
	{
		$output = array();
		$options = BuilderFactory::getModel('types')->getTypes();

		$name = 'type_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_TYPE_ID_LABEL'),
				'callback' => array($this->uiComponents, 'getTypeNameByTypeId')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'select',
				'options' => $options,
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_TYPE_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_TYPE_ID_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), Text::_('MOD_BUILDER_BUILDER_FIELDS_TYPE_ID_INARRAY')),
			);
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
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_SORT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_SORT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELDS_SORT_NUMERIC')),
			);
		}

		return $output;
	}

	/**
	 * 获取“HTML：Table和Form显示名”配置
	 * @param integer $type
	 * @return array
	 */
	public function getHtmlLabel($type)
	{
		$output = array();
		$name = 'html_label';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_HTML_LABEL_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_HTML_LABEL_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_HTML_LABEL_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'NotEmpty' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELDS_HTML_LABEL_NOTEMPTY')),
			);
		}

		return $output;
	}

	/**
	 * 获取“表单提示”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFormPrompt($type)
	{
		$output = array();
		$name = 'form_prompt';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_PROMPT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_PROMPT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_PROMPT_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“表单是否必填”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFormRequired($type)
	{
		$output = array();
		$options = array(
			self::FORM_REQUIRED_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_REQUIRED_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'form_required';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_REQUIRED_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_REQUIRED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_REQUIRED_HINT'),
				'options' => $options,
				'value' => self::FORM_REQUIRED_Y,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_REQUIRED_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“编辑表单中允许输入”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFormModifiable($type)
	{
		$output = array();
		$options = array(
			self::FORM_MODIFIABLE_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_MODIFIABLE_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'form_modifiable';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFIABLE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFIABLE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFIABLE_HINT'),
				'options' => $options,
				'value' => self::FORM_MODIFIABLE_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFIABLE_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“是否在列表中展示”配置
	 * @param integer $type
	 * @return array
	 */
	public function getIndexShow($type)
	{
		$output = array();
		$options = array(
			self::INDEX_SHOW_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::INDEX_SHOW_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'index_show';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SHOW_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SHOW_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SHOW_HINT'),
				'options' => $options,
				'value' => self::INDEX_SHOW_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SHOW_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“在列表中排序”配置
	 * @param integer $type
	 * @return array
	 */
	public function getIndexSort($type)
	{
		$output = array();
		$name = 'index_sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SORT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'value' => 0,
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SORT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SORT_NUMERIC')),
			);
		}

		return $output;
	}

	/**
	 * 获取“是否在新增表单中展示”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFormCreateShow($type)
	{
		$output = array();
		$options = array(
			self::FORM_CREATE_SHOW_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_CREATE_SHOW_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'form_create_show';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SHOW_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SHOW_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SHOW_HINT'),
				'options' => $options,
				'value' => self::FORM_CREATE_SHOW_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SHOW_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“在新增表单中排序”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFormCreateSort($type)
	{
		$output = array();
		$name = 'form_create_sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SORT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'value' => 0,
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SORT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SORT_NUMERIC')),
			);
		}

		return $output;
	}

	/**
	 * 获取“是否在编辑表单中展示”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFormModifyShow($type)
	{
		$output = array();
		$options = array(
			self::FORM_MODIFY_SHOW_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_MODIFY_SHOW_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'form_modify_show';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SHOW_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SHOW_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SHOW_HINT'),
				'options' => $options,
				'value' => self::FORM_MODIFY_SHOW_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SHOW_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“在编辑表单中排序”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFormModifySort($type)
	{
		$output = array();
		$name = 'form_modify_sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SORT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'value' => 0,
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SORT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SORT_NUMERIC')),
			);
		}

		return $output;
	}

	/**
	 * 获取“是否在查询表单中展示”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFormSearchShow($type)
	{
		$output = array();
		$options = array(
			self::FORM_SEARCH_SHOW_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORM_SEARCH_SHOW_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'form_search_show';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SHOW_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SHOW_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SHOW_HINT'),
				'options' => $options,
				'value' => self::FORM_SEARCH_SHOW_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SHOW_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“在查询表单中排序”配置
	 * @param integer $type
	 * @return array
	 */
	public function getFormSearchSort($type)
	{
		$output = array();
		$name = 'form_search_sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SORT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'view',
				'type' => 'text',
				'value' => 0,
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SORT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SORT_NUMERIC')),
			);
		}

		return $output;
	}

}
