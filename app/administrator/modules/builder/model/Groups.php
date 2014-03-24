<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\model;

use tfc\ap\Ap;
use tfc\ap\Registry;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Model;
use library\PageHelper;
use library\ErrorNo;

/**
 * Groups class file
 * 表单字段组
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Groups extends Model
{
	/**
	 * @var string 查询列表数据Action名
	 */
	const ACT_INDEX = 'index';

	/**
	 * @var string 新增数据Action名
	 */
	const ACT_CREATE = 'create';

	/**
	 * @var string 编辑数据Action名
	 */
	const ACT_MODIFY = 'modify';

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getLastIndexUrl()
	 */
	public function getLastIndexUrl()
	{
		if (($lastIndexUrl = parent::getLastIndexUrl()) !== '') {
			return $lastIndexUrl;
		}

		return $this->getUrl('index', Mvc::$controller, Mvc::$module, array('builder_id' => $this->getBuilderId()));
	}

	/**
	 * 获取builder_id值
	 * @return integer
	 */
	public function getBuilderId()
	{
		$builderId = Ap::getRequest()->getInteger('builder_id');
		if ($builderId <= 0) {
			$id = Ap::getRequest()->getInteger('id');
			$builderId = $this->getBuilderIdByGroupId($id);
		}

		return $builderId;
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
		$ret = array(
			'group_id' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_ID_HINT'),
			),
			'group_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_HINT'),
				'required' => true,
				'table' => array(
					'callback' => array($this, 'getGroupNameLink')
				)
			),
			'prompt' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_HINT'),
				'required' => true,
			),
			'builder_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'value' => $this->getBuilderId(),
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_BUILDER_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_BUILDER_ID_HINT'),
			),
			'builder_name' => array(
				'type' => 'string',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'value' => Model::getInstance('Builders')->getBuilderNameByBuilderId($this->getBuilderId()),
				'table' => array(
					'callback' => array($this, 'getBuilderNameTblColumn')
				)
			),
			'sort' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_SORT_HINT'),
				'required' => true,
			),
			'description' => array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_DESCRIPTION_HINT'),
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
			)
		);

		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::create()
	 */
	public function create(array $params = array())
	{
		$ret = parent::create($params);
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$ret['builder_id'] = $this->getBuilderIdByGroupId($ret['id']);
		}

		return $ret;
	}

	/**
	 * 通过builder_id获取所有的Groups
	 * @param integer $value
	 * @param boolean $joinDafault
	 * @return array
	 */
	public function getGroupsByBuilderId($value, $joinDafault = false)
	{
		return $this->getService()->getGroupsByBuilderId($value, $joinDafault);
	}

	/**
	 * 通过group_id获取group_name值
	 * @param integer $value
	 * @return string
	 */
	public function getGroupNameByGroupId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$groupName = $this->getService()->getGroupNameByGroupId($value);
			Registry::set($name, $groupName);
		}

		return Registry::get($name);
	}

	/**
	 * 通过group_id获取builder_id值
	 * @param integer $value
	 * @return string
	 */
	public function getBuilderIdByGroupId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$builderId = $this->getService()->getBuilderIdByGroupId($value);
			Registry::set($name, $builderId);
		}

		return Registry::get($name);
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
			'builder_id' => $data['builder_id']
		);
		$componentsBuilder = PageHelper::getComponentsBuilder();

		$modifyIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconModify(),
			'url' => $this->getUrl('modify', Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_MODIFY'),
		));

		$removeIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconRemove(),
			'url' => $this->getUrl('remove', Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncDialogRemove(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_REMOVE')
		));

		$ret = $modifyIcon . $removeIcon;
		return $ret;
	}

	/**
	 * 获取列表页“组名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getGroupNameLink($data)
	{
		$params = array(
			'id' => $data['group_id'],
			'last_index_url' => $this->getLastIndexUrl()
		);

		$url = $this->getUrl('view', Mvc::$controller, Mvc::$module, $params);
		$ret = $this->a($data['group_name'], $url);
		return $ret;
	}

	/**
	 * 获取列表页“生成代码名”选项
	 * @param array $data
	 * @return string
	 */
	public function getBuilderNameTblColumn($data)
	{
		return Model::getInstance('Builders')->getBuilderNameByBuilderId($data['builder_id']);
	}
}
