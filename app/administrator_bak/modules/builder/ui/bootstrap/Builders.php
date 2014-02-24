<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\ui\bootstrap;

use ui\bootstrap\Components;
use tfc\ap\Ap;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Url;
use library\BuilderFactory;

/**
 * Builders class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builders.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.ui.bootstrap
 * @since 1.0
 */
class Builders
{
	/**
	 * 获取表单的“保存”按钮
	 * @return array
	 */
	public function getButtonSave()
	{
		return Components::getButtonSave();
	}

	/**
	 * 获取表单的“保存并关闭”按钮
	 * @return array
	 */
	public function getButtonSaveClose()
	{
		return Components::getButtonSaveClose();
	}

	/**
	 * 获取表单的“保存并新建”按钮
	 * @return array
	 */
	public function getButtonSaveNew()
	{
		return Components::getButtonSaveNew();
	}

	/**
	 * 获取表单的“取消”按钮
	 * @return array
	 */
	public function getButtonCancel()
	{
		$url = Url::getUrl('index', Mvc::$controller, Mvc::$module);
		return Components::getButtonCancel($url);
	}

	/**
	 * 获取操作图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getOperate($data)
	{
		$params = array('id' => $data['builder_id']);

		$modifyUrl = Url::getUrl('modify', Mvc::$controller, Mvc::$module, $params);
		$modifyIcon = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modifyUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_GLOBAL_MODIFY'));

		$trashUrl = Url::getUrl('trash', Mvc::$controller, Mvc::$module, $params);
		$trashIcon = Components::getGlyphicon(Components::GLYPHICON_TRASH, $trashUrl, Components::JSFUNC_DIALOGTRASH, Text::_('CFG_SYSTEM_GLOBAL_TRASH'));

		$removeUrl = Url::getUrl('remove', Mvc::$controller, Mvc::$module, $params);
		$removeIcon = Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $trashUrl, Components::JSFUNC_DIALOGREMOVE, Text::_('CFG_SYSTEM_GLOBAL_REMOVE'));

		$gcUrl = Url::getUrl('gc', Mvc::$controller, Mvc::$module, $params);
		$gcIcon = Components::getGlyphicon(Components::GLYPHICON_WRENCH, $gcUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_URLS_BUILDER_INDEX_GC_LABEL'));

		$params['column_name'] = 'trash';
		$params['value'] = 'n';
		$restoreUrl = Url::getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$restoreIcon = Components::getGlyphicon(Components::GLYPHICON_OK_SIGN, $restoreUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_GLOBAL_RESTORE'));

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
	public function getBuilderNameUrl($data)
	{
		$params = array('id' => $data['builder_id']);

		return Components::getHtml()->a($data['builder_name'], Url::getUrl('modify', Mvc::$controller, Mvc::$module, $params));
	}

	/**
	 * 获取列表页“是否生成扩展表”美化版“是|否”选择项表单元素
	 * @param array $data
	 * @return string
	 */
	public function getTblProfileSwitchLabel($data)
	{
		if ($data['trash'] === 'y') {
			$elements = BuilderFactory::getElements('Builders');
			$tblProfiles = $elements->getTblProfile($elements::TYPE_OPTIONS);
			return $tblProfiles[$data['tbl_profile']];
		}

		$params = array(
			'id' => $data['builder_id'],
			'column_name' => 'tbl_profile'
		);

		$modifyUrl = Url::getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$ret = Components::getSwitch($data['builder_id'], 'tbl_profile', $data['tbl_profile'], $modifyUrl);
		return $ret;
	}

	/**
	 * 获取字段组图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getBuilderFieldGroupsLabel($data)
	{
		$params = array(
			'builder_id' => $data['builder_id']
		);

		$indexUrl = Url::getUrl('index', 'groups', Mvc::$module, $params);
		$indexIcon = Components::getGlyphicon(Components::GLYPHICON_LIST, $indexUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_URLS_BUILDER_GROUPS_INDEX_LABEL'));

		$createUrl = Url::getUrl('create', 'groups', Mvc::$module, $params);
		$createIcon = Components::getGlyphicon(Components::GLYPHICON_PLUS_SIGN, $createUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_URLS_BUILDER_GROUPS_CREATE_LABEL'));

		$ret = $indexIcon . $createIcon;
		return $ret;
	}

	/**
	 * 获取表单字段图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getBuilderFieldsLabel($data)
	{
		$params = array(
			'builder_id' => $data['builder_id']
		);

		$indexUrl = Url::getUrl('index', 'fields', Mvc::$module, $params);
		$indexIcon = Components::getGlyphicon(Components::GLYPHICON_LIST, $indexUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_URLS_BUILDER_FIELDS_INDEX_LABEL'));

		$createUrl = Url::getUrl('create', 'fields', Mvc::$module, $params);
		$createIcon = Components::getGlyphicon(Components::GLYPHICON_PLUS_SIGN, $createUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_URLS_BUILDER_FIELDS_CREATE_LABEL'));

		$ret = $indexIcon . $createIcon;
		return $ret;
	}
}
