<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use tfc\ap\Ap;
use tfc\mvc\Action;

/**
 * BaseAction abstract class file
 * Action基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseAction.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
abstract class BaseAction extends Action
{
	/**
	 * @var array 项目支持的语言种类
	 */
	protected $_languageTypes = array('zh-CN', 'en-GB');

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Action::_init()
	 */
	protected function _init()
	{
		$this->_initLanguageType();
	}

	/**
	 * 初始化输出的语言种类
	 * @return void
	 */
	protected function _initLanguageType()
	{
		// 从RGP中获取‘ol’的值（output language type），并验证是否合法
		$languageType = Ap::getRequest()->getTrim('ol');
		if ($languageType !== '') {
			if (in_array($languageType, $this->_languageTypes)) {
				// 以RGP中指定的输出语种为主
				Ap::setLanguageType($languageType);
			}
		}
	}
}
