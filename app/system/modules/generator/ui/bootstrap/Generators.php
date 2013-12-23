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

use tfc\saf\Text;
use ui\bootstrap\Components;
use library\GeneratorFactory;
use library\Url;

/**
 * Generators class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Generators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.ui.bootstrap
 * @since 1.0
 */
class Generators
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
		$url = Url::getUrl('index', 'index', 'generator');
		return Components::getButtonCancel($url);
	}

	/**
	 * 获取列表页“是否生成扩展表”美化版“是|否”选择项表单元素
	 * @param array $data
	 * @return string
	 */
	public function getTblProfileSwitchLabel($data)
	{
		if ($data['trash'] === 'y') {
			$elements = GeneratorFactory::getElements('generators');
			$tblProfiles = $elements->getTblProfile($elements::TYPE_OPTIONS);
			return $tblProfiles[$data['tbl_profile']];
		}

		$params = array(
			'id' => $data['generator_id'],
			'column_name' => 'tbl_profile'
		);

		$href = Url::getUrl('singlemodify', 'index', 'generator', $params);
		$ret = Components::getSwitch($data['generator_id'], 'tbl_profile', $data['tbl_profile'], $href);
		return $ret;
	}

	/**
	 * 获取字段组图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getGeneratorFieldGroupsLabel($data)
	{
		$params = array(
			'generator_id' => $data['generator_id']
		);

		$index = Url::getUrl('index', 'groups', 'generator', $params);
		$create = Url::getUrl('create', 'groups', 'generator', $params);
		$ret = Components::getGlyphicon(Components::GLYPHICON_LIST, $index, 'Trotri.href', Text::_('MOD_GENERATOR_GENERATOR_FIELD_GROUPS_INDEX')) 
			 . Components::getGlyphicon(Components::GLYPHICON_PLUS_SIGN, $create, 'Trotri.href', Text::_('MOD_GENERATOR_GENERATOR_FIELD_GROUPS_CREATE'));

		return $ret;
	}

	/**
	 * 获取字段类型图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getGeneratorFieldTypesLabel($data)
	{
		$params = array(
			'generator_id' => $data['generator_id']
		);

		$index = Url::getUrl('index', 'types', 'generator', $params);
		$create = Url::getUrl('create', 'types', 'generator', $params);
		$ret = Components::getGlyphicon(Components::GLYPHICON_LIST, $index, 'Trotri.href', Text::_('MOD_GENERATOR_GENERATOR_FIELD_TYPES_INDEX'))
			 . Components::getGlyphicon(Components::GLYPHICON_PLUS_SIGN, $create, 'Trotri.href', Text::_('MOD_GENERATOR_GENERATOR_FIELD_TYPES_CREATE'));

		return $ret;
	}

	/**
	 * 获取表单字段图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getGeneratorFieldsLabel($data)
	{
		$params = array(
			'generator_id' => $data['generator_id']
		);

		$index = Url::getUrl('index', 'fields', 'generator', $params);
		$create = Url::getUrl('create', 'fields', 'generator', $params);
		$ret = Components::getGlyphicon(Components::GLYPHICON_LIST, $index, 'Trotri.href', Text::_('MOD_GENERATOR_GENERATOR_FIELDS_INDEX'))
			 . Components::getGlyphicon(Components::GLYPHICON_PLUS_SIGN, $create, 'Trotri.href', Text::_('MOD_GENERATOR_GENERATOR_FIELDS_CREATE'));

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
			'id' => $data['generator_id']
		);

		$modify = Url::getUrl('modify', '', '', $params);
		$trash = Url::getUrl('trash', '', '', $params);
		$remove = Url::getUrl('remove', '', '', $params);
		$build = Url::getUrl('build', '', '', $params);

		$params['column_name'] = 'trash';
		$params['value'] = 'n';
		$restore = Url::getUrl('singlemodify', '', '', $params);

		if ($data['trash'] === 'n') {
			$ret = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modify, 'Trotri.href', Text::_('MOD_GENERATOR_GENERATORS_MODIFY'))
				 . Components::getGlyphicon(Components::GLYPHICON_TRASH, $trash, 'Core.dialogTrash', Text::_('CFG_SYSTEM_GLOBAL_TRASH'))
				 . Components::getGlyphicon(Components::GLYPHICON_WRENCH, $build, 'Trotri.href', Text::_('CFG_SYSTEM_URLS_GENERATOR_INDEX_BUILD_LABEL'));
		}
		else {
			$ret = Components::getGlyphicon(Components::GLYPHICON_OK_SIGN, $restore, 'Trotri.href', Text::_('CFG_SYSTEM_GLOBAL_RESTORE'))
				 . Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $remove, 'Core.dialogRemove', Text::_('CFG_SYSTEM_GLOBAL_REMOVE'));
		}

		return $ret;
	}

	/**
	 * 获取列表页“生成代码名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getGeneratorNameUrl($data)
	{
		$params = array(
			'id' => $data['generator_id']
		);

		return Components::getHtml()->a($data['generator_name'], Url::getUrl('modify', 'index', 'generator', $params));
	}
}
