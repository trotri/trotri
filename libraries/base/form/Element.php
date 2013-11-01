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

use tfc\ap\ErrorException;
use tfc\ap\Singleton;

/**
 * Element abstract class file
 * 表单元素基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Element.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.form
 * @since 1.0
 */
abstract class Element
{
	/**
	 * @var string 表单元素的名称
	 */
	public $name = '';

	/**
	 * @var string 表单元素的默认值
	 */
	public $value = '';

	/**
	 * @var array 寄存表单元素属性
	 */
	public $attributes = array();

	/**
	 * @var string 表单元素的类型
	 */
	protected $_type = '';

	/**
	 * @var boolean 是否显示
	 */
	protected $_visible = true;

	/**
	 * @var boolean 是否必填
	 */
	protected $_required = false;

	/**
	 * @var boolean 是否只读
	 */
	protected $_readonly = false;

	/**
	 * 获取页面辅助类
	 * @return instance of tfc\mvc\Html
	 */
	public function getHtml()
	{
		return Singleton::getInstance('\\tfc\\mvc\\Html');
	}

	/**
	 * 获取Input框的属性
	 * @param string $name
	 * @return mixed
	 */
	public function getAttribute($name)
	{
		return isset($this->attributes[$name]) ? $this->attributes[$name] : '';
	}

	/**
	 * 魔术方法：请求set开头的方法，设置一个受保护的属性值
	 * @param string $name
	 * @param mixed $value
	 * @return base\form\Element
	 */
	public function setAttribute($name, $value)
	{
		$this->attributes[$name] = $value;
		return $this;
	}

	/**
	 * 获取表单元素的类型
	 * @return string
	 */
	public function getType()
	{
		if ($this->_type === '') {
			throw new ErrorException('Element no type is registered.');
		}

		return $this->_type;
	}

	/**
	 * 设置表单元素的类型
	 * @param string $value
	 * @return base\form\Element
	 */
	public function setType($value)
	{
		$this->_type = trim($value);
		return $this;
	}

	/**
	 * 获取是否显示
	 * @return boolean
	 */
	public function getVisible()
	{
		return $this->_visible;
	}

	/**
	 * 设置是否显示
	 * @param boolean $value
	 * @return base\form\Element
	 */
	public function setVisible($value)
	{
		$this->_visible = (boolean) $value;
		return $this;
	}

	/**
	 * 获取是否必填
	 * @return boolean
	 */
	public function getRequired()
	{
		return $this->_required;
	}

	/**
	 * 设置是否必填
	 * @param boolean $value
	 * @return base\form\Element
	 */
	public function setRequired($value)
	{
		$this->_required = (boolean) $value;
		return $this;
	}

	/**
	 * 获取是否只读
	 * @return boolean
	 */
	public function getReadonly()
	{
		return $this->_readonly;
	}

	/**
	 * 设置是否只读
	 * @param boolean $value
	 * @return base\form\Element
	 */
	public function setReadonly($value)
	{
		$this->_readonly = (boolean) $value;
		return $this;
	}

	/**
	 * 魔术方法：执行Element类，获取输出内容
	 * @return string
	 */
	public function __toString()
	{
		return $this->fetch();
	}

	/**
	 * 魔术方法：执行Element类，输出内容
	 * @return string
	 */
	public function display()
	{
		echo $this->fetch();
	}

	/**
	 * 执行Element类，获取输出内容，根据需求输出到浏览器
	 * @return string
	 */
	abstract public function fetch();
}
