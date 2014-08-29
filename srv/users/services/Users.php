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

use libsrv\AbstractService;
use tfc\util\String;
use users\db\Users AS DbUsers;

/**
 * Users class file
 * 业务层：业务处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Users.php 1 2014-08-07 10:09:58Z Code Generator $
 * @package users.services
 * @since 1.0
 */
class Users extends AbstractService
{
	/**
	 * @var instance of users\db\Users
	 */
	protected $_dbUsers = null;

	/**
	 * @var instance of users\services\Usergroups
	 */
	protected $_userGroups = null;

	/**
	 * 构造方法：初始化数据库操作类
	 */
	public function __construct()
	{
		parent::__construct();

		$this->_dbUsers = new DbUsers();
		$this->_userGroups = new Usergroups();
	}

	/**
	 * 通过多个字段名和值，查询多条记录，字段之间用简单的AND连接
	 * @param array $attributes
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findAllByAttributes(array $attributes = array(), $order = '', $limit = 0, $offset = 0)
	{
		$rows = $this->_dbUsers->findAllByAttributes($attributes, $order, $limit, $offset);
		return $rows;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $userId
	 * @return array
	 */
	public function findByPk($userId)
	{
		$row = $this->_dbUsers->findByPk($userId);
		if ($row && is_array($row) && isset($row['user_id'])) {
			$groupIds = $this->_userGroups->findGroupIdsByUserId($row['user_id']);
			$row['group_ids'] = is_array($groupIds) ? $groupIds : array();
		}

		return $row;
	}

	/**
	 * 通过登录名，查询一条记录
	 * @param string $loginName
	 * @return array
	 */
	public function findByLoginName($loginName)
	{
		$row = $this->_dbUsers->findByLoginName($loginName);
		if ($row && is_array($row) && isset($row['user_id'])) {
			$groupIds = $this->_userGroups->findGroupIdsByUserId($row['user_id']);
			$row['group_ids'] = is_array($groupIds) ? $groupIds : array();
		}

		return $row;
	}

	/**
	 * (non-PHPdoc)
	 * @see \libsrv\AbstractService::create()
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$userId = parent::create($params, $ignore);
		if (($userId = (int) $userId) <= 0) {
			return false;
		}

		$groupIds = $this->getFormProcessor()->group_ids;
		if (is_array($groupIds)) {
			$this->_userGroups->modify($userId, $groupIds);
		}

		return $userId;
	}

	/**
	 * (non-PHPdoc)
	 * @see \libsrv\AbstractService::modifyByPk()
	 */
	public function modifyByPk($value, array $params = array())
	{
		$rowCount = parent::modifyByPk($value, $params);
		if ($rowCount === false) {
			return false;
		}

		$groupIds = $this->getFormProcessor()->group_ids;
		if (is_array($groupIds)) {
			return $this->_userGroups->modify($value, $groupIds);
		}

		return $rowCount;
	}

	/**
	 * 通过主键，获取某个列的值
	 * @param string $columnName
	 * @param integer $userId
	 * @return mixed
	 */
	public function getByPk($columnName, $userId)
	{
		$value = $this->_dbUsers->getByPk($columnName, $userId);
		return $value;
	}

	/**
	 * 通过“主键ID”，获取“登录名”
	 * @param integer $userId
	 * @return string
	 */
	public function getLoginNameByUserId($userId)
	{
		$value = $this->getByPk('login_name', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“登录方式”
	 * @param integer $userId
	 * @return string
	 */
	public function getLoginTypeByUserId($userId)
	{
		$value = $this->getByPk('login_type', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“登录密码”
	 * @param integer $userId
	 * @return string
	 */
	public function getPasswordByUserId($userId)
	{
		$value = $this->getByPk('password', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“随机附加混淆码”
	 * @param integer $userId
	 * @return string
	 */
	public function getSaltByUserId($userId)
	{
		$value = $this->getByPk('salt', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“用户名”
	 * @param integer $userId
	 * @return string
	 */
	public function getUserNameByUserId($userId)
	{
		$value = $this->getByPk('user_name', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“邮箱”
	 * @param integer $userId
	 * @return string
	 */
	public function getUserMailByUserId($userId)
	{
		$value = $this->getByPk('user_mail', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“手机号”
	 * @param integer $userId
	 * @return string
	 */
	public function getUserPhoneByUserId($userId)
	{
		$value = $this->getByPk('user_phone', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“注册时间”
	 * @param integer $userId
	 * @return string
	 */
	public function getDtRegisteredByUserId($userId)
	{
		$value = $this->getByPk('dt_registered', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“上次登录时间”
	 * @param integer $userId
	 * @return string
	 */
	public function getDtLastLoginByUserId($userId)
	{
		$value = $this->getByPk('dt_last_login', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“上次更新密码时间”
	 * @param integer $userId
	 * @return string
	 */
	public function getDtLastRepwdByUserId($userId)
	{
		$value = $this->getByPk('dt_last_repwd', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“注册IP”
	 * @param integer $userId
	 * @return integer
	 */
	public function getIpRegisteredByUserId($userId)
	{
		$value = $this->getByPk('ip_registered', $userId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“上次登录IP”
	 * @param integer $userId
	 * @return integer
	 */
	public function getIpLastLoginByUserId($userId)
	{
		$value = $this->getByPk('ip_last_login', $userId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“上次更新密码IP”
	 * @param integer $userId
	 * @return integer
	 */
	public function getIpLastRepwdByUserId($userId)
	{
		$value = $this->getByPk('ip_last_repwd', $userId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“总登录次数”
	 * @param integer $userId
	 * @return integer
	 */
	public function getLoginCountByUserId($userId)
	{
		$value = $this->getByPk('login_count', $userId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“总更新密码次数”
	 * @param integer $userId
	 * @return integer
	 */
	public function getRepwdCountByUserId($userId)
	{
		$value = $this->getByPk('repwd_count', $userId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“是否已验证邮箱”
	 * @param integer $userId
	 * @return string
	 */
	public function getValidMailByUserId($userId)
	{
		$value = $this->getByPk('valid_mail', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“是否已验证手机号”
	 * @param integer $userId
	 * @return string
	 */
	public function getValidPhoneByUserId($userId)
	{
		$value = $this->getByPk('valid_phone', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“是否禁用”
	 * @param integer $userId
	 * @return string
	 */
	public function getForbiddenByUserId($userId)
	{
		$value = $this->getByPk('forbidden', $userId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“是否删除”
	 * @param integer $userId
	 * @return string
	 */
	public function getTrashByUserId($userId)
	{
		$value = $this->getByPk('trash', $userId);
		return $value ? $value : '';
	}

	/**
	 * 获取“是否已验证邮箱”
	 * @param string $validMail
	 * @return string
	 */
	public function getValidMailLangByValidMail($validMail)
	{
		$enum = DataUsers::getValidMailEnum();
		return isset($enum[$validMail]) ? $enum[$validMail] : '';
	}

	/**
	 * 获取“是否已验证手机号”
	 * @param string $validPhone
	 * @return string
	 */
	public function getValidPhoneLangByValidPhone($validPhone)
	{
		$enum = DataUsers::getValidPhoneEnum();
		return isset($enum[$validPhone]) ? $enum[$validPhone] : '';
	}

	/**
	 * 获取“是否禁用”
	 * @param string $forbidden
	 * @return string
	 */
	public function getForbiddenLangByForbidden($forbidden)
	{
		$enum = DataUsers::getForbiddenEnum();
		return isset($enum[$forbidden]) ? $enum[$forbidden] : '';
	}

	/**
	 * 通过“主键ID”，获取“所属用户分组ID”
	 * @param integer $userId
	 * @return array
	 */
	public function getGroupIdsByUserId($userId)
	{
		$row = $this->findByPk($userId);
		if ($row && is_array($row) && isset($row['group_ids'])) {
			return $row['group_ids'];
		}

		return array();
	}

	/**
	 * 获取用户登录随机附加混淆码
	 * @return string
	 */
	public function getSalt()
	{
		return String::randStr(6);
	}

	/**
	 * 加密用户登录密码
	 * @param string $pwd
	 * @param string $salt
	 * @return string
	 */
	public function encrypt($pwd, $salt = '')
	{
		return md5($salt . substr(md5($pwd), 3));
	}

	/**
	 * 通过登录名自动识别登录方式
	 * @param string $loginName
	 * @return string
	 */
	public function getLoginType($loginName)
	{
		if (strpos($loginName, '@')) {
			return DataUsers::LOGIN_TYPE_MAIL;
		}

		if (is_numeric($loginName)) {
			return DataUsers::LOGIN_TYPE_PHONE;
		}

		return DataUsers::LOGIN_TYPE_NAME;
	}

	/**
	 * 是否通过邮箱登录
	 * @param string $loginType
	 * @return boolean
	 */
	public function isMailLogin($loginType)
	{
		return $loginType === DataUsers::LOGIN_TYPE_MAIL;
	}

	/**
	 * 是否通过手机号登录
	 * @param string $loginType
	 * @return boolean
	 */
	public function isPhoneLogin($loginType)
	{
		return $loginType === DataUsers::LOGIN_TYPE_PHONE;
	}

}
