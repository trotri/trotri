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
 * Validators class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Validators.php 1 2014-01-20 15:58:15Z huan.song $
 * @package modules.builder.ui.bootstrap
 * @since 1.0
 */
class Validators
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
		$fieldId = BuilderFactory::getModel('Validators')->getFieldId();

		$url = Url::getUrl('index', Mvc::$controller, Mvc::$module, array('field_id' => $fieldId));
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
			'id' => $data['validator_id'],
			'field_id' => $data['field_id']
		);

		$modifyUrl = Url::getUrl('modify', Mvc::$controller, Mvc::$module, $params);
		$modifyIcon = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modifyUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_GLOBAL_MODIFY'));

		$removeUrl = Url::getUrl('remove', Mvc::$controller, Mvc::$module, $params);
		$removeIcon = Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $removeUrl, Components::JSFUNC_DIALOGREMOVE, Text::_('CFG_SYSTEM_GLOBAL_REMOVE'));

		$ret = $modifyIcon . $removeIcon;
		return $ret;
	}

	/**
	 * 获取列表页“验证类名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getValidatorNameUrl($data)
	{
		$params = array(
			'id' => $data['validator_id'],
		);

		return Components::getHtml()->a($data['validator_name'], Url::getUrl('modify', Mvc::$controller, Mvc::$module, $params));
	}

	/**
	 * 获取列表页“字段名”标签
	 * @param array $data
	 * @return string
	 */
	public function getFieldNameByFieldId($data)
	{
		return BuilderFactory::getModel('Fields')->getFieldNameByFieldId($data['field_id']);
	}

	/**
	 * 获取“验证时对比值类型”值
	 * @param array $data
	 * @return string
	 */
	public function getOptionCategoryLabel($data)
	{
		$elements = BuilderFactory::getElements('Validators');
		$categories = $elements->getOptionCategory($elements::TYPE_OPTIONS);
		return $categories[$data['option_category']];
	}

	/**
	 * 获取“验证环境”值
	 * @param array $data
	 * @return string
	 */
	public function getWhenLabel($data)
	{
		$elements = BuilderFactory::getElements('Validators');
		$whens = $elements->getWhen($elements::TYPE_OPTIONS);
		return $whens[$data['when']];
	}
}
