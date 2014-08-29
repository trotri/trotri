<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace users\services;

/**
 * DataAccount class file
 * 业务层：数据管理类，寄存常量、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataAccount.php 1 2014-08-28 10:09:58Z huan.song $
 * @package users.services
 * @since 1.0
 */
class DataAccount
{
	/**
	 * @var integer 登录成功
	 */
	const SUCCESS_LOGIN_NUM          = 0;

	/**
	 * @var integer 登录失败：登录名为空
	 */
	const ERROR_LOGIN_NAME_EMPTY     = 3001;

	/**
	 * @var integer 登录失败：密码为空
	 */
	const ERROR_LOGIN_PASSWORD_EMPTY = 3002;

	/**
	 * @var integer 登录失败：登录名不存在
	 */
	const ERROR_LOGIN_NAME_UNDEFINED = 3003;

	/**
	 * @var integer 登录失败：用户已被删除
	 */
	const ERROR_LOGIN_USER_TRASH     = 3004;

	/**
	 * @var integer 登录失败：用户已被禁用
	 */
	const ERROR_LOGIN_USER_FORBIDDEN = 3005;

	/**
	 * @var integer 登录失败：密码错误
	 */
	const ERROR_LOGIN_PASSWORD_WRONG = 3006;

	/**
	 * @var integer 登录失败：未知错误
	 */
	const ERROR_LOGIN_UNKNOWN_WRONG  = 3007;

}
