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

use tfc\util\String;

/**
 * Auth class file
 * 权限管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Auth.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Auth
{
	/**
	 * @var string 登录方式：邮箱
	 */
	const LOGIN_TYPE_MAIL = 'mail';

	/**
	 * @var string 登录方式：用户名(不能是纯数字、不能包含@符)
	 */
	const LOGIN_TYPE_NAME = 'name';

	/**
	 * @var string 登录方式：手机号(11位数字)
	 */
	const LOGIN_TYPE_PHONE = 'phone';

	/**
	 * 获取会员登录随机附加混淆码
	 * @return string
	 */
	public static function getSalt()
	{
		return String::randStr(6);
	}

	/**
	 * 加密会员登录密码
	 * @param string $pwd
	 * @param string $salt
	 * @return string
	 */
	public static function encrypt($pwd, $salt = '')
	{
		return md5($salt . substr(md5($pwd), 3));
	}

	/**
	 * 通过登录名自动识别登录方式
	 * @param string $loginName
	 * @return string
	 */
	public static function getLoginType($loginName)
	{
		if (strpos($loginName, '@')) {
			return self::LOGIN_TYPE_MAIL;
		}

		if (is_numeric($loginName)) {
			return self::LOGIN_TYPE_PHONE;
		}

		return self::LOGIN_TYPE_NAME;
	}

	/**
	 * 通过登录方式获取是否通过邮箱登录
	 * @param string $loginType
	 * @return boolean
	 */
	public static function isMailLogin($loginType)
	{
		return $loginType === self::LOGIN_TYPE_MAIL;
	}

	/**
	 * 通过登录方式获取是否通过手机号登录
	 * @param string $loginType
	 * @return boolean
	 */
	public static function isPhoneLogin($loginType)
	{
		return $loginType === self::LOGIN_TYPE_PHONE;
	}
}
