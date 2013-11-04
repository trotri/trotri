<?php
/**
 * Trotri Foundation Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tfc\mvc\form;

use tfc\mvc\Widget;

/**
 * FormBuilder class file
 * 表单处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FormBuilder.php 1 2013-03-29 16:48:06Z huan.song $
 * @package tfc.mvc.form
 * @since 1.0
 */
class FormBuilder extends Widget
{
	/**
	 * @var string 表单的名称
	 */
	public $name = '';

	/**
	 * @var string 表单的提交链接
	 */
	public $action = '';

	/**
	 * @var string 表单的提交方式
	 */
	public $method = 'post';

	/**
	 * @var array 寄存表单属性
	 */
	public $attributes = array();

	/**
	 * @var boolean 数据是否二进制提交
	 */
	public $multipart = false;

	/**
	 * @var array 寄存表单元素的默认值
	 */
	public $values = array();

	/**
	 * @var array 寄存所有表单元素的错误提示
	 */
	public $errors = array();

	/**
	 * @var array 表单元素分类标签
	 */
	protected $_tabs = array();

	/**
	 * @var array 寄存所有输入框和字符串类表单元素
	 */
	protected $_inputElements = array();

	/**
	 * @var array 寄存所有按钮类表单元素
	 */
	protected $_buttonElements = array();

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::run()
	 */
	public function run()
	{
		$this->sortTabs();

		$this->assign('tabRender', $this->renderTab());
		$this->assign('inputRender', $this->renderInput());
		$this->assign('buttonRender', $this->renderButton());
		$this->assign('openForm', $this->openForm());
		$this->assign('closeForm', $this->closeForm());
		$this->display();
	}

	/**
	 * 获取所有输入框和字符串类表单元素
	 * @param string $tabId
	 * @return array
	 */
	public function getInputElements($tabId = null)
	{
		if ($tabId !== null) {
			return isset($this->_inputElements[$tabId]) ? $this->_inputElements[$tabId] : array();
		}

		return $this->_inputElements;
	}

	/**
	 * 添加输入框和字符串类表单元素
	 * @param Element $element
	 * @param string $tabId
	 * @return tfc\mvc\form\FormBuilder
	 */
	public function addInputElement(Element $element, $tabId = null)
	{
		$name = $element->getName(true);

		if (isset($this->values[$name])) {
			$element->value = $this->values[$name];
		}

		if (isset($this->errors[$name])) {
			$element->error = $this->errors[$name];
		}

		if ($tabId !== null) {
			$this->_inputElements[$tabId] = $element;
		}
		else {
			$this->_inputElements[] = $element;
		}

		return $this;
	}

	/**
	 * 获取所有的按钮类表单元素
	 * @return array
	 */
	public function getButtonElements()
	{
		return $this->_buttonElements;
	}

	/**
	 * 添加按钮类表单元素
	 * @param ButtonElement $element
	 * @return tfc\mvc\form\FormBuilder
	 */
	public function addButtonElement(ButtonElement $element)
	{
		$this->_buttonElements[] = $element;
		return $this;
	}

	/**
	 * 获取所有的输入框分类
	 * @return array
	 */
	public function getTabs()
	{
		return $this->_tabs;
	}

	/**
	 * 通过ID获取输入框分类
	 * @param string $tabId
	 * @return array
	 */
	public function getTabById($tabId)
	{
		$tabs = $this->getTabs();
		foreach ($tabs as $tab) {
			if ($tab['tab_id'] === $tabId) {
				return $tab;
			}
		}

		return null;
	}

	/**
	 * 获取所有的输入框分类
	 * @return tfc\mvc\form\FormBuilder
	 */
	public function sortTabs()
	{
		ksort($this->_tabs);
		return $this;
	}

	/**
	 * 添加输入框分类，数字越小排序越靠前
	 * @param integer $sort
	 * @param string $tabId
	 * @param string $prompt
	 * @param boolean $active
	 * @return tfc\mvc\form\FormBuilder
	 */
	public function addTab($sort, $tabId, $prompt, $active = false)
	{
		if (($tabId = trim((string) $tabId)) === '') {
			return $this;
		}

		$sort = (int) $sort;
		if (isset($this->_tabs[$sort])) {
			return $this->addTab($sort + 1, $tabId, $prompt, $active);
		}

		$this->_tabs[$sort] = array(
			'tab_id' => $tabId,
			'prompt' => $prompt,
			'active' => (boolean) $active
		);

		return $this;
	}

	/**
	 * 获取Form开始标签
	 * @return string
	 */
	public function openForm()
	{
		$this->attributes['name'] = $this->name;
		if ($this->multipart) {
			return $this->getHtml()->openFormMultipart($this->action, $this->attributes);
		}

		return $this->getHtml()->openForm($this->action, $this->method, $this->attributes);
	}

	/**
	 * 获取Form结束标签
	 * @return string
	 */
	public function closeForm()
	{
		return $this->getHtml()->closeForm();
	}

	/**
	 * 获取输入框HTML
	 * @param string $tabId
	 * @return string
	 */
	public function renderInput($tabId = null)
	{
		$output = '';
		$tabs = $this->getTabs();
		if ($tabs && $tabId === null) {
			foreach ($tabs as $tab) {
				$output .= $this->renderInput($tab['tab_id']);
			}
		}
		else {
			$output .= $this->openInput($tabId);
			$inputElements = $this->getInputElements($tabId);
			foreach ($inputElements as $inputElement) {
				$output .= $inputElement->fetch();
			}

			$output .= $this->closeInput();
		}

		return $output;
	}

	/**
	 * 获取按钮HTML
	 * @return string
	 */
	public function renderButton()
	{
		$output = '';
		$buttonElements = $this->getButtonElements();
		foreach ($buttonElements as $buttonElement) {
			$output .= $buttonElement->fetch();
		}

		return $output;
	}

	/**
	 * 获取分类-HTML
	 * @return string
	 */
	public function renderTab()
	{
		return '';
	}

	/**
	 * 获取某个输入框分类的外开始标签
	 * @param string $tabId
	 * @return string
	 */
	public function openInput($tabId = null)
	{
		return '';
	}

	/**
	 * 获取某个输入框分类的外结束标签
	 * @return string
	 */
	public function closeInput()
	{
		return '';
	}
}
