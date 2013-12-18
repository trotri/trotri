<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\ui\bootstrap;

use ui\bootstrap\Components;
use tfc\ap\Ap;
use tfc\ap\Registry;
use tfc\saf\Text;
use library\Url;
use library\GeneratorFactory;

/**
 * Fields class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Fields.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.ui.bootstrap
 * @since 1.0
 */
class Fields
{
	/**
	 * 获取表单的“保存”按钮信息
	 * @return array
	 */
	public function getButtonSave()
	{
		return Components::getButtonSave();
	}

	/**
	 * 获取表单的“保存并关闭”按钮信息
	 * @return array
	 */
	public function getButtonSaveClose()
	{
		return Components::getButtonSaveClose();
	}

	/**
	 * 获取表单的“保存并新建”按钮信息
	 * @return array
	 */
	public function getButtonSaveNew()
	{
		return Components::getButtonSaveNew();
	}

	/**
	 * 获取表单的“取消”按钮信息
	 * @return array
	 */
	public function getButtonCancel()
	{
		$params = array(
			'generator_id' => Ap::getRequest()->getInteger('generator_id')
		);

		$url = Url::getUrl('index', 'fields', 'generator', $params);
		return Components::getButtonCancel($url);
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
		);

		$modify = 'Trotri.href(\'' . Url::getUrl('modify', 'fields', 'generator', $params) . '\')';
		$remove = 'Core.dialogRemove(\'' . Url::getUrl('remove', 'fields', 'generator', $params) . '\')';

		$ret = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modify, Text::_('MOD_GENERATOR_GENERATOR_FIELDS_MODIFY'))
			 . Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $remove, Text::_('CFG_SYSTEM_GLOBAL_REMOVE'));

		return $ret;
	}

	/**
	 * 获取列表页“字段名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getFieldNameUrl($data)
	{
		$params = array(
			'id' => $data['field_id'],
		);

		return Components::getHtml()->a($data['field_name'], Url::getUrl('modify', 'fields', 'generator', $params));
	}

	/**
	 * 获取列表页“是否自动递增”美化版“是|否”选择项表单元素
	 * @param array $data
	 * @return string
	 */
	public function getColumnAutoIncrementLabel($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'column_name' => 'column_auto_increment'
		);

		$href = Url::getUrl('singlemodify', 'fields', 'generator', $params);
		$ret = Components::getSwitch($data['field_id'], 'column_auto_increment', $data['column_auto_increment'], $href);
		return $ret;
	}

	/**
	 * 获取列表页“是否无符号”美化版“是|否”选择项表单元素
	 * @param array $data
	 * @return string
	 */
	public function getColumnUnsignedLabel($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'column_name' => 'column_unsigned'
		);

		$href = Url::getUrl('singlemodify', 'fields', 'generator', $params);
		$ret = Components::getSwitch($data['field_id'], 'column_unsigned', $data['column_unsigned'], $href);
		return $ret;
	}

	/**
	 * 通过generator_id获取generator_name值
	 * @param array $data
	 * @return string
	 */
	public function getGeneratorNameByGeneratorId($data)
	{
		return GeneratorFactory::getModel('generators')->getGeneratorNameByGeneratorId($data['generator_id']);
	}

	/**
	 * 通过group_id获取group_name值
	 * @param array $data
	 * @return array
	 */
	public function getGroupNameByGroupId($data)
	{
		return GeneratorFactory::getModel('groups')->getGroupNameByGroupId($data['group_id']);
	}

	/**
	 * 通过type_id获取type_name值
	 * @param array $data
	 * @return string
	 */
	public function getTypeNameByTypeId($data)
	{
		return GeneratorFactory::getModel('types')->getTypeNameByTypeId($data['type_id']);
	}

	/**
	 * 获取美化版表单元素：“表单是否必填”的“是|否”选择项
	 * @param array $data
	 * @return string
	 */
	public function getFormRequiredLabel($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'column_name' => 'form_required'
		);

		$href = Url::getUrl('singlemodify', 'fields', 'generator', $params);
		$ret = Components::getSwitch($data['field_id'], 'form_required', $data['form_required'], $href);
		return $ret;
	}

	/**
	 * 获取美化版表单元素：“编辑表单中是否允许输入”的“是|否”选择项
	 * @param array $data
	 * @return string
	 */
	public function getFormModifiableLabel($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'column_name' => 'form_modifiable'
		);

		$href = Url::getUrl('singlemodify', 'fields', 'generator', $params);
		$ret = Components::getSwitch($data['field_id'], 'form_modifiable', $data['form_modifiable'], $href);
		return $ret;
	}

	/**
	 * 获取美化版表单元素：“是否在列表中展示”的“是|否”选择项
	 * @param array $data
	 * @return string
	 */
	public function getIndexShowLabel($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'column_name' => 'index_show'
		);

		$href = Url::getUrl('singlemodify', 'fields', 'generator', $params);
		$ret = Components::getSwitch($data['field_id'], 'index_show', $data['index_show'], $href);
		return $ret;
	}

	/**
	 * 获取美化版表单元素：“是否在新增表单中展示”的“是|否”选择项
	 * @param array $data
	 * @return string
	 */
	public function getFormCreateShowLabel($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'column_name' => 'form_create_show'
		);

		$href = Url::getUrl('singlemodify', 'fields', 'generator', $params);
		$ret = Components::getSwitch($data['field_id'], 'form_create_show', $data['form_create_show'], $href);
		return $ret;
	}

	/**
	 * 获取美化版表单元素：“是否在编辑表单中展示”的“是|否”选择项
	 * @param array $data
	 * @return string
	 */
	public function getFormModifyShowLabel($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'column_name' => 'form_modify_show'
		);

		$href = Url::getUrl('singlemodify', 'fields', 'generator', $params);
		$ret = Components::getSwitch($data['field_id'], 'form_modify_show', $data['form_modify_show'], $href);
		return $ret;
	}

	/**
	 * 获取美化版表单元素：“是否在查询表单中展示”的“是|否”选择项
	 * @param array $data
	 * @return string
	 */
	public function getFormSearchShowLabel($data)
	{
		$params = array(
			'id' => $data['field_id'],
			'column_name' => 'form_search_show'
		);

		$href = Url::getUrl('singlemodify', 'fields', 'generator', $params);
		$ret = Components::getSwitch($data['field_id'], 'form_search_show', $data['form_search_show'], $href);
		return $ret;
	}

	/**
	 * 获取字段验证图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getGeneratorFieldValidatorsLabel($data)
	{
		$params = array(
			'field_id' => $data['field_id']
		);

		$index = 'Trotri.href(\'' . Url::getUrl('index', 'validators', 'generator', $params) . '\')';
		$create = 'Trotri.href(\'' . Url::getUrl('create', 'validators', 'generator', $params) . '\')';
		$ret = Components::getGlyphicon(Components::GLYPHICON_LIST, $index, Text::_('MOD_GENERATOR_GENERATOR_FIELD_VALIDATORS_INDEX'))
			 . Components::getGlyphicon(Components::GLYPHICON_PLUS_SIGN, $create, Text::_('MOD_GENERATOR_GENERATOR_FIELD_VALIDATORS_CREATE'));

		return $ret;
	}
}
