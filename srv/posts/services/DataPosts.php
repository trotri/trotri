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
 * DataPosts class file
 * 业务层：数据管理类，寄存常量、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataPosts.php 1 2014-09-16 19:26:44Z Code Generator $
 * @package posts.services
 * @since 1.0
 */
class DataPosts
{
	/**
	 * @var string 是否发表：y
	 */
	const IS_PUBLIC_Y = 'y';

	/**
	 * @var string 是否发表：n
	 */
	const IS_PUBLIC_N = 'n';

	/**
	 * @var string 是否删除：y
	 */
	const TRASH_Y = 'y';

	/**
	 * @var string 是否删除：n
	 */
	const TRASH_N = 'n';

	/**
	 * @var string 是否头条：y
	 */
	const IS_HEAD_Y = 'y';

	/**
	 * @var string 是否头条：n
	 */
	const IS_HEAD_N = 'n';

	/**
	 * @var string 是否推荐：y
	 */
	const IS_RECOMMEND_Y = 'y';

	/**
	 * @var string 是否推荐：n
	 */
	const IS_RECOMMEND_N = 'n';

	/**
	 * @var string 是否跳转：y
	 */
	const IS_JUMP_Y = 'y';

	/**
	 * @var string 是否跳转：n
	 */
	const IS_JUMP_N = 'n';

	/**
	 * @var string 生成静态页面：y
	 */
	const IS_HTML_Y = 'y';

	/**
	 * @var string 生成静态页面：n
	 */
	const IS_HTML_N = 'n';

	/**
	 * @var string 是否允许评论：y
	 */
	const ALLOW_COMMENT_Y = 'y';

	/**
	 * @var string 是否允许评论：n
	 */
	const ALLOW_COMMENT_N = 'n';

	/**
	 * @var string 允许其他人编辑：y
	 */
	const ALLOW_OTHER_MODIFY_Y = 'y';

	/**
	 * @var string 允许其他人编辑：n
	 */
	const ALLOW_OTHER_MODIFY_N = 'n';

	/**
	 * 获取“是否发表”所有选项
	 * @return array
	 */
	public static function getIsPublicEnum()
	{
		static $enum = null;

		if ($enum === null) {
			$enum = array(
				self::IS_PUBLIC_Y => Lang::_('SRV_ENUM_GLOBAL_YES'),
				self::IS_PUBLIC_N => Lang::_('SRV_ENUM_GLOBAL_NO'),
			);
		}

		return $enum;
	}

	/**
	 * 获取“是否删除”所有选项
	 * @return array
	 */
	public static function getTrashEnum()
	{
		static $enum = null;

		if ($enum === null) {
			$enum = array(
				self::TRASH_Y => Lang::_('SRV_ENUM_GLOBAL_YES'),
				self::TRASH_N => Lang::_('SRV_ENUM_GLOBAL_NO'),
			);
		}

		return $enum;
	}

	/**
	 * 获取“是否头条”所有选项
	 * @return array
	 */
	public static function getIsHeadEnum()
	{
		static $enum = null;

		if ($enum === null) {
			$enum = array(
				self::IS_HEAD_Y => Lang::_('SRV_ENUM_GLOBAL_YES'),
				self::IS_HEAD_N => Lang::_('SRV_ENUM_GLOBAL_NO'),
			);
		}

		return $enum;
	}

	/**
	 * 获取“是否推荐”所有选项
	 * @return array
	 */
	public static function getIsRecommendEnum()
	{
		static $enum = null;

		if ($enum === null) {
			$enum = array(
				self::IS_RECOMMEND_Y => Lang::_('SRV_ENUM_GLOBAL_YES'),
				self::IS_RECOMMEND_N => Lang::_('SRV_ENUM_GLOBAL_NO'),
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
	 * 获取“生成静态页面”所有选项
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

	/**
	 * 获取“是否允许评论”所有选项
	 * @return array
	 */
	public static function getAllowCommentEnum()
	{
		static $enum = null;

		if ($enum === null) {
			$enum = array(
				self::ALLOW_COMMENT_Y => Lang::_('SRV_ENUM_GLOBAL_YES'),
				self::ALLOW_COMMENT_N => Lang::_('SRV_ENUM_GLOBAL_NO'),
			);
		}

		return $enum;
	}

	/**
	 * 获取“允许其他人编辑”所有选项
	 * @return array
	 */
	public static function getAllowOtherModifyEnum()
	{
		static $enum = null;

		if ($enum === null) {
			$enum = array(
				self::ALLOW_OTHER_MODIFY_Y => Lang::_('SRV_ENUM_GLOBAL_YES'),
				self::ALLOW_OTHER_MODIFY_N => Lang::_('SRV_ENUM_GLOBAL_NO'),
			);
		}

		return $enum;
	}

}
