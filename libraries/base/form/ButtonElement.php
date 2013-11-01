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
 * ButtonElement class file
 * 按钮类表单元素，button、submit、reset等
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ButtonElement.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.form
 * @since 1.0
 */
class ButtonElement extends Element
{
	/**
	 * @var string Label名
	 */
	public $label = '';

	/**
	 * @var string 按钮的CSS类
	 */
	public $class = 'btn btn-default';

	/**
	 * @var string JS点击函数
	 */
	public $func = '';

	/**
	 * @var string Glyphicon名
	 */
	public $glyphicon = '';

	/**
	 * (non-PHPdoc)
	 * @see base\form.Element::fetch()
	 */
	public function fetch()
	{
		return $this->openButton() . "\n" . $this->getGlyphicon() . $this->label . $this->closeButton();
	}

	/**
	 * 获取Button的开始标签
	 * @return string
	 */
	public function openButton()
	{
		return $this->getHtml()->openTag('button', array('type' => 'button', 'class' => $this->class, 'onclick' => $this->func));
	}

	/**
	 * 获取Button的结束标签
	 * @return string
	 */
	public function closeButton()
	{
		return $this->getHtml()->closeTag('button');
	}

	/**
	 * 获取Glyphicon-HTML
	 * @return string
	 */
	public function getGlyphicon()
	{
		return $this->getHtml()->tag('span', array('class' => 'glyphicon glyphicon-' . $this->glyphicon));
	}
}
