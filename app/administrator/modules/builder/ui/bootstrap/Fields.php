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
 * Fields class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Fields.php 1 2014-01-19 17:52:00Z huan.song $
 * @package modules.builder.ui.bootstrap
 * @since 1.0
 */
class Fields
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
		$builderId = BuilderFactory::getModel('Fields')->getBuilderId();

		$url = Url::getUrl('index', Mvc::$controller, Mvc::$module, array('builder_id' => $builderId));
		return Components::getButtonCancel($url);
	}

	/**
	 * 获取操作图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getOperate($data)
	{
		$params = array('id' => $data['field_id']);

		$modifyUrl = Url::getUrl('modify', Mvc::$controller, Mvc::$module, $params);
		$modifyIcon = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modifyUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_GLOBAL_MODIFY'));

		$removeUrl = Url::getUrl('remove', Mvc::$controller, Mvc::$module, $params);
		$removeIcon = Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $removeUrl, Components::JSFUNC_DIALOGREMOVE, Text::_('CFG_SYSTEM_GLOBAL_REMOVE'));

		$ret = $modifyIcon . $removeIcon;
		return $ret;
	}

	/**
	 * 获取列表页“字段名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getFieldNameUrl($data)
	{
		$params = array('id' => $data['field_id']);

		return Components::getHtml()->a($data['field_name'], Url::getUrl('modify', Mvc::$controller, Mvc::$module, $params));
	}

	/**
	 * 通过builder_id获取builder_name值
	 * @param integer $value
	 * @return string
	 */
	public function getBuilderNameByBuilderId($value)
	{
		return BuilderFactory::getModel('Fields')->getBuilderNameByBuilderId($value);
	}

	/**
	 * 通过group_id获取group_name值
	 * @param array $data
	 * @return array
	 */
	public function getGroupNameByGroupId($data)
	{
		return BuilderFactory::getModel('Groups')->getGroupNameByGroupId($data['group_id']);
	}

	/**
	 * 通过type_id获取type_name值
	 * @param array $data
	 * @return string
	 */
	public function getTypeNameByTypeId($data)
	{
		return BuilderFactory::getModel('types')->getTypeNameByTypeId($data['type_id']);
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

		$modifyUrl = Url::getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$ret = Components::getSwitch($data['field_id'], 'column_auto_increment', $data['column_auto_increment'], $modifyUrl);
		return $ret;
	}

	/**
	 * 获取字段验证图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getBuilderFieldValidatorsLabel($data)
	{
		$params = array(
			'field_id' => $data['field_id']
		);

		$indexUrl = Url::getUrl('index', 'validators', Mvc::$module, $params);
		$indexIcon = Components::getGlyphicon(Components::GLYPHICON_LIST, $indexUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_URLS_BUILDER_VALIDATORS_INDEX_LABEL'));

		$createUrl = Url::getUrl('create', 'validators', Mvc::$module, $params);
		$createIcon = Components::getGlyphicon(Components::GLYPHICON_PLUS_SIGN, $createUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_URLS_BUILDER_VALIDATORS_CREATE_LABEL'));

		$ret = $indexIcon . $createIcon;
		return $ret;
	}
}
