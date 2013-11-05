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
	 * @var string 错误提示样式名
	 */
	protected $_errorClassName = 'has-error';

	/**
	 * @var string 隐藏表单样式名
	 */
	protected $_hiddenClassName = 'hidden';

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::openWrap()
	 */
	public function openWrap()
	{
		$className = 'form-group';
		if ($this->hasError() && $this->_errorClassName !== '') {
			$className .= ' ' . $this->_errorClassName;
		}

		if ($this->getVisible() && $this->_hiddenClassName !== '') {
			$className .= ' ' . $this->_hiddenClassName;
		}

		return $this->getHtml()->openTag('div', array('class' => $className)) . "\n";
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::closeWrap()
	 */
	public function closeWrap()
	{
		return "\n" . $this->getHtml()->closeTag('div');
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::openLabel()
	 */
	public function openLabel()
	{
		return $this->getHtml()->openTag('label', array('class' => 'col-lg-2 control-label')) . "\n";
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::closeLabel()
	 */
	public function closeLabel()
	{
		return "\n" . $this->getHtml()->closeTag('label');
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::openInput()
	 */
	public function openInput()
	{
		return $this->getHtml()->openTag('div', array('class' => 'col-lg-4')) . "\n";
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::closeInput()
	 */
	public function closeInput()
	{
		return "\n" . $this->getHtml()->closeTag('div');
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::openPrompt()
	 */
	public function openPrompt()
	{
		return $this->getHtml()->openTag('span', array('class' => 'control-label')) . "\n";
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::closePrompt()
	 */
	public function closePrompt()
	{
		return "\n" . $this->getHtml()->closeTag('span');
	}
}
