<?php
/**
 * Trotri Base Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
namespace library\form;

use tfc\mvc\form;

/**
 * StringElement class file
 * 按钮类表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: StringElement.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library.form
 * @since 1.0
 */
class StringElement extends form\StringElement
{
	/**
	 * @var string Label样式名
	 */
	public $labelClassName = 'col-lg-2 control-label';

	/**
	 * @var string 输入框表单元素样式名
	 */
	public $inputClassName = 'col-lg-4';

	/**
	 * @var string 提示样式名
	 */
	public $promptClassName = 'control-label';

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.StringElement::getInput()
	 */
	public function getInput()
	{
		return $this->getHtml()->tag('div', array('class' => $this->inputClassName), $this->value);
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.StringElement::getLabel()
	 */
	public function getLabel()
	{
		return $this->getHtml()->tag('label', array('class' => $this->labelClassName), $this->label);
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.StringElement::openWrap()
	 */
	public function openWrap()
	{
		return $this->getHtml()->openTag('div', array('class' => 'form-group')) . "\n";
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.StringElement::closeWrap()
	 */
	public function closeWrap()
	{
		return "\n" . $this->getHtml()->closeTag('div');
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.StringElement::openInput()
	 */
	public function openInput()
	{
		return $this->getHtml()->openTag('div', array('class' => $this->inputClassName)) . "\n";
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.StringElement::closeInput()
	 */
	public function closeInput()
	{
		return "\n" . $this->getHtml()->closeTag('div');
	}
}
