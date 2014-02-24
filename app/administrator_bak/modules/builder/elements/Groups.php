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
 * Groups class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2014-01-19 13:18:49Z huan.song $
 * @package modules.builder.elements
 * @since 1.0
 */
class Groups extends ElementCollections
{
	/**
	 * @var ui\bootstrap\Components 页面小组件类
	 */
	public $uiComponents = null;

	/**
	 * 构造方法：初始化页面小组件类
	 */
	public function __construct()
	{
		$this->uiComponents = BuilderFactory::getUi('Groups');
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
	public function getGroupId($type)
	{
		$output = array();
		$name = 'group_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_ID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_ID_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“组名”配置
	 * @param integer $type
	 * @return array
	 */
	public function getGroupName($type)
	{
		$output = array();
		$name = 'group_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_LABEL'),
				'callback' => array($this->uiComponents, 'getGroupNameUrl')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“提示”配置
	 * @param integer $type
	 * @return array
	 */
	public function getPrompt($type)
	{
		$output = array();
		$name = 'prompt';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_MAXLENGTH')),
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
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_BUILDER_ID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$builderId = BuilderFactory::getModel('Groups')->getBuilderId();
			$output = array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'value' => $builderId,
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_BUILDER_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_BUILDER_ID_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Integer' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_BUILDER_ID_INTEGER')),
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
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_SORT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_SORT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_SORT_NUMERIC')),
			);
		}

		return $output;
	}

	/**
	 * 获取“描述”配置
	 * @param integer $type
	 * @return array
	 */
	public function getDescription($type)
	{
		$output = array();
		$name = 'description';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_DESCRIPTION_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_DESCRIPTION_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
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
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'callback' => array($this->uiComponents, 'getBuilderNameByBuilderId')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$builderId = BuilderFactory::getModel('Groups')->getBuilderId();
			$builderName = BuilderFactory::getModel('Builders')->getBuilderNameByBuilderId($builderId);
			$output = array(
				'type' => 'string',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'value' => $builderName
			);
		}

		return $output;
	}

}
