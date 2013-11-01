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
 * TextElement class file
 * Text表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TextElement.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.form
 * @since 1.0
 */
class TextElement extends InputElement
{
	/**
	 * @var string 表单元素的样式
	 */
	public $class = 'form-control input-sm';

	/**
	 * @var string 表单元素的类型
	 */
	protected $_type = 'text';

	/**
	 * (non-PHPdoc)
	 * @see base\form.InputElement::getInput()
	 */
	public function getInput()
	{
		$this->setAttribute('class', $this->class);

		$method = $this->getType();
		$output = $this->openInput() . "\n" 
				. $this->getHtml()->$method($this->name, $this->value, $this->attributes) . "\n"
				. $this->closeInput();

		return $output;
	}
}
