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
 * SelectElement class file
 * Select表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SelectElement.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.form
 * @since 1.0
 */
class SelectElement extends InputElement
{
	/**
	 * @var string 表单元素的样式
	 */
	public $class = 'checkbox-inline';

	/**
	 * @var string 表单元素的类型
	 */
	protected $_type = 'select';

	/**
	 * (non-PHPdoc)
	 * @see base\form.InputElement::getInput()
	 */
	public function getInput()
	{
		$html = $this->getHtml();
		$this->setAttribute('class', $this->class);

		$method = $this->getType();
		$output = $this->openInput() . "\n"
				. $html->openSelect($this->name, $this->attributes) . "\n"
				. $html->options($this->options, $this->value) . "\n"
				. $html->closeSelect() . "\n"
				. $this->closeInput();

		return $output;
	}
}
