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
 * IRadioElement class file
 * 美化版Radio表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: IRadioElement.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.form
 * @since 1.0
 */
class IRadioElement extends InputElement
{
	/**
	 * @var string 表单元素的样式
	 */
	public $irClass = 'checkbox-inline';

	/**
	 * @var string 表单元素的类型
	 */
	protected $_type = 'radio';

	/**
	 * @var string 表单元素样式名
	 */
	protected $_class = 'icheck';

	/**
	 * (non-PHPdoc)
	 * @see base\form.Element::getInput()
	 */
	public function getInput()
	{
		$html = $this->getHtml();
		$type = $this->getType();
		$this->setAttribute('class', $this->_class);

		$output = '';
		foreach ($this->options as $value => $prompt) {
			$checked = (($value === $this->value) ? true : false);
			$output .= $html->$type($this->name, $value, $checked, $this->attributes);
			$output .= $html->tag('label', $this->attributes, $prompt);
		}

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see base\form.InputElement::openInput()
	 */
	public function openInput()
	{
		return '';
	}

	/**
	 * (non-PHPdoc)
	 * @see base\form.InputElement::closeInput()
	 */
	public function closeInput()
	{
		return '';
	}
}
