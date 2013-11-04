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
 * ButtonElement class file
 * 按钮类表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ButtonElement.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library.form
 * @since 1.0
 */
class ButtonElement extends form\ButtonElement
{
	/**
	 * @var string Label名
	 */
	public $label = '';

	/**
	 * @var string Glyphicon名
	 */
	public $glyphicon = '';

	/**
	 * @var string 表单元素样式名
	 */
	protected $_class = 'btn btn-default';

	/**
	 * @var string 表单元素的类型
	 */
	protected $_type = 'button';

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.ButtonElement::fetch()
	 */
	public function fetch()
	{
		return $this->openButton() . $this->getGlyphicon() . $this->label . $this->closeButton();
	}

	/**
	 * 获取Button的开始标签
	 * @return string
	 */
	public function openButton()
	{
		$this->setAttribute('type', $this->getType());
		if (!$this->hasAttribute('class')) {
			$this->setAttribute('class', $this->_class);
		}

		return $this->getHtml()->openTag('button', $this->getAttributes()) . "\n";
	}

	/**
	 * 获取Button的结束标签
	 * @return string
	 */
	public function closeButton()
	{
		return "\n" . $this->getHtml()->closeTag('button');
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
