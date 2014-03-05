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

/**
 * Constant class file
 * 常用常量类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Constant.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Constant
{
	/**
	 * @var string 表单提交后跳转方式：保存并跳转到编辑页
	 */
	const SUBMIT_TYPE_SAVE = 'save';

	/**
	 * @var string 表单提交后跳转方式：保存并跳转到列表页
	 */
	const SUBMIT_TYPE_SAVE_CLOSE = 'save_close';

	/**
	 * @var string 表单提交后跳转方式：保存并跳转到新增页
	 */
	const SUBMIT_TYPE_SAVE_NEW = 'save_new';

	/**
	 * @var string 表单提交后默认的跳转方式
	 */
	const SUBMIT_TYPE_DEFAULT = self::SUBMIT_TYPE_SAVE;

	/**
	 * @var array 寄存表单提交后跳转方式
	 */
	public static $submitTypes = array(
		self::SUBMIT_TYPE_SAVE,
		self::SUBMIT_TYPE_SAVE_CLOSE,
		self::SUBMIT_TYPE_SAVE_NEW
	);
}
