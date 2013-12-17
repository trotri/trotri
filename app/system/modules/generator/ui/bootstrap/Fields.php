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
}
