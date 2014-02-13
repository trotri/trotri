<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\model;

use tfc\ap\Ap;
use tfc\ap\Registry;
use koala\Model;
use library\Auth;
use library\ErrorNo;
use library\UcenterFactory;

/**
 * Users class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Users.php 1 2014-02-11 15:51:13Z huan.song $
 * @package modules.ucenter.model
 * @since 1.0
 */
class Users extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = UcenterFactory::getDb('Users');
		parent::__construct($db);
	}

	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $pageNo
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $pageNo = 0)
	{
		$attributes = array();
		//--待开发--
		$ret = $this->findIndexByAttributes($attributes, $order, $pageNo);
		return $ret;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		unset($params['dt_last_repwd'], $params['ip_last_repwd']);
		$params['dt_registered'] = $params['dt_last_login'] = date('Y-m-d H:i:s');
		$params['ip_registered'] = $params['ip_last_login'] = Ap::getRequest()->getClientIp();
		$params['login_count'] = 1;
		$params['repwd_count'] = 0;
		$params['salt'] = $salt = Auth::getSalt();
		Registry::set(__CLASS__ . '_salt', $salt);

		$params['login_name'] = $loginName = isset($params['login_name']) ? trim($params['login_name']) : '';
		$params['login_type'] = $loginType = Auth::getLoginType($loginName);
		$params['user_name'] = isset($params['user_name']) ? trim($params['user_name']) : '';
		if ($params['user_name'] === '') {
			unset($params['user_name']);
		}

		$params['user_mail'] = isset($params['user_mail']) ? trim($params['user_mail']) : '';
		if ($params['user_mail'] === '') {
			if ($loginType === Auth::LOGIN_TYPE_MAIL) {
				$params['user_mail'] = $loginName;
			}
			else {
				unset($params['user_mail']);
			}
		}

		$params['user_phone'] = isset($params['user_phone']) ? trim($params['user_phone']) : '';
		if ($params['user_phone'] === '') {
			if ($loginType === Auth::LOGIN_TYPE_PHONE) {
				$params['user_phone'] = $loginName;
			}
			else {
				unset($params['user_phone']);
			}
		}

		$params['password'] = isset($params['password']) ? trim($params['password']) : '';
		$params['repassword'] = isset($params['repassword']) ? trim($params['repassword']) : '';

		// $ret = $this->insert($params, false);
		// if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
		//	return $ret;
		// }

		$groupIds = isset($params['group_ids']) ? (array) $params['group_ids'] : array();

		echo '<pre>';
		print_r($params);
		echo '</pre>';
		exit;
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		//--待开发--
		return $this->updateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = UcenterFactory::getElements('Users');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'login_name' => $elements->getLoginName($type),
			'password' => $elements->getPassword($type),
			'repassword' => $elements->getRepassword($type),
			'user_name' => $elements->getUserName($type),
			'user_mail' => $elements->getUserMail($type),
			'user_phone' => $elements->getUserPhone($type),
			'valid_mail' => $elements->getValidMail($type),
			'valid_phone' => $elements->getValidPhone($type),
			'forbidden' => $elements->getForbidden($type),
			'trash' => $elements->getTrash($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = UcenterFactory::getElements('Users');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'user_id' => $elements->getUserId($type),
			'login_name' => $elements->getLoginName($type),
			'login_type' => $elements->getLoginType($type),
			'password' => $elements->getPassword($type),
			'repassword' => $elements->getRepassword($type),
			'salt' => $elements->getSalt($type),
			'user_name' => $elements->getUserName($type),
			'user_mail' => $elements->getUserMail($type),
			'user_phone' => $elements->getUserPhone($type),
			'dt_registered' => $elements->getDtRegistered($type),
			'dt_last_login' => $elements->getDtLastLogin($type),
			'dt_last_repwd' => $elements->getDtLastRepwd($type),
			'ip_registered' => $elements->getIpRegistered($type),
			'ip_last_login' => $elements->getIpLastLogin($type),
			'ip_last_repwd' => $elements->getIpLastRepwd($type),
			'login_count' => $elements->getLoginCount($type),
			'repwd_count' => $elements->getRepwdCount($type),
			'valid_mail' => $elements->getValidMail($type),
			'valid_phone' => $elements->getValidPhone($type),
			'forbidden' => $elements->getForbidden($type),
			'trash' => $elements->getTrash($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getCleanRulesAfterValidator()
	 */
	public function getCleanRulesAfterValidator()
	{
		$output = array(
			'password' => array($this, 'encrypt')
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::filterAttributes()
	 */
	public function filterAttributes(array &$attributes = array(), $columnNames = null, $autoIncrement = true)
	{
		$repassword = isset($attributes['repassword']) ? $attributes['repassword'] : null;
		parent::filterAttributes($attributes, $columnNames, $autoIncrement);
		if ($repassword !== null) {
			$attributes['repassword'] = $repassword;
		}
	}

	/**
	 * 通过登录名统计记录数
	 * @param string $loginName
	 * @return integer
	 */
	public function countByLoginName($loginName)
	{
		$ret = $this->countByAttributes(array(
			'login_name' => $loginName,
		));

		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			return $ret['total'];
		}

		return false;
	}

	/**
	 * 加密会员登录密码
	 * @param string $pwd
	 * @return string
	 */
	public function encrypt($pwd)
	{
		$salt = Registry::get(__CLASS__ . '_salt');
		return Auth::encrypt($pwd, $salt);
	}
}
