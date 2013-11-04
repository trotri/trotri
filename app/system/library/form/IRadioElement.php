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

/**
 * IRadioElement class file
 * 美化版Radio表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: IRadioElement.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library.form
 * @since 1.0
 */
class IRadioElement extends InputElement
{
	/**
	 * @var string 表单元素的样式
	 */
	public $labelClassName = 'checkbox-inline';

	/**
	 * @var string 表单元素的类型
	 */
	protected $_type = 'radio';

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::getInput()
	 */
	public function getInput()
	{
		$this->setAttribute('class', 'icheck');

		$type = $this->getType();
		$name = $this->getName(true);
		$attributes = $this->getAttributes();
		$labelAttributes = array('class' => $this->labelClassName);
		$html = $this->getHtml();

		$output = '';
		foreach ($this->options as $value => $prompt) {
			$checked = ($value === $this->value) ? true : false;
			$output .= $html->tag('label', $labelAttributes, $html->$type($name, $value, $checked, $attributes));
			$output .= $html->tag('label', $labelAttributes, $prompt);
		}

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see library\form.InputElement::openInput()
	 */
	public function openInput()
	{
		return '';
	}

	/**
	 * (non-PHPdoc)
	 * @see library\form.InputElement::closeInput()
	 */
	public function closeInput()
	{
		return '';
	}
}
