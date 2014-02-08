<?php
/**
 * Trotri Ui
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\form;

use ui\bootstrap\form;

/**
 * ICheckboxElement class file
 * 美化版Checkbox表单元素，，基于Bootstrap-v3前端开发框架的iCheck插件
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ICheckboxElement.php 1 2013-05-18 14:58:59Z huan.song $
 * @package ui.bootstrap.form
 * @since 1.0
 */
class ICheckboxElement extends form\ICheckboxElement
{
	/**
	 * @var string 表单元素的类型
	 */
	protected $_type = 'checkbox';

	/**
	 * (non-PHPdoc)
	 * @see ui\bootstrap\form.ICheckboxElement::getInput()
	 */
	public function getInput()
	{
		$name = $this->getName(true);
		$this->setAttribute('class', 'icheck');

		$type = $this->getType();
		$attributes = $this->getAttributes();
		$values = (array) $this->value;
		$html = $this->getHtml();

		$tagName = 'label';
		$tagAttributes = array('class' => 'checkbox-inline');
		$ctrlOptions = array_slice($this->options, 0, 1);
		$actOptions = array_slice($this->options, 1);

		$ctrlOutput = '';
		foreach ($ctrlOptions as $value => $prompt) {
			$ctrlOutput .= $html->tag($tagName, $tagAttributes, $prompt);
			$ctrlOutput .= $html->tag($tagName, $tagAttributes, $html->$type($name, $value, false, $attributes));
		}

		$output = $ctrlOutput;

		$count = 0;
		foreach ($actOptions as $value => $prompt) {
			if ($count++ % 4 === 0) {
				$output .= '<br/>';
			}

			$checked = (in_array($value, $values)) ? true : false;
			$output .= $html->tag($tagName, $tagAttributes, $html->$type($name, $value, $checked, $attributes));
			$output .= $html->tag($tagName, $tagAttributes, $prompt);
		}

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see ui\bootstrap\form.InputElement::openLabel()
	 */
	public function openLabel()
	{
		return '';
	}

	/**
	 * (non-PHPdoc)
	 * @see ui\bootstrap\form.InputElement::closeLabel()
	 */
	public function closeLabel()
	{
		return '';
	}

	/**
	 * (non-PHPdoc)
	 * @see ui\bootstrap\form.InputElement::openPrompt()
	 */
	public function openPrompt()
	{
		return '';
	}

	/**
	 * (non-PHPdoc)
	 * @see ui\bootstrap\form.InputElement::closePrompt()
	 */
	public function closePrompt()
	{
		return '';
	}
}
