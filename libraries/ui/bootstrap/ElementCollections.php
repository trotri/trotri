<?php
/**
 * Trotri Ui Bootstrap
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace ui\bootstrap;

use ui;

/**
 * ElementCollections abstract class file
 * 字段信息寄存基类，包括表格、表单、验证规则、选项，基于Bootstrap-v3框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ElementCollections.php 1 2013-05-18 14:58:59Z huan.song $
 * @package ui.bootstrap
 * @since 1.0
 */
abstract class ElementCollections extends ui\ElementCollections
{
	/**
	 * @var string 取消表单时跳转的URL
	 */
	protected $_buttonCancelHref = '';

	/**
	 * 获取表单的“保存”按钮信息
	 * @param integer $type
	 * @return array
	 */
	public function getButtonSave($type)
	{
		$output = array();

		$name = 'button_save';

		if ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'button',
				'label' => Components::_('UI_BOOTSTRAP_SAVE'),
				'glyphicon' => 'save',
				'class' => 'btn btn-primary',
				'onclick' => "return Core.formSubmit(this, 'save');"
			);
		}

		return $output;
	}

	/**
	 * 获取表单的“保存并关闭”按钮信息
	 * @param integer $type
	 * @return array
	 */
	public function getButtonSaveClose($type)
	{
		$output = array();

		$name = 'button_save_close';

		if ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'button',
				'label' => Components::_('UI_BOOTSTRAP_SAVE_CLOSE'),
				'glyphicon' => 'ok-sign',
				'class' => 'btn btn-default',
				'onclick' => "return Core.formSubmit(this, 'save_close');"
			);
		}

		return $output;
	}

	/**
	 * 获取表单的“保存并新建”按钮信息
	 * @param integer $type
	 * @return array
	 */
	public function getButtonSaveNew($type)
	{
		$output = array();

		$name = 'button_save_new';

		if ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'button',
				'label' => Components::_('UI_BOOTSTRAP_SAVE_NEW'),
				'glyphicon' => 'plus-sign',
				'class' => 'btn btn-default',
				'onclick' => "return Core.formSubmit(this, 'save_new');"
			);
		}

		return $output;
	}

	/**
	 * 获取表单的“取消”按钮信息
	 * @param integer $type
	 * @return array
	 */
	public function getButtonCancel($type)
	{
		$output = array();

		$name = 'button_cancel';

		if ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'button',
				'label' => Components::_('UI_BOOTSTRAP_CANCEL'),
				'glyphicon' => 'remove-sign',
				'class' => 'btn btn-danger',
				'onclick' => 'return Core.href(\'' . $this->_buttonCancelHref . '\');'
			);
		}

		return $output;
	}
}
