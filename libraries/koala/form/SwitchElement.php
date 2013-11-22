<?php
/**
 * Trotri Koala
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace koala\form;

/**
 * SwitchElement class file
 * 美化版“是|否”选择项表单元素，基于Bootstrap-CSS框架的switch开关控件
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SwitchElement.php 1 2013-05-18 14:58:59Z huan.song $
 * @package koala.form
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
	public $swClass = 'make-switch switch-small';

	/**
	 * @var string 选项ID
	 */
	public $swId = 'label_switch';

	/**
	 * @var string 选项“是”标签
	 */
	public $swOn = '是';

	/**
	 * @var string 选项“否”标签
	 */
	public $swOff = '否';

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::getInput()
	 */
	public function getInput()
	{
		$name = $this->getName(true);
		
		$attributes = array(
			'id'             => $this->swId . '_' . $name,
			'class'          => $this->swClass,
			'data-on-label'  => $this->swOn,
			'data-off-label' => $this->swOff
		);

		if ($this->value === 'y') {
			$this->checked = true;
		}

		$html = $this->getHtml();
		return $html->tag('div', $attributes, $html->checkbox($name, $this->value, $this->checked));
	}
}
