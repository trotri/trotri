<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\elements;

use tfc\saf\Text;
use ui\ElementCollections;
use library\UcenterFactory;

/**
 * Users class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Users.php 1 2014-02-11 15:33:01Z huan.song $
 * @package modules.ucenter.elements
 * @since 1.0
 */
class Users extends ElementCollections
{
	/**
	 * @var string login_type：mail
	 */
	const LOGIN_TYPE_MAIL = 'mail';

	/**
	 * @var string login_type：name
	 */
	const LOGIN_TYPE_NAME = 'name';

	/**
	 * @var string login_type：phone
	 */
	const LOGIN_TYPE_PHONE = 'phone';

	/**
	 * @var string valid_mail：y
	 */
	const VALID_MAIL_Y = 'y';

	/**
	 * @var string valid_mail：n
	 */
	const VALID_MAIL_N = 'n';

	/**
	 * @var string valid_phone：y
	 */
	const VALID_PHONE_Y = 'y';

	/**
	 * @var string valid_phone：n
	 */
	const VALID_PHONE_N = 'n';

	/**
	 * @var string forbidden：y
	 */
	const FORBIDDEN_Y = 'y';

	/**
	 * @var string forbidden：n
	 */
	const FORBIDDEN_N = 'n';

	/**
	 * @var string trash：y
	 */
	const TRASH_Y = 'y';

	/**
	 * @var string trash：n
	 */
	const TRASH_N = 'n';

	/**
	 * @var ui\bootstrap\Components 页面小组件类
	 */
	public $uiComponents = null;

	/**
	 * 构造方法：初始化页面小组件类
	 */
	public function __construct()
	{
		$this->uiComponents = UcenterFactory::getUi('Users');
	}

	/**
	 * (non-PHPdoc)
	 * @see ui.ElementCollections::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
			'groups' => array(
				'tid' => 'groups',
				'prompt' => Text::_('MOD_UCENTER_USERS_VIEWTAB_GROUPS_PROMPT')
			),
			'system' => array(
				'tid' => 'system',
				'prompt' => Text::_('MOD_UCENTER_USERS_VIEWTAB_SYSTEM_PROMPT')
			),
		);

		return $output;
	}

	/**
	 * 获取“主键ID”配置
	 * @param integer $type
	 * @return array
	 */
	public function getUserId($type)
	{
		$output = array();
		$name = 'user_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_USER_ID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_USER_ID_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_USER_ID_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“登录名：邮箱|用户名|手机号”配置
	 * @param integer $type
	 * @return array
	 */
	public function getLoginName($type)
	{
		$output = array();
		$name = 'login_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_LOGIN_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_LOGIN_NAME_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_LOGIN_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'MinLength' => array(6, Text::_('MOD_UCENTER_USERS_LOGIN_NAME_MINLENGTH')),
				'MaxLength' => array(18, Text::_('MOD_UCENTER_USERS_LOGIN_NAME_MAXLENGTH')),
				'Mail' => array(true, Text::_('MOD_UCENTER_USERS_LOGIN_NAME_MAIL')),
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'text',
				'placeholder' => Text::_('MOD_UCENTER_USERS_LOGIN_NAME_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“通过登录名自动识别登录方式，mail：邮箱、name：用户名(不能是纯数字、不能包含@符)、phone：手机号(11位数字)”配置
	 * @param integer $type
	 * @return array
	 */
	public function getLoginType($type)
	{
		$output = array();
		$options = array(
			self::LOGIN_TYPE_MAIL => self::LOGIN_TYPE_MAIL,
			self::LOGIN_TYPE_NAME => self::LOGIN_TYPE_NAME,
			self::LOGIN_TYPE_PHONE => self::LOGIN_TYPE_PHONE,
		);

		$name = 'login_type';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_LOGIN_TYPE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“登录密码”配置
	 * @param integer $type
	 * @return array
	 */
	public function getPassword($type)
	{
		$output = array();
		$name = 'password';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_PASSWORD_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'password',
				'label' => Text::_('MOD_UCENTER_USERS_PASSWORD_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_PASSWORD_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'MinLength' => array(6, Text::_('MOD_UCENTER_USERS_PASSWORD_MINLENGTH')),
				'MaxLength' => array(20, Text::_('MOD_UCENTER_USERS_PASSWORD_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“确认密码”配置
	 * @param integer $type
	 * @return array
	 */
	public function getRepassword($type)
	{
		$output = array();
		$name = 'repassword';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_REPASSWORD_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'password',
				'label' => Text::_('MOD_UCENTER_USERS_REPASSWORD_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_REPASSWORD_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'EqualTo' => array('password', Text::_('MOD_UCENTER_USERS_REPASSWORD_EQUALTO')),
			);
		}

		return $output;
	}

	/**
	 * 获取“随机附加混淆码”配置
	 * @param integer $type
	 * @return array
	 */
	public function getSalt($type)
	{
		$output = array();
		$name = 'salt';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_SALT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“用户名”配置
	 * @param integer $type
	 * @return array
	 */
	public function getUserName($type)
	{
		$output = array();
		$name = 'user_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_USER_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_USER_NAME_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_USER_NAME_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'MinLength' => array(4, Text::_('MOD_UCENTER_USERS_USER_NAME_MINLENGTH')),
				'MaxLength' => array(50, Text::_('MOD_UCENTER_USERS_USER_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“用户邮箱，可用来找回密码”配置
	 * @param integer $type
	 * @return array
	 */
	public function getUserMail($type)
	{
		$output = array();
		$name = 'user_mail';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_USER_MAIL_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_USER_MAIL_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_USER_MAIL_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Mail' => array(true, Text::_('MOD_UCENTER_USERS_USER_MAIL_MAIL')),
			);
		}

		return $output;
	}

	/**
	 * 获取“用户手机号，可用来找回密码”配置
	 * @param integer $type
	 * @return array
	 */
	public function getUserPhone($type)
	{
		$output = array();
		$name = 'user_phone';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_USER_PHONE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_USER_PHONE_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_USER_PHONE_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'library\\validator\\PhoneValidator' => array(true, Text::_('MOD_UCENTER_USERS_USER_PHONE_PHONE')),
			);
		}

		return $output;
	}

	/**
	 * 获取“注册时间”配置
	 * @param integer $type
	 * @return array
	 */
	public function getDtRegistered($type)
	{
		$output = array();
		$name = 'dt_registered';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_DT_REGISTERED_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_DT_REGISTERED_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_DT_REGISTERED_HINT'),
				'disabled' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“上次登录时间”配置
	 * @param integer $type
	 * @return array
	 */
	public function getDtLastLogin($type)
	{
		$output = array();
		$name = 'dt_last_login';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_DT_LAST_LOGIN_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_DT_LAST_LOGIN_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_DT_LAST_LOGIN_HINT'),
				'disabled' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“上次更新密码时间”配置
	 * @param integer $type
	 * @return array
	 */
	public function getDtLastRepwd($type)
	{
		$output = array();
		$name = 'dt_last_repwd';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_DT_LAST_REPWD_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_DT_LAST_REPWD_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_DT_LAST_REPWD_HINT'),
				'disabled' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“注册IP”配置
	 * @param integer $type
	 * @return array
	 */
	public function getIpRegistered($type)
	{
		$output = array();
		$name = 'ip_registered';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_IP_REGISTERED_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_IP_REGISTERED_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_IP_REGISTERED_HINT'),
				'disabled' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“上次登录IP”配置
	 * @param integer $type
	 * @return array
	 */
	public function getIpLastLogin($type)
	{
		$output = array();
		$name = 'ip_last_login';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_IP_LAST_LOGIN_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_IP_LAST_LOGIN_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_IP_LAST_LOGIN_HINT'),
				'disabled' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“上次更新密码IP”配置
	 * @param integer $type
	 * @return array
	 */
	public function getIpLastRepwd($type)
	{
		$output = array();
		$name = 'ip_last_repwd';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_IP_LAST_REPWD_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_IP_LAST_REPWD_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_IP_LAST_REPWD_HINT'),
				'disabled' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“总登录次数”配置
	 * @param integer $type
	 * @return array
	 */
	public function getLoginCount($type)
	{
		$output = array();
		$name = 'login_count';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_LOGIN_COUNT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_LOGIN_COUNT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_LOGIN_COUNT_HINT'),
				'disabled' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“总更新密码次数”配置
	 * @param integer $type
	 * @return array
	 */
	public function getRepwdCount($type)
	{
		$output = array();
		$name = 'repwd_count';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_REPWD_COUNT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_REPWD_COUNT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_REPWD_COUNT_HINT'),
				'disabled' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“是否验证邮箱”配置
	 * @param integer $type
	 * @return array
	 */
	public function getValidMail($type)
	{
		$output = array();
		$options = array(
			self::VALID_MAIL_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::VALID_MAIL_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'valid_mail';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_VALID_MAIL_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_UCENTER_USERS_VALID_MAIL_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_VALID_MAIL_HINT'),
				'options' => $options,
				'value' => self::VALID_MAIL_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_UCENTER_USERS_VALID_MAIL_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“是否验证手机号”配置
	 * @param integer $type
	 * @return array
	 */
	public function getValidPhone($type)
	{
		$output = array();
		$options = array(
			self::VALID_PHONE_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::VALID_PHONE_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'valid_phone';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_VALID_PHONE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_UCENTER_USERS_VALID_PHONE_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_VALID_PHONE_HINT'),
				'options' => $options,
				'value' => self::VALID_PHONE_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_UCENTER_USERS_VALID_PHONE_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“是否禁用”配置
	 * @param integer $type
	 * @return array
	 */
	public function getForbidden($type)
	{
		$output = array();
		$options = array(
			self::FORBIDDEN_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::FORBIDDEN_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'forbidden';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_FORBIDDEN_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_UCENTER_USERS_FORBIDDEN_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_FORBIDDEN_HINT'),
				'options' => $options,
				'value' => self::FORBIDDEN_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_UCENTER_USERS_FORBIDDEN_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“是否删除”配置
	 * @param integer $type
	 * @return array
	 */
	public function getTrash($type)
	{
		$output = array();
		$options = array(
			self::TRASH_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::TRASH_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'trash';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_TRASH_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_UCENTER_USERS_TRASH_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_TRASH_HINT'),
				'options' => $options,
				'value' => self::TRASH_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_UCENTER_USERS_TRASH_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“所属分组”配置
	 * @param integer $type
	 * @return array
	 */
	public function getGroupIds($type)
	{
		$output = array();
		$options = UcenterFactory::getModel('Groups')->findPairs();

		$name = 'group_ids';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USERS_GROUP_IDS_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'groups',
				'__object__' => 'modules\\ucenter\\form\\UsersGroupsCbElement',
				'type' => 'checkbox',
				'label' => '',
				'hint' => '',
				'options' => $options
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array(), Text::_('MOD_UCENTER_USERS_GROUP_IDS_INARRAY')),
			);
		}

		return $output;
	}

}
