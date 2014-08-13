<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace users\db;

use tdo\AbstractDb;
use libsrv\Clean;
use users\library\Constant;
use users\library\TableNames;

/**
 * Users class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Users.php 1 2014-08-07 10:09:58Z Code Generator $
 * @package users.db
 * @since 1.0
 */
class Users extends AbstractDb
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = Constant::DB_CLUSTER;

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
		$commandBuilder = $this->getCommandBuilder();
		$usersTblName = $this->getTblprefix() . TableNames::getUsers();
		$userGroupsTblName = $this->getTblprefix() . TableNames::getUsergroups();

		$sql = 'SELECT SQL_CALC_FOUND_ROWS `u`.`user_id`, `u`.`login_name`, `u`.`login_type`, `u`.`user_name`, `u`.`user_mail`, `u`.`user_phone`, `u`.`dt_registered`, `u`.`dt_last_login`, `u`.`dt_last_repwd`, `u`.`ip_registered`, `u`.`ip_last_login`, `u`.`ip_last_repwd`, `u`.`login_count`, `u`.`repwd_count`, `u`.`valid_mail`, `u`.`valid_phone`, `u`.`forbidden`, `u`.`trash` FROM `' . $usersTblName . '` AS `u`';
		if (isset($attributes['group_id'])) {
			$sql .= ' LEFT JOIN `' . $userGroupsTblName . '` AS `g` ON `u`.`user_id` = `g`.`user_id`';
		}

		$condition = '1';
		foreach ($attributes as $columnName => $value) {
			$alias = ($columnName === 'group_id') ? '`g`' : '`u`';
			$condition .= ' AND ' . $alias . '.' . $commandBuilder->quoteColumnName($columnName) . ' = ' . $commandBuilder::PLACE_HOLDERS;
		}

		$sql = $commandBuilder->applyCondition($sql, $condition);
		$sql = $commandBuilder->applyOrder($sql, $order);
		$sql = $commandBuilder->applyLimit($sql, $limit, $offset);
		$ret = $this->fetchAllNoCache($sql, $attributes);
		if (is_array($ret)) {
			$ret['attributes'] = $attributes;
			$ret['order']      = $order;
			$ret['limit']      = $limit;
			$ret['offset']     = $offset;
		}

		return $ret;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $userId
	 * @return array
	 */
	public function findByPk($userId)
	{
		if (($userId = (int) $userId) <= 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getUsers();
		$sql = 'SELECT `user_id`, `login_name`, `login_type`, `password`, `salt`, `user_name`, `user_mail`, `user_phone`, `dt_registered`, `dt_last_login`, `dt_last_repwd`, `ip_registered`, `ip_last_login`, `ip_last_repwd`, `login_count`, `repwd_count`, `valid_mail`, `valid_phone`, `forbidden`, `trash` FROM ' . $tableName . ' WHERE `user_id` = ?';
		return $this->fetchAssoc($sql, $userId);
	}

	/**
	 * 通过登录名，查询一条记录
	 * @param string $loginName
	 * @return array
	 */
	public function findByLoginName($loginName)
	{
		if (($loginName = trim($loginName)) === '') {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getUsers();
		$sql = 'SELECT `user_id`, `login_name`, `login_type`, `password`, `salt`, `user_name`, `user_mail`, `user_phone`, `dt_registered`, `dt_last_login`, `dt_last_repwd`, `ip_registered`, `ip_last_login`, `ip_last_repwd`, `login_count`, `repwd_count`, `valid_mail`, `valid_phone`, `forbidden`, `trash` FROM ' . $tableName . ' WHERE `login_name` = ?';
		return $this->fetchAssoc($sql, $loginName);
	}

	/**
	 * 通过主键，获取某个列的值
	 * @param string $columnName
	 * @param integer $userId
	 * @return mixed
	 */
	public function getByPk($columnName, $userId)
	{
		$row = $this->findByPk($userId);
		if ($row && is_array($row) && isset($row[$columnName])) {
			return $row[$columnName];
		}

		return false;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return integer
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$loginName = isset($params['login_name']) ? trim($params['login_name']) : '';
		$loginType = isset($params['login_type']) ? trim($params['login_type']) : '';
		$password = isset($params['password']) ? trim($params['password']) : '';
		$salt = isset($params['salt']) ? trim($params['salt']) : '';
		$userName = isset($params['user_name']) ? trim($params['user_name']) : '';
		$userMail = isset($params['user_mail']) ? trim($params['user_mail']) : '';
		$userPhone = isset($params['user_phone']) ? trim($params['user_phone']) : '';
		$dtRegistered = isset($params['dt_registered']) ? trim($params['dt_registered']) : '';
		$dtLastLogin = isset($params['dt_last_login']) ? trim($params['dt_last_login']) : '';
		$ipRegistered = isset($params['ip_registered']) ? (int) $params['ip_registered'] : 0;
		$ipLastLogin = isset($params['ip_last_login']) ? (int) $params['ip_last_login'] : 0;
		$loginCount = isset($params['login_count']) ? (int) $params['login_count'] : 0;
		$validMail = isset($params['valid_mail']) ? trim($params['valid_mail']) : '';
		$validPhone = isset($params['valid_phone']) ? trim($params['valid_phone']) : '';
		$forbidden = isset($params['forbidden']) ? trim($params['forbidden']) : '';
		$trash = 'n';

		if ($loginName === '' || $loginType === '' || $password === '' || $salt === ''
			|| $dtRegistered === '' || $dtLastLogin === '' || $ipRegistered < 0 || $ipLastLogin < 0 
			|| $loginCount < 0 || $validMail === '' || $validPhone === '' || $forbidden === '') {
			return false;
		}

		if ($userName === '' && $userMail === '' && $userPhone === '') {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getUsers();
		$attributes = array(
			'login_name' => $loginName,
			'login_type' => $loginType,
			'password' => $password,
			'salt' => $salt,
			'user_name' => $userName,
			'user_mail' => $userMail,
			'user_phone' => $userPhone,
			'dt_registered' => $dtRegistered,
			'dt_last_login' => $dtLastLogin,
			'ip_registered' => $ipRegistered,
			'ip_last_login' => $ipLastLogin,
			'login_count' => $loginCount,
			'valid_mail' => $validMail,
			'valid_phone' => $validPhone,
			'forbidden' => $forbidden,
			'trash' => $trash,
		);

		$sql = $this->getCommandBuilder()->createInsert($tableName, array_keys($attributes), $ignore);
		return $this->insert($sql, $attributes);
	}

	/**
	 * 通过主键，编辑一条记录，禁止编辑“登录名”和“登录方式”
	 * @param integer $userId
	 * @param array $params
	 * @return integer
	 */
	public function modifyByPk($userId, array $params = array())
	{
		if (($userId = (int) $userId) <= 0) {
			return false;
		}

		$attributes = array();

		if (isset($params['password'])) {
			$password = trim($params['password']);
			if ($password !== '') {
				$attributes['password'] = $password;
			}
			else {
				return false;
			}
		}

		if (isset($params['salt'])) {
			$salt = trim($params['salt']);
			if ($salt !== '') {
				$attributes['salt'] = $salt;
			}
			else {
				return false;
			}
		}

		if (isset($params['user_name'])) {
			$attributes['user_name'] = trim($params['user_name']);
		}

		if (isset($params['user_mail'])) {
			$attributes['user_mail'] = trim($params['user_mail']);
		}

		if (isset($params['user_phone'])) {
			$attributes['user_phone'] = trim($params['user_phone']);
		}

		if (isset($params['dt_last_login'])) {
			$attributes['dt_last_login'] = trim($params['dt_last_login']);
		}

		if (isset($params['dt_last_repwd'])) {
			$attributes['dt_last_repwd'] = trim($params['dt_last_repwd']);
		}

		if (isset($params['ip_last_login'])) {
			$ipLastLogin = (int) $params['ip_last_login'];
			if ($ipLastLogin >= 0) {
				$attributes['ip_last_login'] = $ipLastLogin;
			}
		}

		if (isset($params['ip_last_repwd'])) {
			$ipLastRepwd = (int) $params['ip_last_repwd'];
			if ($ipLastRepwd >= 0) {
				$attributes['ip_last_repwd'] = $ipLastRepwd;
			}
		}

		if (isset($params['login_count'])) {
			$loginCount = (int) $params['login_count'];
			if ($loginCount >= 0) {
				$attributes['login_count'] = $loginCount;
			}
		}

		if (isset($params['repwd_count'])) {
			$repwdCount = (int) $params['repwd_count'];
			if ($repwdCount >= 0) {
				$attributes['repwd_count'] = $repwdCount;
			}
		}

		if (isset($params['valid_mail'])) {
			$validMail = trim($params['valid_mail']);
			if ($validMail !== '') {
				$attributes['valid_mail'] = $validMail;
			}
		}

		if (isset($params['valid_phone'])) {
			$validPhone = trim($params['valid_phone']);
			if ($validPhone !== '') {
				$attributes['valid_phone'] = $validPhone;
			}
		}

		if (isset($params['forbidden'])) {
			$forbidden = trim($params['forbidden']);
			if ($forbidden !== '') {
				$attributes['forbidden'] = $forbidden;
			}
		}

		if (isset($params['trash'])) {
			$trash = trim($params['trash']);
			if ($trash !== '') {
				$attributes['trash'] = $trash;
			}
		}

		if ($attributes === array()) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getUsers();
		$sql = $this->getCommandBuilder()->createUpdate($tableName, array_keys($attributes), '`user_id` = ?');
		$attributes['user_id'] = $userId;
		return $this->update($sql, $attributes);
	}

	/**
	 * 通过主键，编辑多条记录。不支持联合主键
	 * @param string $userIds
	 * @param array $params
	 * @return integer
	 */
	public function batchModifyByPk($userIds, array $params = array())
	{
		$userIds = Clean::sqlPositiveInteger($userIds);
		if ($userIds === false) {
			return false;
		}

		$attributes = array();

		if (isset($params['valid_mail'])) {
			$validMail = trim($params['valid_mail']);
			if ($validMail !== '') {
				$attributes['valid_mail'] = $validMail;
			}
		}

		if (isset($params['valid_phone'])) {
			$validPhone = trim($params['valid_phone']);
			if ($validPhone !== '') {
				$attributes['valid_phone'] = $validPhone;
			}
		}

		if (isset($params['forbidden'])) {
			$forbidden = trim($params['forbidden']);
			if ($forbidden !== '') {
				$attributes['forbidden'] = $forbidden;
			}
		}

		if (isset($params['trash'])) {
			$trash = trim($params['trash']);
			if ($trash !== '') {
				$attributes['trash'] = $trash;
			}
		}

		if ($attributes === array()) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getUsers();
        $condition = '`user_id` IN (' . $userIds . ')';
        $sql = $this->getCommandBuilder()->createUpdate($tableName, array_keys($attributes), $condition);
        return $this->update($sql, $attributes);
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $userId
	 * @return integer
	 */
	public function removeByPk($userId)
	{
		if (($userId = (int) $userId) <= 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getUsers();
		$sql = $this->getCommandBuilder()->createDelete($tableName, '`user_id` = ?');
		return $this->delete($sql, $userId);
	}
}
