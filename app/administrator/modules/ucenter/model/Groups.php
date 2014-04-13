<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\model;

use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Model;
use library\ErrorNo;
use library\PageHelper;

/**
 * Groups class file
 * 用户组
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2014-04-10 17:43:20Z Code Generator $
 * @package modules.ucenter.model
 * @since 1.0
 */
class Groups extends Model
{
	/**
	 * @var string 查询列表数据Action名
	 */
	const ACT_INDEX = 'index';

	/**
	 * @var string 数据详情Action名
	 */
	const ACT_VIEW = 'view';

	/**
	 * @var string 新增数据Action名
	 */
	const ACT_CREATE = 'create';

	/**
	 * @var string 编辑数据Action名
	 */
	const ACT_MODIFY = 'modify';

	/**
	 * @var string 删除数据Action名
	 */
	const ACT_REMOVE = 'remove';

	/**
	 * @var string 移至回收站Action名
	 */
	const ACT_TRASH = 'trash';

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getLastIndexUrl()
	 */
	public function getLastIndexUrl()
	{
		if (($lastIndexUrl = parent::getLastIndexUrl()) !== '') {
			return $lastIndexUrl;
		}

		$params = array();
		return $this->getUrl(self::ACT_INDEX, Mvc::$controller, Mvc::$module, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getElementsRender()
	 */
	public function getElementsRender()
	{
		$data = $this->getData();
		$output = array(
			'group_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_ID_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_ID_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'group_pid' => array(
				'__tid__' => 'main',
				'type' => 'select',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_PID_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_PID_HINT'),
				'options' => $this->getOptions(),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'group_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_GROUP_NAME_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'sort' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_SORT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_SORT_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'permission' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_PERMISSION_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_PERMISSION_HINT'),
				'table' => array(
					'callback' => array($this, 'getPermissionTblColumn')
				),
				'search' => array(
					'type' => 'text',
				),
			),
			'description' => array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_UCENTER_USER_GROUPS_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_GROUPS_DESCRIPTION_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'_button_save_' => PageHelper::getComponentsBuilder()->getButtonSave(),
			'_button_save2close_' => PageHelper::getComponentsBuilder()->getButtonSaveClose(),
			'_button_save2new_' => PageHelper::getComponentsBuilder()->getButtonSaveNew(),
			'_button_cancel_' => PageHelper::getComponentsBuilder()->getButtonCancel(array('url' => $this->getLastIndexUrl())),
			'_button_history_back_' => PageHelper::getComponentsBuilder()->getButtonHistoryBack(array('url' => $this->getLastIndexUrl())),
			'_operate_' => array(
				'label' => Text::_('CFG_SYSTEM_GLOBAL_OPERATE'),
				'table' => array(
					'callback' => array($this, 'getOperate')
				)
			),
		);

		return $output;
	}

	/**
	 * 获取操作图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getOperate($data)
	{
		$params = array(
			'id' => $data['group_id'],
			'last_index_url' => $this->getLastIndexUrl()
		);

		$componentsBuilder = PageHelper::getComponentsBuilder();

		$modifyIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconModify(),
			'url' => $this->getUrl(self::ACT_MODIFY, Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_MODIFY'),
		));

		$removeIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconRemove(),
			'url' => $this->getUrl(self::ACT_REMOVE, Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncDialogRemove(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_REMOVE'),
		));

		$output = $modifyIcon . $removeIcon;
		return $output;
	}

	/**
	 * 获取列表页“权限设置”选项
	 * @param array $data
	 * @return string
	 */
	public function getPermissionTblColumn($data)
	{
		$params = array(
			'id' => $data['group_id'],
			'last_index_url' => $this->getLastIndexUrl()
		);

		$componentsBuilder = PageHelper::getComponentsBuilder();

		$modifyIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconModify(),
			'url' => $this->getUrl('permissionmodify', Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_MODIFY'),
		));

		return $modifyIcon;
	}

	/**
	 * 递归方式获取所有的组，默认用空格填充子类别左边用于和父类别错位（可用于Table列表）
	 * @param integer $groupPid
	 * @param string $padStr
	 * @param string $leftPad
	 * @param string $rightPad
	 * @return array
	 */
	public function findLists($groupPid = 0, $padStr = '|—', $leftPad = '', $rightPad = null)
	{
		return $this->getService()->findLists($groupPid, $padStr, $leftPad, $rightPad);
	}

	/**
	 * 递归方式获取所有的组，默认用空格填充子类别左边用于和父类别错位（可用于Select表单的Option选项）
	 * @param integer $groupPid
	 * @param string $padStr
	 * @param string $leftPad
	 * @param string $rightPad
	 * @return array
	 */
	public function getOptions($groupPid = 0, $padStr = '&nbsp;&nbsp;&nbsp;&nbsp;', $leftPad = '', $rightPad = null)
	{
		return $this->getService()->getOptions($groupPid, $padStr, $leftPad, $rightPad);
	}

	/**
	 * 通过主键，获取权限，并递归获取父级权限、父父级权限等
	 * @param integer $groupId
	 * @return array
	 */
	public function getPermissions($groupId)
	{
		return $this->getService()->getOptions($groupId);
	}

	/**
	 * 获取所有的事件，并选中有权限的事件
	 * @param integer $groupId
	 * @return array
	 */
	public function getAmcas($groupId)
	{
		$enum = $this->getData()->getPowerEnum();

		$amcas = Model::getInstance('Amcas')->findRecur();
		foreach ($amcas as $appName => $app) {
			foreach ($app['rows'] as $modName => $mod) {
				foreach ($mod['rows'] as $ctrlName => $ctrl) {
					$amcas[$appName]['rows'][$modName]['rows'][$ctrlName]['powers'] = $enum;
					$amcas[$appName]['rows'][$modName]['rows'][$ctrlName]['checked'] = array();
				}
			}
		}

		return $amcas;
	}
}
