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

use tfc\ap\Registry;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Model;
use library\PageHelper;
use library\ErrorNo;

/**
 * Builders class file
 * 生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builders.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Builders extends Model
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

		return $this->getUrl('index', Mvc::$controller, Mvc::$module, array('trash' => 'n'));
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
			'act' => array(
				'tid' => 'act',
				'prompt' => Text::_('MOD_BUILDER_BUILDERS_VIEWTAB_ACT_PROMPT')
			),
			'system' => array(
				'tid' => 'system',
				'prompt' => Text::_('MOD_BUILDER_BUILDERS_VIEWTAB_SYSTEM_PROMPT')
			),
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
		$ret = array(
			'builder_id' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_HINT'),
			),
			'builder_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_HINT'),
				'required' => true,
				'table' => array(
					'callback' => array($this, 'getBuilderNameLink')
				)
			),
			'tbl_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_HINT'),
				'required' => true,
			),
			'tbl_profile' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_HINT'),
				'options' => $data->getEnum('tbl_profile'),
				'value' => $data::TBL_PROFILE_N,
				'table' => array(
					'callback' => array($this, 'getTblProfileTblColumn')
				),
				'search' => array(
					'type' => 'select'
				),
			),
			'tbl_engine' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_HINT'),
				'options' => $data->getEnum('tbl_engine'),
				'value' => $data::TBL_ENGINE_INNODB,
				'search' => array(
					'type' => 'select'
				),
			),
			'tbl_charset' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_HINT'),
				'options' => $data->getEnum('tbl_charset'),
				'value' => $data::TBL_CHARSET_UTF8,
				'search' => array(
					'type' => 'select'
				),
			),
			'tbl_comment' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_HINT'),
				'required' => true,
			),
			'app_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_HINT'),
				'required' => true,
			),
			'mod_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_HINT'),
				'required' => true,
			),
			'ctrl_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_HINT'),
				'required' => true,
			),
			'cls_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_HINT'),
				'required' => true,
			),
			'act_index_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'index',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_HINT'),
				'required' => true,
			),
			'act_view_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'view',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_HINT'),
				'required' => true,
			),
			'act_create_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'create',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_HINT'),
				'required' => true,
			),
			'act_modify_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'modify',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_HINT'),
				'required' => true,
			),
			'act_remove_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'remove',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_HINT'),
				'required' => true,
			),
			'index_row_btns' => array(
				'__tid__' => 'main',
				'type' => 'checkbox',
				'label' => Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_HINT'),
				'options' => $data->getEnum('index_row_btns'),
				'value' => $data::INDEX_ROW_BTNS_PENCIL,
			),
			'description' => array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DESCRIPTION_HINT'),
			),
			'dt_created' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_HINT'),
				'disabled' => true,
			),
			'author_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_NAME_HINT'),
				'required' => true,
			),
			'author_mail' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_MAIL_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_MAIL_HINT'),
				'required' => true,
			),
			'dt_modified' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_HINT'),
				'disabled' => true,
			),
			'trash' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TRASH_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TRASH_HINT'),
				'options' => $data->getEnum('trash'),
				'value' => $data::TRASH_N,
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
			'builder_field_groups' => array(
				'name' => 'builder_field_groups',
				'label' => Text::_('MOD_BUILDER_URLS_GROUPS_INDEX'),
				'table' => array(
					'callback' => array($this, 'getBuilderFieldGroupsTblColumn')
				),
			),
			'builder_fields' => array(
				'name' => 'builder_fields',
				'label' => Text::_('MOD_BUILDER_URLS_FIELDS_INDEX'),
				'table' => array(
					'callback' => array($this, 'getBuilderFieldsTblColumn')
				),
			)
		);

		return $ret;
	}

	/**
	 * 获取所有的表名
	 * @return array
	 */
	public function getTblNames()
	{
		$ret = $this->getService()->getTblNames();
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return array();
		}

		return $ret['data'];
	}

	/**
	 * 通过builder_id获取builder_name值
	 * @param integer $value
	 * @return string
	 */
	public function getBuilderNameByBuilderId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$builderName = $this->getService()->getBuilderNameByBuilderId($value);
			Registry::set($name, $builderName);
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
		$params = array('id' => $data['builder_id']);
		$componentsBuilder = PageHelper::getComponentsBuilder();

		$modifyIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconModify(),
			'url' => $this->getUrl('modify', Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_MODIFY'),
		));

		$trashIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconTrash(),
			'url' => $this->getUrl('trash', Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncDialogTrash(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_TRASH')
		));

		$removeIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconRemove(),
			'url' => $this->getUrl('remove', Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncDialogRemove(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_REMOVE')
		));

		// 生成代码按钮
		$gcIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconTool(),
			'url' => $this->getUrl('gc', Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('MOD_BUILDER_BUILDERS_GC_LABEL')
		));

		$params['is_restore'] = '1';
		$restoreIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconRestore(),
			'url' => $this->getUrl('trash', Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_RESTORE')
		));

		if ($data['trash'] === 'n') {
			$ret = $modifyIcon . $trashIcon . $gcIcon;
		}
		else {
			$ret = $restoreIcon . $removeIcon;
		}

		return $ret;
	}

	/**
	 * 获取列表页“生成代码名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getBuilderNameLink($data)
	{
		$params = array(
			'id' => $data['builder_id'],
			'last_index_url' => $this->getLastIndexUrl()
		);

		$url = $this->getUrl('view', Mvc::$controller, Mvc::$module, $params);
		$ret = $this->a($data['builder_name'], $url);
		return $ret;
	}

	/**
	 * 获取列表页“是否生成扩展表”选项
	 * @param array $data
	 * @return string
	 */
	public function getTblProfileTblColumn($data)
	{
		if ($data['trash'] === 'y') {
			$enum = $this->getData()->getEnum('tbl_profile');
			return $enum[$data['tbl_profile']];
		}

		$params = array(
			'id' => $data['builder_id'],
			'column_name' => 'tbl_profile'
		);

		$url = $this->getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$ret = PageHelper::getComponentsBuilder()->getSwitch(array(
			'id' => $data['builder_id'],
			'name' => 'tbl_profile',
			'value' => $data['tbl_profile'],
			'href' => $url
		));

		return $ret;
	}

	/**
	 * 获取列表页“字段组”图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getBuilderFieldGroupsTblColumn($data)
	{
		$params = array('builder_id' => $data['builder_id']);
		$componentsBuilder = PageHelper::getComponentsBuilder();

		$indexIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconIndex(),
			'url' => $this->getUrl('index', 'groups', Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('MOD_BUILDER_URLS_GROUPS_INDEX'),
		));

		$createIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconCreate(),
			'url' => $this->getUrl('create', 'groups', Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('MOD_BUILDER_URLS_GROUPS_CREATE'),
		));

		$ret = $indexIcon . $createIcon;
		return $ret;
	}

	/**
	 * 获取列表页“表单字段”图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getBuilderFieldsTblColumn($data)
	{
		$params = array('builder_id' => $data['builder_id']);
		$componentsBuilder = PageHelper::getComponentsBuilder();

		$indexIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconIndex(),
			'url' => $this->getUrl('index', 'fields', Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('MOD_BUILDER_URLS_FIELDS_INDEX'),
		));

		$createIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconCreate(),
			'url' => $this->getUrl('create', 'fields', Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('MOD_BUILDER_URLS_FIELDS_CREATE'),
		));

		$ret = $indexIcon . $createIcon;
		return $ret;
	}
}
