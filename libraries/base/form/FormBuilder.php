<?php
/**
 * Trotri Base Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace base\form;

use tfc\mvc\Widget;

/**
 * FormBuilder class file
 * 表单处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FormBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package base
 * @since 1.0
 */
class FormBuilder extends Widget
{
	public $name = '';

	public $action = '';

	public $method = 'post';

	public $class = 'form-horizontal';

	public $values = array();

	public $errors = array();

	/**
	 * @var string 页面布局
	 */
	public $layout = "{tabs}\n{buttons}\n{inputs}\n{buttons}";

	/**
	 * @var array 寄存表单属性
	 */
	protected $_attributes = array();

	protected $_multipart = false;

	protected $_tabs = array(
		0 => array('name' => 'main', 'prompt' => '主要信息', 'active' => true)
	);

	protected $_inputs = array();

	protected $_buttons = array();
	
	public function run()
	{
		$output = array(
			'{tabs}' => $this->renderTabs(),
			'{buttons}' => $this->renderButtons(),
			'{inputs}' => $this->renderInputs(),
		);

		return $this->openForm() . strtr($this->layout, $output) . $this->closeForm();
	}

	public function renderTabs()
	{		
		$html = $this->getHtml();
		$output = $html->openTag('ul', array('class' => 'nav nav-tabs'));

		$tabs = $this->getTabs(); sort($tabs);
		foreach ($tabs as $tab) {
			$attributes = $tab['active'] ? array('class' => 'active') : array();
			$output .= $html->tag('li', $attributes, $html->a($tab['prompt'], '#' . $tab['name'], array('data-toggle' => 'tab')));
		}

		$output .= $html->closeTag('ul') . '<!-- /.nav nav-tabs -->';
		return $output;
	}
	
	public function renderButtons()
	{
		$html = $this->getHtml();
		$output = $html->openTag('div', array('class' => 'form-group'));
		$output .= $html->tag('div', array('class' => 'col-lg-1'), '');
		$output .= $html->openTag('div', array('class' => 'col-lg-11'));

		$buttons = $this->getButtons();
		foreach ($buttons as $button) {
			$output .= $button->fetch();
		}

		$output .= $html->closeTag('div');
		$output .= $html->closeTag('div') . '<!-- /.form-group -->';
		
		return $output;
	}
	
	public function renderInputs()
	{
		$html = $this->getHtml();
		$output = $html->openTag('div', array('class' => 'tab-content'));

		$tabs = $this->getTabs(); sort($tabs);
		foreach ($tabs as $tab) {
			$output .= $html->openTag('div', array('id' => $tab['name'], 'class' => 'tab-pane fade' . ($tab['active'] ? ' active in' : '')));
			$inputs = $this->getInputs($tab['name']);
			foreach ($inputs as $input) {
				$output .= $input->fetch();
			}

			$output .= $html->closeTag('div');
		}

		$output .= $html->closeTag('div') . '<!-- /.tab-content -->';
		return $output;
	}

	public function getInputs($tabName)
	{
		return $this->_inputs[$tabName];
	}

	public function addInput($tabName, Element $element, array $attributes = array())
	{
		foreach ($attributes as $name => $value) {
			$element->$name = $value;
		}

		$name = $element->getName();
		if (isset($this->values[$name])) {
			$element->value = $this->values[$name];
		}

		if (isset($this->errors[$name])) {
			$element->error = $this->errors[$name];
		}

		$this->_inputs[$tabName] = $element;
		return $this;
	}

	public function getButtons()
	{
		return $this->_buttons;
	}

	public function addButton(Element $element, array $attributes = array())
	{
		foreach ($attributes as $name => $value) {
			$element->$name = $value;
		}

		$this->_buttons[] = $element;
		return $this;
	}

	public function getTabs()
	{
		return $this->_tabs;
	}

	public function addTab($sort, $name, $prompt, $active = false)
	{
		$this->_tabs[$sort] = array(
			'name' => $name,
			'prompt' => $prompt,
			'active' => (boolean) $active
		);

		return $this;
	}

	public function openForm()
	{
		$this->setAttribute('name', $this->name);
		$this->setAttribute('class', $this->class);

		if ($this->getMultipart()) {
			return $this->getHtml()->openFormMultipart($this->action, $this->getAttributes());
		}

		return $this->getHtml()->openForm($this->action, $this->method, $this->getAttributes());
	}

	public function closeForm()
	{
		return $this->getHtml()->closeForm();
	}

	public function getMultipart()
	{
		return $this->_multipart;
	}

	public function setMultipart($value)
	{
		$this->_multipart = (boolean) $value;
		return $this;
	}

	/**
	 * 获取所有的表单属性
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->_attributes;
	}

	/**
	 * 获取表单属性
	 * @param string $name
	 * @return mixed
	 */
	public function getAttribute($name)
	{
		return isset($this->_attributes[$name]) ? $this->_attributes[$name] : '';
	}

	/**
	 * 设置表单属性
	 * @param string $name
	 * @param mixed $value
	 * @return base\form\FormBuilder
	 */
	public function setAttribute($name, $value)
	{
		$this->_attributes[$name] = $value;
		return $this;
	}
}
