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

use koala;

/**
 * ErrorNo class file
 * 常用错误码类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ErrorNo.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library
 * @since 1.0
 */
class ErrorNo extends koala\ErrorNo
{
	/**
	 * @var integer 登录成功
	 */
	const SUCCESS_LOGIN           	          = 200001;

	/**
	 * @var integer 管理员没有访问本Action的权限
	 */
	const ERROR_NO_AUTH     	   		      = 200002;

	/**
	 * @var integer 登录失败，用户名不存在
	 */
	const ERROR_LOGIN_FAILED_NAME_NOT_EXISTS  = 200003;

	/**
	 * @var integer 登录失败，密码错误
	 */
	const ERROR_LOGIN_FAILED_PWD_ERR          = 200004;

	/**
	 * @var integer 登录失败，验证码错误
	 */
	const ERROR_LOGIN_FAILED_VERIFY_ERR       = 200005;

	/**
	 * @var integer 登录失败，用户名为空
	 */
	const ERROR_LOGIN_FAILED_NAME_EMPTY       = 200006;

	/**
	 * @var integer 登录失败，密码为空
	 */
	const ERROR_LOGIN_FAILED_PWD_EMPTY        = 200007;

	/**
	 * @var integer 登录失败，验证码为空
	 */
	const ERROR_LOGIN_FAILED_VERIFY_EMPTY     = 200008;

}
