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
 * Validators class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Validators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.ui.bootstrap
 * @since 1.0
 */
class Validators
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
			'field_id' => Ap::getRequest()->getInteger('field_id')
		);

		$url = Url::getUrl('index', 'validators', 'generator', $params);
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

		$modify = Url::getUrl('modify', 'validators', 'generator', $params);
		$remove = Url::getUrl('remove', 'validators', 'generator', $params);

		$ret = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modify, 'Trotri.href', Text::_('MOD_GENERATOR_GENERATOR_FIELDS_MODIFY'))
			 . Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $remove, 'Core.dialogRemove', Text::_('CFG_SYSTEM_GLOBAL_REMOVE'));

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

		return Components::getHtml()->a($data['validator_name'], Url::getUrl('modify', 'validators', 'generator', $params));
	}

	/**
	 * 通过field_id获取field_name值
	 * @param array $data
	 * @return string
	 */
	public function getFieldNameByFieldId($data)
	{
		return GeneratorFactory::getModel('Fields')->getFieldNameByFieldId($data['field_id']);
	}

	/**
	 * 获取“验证时对比值类型”值
	 * @param array $data
	 * @return string
	 */
	public function getOptionCategoryLabel($data)
	{
		$elements = GeneratorFactory::getElements('validators');
		$optionCategories = $elements->getOptionCategory($elements::TYPE_OPTIONS);
		return $optionCategories[$data['option_category']];
	}

	/**
	 * 获取“验证环境”值
	 * @param array $data
	 * @return string
	 */
	public function getWhenLabel($data)
	{
		$elements = GeneratorFactory::getElements('validators');
		$whens = $elements->getWhen($elements::TYPE_OPTIONS);
		return $whens[$data['when']];
	}
}
