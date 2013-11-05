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
use tfc\ap\ErrorException;

/**
 * FormBuilder abstract class file
 * 表单处理基类，需要加载模板文件才能生成表单
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FormBuilder.php 1 2013-03-29 16:48:06Z huan.song $
 * @package tfc.mvc.form
 * @since 1.0
 */
abstract class FormBuilder extends Widget
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
	 * @var boolean 表单数据是否二进制提交
	 */
	public $multipart = false;

	/**
	 * @var array 寄存所有表单元素的默认值
	 */
	public $values = array();

	/**
	 * @var array 寄存所有表单元素的错误提示
	 */
	public $errors = array();

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
    	$this->assign('form_inputs', $this->getInputs());
    	$this->assign('form_buttons', $this->getButtons());

    	$this->assign('form_open', $this->openForm());
    	$this->assign('form_close', $this->closeForm());

    	$this->display();
    }

	/**
	 * 获取一组输入框HTML
	 * @param string $id
	 * @return string
	 */
	public function getInputs($id = '')
	{
		$output = $this->openInputs($id);
		$inputElements = $this->getInputElements($id);
		foreach ($inputElements as $inputElement) {
			$output .= $inputElement->fetch();
		}

		$output .= $this->openInputs();
		return $output;
	}

	/**
	 * 获取所有按钮HTML
	 * @return string
	 */
	public function getButtons()
	{
		$output = '';
		$buttonElements = $this->getButtonElements();
		foreach ($buttonElements as $buttonElement) {
			$output .= $buttonElement->fetch();
		}

		return $output;
	}

	/**
	 * 获取所有输入框和字符串类表单元素
	 * @param string $id
	 * @return array
	 */
	public function getInputElements($id = '')
	{
		if ($id !== '') {
			return isset($this->_inputElements[$id]) ? $this->_inputElements[$id] : array();
		}

		return $this->_inputElements;
	}

	/**
	 * 添加输入框和字符串类表单元素
	 * @param InputElement $element
	 * @param string $id
	 * @return tfc\mvc\form\FormBuilder
	 */
	public function addInputElement(InputElement $element, $id = '')
	{
		$name = $element->getName(true);

		if (isset($this->values[$name])) {
			$element->value = $this->values[$name];
		}

		if (isset($this->errors[$name])) {
			$element->error = $this->errors[$name];
		}

		if ($id !== '') {
			$this->_inputElements[$id] = $element;
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
	 * 设置多个表单元素
	 * @param array $elements
	 * @return tfc\mvc\form\FormBuilder
	 * @throws ErrorException 如果获取的实例不是tfc\mvc\form\InputElement或tfc\mvc\form\ButtonElement类的子类，抛出异常
	 */
	public function setElements(array $elements = array())
	{
		foreach ($elements as $element) {
			if (!isset($element['className'])) {
				continue;
			}

			$className = $element['className'];
			$id = isset($element['id']) ? $element['id'] : '';
			$config = isset($element['config']) ? $element['config'] : array();

			$instance = $this->createElement($className, $config);
			if ($instance instanceof InputElement) {
				$this->addInputElement($instance, $id);
			}
			elseif ($instance instanceof ButtonElement) {
				$this->addButtonElement($instance);
			}
			else {
				throw new ErrorException(sprintf(
					'Filter Element class "%s" is not instanceof tfc\mvc\form\InputElement or tfc\mvc\form\ButtonElement.', $className
				));
			}
		}

		return $this;
	}

	/**
	 * 创建表单元素类
	 * @param string $className
	 * @param array $config
	 * @return tfc\mvc\form\Element
	 * @throws ErrorException 如果Element类不存在，抛出异常
	 * @throws ErrorException 如果获取的实例不是tfc\mvc\form\Element类的子类，抛出异常
	 */
	public function createElement($className, array $config = array())
	{
		if (!class_exists($className)) {
			throw new ErrorException(sprintf(
				'FormBuilder is unable to find the requested element "%s".', $className
			));
		}

		$instance = new $className($config);
		if (!$instance instanceof Element) {
			throw new ErrorException(sprintf(
				'Filter Element class "%s" is not instanceof tfc\mvc\form\Element.', $className
			));
		}

		return $instance;
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
	 * 获取一组输入框外开始标签
	 * @param string $id
	 * @return string
	 */
	public function openInputs($id = '')
	{
		return '';
	}

	/**
	 * 获取一组输入框外结束标签
	 * @return string
	 */
	public function closeInputs()
	{
		return '';
	}
}
