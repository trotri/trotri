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
 * InputElement class file
 * 输入框类表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: InputElement.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library.form
 * @since 1.0
 */
class InputElement extends form\InputElement
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
	 * @see tfc\mvc\form.InputElement::getLabel()
	 */
	public function getLabel()
	{
		return $this->getHtml()->tag('label', array('class' => $this->labelClassName), parent::getLabel());
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::getPrompt()
	 */
	public function getPrompt()
	{
		return $this->getHtml()->tag('span', array('class' => $this->promptClassName), parent::getPrompt());
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::openWrap()
	 */
	public function openWrap()
	{
		return $this->getHtml()->openTag('div',
			array('class' => 'form-group' . ($this->hasError() ? ' has-error' : '') . ($this->getVisible() ? '' : ' hidden'))
		) . "\n";
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::openInput()
	 */
	public function openInput()
	{
		return $this->getHtml()->openTag('div', array('class' => $this->inputClassName)) . "\n";
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::closeInput()
	 */
	public function closeInput()
	{
		return "\n" . $this->getHtml()->closeTag('div');
	}
}
