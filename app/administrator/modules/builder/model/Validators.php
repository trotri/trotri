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
 * Validators class file
 * 表单字段验证
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Validators.php 1 2014-04-05 22:11:11Z Code Generator $
 * @package modules.builder.model
 * @since 1.0
 */
class Validators extends Model
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

		$params = array('field_id' => $this->getFieldId());
		return $this->getUrl(self::ACT_INDEX, Mvc::$controller, Mvc::$module, $params);
	}

	/**
	 * 获取field_id值
	 * @return integer
	 */
	public function getFieldId()
	{
		$fieldId = Ap::getRequest()->getInteger('field_id');
		if ($fieldId <= 0) {
			$id = Ap::getRequest()->getInteger('id');
			$fieldId = $this->getColById('field_id', $id);
		}

		return $fieldId;
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
		$fieldId = $this->getFieldId();
		$data = $this->getData();
		$output = array(
			'validator_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_VALIDATOR_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_VALIDATOR_ID_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'validator_name' => array(
				'__tid__' => 'main',
				'type' => 'select',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_VALIDATOR_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_VALIDATOR_NAME_HINT'),
				'options' => $data->getEnum('validator_name'),
				'value' => 'Integer',
				'table' => array(
					'callback' => array($this, 'getValidatorNameLink')
				),
				'search' => array(
					'type' => 'text',
				),
			),
			'field_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_FIELD_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_FIELD_ID_HINT'),
				'value' => $fieldId,
				'search' => array(
					'type' => 'text',
				),
			),
			'field_name' => array(
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELDS_FIELD_NAME_LABEL'),
				'value' => Model::getInstance('Fields')->getHtmlLabelByFieldId($fieldId),
				'readonly' => true,
				'table' => array(
					'callback' => array($this, 'getFieldNameTblColumn')
				)
			),
			'options' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_OPTIONS_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_OPTIONS_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'option_category' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_OPTION_CATEGORY_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_OPTION_CATEGORY_HINT'),
				'options' => $data->getEnum('option_category'),
				'value' => $data::OPTION_CATEGORY_INTEGER,
				'table' => array(
					'callback' => array($this, 'getOptionCategoryTblColumn')
				),
				'search' => array(
					'type' => 'select',
				),
			),
			'message' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_HINT'),
				'value' => '',
				'search' => array(
					'type' => 'text',
				),
			),
			'sort' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_SORT_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'when' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_WHEN_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_WHEN_HINT'),
				'options' => $data->getEnum('when'),
				'value' => $data::WHEN_ALL,
				'table' => array(
					'callback' => array($this, 'getWhenTblColumn')
				),
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
			$ret['field_id'] = $this->getColById('field_id', $ret['id']);
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
			'id' => $data['validator_id'],
			'field_id' => $data['field_id']
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
	 * 获取列表页“验证类名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getValidatorNameLink($data)
	{
		$params = array(
			'id' => $data['validator_id'],
			'last_index_url' => $this->getLastIndexUrl()
		);

		$url = $this->getUrl(self::ACT_VIEW, Mvc::$controller, Mvc::$module, $params);
		$output = $this->a($data['validator_name'], $url);
		return $output;
	}

	/**
	 * 获取列表页“字段名”标签
	 * @param array $data
	 * @return string
	 */
	public function getFieldNameTblColumn($data)
	{
		return Model::getInstance('Fields')->getFieldNameByFieldId($data['field_id']);
	}

	/**
	 * 获取列表页“验证时对比值类型”标签
	 * @param array $data
	 * @return string
	 */
	public function getOptionCategoryTblColumn($data)
	{
		$enum = $this->getData()->getEnum('option_category');
		return isset($enum[$data['option_category']]) ? $enum[$data['option_category']] : '';
	}

	/**
	 * 获取列表页“验证环境，任意时候验证、只在新增数据时验证、只在编辑数据时验证”标签
	 * @param array $data
	 * @return string
	 */
	public function getWhenTblColumn($data)
	{
		$enum = $this->getData()->getEnum('when');
		return isset($enum[$data['when']]) ? $enum[$data['when']] : '';
	}

	/**
	 * 获取“出错提示消息”所有选项
	 * @return array
	 */
	public function getMessageEnum()
	{
		$enum = $this->getData()->getEnum('message');
		return $enum;
	}

	/**
	 * 获取“验证时对比值类型”所有选项
	 * @return array
	 */
	public function getOptionCategoryEnum()
	{
		$enum = $this->getData()->getEnum('option_category');
		return $enum;
	}

	/**
	 * 通过validator_id获取validator_name值
	 * @param integer $value
	 * @return string
	 */
	public function getValidatorNameByValidatorId($value)
	{
		return $this->getColById('validator_name', $value);
	}

	/**
	 * 通过validator_id获取field_id值
	 * @param integer $value
	 * @return string
	 */
	public function getFieldIdByValidatorId($value)
	{
		return $this->getColById('field_id', $value);
	}

}
