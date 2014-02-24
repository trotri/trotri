<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\ui\bootstrap;

use ui\bootstrap\Components;
use tfc\ap\Ap;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Url;
use library\UcenterFactory;

/**
 * Amcas class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-01-22 16:43:52Z huan.song $
 * @package modules.ucenter.ui.bootstrap
 * @since 1.0
 */
class Amcas
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
		$appId = UcenterFactory::getModel('Amcas')->getAmcaPid();
		if ($appId <= 0) {
			$appId = Ap::getRequest()->getInteger('id');
		}

		$url = Url::getUrl('index', Mvc::$controller, Mvc::$module, array('app_id' => $appId));
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
			'id' => $data['amca_id']
		);

		$modifyUrl = Url::getUrl('modify', Mvc::$controller, Mvc::$module, $params);
		$modifyIcon = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modifyUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_GLOBAL_MODIFY'));

		$removeUrl = Url::getUrl('remove', Mvc::$controller, Mvc::$module, $params);
		$removeIcon = Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $removeUrl, Components::JSFUNC_DIALOGREMOVE, Text::_('CFG_SYSTEM_GLOBAL_REMOVE'));

		$synchUrl = Url::getUrl('synch', Mvc::$controller, Mvc::$module, $params);
		$synchIcon = Components::getGlyphicon(Components::GLYPHICON_WRENCH, $synchUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_URLS_UCENTER_AMCAS_SYNCH_LABEL'));

		$viewUrl = Url::getUrl('actsview', Mvc::$controller, Mvc::$module, array('ctrl_id' => $data['amca_id']));
		$viewIcon = Components::getGlyphicon(Components::GLYPHICON_LIST, $viewUrl, Components::JSFUNC_DIALOGAJAXVIEW, Text::_('CFG_SYSTEM_URLS_UCENTER_AMCAS_ACTSVIEW_LABEL'));

		$ret = '';
		if ($data['category'] === 'app') {
			$ret = $modifyIcon . $removeIcon;
		}
		elseif ($data['category'] === 'mod') {
			$ret = $modifyIcon . $removeIcon . $synchIcon;
		}
		elseif ($data['category'] === 'ctrl') {
			$ret = $viewIcon;
		}

		return $ret;
	}

	/**
	 * 通过amca_id获取amca_name值
	 * @param array $data
	 * @return string
	 */
	public function getAmcaNameUrl($data)
	{
		if ($data['category'] === 'mod') {
			$params = array('id' => $data['amca_id']);
			return Components::getHtml()->a($data['amca_name'], Url::getUrl('modify', Mvc::$controller, Mvc::$module, $params));
		}

		return $data['amca_name'];
	}

	/**
	 * 通过amca_pid获取amca_name值
	 * @param array $data
	 * @return string
	 */
	public function getAmcaNameByAmcaPid($data)
	{
		return UcenterFactory::getModel('Amcas')->getAmcaNameByAmcaId($data['amca_pid']);
	}

	/**
	 * 获取列表页“类型”表单元素
	 * @param array $data
	 * @return string
	 */
	public function getCategoryLabel($data)
	{
		$elements = UcenterFactory::getElements('Amcas');
		$options = $elements->getCategory($elements::TYPE_OPTIONS);
		return isset($options[$data['category']]) ? $options[$data['category']] : '';
	}
}
