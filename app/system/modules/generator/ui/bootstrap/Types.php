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
use tfc\saf\Text;
use library\Url;

/**
 * Types class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Types.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.ui.bootstrap
 * @since 1.0
 */
class Types
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
		$url = Url::getUrl('index', 'types', 'generator');
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
			'id' => $data['type_id'],
		);

		$modify = Url::getUrl('modify', 'types', 'generator', $params);
		$remove = Url::getUrl('remove', 'types', 'generator', $params);
		$ret = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modify, 'Trotri.href', Text::_('MOD_GENERATOR_GENERATOR_FIELD_TYPES_MODIFY'))
			 . Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $remove, 'Core.dialogRemove', Text::_('CFG_SYSTEM_GLOBAL_REMOVE'));

		return $ret;
	}

	/**
	 * 获取列表页“类型名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getTypeNameUrl($data)
	{
		$params = array(
			'id' => $data['type_id'],
		);

		return Components::getHtml()->a($data['type_name'], Url::getUrl('modify', 'types', 'generator', $params));
	}
}
