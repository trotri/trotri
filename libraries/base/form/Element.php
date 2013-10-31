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
	 * @var string 文本输入类表单元素，如：text、textarea、password等
	 */
	const CATEGORY_TEXT = 'text';

	/**
	 * @var string 选项类表单元素，如：radio、checkbox、select等
	 */
	const CATEGORY_OPTION = 'option';

	/**
	 * @var string 按钮类表单元素，如：button、submit、reset等
	 */
	const CATEGORY_BUTTON = 'button';

	/**
	 * @var array 将表单元素的类型归类
	 */
	public static $categories = array (
		self::CATEGORY_TEXT,
		self::CATEGORY_OPTION,
		self::CATEGORY_BUTTON
	);

	/**
	 * @var string 表单元素的类型所属的大类别
	 */
	public $category = '';

	/**
	 * @var string 表单元素的类型
	 */
	public $type = '';

	/**
	 * @var string 表单元素的名称
	 */
	public $name = '';

	/**
	 * @var string 表单元素的默认值
	 */
	public $value = '';

	/**
	 * @var string Label
	 */
	public $label = '';

	/**
	 * @var string 用户输入提示
	 */
	public $prompt = '';

	/**
	 * @var string 错误提示
	 */
	public $errMsg = '';

	/**
	 * @var boolean 是否必填
	 */
	public $required = false;

	/**
	 * @var boolean 是否只读
	 */
	public $readonly = false;

	/**
	 * @var integer label标签所占的列数，默认2列
	 */
	public $labelColumns = 2;

	/**
	 * @var integer 表单元素所占的列数，默认4列
	 */
	public $mainColumns = 4;

	/**
	 * 构造方法：初始化表单元素参数
	 * @param string $name
	 * @param string $label
	 * @param string $value
	 * @param string $errMsg
	 * @param string $prompt
	 * @param boolean $required
	 * @param boolean $readonly
	 */
	public function __construct($name, $label, $value = '', $errMsg = '', $prompt = '', $required = false, $readonly = false)
	{
		$this->name = $name;
		$this->label = $label;
		$this->value = $value;
		$this->errMsg = $errMsg;
		$this->prompt = $prompt;
		$this->required = (boolean) $required;
		$this->readonly = (boolean) $readonly;
	}

	/**
	 * 获取主Div的HTML
	 * @return string
	 */
	public function getWrap()
	{
		return $this->openWrap() . $this->getLabel() . $this->getMain() . $this->getPrompt() . $this->closeWrap();
	}

	/**
	 * 获取主Div的开始标签
	 * @return string
	 */
	public function openWrap()
	{
		return $this->html->openTag('div', array('class' => 'form-group' . ($this->hasError() ? ' has-error' : '')));
	}

	/**
	 * 获取主Div的结束标签
	 * @return string
	 */
	public function closeWrap()
	{
		return $this->html->closeTag('div');
	}

	/**
	 * 获取表单元素HTML
	 * @return string
	 */
	public function getMain()
	{
		return $this->html->tag('div', array('class' => 'col-lg-' . $this->mainColumns), $this->getInput());
	}

	/**
	 * 获取标题HTML
	 * @return string
	 */
	public function getLabel()
	{
		return $this->html->tag('label', array('class' => 'col-lg-' . $this->labelColumns . ' control-label'), $this->label . ($this->required ? ' *' : ''));
	}

	/**
	 * 获取用户输入提示或错误提示HTML
	 * @return string
	 */
	public function getPrompt()
	{
		return $this->html->tag('span', array('class' => 'control-label'), $this->hasError() ? $this->errMsg : $this->prompt);
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
	 * 判定是否有错误提示
	 * @return boolean
	 */
	public function hasError()
	{
		return $this->errMsg !== '';
	}

	/**
	 * 判定表单元素的类型所属的大类别是否是文本输入类
	 * @return boolean
	 */
	public function isCategoryText()
	{
		return $this->category === self::CATEGORY_TEXT;
	}

	/**
	 * 判定表单元素的类型所属的大类别是否是选项类
	 * @return boolean
	 */
	public function isCategoryOption()
	{
		return $this->category === self::CATEGORY_OPTION;
	}

	/**
	 * 判定表单元素的类型所属的大类别是否是按钮类
	 * @return boolean
	 */
	public function isCategoryButton()
	{
		return $this->category === self::CATEGORY_BUTTON;
	}

	/**
	 * 获取表单元素，需要通过子类重写
	 * @return string
	 */
	abstract public function getInput();
}
