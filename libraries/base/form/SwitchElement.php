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
 * SwitchElement class file
 * 是否选择表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SwitchElement.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.form
 * @since 1.0
 */
class SwitchElement extends InputElement
{
	/**
	 * @var boolean 是否被选中
	 */
	public $checked = false;

	/**
	 * @var string 表单元素的样式
	 */
	public $class = 'make-switch switch-small';

	/**
	 * @var string 选项ID
	 */
	public $id = 'label-switch';

	/**
	 * @var string 选项“是”标签
	 */
	public $on = '是';

	/**
	 * @var string 选项“否”标签
	 */
	public $off = '否';

	/**
	 * @var string 表单元素的类型
	 */
	protected $_type = 'radio';

	/**
	 * (non-PHPdoc)
	 * @see base\form.InputElement::getInput()
	 */
	public function getInput()
	{
		$attributes = array(
			'id'             => $this->id,
			'class'          => $this->class,
			'data-on-label'  => $this->on,
			'data-off-label' => $this->off
		);

		$method = $this->getType();
		$output = $this->openInput() . "\n"
				. $this->getHtml()->openTag('div', $attributes) . "\n"
				. $this->getHtml()->$method($this->name, $this->value, $this->checked) . "\n"
				. $this->getHtml()->closeTag('div') . "\n"
				. $this->closeInput();

		return $output;
	}
}
