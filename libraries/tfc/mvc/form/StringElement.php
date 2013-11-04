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
 * StringElement class file
 * 字符串类表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: StringElement.php 1 2013-03-29 16:48:06Z huan.song $
 * @package tfc.mvc.form
 * @since 1.0
 */
class StringElement extends Element
{
	/**
	 * @var string Label名
	 */
	public $label = '';

	/**
	 * @var string 页面布局
	 */
	public $layout = "{label}\n{input}";

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.Element::fetch()
	 */
	public function fetch()
	{
		$output = array(
			'{label}' => $this->getLabel(),
			'{input}' => $this->openInput() . $this->getInput() . $this->closeInput(),
		);

		return $this->openWrap() . strtr($this->layout, $output) . $this->closeWrap();
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.Element::getInput()
	 */
	public function getInput()
	{
		return $this->value;
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
	 * 获取主Div的外开始标签
	 * @return string
	 */
	public function openWrap()
	{
		return $this->getHtml()->openTag('div',
			array('style' => ($this->getVisible() ? '' : ' display: none;'))
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
