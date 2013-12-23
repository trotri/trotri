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

use tfc\ap\Ap;
use tfc\ap\Registry;
use tfc\saf\Text;
use ui\bootstrap\Components;
use library\GeneratorFactory;
use library\Url;

/**
 * Groups class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.ui.bootstrap
 * @since 1.0
 */
class Groups
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
		$generatorId = Ap::getRequest()->getInteger('generator_id');

		$url = Url::getUrl('index', 'groups', 'generator', array('generator_id' => $generatorId));
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
			'id' => $data['group_id'],
			'generator_id' => $data['generator_id']
		);

		$modify = Url::getUrl('modify', 'groups', 'generator', $params);
		$remove = Url::getUrl('remove', 'groups', 'generator', $params);
		$ret = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modify, 'Trotri.href', Text::_('MOD_GENERATOR_GENERATOR_FIELD_GROUPS_MODIFY'))
			 . Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $remove, 'Core.dialogRemove', Text::_('CFG_SYSTEM_GLOBAL_REMOVE'));

		return $ret;
	}

	/**
	 * 获取列表页“生成代码名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getGroupNameUrl($data)
	{
		$params = array(
			'id' => $data['group_id'],
			'generator_id' => $data['generator_id']
		);

		return Components::getHtml()->a($data['group_name'], Url::getUrl('modify', 'groups', 'generator', $params));
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
}
