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

use tfc\ap\Ap;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Model;
use library\ErrorNo;
use library\PageHelper;

/**
 * Fields class file
 * 表单字段
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Fields.php 1 2014-04-05 00:37:20Z Code Generator $
 * @package modules.builder.model
 * @since 1.0
 */
class Fields extends Model
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

		$params = array('builder_id' => $this->getBuilderId());
		return $this->getUrl(self::ACT_INDEX, Mvc::$controller, Mvc::$module, $params);
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
			$builderId = $this->getColById('builder_id', $id);
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
			'view' => array(
				'tid' => 'view',
				'prompt' => Text::_('MOD_BUILDER_BUILDER_FIELDS_VIEWTAB_VIEW_PROMPT')
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
		$builderId = $this->getBuilderId();
		$output = array(
			'field_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_ID_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'field_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_HINT'),
				'required' => true,
				'table' => array(
					'callback' => array($this, 'getFieldNameLink')
				),
				'search' => array(
					'type' => 'text',
				),
			),
			'column_length' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_LENGTH_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_LENGTH_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'column_auto_increment' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_AUTO_INCREMENT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_AUTO_INCREMENT_HINT'),
				'options' => $data->getEnum('column_auto_increment'),
				'value' => $data::COLUMN_AUTO_INCREMENT_N,
				'table' => array(
					'callback' => array($this, 'getColumnAutoIncrementTblColumn')
				),
				'search' => array(
					'type' => 'select',
				),
			),
			'column_unsigned' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_UNSIGNED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_UNSIGNED_HINT'),
				'options' => $data->getEnum('column_unsigned'),
				'value' => $data::COLUMN_UNSIGNED_N,
				'search' => array(
					'type' => 'select',
				),
			),
			'column_comment' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_COMMENT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_COLUMN_COMMENT_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'builder_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_BUILDER_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_BUILDER_ID_HINT'),
				'value' => $builderId,
				'search' => array(
					'type' => 'text',
				),
			),
			'builder_name' => array(
				'type' => 'string',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'value' => Model::getInstance('Builders')->getBuilderNameByBuilderId($builderId),
				'table' => array(
					'callback' => array($this, 'getBuilderNameTblColumn')
				)
			),
			'group_id' => array(
				'__tid__' => 'main',
				'type' => 'select',
				'options' => Model::getInstance('Groups')->getGroupsByBuilderId($builderId, true),
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_GROUP_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_GROUP_ID_HINT'),
				'table' => array(
					'callback' => array($this, 'getGroupNameTblColumn')
				),
				'search' => array(
					'type' => 'text',
				),
			),
			'type_id' => array(
				'__tid__' => 'main',
				'type' => 'select',
				'options' => $data->getEnum('type_id'),
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_TYPE_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_TYPE_ID_HINT'),
				'table' => array(
					'callback' => array($this, 'getTypeNameTblColumn')
				),
				'search' => array(
					'type' => 'text',
				),
			),
			'sort' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_SORT_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'html_label' => array(
				'__tid__' => 'view',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_HTML_LABEL_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_HTML_LABEL_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'form_prompt' => array(
				'__tid__' => 'view',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_PROMPT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_PROMPT_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'form_prompt_examples' => array(
				'__tid__' => 'view',
				'type' => 'select',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_PROMPT_EXAMPLES_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_PROMPT_EXAMPLES_HINT'),
				'options' => $data->getEnum('form_prompt_examples'),
			),
			'form_required' => array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_REQUIRED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_REQUIRED_HINT'),
				'options' => $data->getEnum('form_required'),
				'value' => $data::FORM_REQUIRED_Y,
				'search' => array(
					'type' => 'select',
				),
			),
			'form_modifiable' => array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFIABLE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFIABLE_HINT'),
				'options' => $data->getEnum('form_modifiable'),
				'value' => $data::FORM_MODIFIABLE_N,
				'search' => array(
					'type' => 'select',
				),
			),
			'index_show' => array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SHOW_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SHOW_HINT'),
				'options' => $data->getEnum('index_show'),
				'value' => $data::INDEX_SHOW_N,
				'search' => array(
					'type' => 'select',
				),
			),
			'index_sort' => array(
				'__tid__' => 'view',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_INDEX_SORT_HINT'),
				'value' => 0,
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'form_create_show' => array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SHOW_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SHOW_HINT'),
				'options' => $data->getEnum('form_create_show'),
				'value' => $data::FORM_CREATE_SHOW_N,
				'search' => array(
					'type' => 'select',
				),
			),
			'form_create_sort' => array(
				'__tid__' => 'view',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_CREATE_SORT_HINT'),
				'value' => 0,
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'form_modify_show' => array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SHOW_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SHOW_HINT'),
				'options' => $data->getEnum('form_modify_show'),
				'value' => $data::FORM_MODIFY_SHOW_N,
				'search' => array(
					'type' => 'select',
				),
			),
			'form_modify_sort' => array(
				'__tid__' => 'view',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_MODIFY_SORT_HINT'),
				'value' => 0,
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'form_search_show' => array(
				'__tid__' => 'view',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SHOW_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SHOW_HINT'),
				'options' => $data->getEnum('form_search_show'),
				'value' => $data::FORM_SEARCH_SHOW_N,
				'search' => array(
					'type' => 'select',
				),
			),
			'form_search_sort' => array(
				'__tid__' => 'view',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FORM_SEARCH_SORT_HINT'),
				'value' => 0,
				'required' => true,
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
			'builder_field_validators' => array(
				'name' => 'builder_field_validators',
				'label' => Text::_('MOD_BUILDER_URLS_VALIDATORS_INDEX'),
				'table' => array(
					'callback' => array($this, 'getBuilderFieldValidatorsTblColumn')
				),
			)
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::create()
	 */
	public function create(array $params = array())
	{
		$ret = parent::create($params);
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			$ret['builder_id'] = $this->getColById('builder_id', $ret['id']);
		}

		return $ret;
	}

	/**
	 * 获取操作图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getOperate($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'builder_id' => $data['builder_id']
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
	 * 获取列表页“字段名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getFieldNameLink($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'last_index_url' => $this->getLastIndexUrl()
		);

		$url = $this->getUrl(self::ACT_VIEW, Mvc::$controller, Mvc::$module, $params);
		$output = $this->a($data['field_name'], $url);
		return $output;
	}

	/**
	 * 获取列表页“是否自动递增”选项
	 * @param array $data
	 * @return string
	 */
	public function getColumnAutoIncrementTblColumn($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'column_name' => 'column_auto_increment'
		);

		$url = $this->getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$output = PageHelper::getComponentsBuilder()->getSwitch(array(
			'id' => $data['field_id'],
			'name' => 'column_auto_increment',
			'value' => $data['column_auto_increment'],
			'href' => $url
		));

		return $output;
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

	/**
	 * 获取列表页“组名”标签
	 * @param array $data
	 * @return string
	 */
	public function getGroupNameTblColumn($data)
	{
		return Model::getInstance('Groups')->getGroupNameByGroupId($data['group_id']);
	}

	/**
	 * 获取列表页“类型名，单行文本、多行文本、密码、开关选项卡、提交按钮等”标签
	 * @param array $data
	 * @return string
	 */
	public function getTypeNameTblColumn($data)
	{
		return Model::getInstance('Types')->getTypeNameByTypeId($data['type_id']);
	}

	/**
	 * 获取列表页“表单字段验证”图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getBuilderFieldValidatorsTblColumn($data)
	{
		$params = array('field_id' => $data['field_id']);
		$componentsBuilder = PageHelper::getComponentsBuilder();

		$indexIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconIndex(),
			'url' => $this->getUrl('index', 'validators', Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('MOD_BUILDER_URLS_VALIDATORS_INDEX'),
		));

		$createIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconCreate(),
			'url' => $this->getUrl('create', 'validators', Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('MOD_BUILDER_URLS_VALIDATORS_CREATE'),
		));

		$output = $indexIcon . $createIcon;
		return $output;
	}

	/**
	 * 通过field_id获取field_name值
	 * @param integer $value
	 * @return string
	 */
	public function getFieldNameByFieldId($value)
	{
		return $this->getColById('field_name', $value);
	}

	/**
	 * 通过field_id获取html_label值
	 * @param integer $value
	 * @return string
	 */
	public function getHtmlLabelByFieldId($value)
	{
		return $this->getColById('html_label', $value);
	}

	/**
	 * 通过field_id获取builder_id值
	 * @param integer $value
	 * @return string
	 */
	public function getBuilderIdByFieldId($value)
	{
		return $this->getColById('builder_id', $value);
	}

}
