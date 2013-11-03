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
	 * @var string 表单元素的默认值
	 */
	public $value = '';

	/**
	 * @var array 选项类表单元素多选项值，array('value' => 'prompt')
	 */
	public $options = array();

	/**
	 * @var array 寄存表单元素属性
	 */
	protected $_attributes = array();

	/**
	 * @var array Input方法支持的类型
	 */
	protected $_types = array(
		'text' => '|text|password|hidden|file|textarea|',
		'button' => '|button|submit|reset|image|',
		'option' => '|radio|checkbox|select|'
	);

	/**
	 * @var string 表单元素的类型
	 */
	protected $_type = '';

	/**
	 * @var string 表单元素的名称
	 */
	protected $_name = '';

	/**
	 * @var boolean 是否显示
	 */
	protected $_visible = true;

	/**
	 * @var boolean 是否必填
	 */
	protected $_required = false;

	/**
	 * @var string 表单元素样式名
	 */
	protected $_class = '';

	/**
	 * @var boolean 表单元素是否只读
	 */
	protected $_readonly = false;

	/**
	 * @var boolean 表单元素是否禁用
	 */
	protected $_disabled = false;

	/**
	 * 获取Input-HTML
	 * @return string
	 */
	public function getInput()
	{
		$html = $this->getHtml();
		$type = $this->getType();
		$attributes = $this->getAttributes();

		$output = '';
		if ($this->isText()) {
			$output .= $html->$type($this->name, $this->value, $attributes);
		}
		elseif ($this->isButton()) {
			$output .= $html->$type($this->value, $this->name, $attributes);
		}
		elseif ($this->isOption()) {
			if ($type === 'select') {
				$output .= $html->openSelect($this->name, $attributes);
				$output .= $html->options($this->options, $this->value);
				$output .= $html->closeSelect();
			}
			else {
				foreach ($this->options as $value => $prompt) {
					$checked = (($value === $this->value) ? true : false);
					$output .= $html->$type($this->name, $value, $checked, $attributes) . $prompt;
				}
			}
		}

		return $output;
	}

	/**
	 * 获取页面辅助类
	 * @return instance of tfc\mvc\Html
	 */
	public function getHtml()
	{
		return Singleton::getInstance('\\tfc\\mvc\\Html');
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
	 * 获取表单元素的名称
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}

	/**
	 * 设置表单元素的名称
	 * @param string $value
	 * @return base\form\Element
	 */
	public function setName($value)
	{
		$this->_name = trim($value);
		return $this;
	}

	/**
	 * 魔术方法：请求get开头的方法，获取一个受保护的属性值
	 * @param string $name
	 * @return mixed
	 * @throws ErrorException 如果该属性名的getter方法不存在并且attributes键不存在，抛出异常
	 */
	public function __get($name)
	{
		$method = 'get' . $name;
		if (method_exists($this, $method)) {
			return $this->$method();
		}
		elseif ($this->hasAttribute($name)) {
			return $this->getAttribute($name);
		}
		else {
			throw new ErrorException(sprintf(
				'Property "%s.%s" was not defined and "attributes.%s" was not exists.', get_class($this), $method, $name
			));
		}
	}

	/**
	 * 魔术方法：请求set开头的方法，设置一个受保护的属性值
	 * @param string $name
	 * @param mixed $value
	 * @return void
	 */
	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if (method_exists($this, $method)) {
			return $this->$method($value);
		}
		else {
			return $this->setAttribute($name, $value);
		}
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
	 * 获取所有的表单元素属性
	 * @return array
	 */
	public function getAttributes()
	{
		if (!$this->hasAttribute('class') && $this->getClass() !== '') {
			$this->setAttribute('class', $this->getClass());
		}

		if (!$this->hasAttribute('readonly') && $this->getReadonly()) {
			$this->setAttribute('readonly', 'true');
		}

		if (!$this->hasAttribute('disabled') && $this->getDisabled()) {
			$this->setAttribute('disabled', 'true');
		}

		return $this->_attributes;
	}

	/**
	 * 获取表单元素属性是否存在
	 * @param string $name
	 * @return boolean
	 */
	public function hasAttribute($name)
	{
		return isset($this->_attributes[$name]);
	}

	/**
	 * 获取表单元素属性
	 * @param string $name
	 * @return mixed
	 */
	public function getAttribute($name)
	{
		return isset($this->_attributes[$name]) ? $this->_attributes[$name] : '';
	}

	/**
	 * 设置表单元素属性
	 * @param string $name
	 * @param mixed $value
	 * @return base\form\Element
	 */
	public function setAttribute($name, $value)
	{
		$this->_attributes[$name] = $value;
		return $this;
	}

	/**
	 * 获取表单元素样式名
	 * @return string
	 */
	public function getClass()
	{
		return $this->_class;
	}

	/**
	 * 设置表单元素样式名
	 * @param string $value
	 * @return base\form\Element
	 */
	public function setClass($value)
	{
		$this->_class = $value;
		return $this;
	}

	/**
	 * 获取表单元素是否只读
	 * @return boolean
	 */
	public function getReadonly()
	{
		return $this->_readonly;
	}

	/**
	 * 设置表单元素是否只读
	 * @param boolean $value
	 * @return base\form\Element
	 */
	public function setReadonly($value)
	{
		$this->_readonly = (boolean) $value;
		return $this;
	}

	/**
	 * 获取表单元素是否禁用
	 * @return boolean
	 */
	public function getDisabled()
	{
		return $this->_disabled;
	}

	/**
	 * 设置表单元素是否禁用
	 * @param boolean $value
	 * @return base\form\Element
	 */
	public function setDisabled($value)
	{
		$this->_disabled = (boolean) $value;
		return $this;
	}

	/**
	 * 获取是否是文本类型Input
	 * @return boolean
	 */
	public function isText()
	{
		return strpos($this->_types['text'], '|' . $this->getType() . '|');
	}

	/**
	 * 获取是否是按钮类型Input
	 * @return boolean
	 */
	public function isButton()
	{
		return strpos($this->_types['button'], '|' . $this->getType() . '|');
	}

	/**
	 * 获取是否是选项类型Input
	 * @return boolean
	 */
	public function isOption()
	{
		return strpos($this->_types['option'], '|' . $this->getType() . '|');
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
