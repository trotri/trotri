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

/**
 * StringElement abstract class file
 * 字符类表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: StringElement.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.form
 * @since 1.0
 */
class StringElement extends Element
{
	/**
	 * @var string Label名
	 */
	public $label = '';

	/**
	 * (non-PHPdoc)
	 * @see base\form.Element::fetch()
	 */
	public function fetch()
	{
		return $this->openWrap() . "\n" . $this->getLabel() . "\n" . $this->getValue() . $this->closeWrap();
	}

	/**
	 * 获取主Div的开始标签
	 * @return string
	 */
	public function openWrap()
	{
		return $this->getHtml()->openTag('div', array('class' => 'form-group'));
	}

	/**
	 * 获取主Div的结束标签
	 * @return string
	 */
	public function closeWrap()
	{
		return $this->getHtml()->closeTag('div');
	}

	/**
	 * 获取Label-HTML
	 * @return string
	 */
	public function getLabel()
	{
		return $this->getHtml()->tag('label', array('class' => 'col-lg-2 control-label'), $this->label);
	}

	/**
	 * 获取Value-HTML
	 * @return string
	 */
	public function getValue()
	{
		return $this->getHtml()->tag('div', array('class' => 'col-lg-4'), $this->value);
	}
}
