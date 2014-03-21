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

use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Model;
use library\PageHelper;

/**
 * Types class file
 * 表单字段类型-模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Types.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Types extends Model
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

		return $this->getUrl('index', Mvc::$controller, Mvc::$module);
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
		$ret = array(
			'type_id' => array(
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_ID_HINT'),
			),
			'type_name' => array(
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_HINT'),
				'required' => true,
				'table' => array(
					'callback' => array($this, 'getTypeNameLink')
				)
			),
			'form_type' => array(
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_HINT'),
				'required' => true,
			),
			'field_type' => array(
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_HINT'),
				'required' => true,
			),
			'category' => array(
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_HINT'),
				'options' => $data->getEnum('category'),
				'value' => $data::CATEGORY_TEXT,
			),
			'sort' => array(
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_SORT_HINT'),
				'required' => true,
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
	 * 获取列表页“类型名，单行文本、多行文本、密码、开关选项卡、提交按钮等”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getTypeNameLink($data)
	{
		$params = array(
			'id' => $data['type_id'],
			'last_index_url' => $this->getLastIndexUrl()
		);

		$url = $this->getUrl('view', Mvc::$controller, Mvc::$module, $params);
		$ret = $this->a($data['type_name'], $url);
		return $ret;
	}

	/**
	 * 获取操作图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getOperate($data)
	{
		$params = array('id' => $data['type_id']);
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
}
