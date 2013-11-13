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

use base;

/**
 * ErrorMsg class file
 * 常用错误信息类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ErrorMsg.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library
 * @since 1.0
 */
class ErrorMsg extends base\ErrorMsg
{
	/**
	 * @var string 登录成功
	 */
	const SUCCESS_LOGIN           	          = 'Login OK';

	/**
	 * @var string 管理员没有访问本Action的权限
	 */
	const ERROR_NO_AUTH     	   		      = 'No Auth!';

	/**
	 * @var string 登录失败，用户名不存在
	 */
	const ERROR_LOGIN_FAILED_NAME_NOT_EXISTS  = 'Login Failed, Name Not Exists!';

	/**
	 * @var string 登录失败，密码错误
	 */
	const ERROR_LOGIN_FAILED_PWD_ERR          = 'Login Failed, Password Error!';

	/**
	 * @var string 登录失败，验证码错误
	 */
	const ERROR_LOGIN_FAILED_VERIFY_ERR       = 'Login Failed, Verify Error!';

	/**
	 * @var string 登录失败，用户名为空
	 */
	const ERROR_LOGIN_FAILED_NAME_EMPTY       = 'Login Failed, Name Empty!';

	/**
	 * @var string 登录失败，密码为空
	 */
	const ERROR_LOGIN_FAILED_PWD_EMPTY        = 'Login Failed, Password Empty!';

	/**
	 * @var string 登录失败，验证码为空
	 */
	const ERROR_LOGIN_FAILED_VERIFY_EMPTY     = 'Login Failed, Verify Empty!';

}
