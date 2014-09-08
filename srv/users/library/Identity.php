<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace users\library;

use tfc\ap\UserIdentity;
use tid\Authorization;

/**
 * Identity class file
 * 用户身份管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Identity.php 1 2014-09-03 01:08:06Z huan.song $
 * @package users.library
 * @since 1.0
 */
class Identity
{
	/**
	 * @var array 用户所属分组ID
	 */
	protected static $_groupIds = array();

	/**
	 * @var array 用户拥有权限的项目名
	 */
	protected static $_appNames = array();

	/**
	 * @var instance of tid\Authorization
	 */
	protected static $_authorization = null;

	/**
	 * 判断用户是否已登录
	 * @return boolean
	 */
	public static function isLogin()
	{
		return UserIdentity::isLogin();
	}

	/**
	 * 获取用户ID
	 * @return integer
	 */
	public static function getUserId()
	{
		return UserIdentity::getId();
	}

	/**
	 * 设置用户ID
	 * @param integer $id
	 * @return void
	 */
	public static function setUserId($id)
	{
		UserIdentity::setId($id);
	}

	/**
	 * 获取登录名
	 * @return string
	 */
	public static function getLoginName()
	{
		return UserIdentity::getName();
	}

	/**
	 * 设置登录名
	 * @param string $name
	 * @return void
	 */
	public static function setLoginName($name)
	{
		UserIdentity::setName($name);
	}

	/**
	 * 获取用户名
	 * @return string
	 */
	public static function getUserName()
	{
		return UserIdentity::getNick();
	}

	/**
	 * 设置用户名
	 * @param string $nick
	 * @return void
	 */
	public static function setUserName($name)
	{
		UserIdentity::setNick($name);
	}

	/**
	 * 获取用户所属分组ID
	 * @return array
	 */
	public static function getGroupIds()
	{
		return self::$_groupIds;
	}

	/**
	 * 设置用户所属分组ID
	 * @param array $ids
	 * @return void
	 */
	public static function setGroupIds($ids)
	{
		$ids = (array) $ids;

		$temp = array();
		foreach ($ids as $id) {
			if (($id = (int) $id) > 0) {
				$temp[] = $id;
			}
		}

		self::$_groupIds = array_unique($temp);
	}

	/**
	 * 获取用户拥有权限的项目名
	 * @return array
	 */
	public static function getAppNames()
	{
		return self::$_appNames;
	}

	/**
	 * 设置用户拥有权限的项目名
	 * @param array $names
	 * @return void
	 */
	public static function setAppNames($names)
	{
		$names = (array) $names;

		$temp = array();
		foreach ($names as $name) {
			if (($name = trim($name)) !== '') {
				$temp[] = $name;
			}
		}

		self::$_appNames = array_unique($temp);
	}

	/**
	 * 获取用户身份授权类
	 * @return tid\Authorization
	 */
	public static function getAuthorization()
	{
		if (self::$_authorization === null) {
			self::$_authorization = new Authorization();
		}

		return self::$_authorization;
	}

	/**
	 * 设置用户身份授权类
	 * @param tid\Authorization $authorization
	 * @return void
	 */
	public static function setAuthorization(Authorization $authorization)
	{
		self::$_authorization = $authorization;
	}
}
