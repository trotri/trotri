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
 * ICheckboxElement class file
 * 美化版Checkbox表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ICheckboxElement.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.form
 * @since 1.0
 */
class ICheckboxElement extends IRadioElement
{
	/**
	 * @var string 表单元素的类型
	 */
	protected $_type = 'checkbox';

	/**
	 * (non-PHPdoc)
	 * @see base\form.InputElement::getInput()
	 */
	public function getInput()
	{
		if (strpos($this->name, '[') === false) {
			$this->name .= '[]';
		}

		return parent::getInput();
	}
}
