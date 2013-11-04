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

/**
 * ICheckboxElement class file
 * 美化版Checkbox表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ICheckboxElement.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library.form
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
	 * @see library\form.IRadioElement::getInput()
	 */
	public function getInput()
	{
		$name = $this->getName(true);

		if (strpos($name, '[') === false) {
			$this->setName($name . '[]');
		}

		return parent::getInput();
	}
}
