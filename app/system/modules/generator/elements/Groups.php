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
use helper\Util;

/**
 * Groups class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.elements
 * @since 1.0
 */
class Groups extends ElementCollections
{
	/**
	 * 获取“字段组ID”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getGroupId($type)
	{
		$output = array();

		$name = 'group_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => 'ID'
			);
		}

		return $output;
	}

	/**
	 * 获取“组名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getGroupName($type)
	{
		$output = array();

		$name = 'group_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GROUPS_GROUP_NAME_LABEL'),
				'callback' => array($this->getUiComponentsInstance(), 'getGroupNameUrl')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GROUPS_GROUP_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GROUPS_GROUP_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'MinLength' => array(2, Text::_('MOD_GENERATOR_GROUPS_GROUP_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GROUPS_GROUP_NAME_MAXLENGTH'))
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
		$generatorId = Ap::getRequest()->getInteger('generator_id');

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_GENERATOR_NAME_LABEL'),
				'callback' => array($this->getUiComponentsInstance(), 'getGeneratorNameByGeneratorId')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'hidden',
				'label' => Text::_('MOD_GENERATOR_GROUPS_GENERATOR_ID_LABEL'),
				'value' => $generatorId
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Integer' => array(true, Text::_('MOD_GENERATOR_GROUPS_GENERATOR_ID_INTEGER'))
			);
		}

		return $output;
	}

	/**
	 * 获取“生成代码ID”表单元素和验证规则
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
			$generatorId = Ap::getRequest()->getInteger('generator_id');
			$generatorName = Util::getModel('Generators', 'generator')->getGeneratorNameByGeneratorId($generatorId);
			$output = array(
				'type' => 'string',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_GENERATOR_NAME_LABEL'),
				'value' => $generatorName
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
				'label' => Text::_('MOD_GENERATOR_GROUPS_SORT_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GROUPS_SORT_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GROUPS_SORT_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_GENERATOR_GROUPS_SORT_NUMERIC'))
			);
		}

		return $output;
	}

	/**
	 * 获取“描述”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getDescription($type)
	{
		$output = array();

		$name = 'description';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GROUPS_DESCRIPTION_LABEL')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'textarea',
				'label' => Text::_('MOD_GENERATOR_GROUPS_DESCRIPTION_LABEL')
			);
		}

		return $output;
	}
}
