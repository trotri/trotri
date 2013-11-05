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
	 * @var array 表单元素最外层HTML标签属性
	 */
	protected $_wrapTag = array(
		'name' => 'div',
		'attributes' => array('class' => 'form-group')
	);

	/**
	 * @var array 表单元素Label-HTML标签属性
	 */
	protected $_labelTag = array(
		'name' => 'label',
		'attributes' => array('class' => 'col-lg-2 control-label')
	);

	/**
	 * @var array 表单元素Input-HTML标签属性
	 */
	protected $_inputTag = array(
		'name' => 'div',
		'attributes' => array('class' => 'col-lg-4')
	);

	/**
	 * @var array 表单元素用户输入提示和错误提示-HTML标签属性
	 */
	protected $_promptTag = array(
		'name' => 'span',
		'attributes' => array('class' => 'control-label')
	);
}
