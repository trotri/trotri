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

use tfc\ap\ErrorException;

/**
 * InputElement class file
 * 输入框类表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: InputElement.php 1 2013-03-29 16:48:06Z huan.song $
 * @package tfc.mvc.form
 * @since 1.0
 */
class InputElement extends Element
{
	/**
	 * @var array 选项类表单元素多选项值，array('value' => 'prompt')
	 */
	public $options = array();

	/**
	 * @var string Label名
	 */
	public $label = '';

	/**
	 * @var string 用户输入提示
	 */
	public $hint = '';

	/**
	 * @var string 错误提示
	 */
	public $error = '';

	/**
	 * @var string 页面布局，{prompt}是{hint}或{error}其中之一
	 */
	public $layout = "{label}\n{input}\n{prompt}";

	/**
	 * @var string 错误提示样式名
	 */
	protected $_errorClassName = '';

	/**
	 * @var string 隐藏表单样式名
	 */
	protected $_hiddenClassName = '';

	/**
	 * @var array 表单元素最外层HTML标签属性
	 */
	protected $_wrapTag = array(
		'name' => '',
		'attributes' => array('class' => '')
	);

	/**
	 * @var array 表单元素Label-HTML标签属性
	 */
	protected $_labelTag = array(
		'name' => '',
		'attributes' => array('class' => '')
	);

	/**
	 * @var array 表单元素Input-HTML标签属性
	 */
	protected $_inputTag = array(
		'name' => '',
		'attributes' => array('class' => '')
	);

	/**
	 * @var array 表单元素用户输入提示和错误提示-HTML标签属性
	 */
	protected $_promptTag = array(
		'name' => '',
		'attributes' => array('class' => '')
	);

	/**
	 * @var boolean 是否显示
	 */
	protected $_visible = true;

	/**
	 * @var boolean 是否必填
	 */
	protected $_required = false;

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.Element::fetch()
	 */
	public function fetch()
	{
		$output = array(
			'{label}' => $this->getLabel(),
			'{input}' => $this->openInput() . $this->getInput() . $this->closeInput(),
			'{prompt}' => $this->getPrompt(),
		);

		return $this->openWrap() . strtr($this->layout, $output) . $this->closeWrap();
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.Element::getInput()
	 */
	public function getInput()
	{
		$type = $this->getType();
		$name = $this->getName(true);
		$attributes = $this->getAttributes();
		$html = $this->getHtml();

		$output = '';
		if ($type === 'select') {
			$output .= $html->openSelect($name, $attributes);
			$output .= $html->options($this->options, $this->value);
			$output .= $html->closeSelect();
		}
		elseif ($type === 'radio' || $type === 'checkbox') {
			foreach ($this->options as $value => $prompt) {
				$checked = ($value === $this->value) ? true : false;
				$output .= $html->$type($name, $value, $checked, $attributes) . $prompt;
			}
		}
		else {
			$output .= $html->$type($name, $this->value, $attributes);
		}

		return $output;
	}

	/**
	 * 获取Label-HTML
	 * @return string
	 */
	public function getLabel()
	{
		$content = $this->label . ($this->getRequired() ? ' *' : '');
		$name = isset($this->_labelTag['name']) ? $this->_labelTag['name'] : '';
		if ($name === '') {
			return $content;
		}

		$attributes = isset($this->_labelTag['attributes']) ? $this->_labelTag['attributes'] : array();
		return $this->getHtml()->tag($name, $attributes, $content);
	}

	/**
	 * 获取Prompt(Hint|Error)-HTML
	 * @return string
	 */
	public function getPrompt()
	{
		$content = $this->hasError() ? $this->error : $this->hint;
		$name = isset($this->_promptTag['name']) ? $this->_promptTag['name'] : '';
		if ($name === '') {
			return $content;
		}

		$attributes = isset($this->_promptTag['attributes']) ? $this->_promptTag['attributes'] : array();
		return $this->getHtml()->tag($name, $attributes, $content);
	}

	/**
	 * 获取表单元素最外层HTML开始标签
	 * @return string
	 */
	public function openWrap()
	{
		$name = isset($this->_wrapTag['name']) ? $this->_wrapTag['name'] : '';
		if ($name === '') {
			return '';
		}

		$attributes = isset($this->_wrapTag['attributes']) ? $this->_wrapTag['attributes'] : array();
		if ($this->hasError() && $this->_errorClassName !== '') {
			$attributes['class'] .= ' ' . $this->_errorClassName;
		}
		if (!$this->getVisible() && $this->_hiddenClassName !== '') {
			$attributes['class'] .= ' ' . $this->_hiddenClassName;
		}

		return $this->getHtml()->openTag($name, $attributes) . "\n";
	}

	/**
	 * 获取表单元素最外层HTML结束标签
	 * @return string
	 */
	public function closeWrap()
	{
		$name = isset($this->_wrapTag['name']) ? $this->_wrapTag['name'] : '';
		if ($name === '') {
			return '';
		}

		return "\n" . $this->getHtml()->closeTag($name);
	}

	/**
	 * 获取表单元素Input-HTML开始标签
	 * @return string
	 */
	public function openInput()
	{
		$name = isset($this->_inputTag['name']) ? $this->_inputTag['name'] : '';
		if ($name === '') {
			return '';
		}

		$attributes = isset($this->_inputTag['attributes']) ? $this->_inputTag['attributes'] : array();
		return $this->getHtml()->openTag($name, $attributes) . "\n";
	}

	/**
	 * 获取表单元素Input-HTML结束标签
	 * @return string
	 */
	public function closeInput()
	{
		$name = isset($this->_inputTag['name']) ? $this->_inputTag['name'] : '';
		if ($name === '') {
			return '';
		}

		return "\n" . $this->getHtml()->closeTag($name);
	}

	/**
	 * 判定是否有错误提示
	 * @return boolean
	 */
	public function hasError()
	{
		return $this->error !== '';
	}

	/**
	 * 获取是否显示
	 * @return boolean
	 */
	public function getVisible()
	{
		return $this->_visible;
	}

	/**
	 * 设置是否显示
	 * @param boolean $value
	 * @return tfc\mvc\form\InputElement
	 */
	public function setVisible($value)
	{
		$this->_visible = (boolean) $value;
		return $this;
	}

	/**
	 * 获取是否必填
	 * @return boolean
	 */
	public function getRequired()
	{
		return $this->_required;
	}

	/**
	 * 设置是否必填
	 * @param boolean $value
	 * @return tfc\mvc\form\InputElement
	 */
	public function setRequired($value)
	{
		$this->_required = (boolean) $value;
		return $this;
	}
}
