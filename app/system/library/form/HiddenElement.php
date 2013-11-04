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
 * HiddenElement class file
 * Hidden表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: HiddenElement.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library.form
 * @since 1.0
 */
class HiddenElement extends form\Element
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.Element::fetch()
	 */
	public function fetch()
	{
		return $this->getHtml()->hidden($this->getName(true), $this->value, $this->getAttributes());
	}
}
