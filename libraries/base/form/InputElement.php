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
 * InputElement abstract class file
 * 文本类表单元素基类，text、textarea、password等
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: InputElement.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.form
 * @since 1.0
 */
abstract class InputElement extends Element
{
	/**
	 * @var string Label名
	 */
	public $label = '';

	/**
	 * @var string 用户输入提示
	 */
	public $hint = '';

	/**
	 * @var string 错误提示
	 */
	public $error = '';

	/**
	 * @var array 选项类表单元素多选项值，array('value' => 'prompt')
	 */
	public $options = array();

	/**
	 * @var string 页面布局，{prompt}是{hint}或{error}其中之一
	 */
	public $layout = "{label}\n{input}\n{prompt}";

	/**
	 * (non-PHPdoc)
	 * @see base\form.Element::fetch()
	 */
	public function fetch()
	{
		$output = array(
			'{label}' => $this->getLabel(),
			'{input}' => $this->getInput(),
			'{prompt}' => $this->getPrompt(),
		);

		return $this->openWrap() . "\n" . strtr($this->layout, $output) . "\n" . $this->closeWrap();
	}

	/**
	 * 获取主Div的开始标签
	 * @return string
	 */
	public function openWrap()
	{
		return $this->getHtml()->openTag('div', array('class' => 'form-group' . ($this->hasError() ? ' has-error' : '')));
	}

	/**
	 * 获取主Div的结束标签
	 * @return string
	 */
	public function closeWrap()
	{
		return $this->getHtml()->closeTag('div');
	}

	/**
	 * 获取Label-HTML
	 * @return string
	 */
	public function getLabel()
	{
		return $this->getHtml()->tag('label', array('class' => 'col-lg-2 control-label'), $this->label . ($this->getRequired() ? ' *' : ''));
	}

	/**
	 * 获取Prompt(Hint|Error)-HTML
	 * @return string
	 */
	public function getPrompt()
	{
		return $this->getHtml()->tag('span', array('class' => 'control-label'), $this->hasError() ? $this->error : $this->hint);
	}

	/**
	 * 判定是否有错误提示
	 * @return boolean
	 */
	public function hasError()
	{
		return $this->error !== '';
	}

	/**
	 * 获取主Div的开始标签
	 * @return string
	 */
	public function openInput()
	{
		return $this->getHtml()->openTag('div', array('class' => 'col-lg-4'));
	}

	/**
	 * 获取主Div的结束标签
	 * @return string
	 */
	public function closeInput()
	{
		return $this->getHtml()->closeTag('div');
	}

	/**
	 * 获取Input-HTML
	 * @return string
	 */
	abstract public function getInput();
}
