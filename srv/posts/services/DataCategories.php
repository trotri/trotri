<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace posts\services;

use posts\library\Lang;

/**
 * DataCategories class file
 * 业务层：数据管理类，寄存常量、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataCategories.php 1 2014-09-12 15:48:15Z Code Generator $
 * @package posts.services
 * @since 1.0
 */
class DataCategories
{
	/**
	 * @var string 菜单是否隐藏：y
	 */
	const IS_HIDE_Y = 'y';

	/**
	 * @var string 菜单是否隐藏：n
	 */
	const IS_HIDE_N = 'n';

	/**
	 * @var string 是否跳转：y
	 */
	const IS_JUMP_Y = 'y';

	/**
	 * @var string 是否跳转：n
	 */
	const IS_JUMP_N = 'n';

	/**
	 * @var string 是否生成静态页面：y
	 */
	const IS_HTML_Y = 'y';

	/**
	 * @var string 是否生成静态页面：n
	 */
	const IS_HTML_N = 'n';

	/**
	 * 获取“菜单是否隐藏”所有选项
	 * @return array
	 */
	public static function getIsHideEnum()
	{
		static $enum = null;

		if ($enum === null) {
			$enum = array(
				self::IS_HIDE_Y => Lang::_('SRV_ENUM_GLOBAL_YES'),
				self::IS_HIDE_N => Lang::_('SRV_ENUM_GLOBAL_NO'),
			);
		}

		return $enum;
	}

	/**
	 * 获取“是否跳转”所有选项
	 * @return array
	 */
	public static function getIsJumpEnum()
	{
		static $enum = null;

		if ($enum === null) {
			$enum = array(
				self::IS_JUMP_Y => Lang::_('SRV_ENUM_GLOBAL_YES'),
				self::IS_JUMP_N => Lang::_('SRV_ENUM_GLOBAL_NO'),
			);
		}

		return $enum;
	}

	/**
	 * 获取“是否生成静态页面”所有选项
	 * @return array
	 */
	public static function getIsHtmlEnum()
	{
		static $enum = null;

		if ($enum === null) {
			$enum = array(
				self::IS_HTML_Y => Lang::_('SRV_ENUM_GLOBAL_YES'),
				self::IS_HTML_N => Lang::_('SRV_ENUM_GLOBAL_NO'),
			);
		}

		return $enum;
	}

}
