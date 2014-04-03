<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\model;

use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Model;
use library\ErrorNo;
use library\PageHelper;

/**
 * Builders class file
 * 生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builders.php 1 2014-04-03 17:53:20Z Code Generator $
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

		$params = array('trash' => 'n');
		return $this->getUrl(self::ACT_INDEX, Mvc::$controller, Mvc::$module, $params);
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
		$output = array(
			'builder_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'builder_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_HINT'),
				'required' => true,
				'table' => array(
					'callback' => array($this, 'getBuilderNameLink')
				),
				'search' => array(
					'type' => 'text',
				),
			),
			'tbl_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
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
					'type' => 'select',
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
					'type' => 'select',
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
					'type' => 'select',
				),
			),
			'tbl_comment' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'app_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'mod_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'ctrl_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'cls_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'fk_column' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_FK_COLUMN_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_FK_COLUMN_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'act_index_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_HINT'),
				'value' => 'index',
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'act_view_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_HINT'),
				'value' => 'view',
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'act_create_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_HINT'),
				'value' => 'create',
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'act_modify_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_HINT'),
				'value' => 'modify',
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'act_remove_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_HINT'),
				'value' => 'remove',
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
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
				'search' => array(
					'type' => 'text',
				),
			),
			'author_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_NAME_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'author_mail' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_MAIL_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_MAIL_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'dt_created' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'dt_modified' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'trash' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TRASH_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TRASH_HINT'),
				'options' => $data->getEnum('trash'),
				'value' => $data::TRASH_N,
				'search' => array(
					'type' => 'select',
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

		return $output;
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

		$trashIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconTrash(),
			'url' => $this->getUrl(self::ACT_TRASH, Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncDialogTrash(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_TRASH'),
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
			'url' => $this->getUrl(self::ACT_TRASH, Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_RESTORE'),
		));

		if ($data['trash'] === 'n') {
			$output = $modifyIcon . $trashIcon . $gcIcon;
		}
		else {
			$output = $restoreIcon . $removeIcon;
		}

		return $output;
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

		$url = $this->getUrl(self::ACT_VIEW, Mvc::$controller, Mvc::$module, $params);
		$output = $this->a($data['builder_name'], $url);
		return $output;
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
		$output = PageHelper::getComponentsBuilder()->getSwitch(array(
			'id' => $data['builder_id'],
			'name' => 'tbl_profile',
			'value' => $data['tbl_profile'],
			'href' => $url
		));

		return $output;
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

		$output = $indexIcon . $createIcon;
		return $output;
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

		$output = $indexIcon . $createIcon;
		return $output;
	}

	/**
	 * 通过Builders数据生成代码
	 * @param integer $builderId
	 * @return void
	 */
	public function gc($builderId)
	{
		$codeGenerator = new CodeGenerator($builderId);
		$codeGenerator->run();
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
		return $this->getColById('builder_name', $value);
	}

}
