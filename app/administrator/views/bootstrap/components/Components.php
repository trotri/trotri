<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace ui\bootstrap;

/**
 * Components class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Components.php 1 2013-05-18 14:58:59Z huan.song $
 * @package ui.bootstrap
 * @since 1.0
 */
class Components
{
	/**
	 * 获取表单的“保存”按钮信息
	 * @return array
	 */
	public static function getButtonSave()
	{
		$return = self::getHttpReturn();
		$return = String::urlencode($return);
		$output = array(
			'type'      => 'button',
			'label'     => self::_('UI_BOOTSTRAP_SAVE'),
			'glyphicon' => self::GLYPHICON_SAVE,
			'class'     => 'btn btn-primary',
			'onclick'   => 'return Core.formSubmit(this, \'' . self::SUBMIT_TYPE_SAVE . '\', \'' . $return . '\');'
		);

		return $output;
	}

	/**
	 * 获取表单的“保存并关闭”按钮信息
	 * @return array
	 */
	public static function getButtonSaveClose()
	{
		$return = self::getHttpReturn();
		$return = String::urlencode($return);
		$output = array(
			'type'      => 'button',
			'label'     => self::_('UI_BOOTSTRAP_SAVE_CLOSE'),
			'glyphicon' => self::GLYPHICON_OK_SIGN,
			'class'     => 'btn btn-default',
			'onclick'   => 'return Core.formSubmit(this, \'' . self::SUBMIT_TYPE_SAVE_CLOSE . '\', \'' . $return . '\');'
		);

		return $output;
	}

	/**
	 * 获取表单的“保存并新建”按钮信息
	 * @return array
	 */
	public static function getButtonSaveNew()
	{
		$output = array(
			'type'      => 'button',
			'label'     => self::_('UI_BOOTSTRAP_SAVE_NEW'),
			'glyphicon' => self::GLYPHICON_PLUS_SIGN,
			'class'     => 'btn btn-default',
			'onclick'   => 'return Core.formSubmit(this, \'' . self::SUBMIT_TYPE_SAVE_NEW . '\', \'\');'
		);

		return $output;
	}

	/**
	 * 获取表单的“取消”按钮信息
	 * @param string $url
	 * @return array
	 */
	public static function getButtonCancel($url)
	{
		if (($return = self::getHttpReturn()) !== '') {
			$url = $return;
		}

		$output = array(
			'type'      => 'button',
			'label'     => self::_('UI_BOOTSTRAP_CANCEL'),
			'glyphicon' => self::GLYPHICON_REMOVE_SIGN,
			'class'     => 'btn btn-danger',
			'onclick'   => 'return Trotri.href(\'' . $url . '\');'
		);

		return $output;
	}

	/**
	 * 获取美化版“是|否”选择项表单元素
	 * @param integer $id
	 * @param string $name
	 * @param string $value
	 * @param string $url
	 * @return string
	 */
	public static function getSwitch($id, $name, $value = 'n', $url = '')
	{
		$attributes = array(
			'id'             => 'label_switch_' . $name . '_' . $id,
			'name'           => 'label_switch',
			'class'          => 'make-switch switch-small',
			'data-on-label'  => self::_('UI_BOOTSTRAP_YES'),
			'data-off-label' => self::_('UI_BOOTSTRAP_NO'),
		);

		if ($url !== '') {
			$url = self::applyHttpReturn($url);
			$attributes['href'] = $url;
		}

		$html = self::getHtml();
		return $html->tag('div', $attributes, $html->checkbox($name, $value, ($value === 'y')));
	}

	/**
	 * 获取Glyphicons图标按钮和工具提示
	 * @param string $type
	 * @param string $url
	 * @param string $func
	 * @param string $title
	 * @param string $placement
	 * @return string
	 */
	public static function getGlyphicon($type, $url, $func, $title, $placement = 'left')
	{
		$url = self::applyHttpReturn($url);
		$click = $func . '(\'' . $url . '\')';
		$attributes = array(
			'class'               => 'glyphicon glyphicon-' . $type,
			'data-toggle'         => 'tooltip',
			'data-placement'      => $placement,
			'data-original-title' => $title,
			'onclick'             => 'return ' . $click . ';'
		);

		return self::getHtml()->tag('span', $attributes, '');
	}

	/**
	 * 在URL后拼接http_return参数
	 * @param string $url
	 * @return string
	 */
	public static function applyHttpReturn($url)
	{
		if (($return = self::getHttpReturn()) !== '') {
			$params = array('http_return' => $return);
			$url = Mvc::getView()->getUrlManager()->applyParams($url, $params);
		}

		return $url;
	}

	/**
	 * 获取返回列表页面链接
	 * @return string
	 */
	public static function getHttpReturn()
	{
		return Ap::getRequest()->getParam('http_return', '');
	}

	/**
	 * 获取页面辅助类
	 * @return tfc\mvc\Html
	 */
	public static function getHtml()
	{
		if (self::$_html === null) {
			self::$_html = Mvc::getView()->getHtml();
		}

		return self::$_html;
	}
}
