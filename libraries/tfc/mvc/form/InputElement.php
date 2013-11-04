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
	 * @var array 选项类表单元素多选项值，array('value' => 'prompt')
	 */
	public $options = array();

	/**
	 * @var string 页面布局，{prompt}是{hint}或{error}其中之一
	 */
	public $layout = "{label}\n{input}\n{prompt}";

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
		return $this->label . ($this->getRequired() ? ' *' : '');
	}

	/**
	 * 获取Prompt(Hint|Error)-HTML
	 * @return string
	 */
	public function getPrompt()
	{
		return $this->hasError() ? $this->error : $this->hint;
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
	 * 获取主Div的外开始标签
	 * @return string
	 */
	public function openWrap()
	{
		return $this->getHtml()->openTag('div',
			array('style' => ($this->hasError() ? ' color: red;' : '') . ($this->getVisible() ? '' : ' display: none;'))
		) . "\n";
	}

	/**
	 * 获取主Div的外结束标签
	 * @return string
	 */
	public function closeWrap()
	{
		return "\n" . $this->getHtml()->closeTag('div');
	}

	/**
	 * 获取Input-HTML的外开始标签
	 * @return string
	 */
	public function openInput()
	{
		return '';
	}

	/**
	 * 获取Input-HTML的外结束标签
	 * @return string
	 */
	public function closeInput()
	{
		return '';
	}
}
