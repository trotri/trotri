<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\ucenter;

use slib\BaseData;
use slib\Data;

/**
 * DataUsers class file
 * 业务层：数据管理类，寄存常量、选项、验证规则
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataUsers.php 1 2014-04-15 14:43:50Z Code Generator $
 * @package smods.ucenter
 * @since 1.0
 */
class DataUsers extends BaseData
{
	/**
	 * @var string 登录方式：mail
	 */
	const LOGIN_TYPE_MAIL = 'mail';

	/**
	 * @var string 登录方式：name
	 */
	const LOGIN_TYPE_NAME = 'name';

	/**
	 * @var string 登录方式：phone
	 */
	const LOGIN_TYPE_PHONE = 'phone';

	/**
	 * @var string 是否已验证邮箱：y
	 */
	const VALID_MAIL_Y = 'y';

	/**
	 * @var string 是否已验证邮箱：n
	 */
	const VALID_MAIL_N = 'n';

	/**
	 * @var string 是否已验证手机号：y
	 */
	const VALID_PHONE_Y = 'y';

	/**
	 * @var string 是否已验证手机号：n
	 */
	const VALID_PHONE_N = 'n';

	/**
	 * @var string 是否禁用：y
	 */
	const FORBIDDEN_Y = 'y';

	/**
	 * @var string 是否禁用：n
	 */
	const FORBIDDEN_N = 'n';

	/**
	 * @var string 是否删除：y
	 */
	const TRASH_Y = 'y';

	/**
	 * @var string 是否删除：n
	 */
	const TRASH_N = 'n';

	/**
	 * 获取“登录方式”所有选项
	 * @return array
	 */
	public function getLoginTypeEnum()
	{
		return array(
			self::LOGIN_TYPE_MAIL => $this->_('MOD_UCENTER_USERS_ENUM_LOGIN_TYPE_MAIL'),
			self::LOGIN_TYPE_NAME => $this->_('MOD_UCENTER_USERS_ENUM_LOGIN_TYPE_NAME'),
			self::LOGIN_TYPE_PHONE => $this->_('MOD_UCENTER_USERS_ENUM_LOGIN_TYPE_PHONE'),
		);
	}

	/**
	 * 获取“用户分组ID”所有选项
	 * @return array
	 */
	public function getGroupIdsEnum()
	{
		return Data::getInstance('Groups', 'ucenter', $this->getLanguage())->getGroupIdsEnum();
	}

	/**
	 * 获取“是否已验证邮箱”所有选项
	 * @return array
	 */
	public function getValidMailEnum()
	{
		return array(
			self::VALID_MAIL_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::VALID_MAIL_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“是否已验证手机号”所有选项
	 * @return array
	 */
	public function getValidPhoneEnum()
	{
		return array(
			self::VALID_PHONE_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::VALID_PHONE_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“是否禁用”所有选项
	 * @return array
	 */
	public function getForbiddenEnum()
	{
		return array(
			self::FORBIDDEN_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORBIDDEN_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“是否删除”所有选项
	 * @return array
	 */
	public function getTrashEnum()
	{
		return array(
			self::TRASH_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::TRASH_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“登录名”验证规则
	 * @return array
	 */
	public function getLoginNameRule()
	{
		return array(
			'MinLength' => array(6, $this->_('MOD_UCENTER_USERS_LOGIN_NAME_MINLENGTH')),
			'MaxLength' => array(18, $this->_('MOD_UCENTER_USERS_LOGIN_NAME_MAXLENGTH')),
			'smods\\ucenter\\validator\\UsersLoginName' => array(true, $this->_('MOD_UCENTER_USERS_LOGIN_NAME_ALPHANUM')),
			'smods\\ucenter\\validator\\UsersLoginNameUnique' => array(true, $this->_('MOD_UCENTER_USERS_LOGIN_NAME_UNIQUE')),
		);
	}

	/**
	 * 获取“登录密码”验证规则
	 * @return array
	 */
	public function getPasswordRule()
	{
		return array(
			'MinLength' => array(6, $this->_('MOD_UCENTER_USERS_PASSWORD_MINLENGTH')),
			'MaxLength' => array(20, $this->_('MOD_UCENTER_USERS_PASSWORD_MAXLENGTH')),
		);
	}

	/**
	 * 获取“确认密码”验证规则
	 * @return array
	 */
	public function getRepasswordRule()
	{
		return array(
			'EqualTo' => array('password', $this->_('MOD_UCENTER_USERS_REPASSWORD_EQUALTO')),
		);
	}

	/**
	 * 获取“用户名”验证规则
	 * @return array
	 */
	public function getUserNameRule()
	{
		return array(
			'MinLength' => array(4, $this->_('MOD_UCENTER_USERS_USER_NAME_MINLENGTH')),
			'MaxLength' => array(50, $this->_('MOD_UCENTER_USERS_USER_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“用户邮箱”验证规则
	 * @return array
	 */
	public function getUserMailRule()
	{
		return array(
			'Mail' => array(true, $this->_('MOD_UCENTER_USERS_USER_MAIL_MAIL')),
		);
	}

	/**
	 * 获取“手机号”验证规则
	 * @return array
	 */
	public function getUserPhoneRule()
	{
		return array(
			'slib\\validator\\PhoneValidator' => array(true, $this->_('MOD_UCENTER_USERS_USER_PHONE_PHONE')),
		);
	}

	/**
	 * 获取“是否禁用”验证规则
	 * @return array
	 */
	public function getForbiddenRule()
	{
		$enum = $this->getForbiddenEnum();
		return array(
			'InArray' => array(
				array_keys($enum), 
				sprintf($this->_('MOD_UCENTER_USERS_FORBIDDEN_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“是否删除”验证规则
	 * @return array
	 */
	public function getTrashRule()
	{
		$enum = $this->getTrashEnum();
		return array(
			'InArray' => array(
				array_keys($enum), 
				sprintf($this->_('MOD_UCENTER_USERS_TRASH_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“用户分组ID”验证规则
	 * @return array
	 */
	public function getGroupIdsRule()
	{
		$enum = $this->getGroupIdsEnum();
		return array(
			'InArray' => array(
				$enum,
				$this->_('MOD_UCENTER_USERS_GROUP_IDS_INARRAY')
			),
		);
	}
}
