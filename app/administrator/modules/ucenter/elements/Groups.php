<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\elements;

use tfc\ap\Ap;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use ui\ElementCollections;
use library\UcenterFactory;

/**
 * Groups class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2014-01-27 15:15:38Z huan.song $
 * @package modules.ucenter.elements
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
		$this->uiComponents = UcenterFactory::getUi('Groups');
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
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_ID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_ID_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_ID_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“父ID”配置
	 * @param integer $type
	 * @return array
	 */
	public function getGroupPid($type)
	{
		$output = array();
		$options = UcenterFactory::getModel('Groups')->findOptions();

		$name = 'group_pid';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_PID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'select',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_PID_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_PID_HINT'),
				'options' => $options
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), Text::_('MOD_UCENTER_USER_GROUPS_GROUP_PID_INARRAY')),
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
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$groupId = (Mvc::$action == 'modify') ? Ap::getRequest()->getInteger('id') : 0;
			$output = array(
				'MinLength' => array(2, Text::_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_MINLENGTH')),
				'MaxLength' => array(50, Text::_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_MAXLENGTH')),
				'modules\\ucenter\\validator\\UserGroupsGroupNameUniqueValidator' => array($groupId, Text::_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_UNIQUE')),
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
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_SORT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_SORT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_SORT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_UCENTER_USER_GROUPS_SORT_NUMERIC')),
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
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_DESCRIPTION_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_DESCRIPTION_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“权限设置，可访问的事件，由应用-模块-控制器-行动组合”配置
	 * @param integer $type
	 * @return array
	 */
	public function getPermission($type)
	{
		$output = array();
		$name = 'permission';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_PERMISSION_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'checkbox',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_PERMISSION_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_PERMISSION_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

}
