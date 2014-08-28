<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\users\model;

use library\BaseModel;
use tfc\saf\Text;
use tfc\saf\Cfg;
use tid\Authentication;
use users\library\Lang;
use users\services\DataUsers;
use libsrv\Service;
use libapp\Model;

/**
 * Users class file
 * 用户管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Users.php 1 2014-08-08 14:05:27Z Code Generator $
 * @package modules.users.model
 * @since 1.0
 */
class Users extends BaseModel
{
	/**
	 * (non-PHPdoc)
	 * @see \libapp\Elements::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
			'groups' => array(
				'tid' => 'groups',
				'prompt' => Text::_('MOD_USERS_USERS_VIEWTAB_GROUPS_PROMPT')
			),
			'system' => array(
				'tid' => 'system',
				'prompt' => Text::_('MOD_USERS_USERS_VIEWTAB_SYSTEM_PROMPT')
			),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see \libapp\Elements::getElementsRender()
	 */
	public function getElementsRender()
	{
		$output = array(
			'user_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_USERS_USERS_USER_ID_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_USER_ID_HINT'),
			),
			'login_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_LOGIN_NAME_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_LOGIN_NAME_HINT'),
				'required' => true,
			),
			'login_type' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_USERS_USERS_LOGIN_TYPE_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_LOGIN_TYPE_HINT'),
				'options' => DataUsers::getLoginTypeEnum(),
				'value' => DataUsers::LOGIN_TYPE_MAIL,
			),
			'password' => array(
				'__tid__' => 'main',
				'type' => 'password',
				'label' => Text::_('MOD_USERS_USERS_PASSWORD_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_PASSWORD_HINT'),
				'required' => true,
			),
			'repassword' => array(
				'__tid__' => 'main',
				'type' => 'password',
				'label' => Text::_('MOD_USERS_USERS_REPASSWORD_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_REPASSWORD_HINT'),
				'required' => true,
			),
			'user_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_USER_NAME_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_USER_NAME_HINT'),
			),
			'user_mail' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_USER_MAIL_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_USER_MAIL_HINT'),
			),
			'user_phone' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_USER_PHONE_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_USER_PHONE_HINT'),
			),
			'dt_registered' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_DT_REGISTERED_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_DT_REGISTERED_HINT'),
				'disabled' => true,
			),
			'dt_last_login' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_DT_LAST_LOGIN_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_DT_LAST_LOGIN_HINT'),
				'disabled' => true,
			),
			'dt_last_repwd' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_DT_LAST_REPWD_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_DT_LAST_REPWD_HINT'),
				'disabled' => true,
			),
			'ip_registered' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_IP_REGISTERED_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_IP_REGISTERED_HINT'),
				'disabled' => true,
			),
			'ip_last_login' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_IP_LAST_LOGIN_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_IP_LAST_LOGIN_HINT'),
				'disabled' => true,
			),
			'ip_last_repwd' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_IP_LAST_REPWD_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_IP_LAST_REPWD_HINT'),
				'disabled' => true,
			),
			'login_count' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_LOGIN_COUNT_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_LOGIN_COUNT_HINT'),
				'disabled' => true,
			),
			'repwd_count' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_USERS_USERS_REPWD_COUNT_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_REPWD_COUNT_HINT'),
				'disabled' => true,
			),
			'valid_mail' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_USERS_USERS_VALID_MAIL_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_VALID_MAIL_HINT'),
				'options' => DataUsers::getValidMailEnum(),
				'value' => DataUsers::VALID_MAIL_N,
			),
			'valid_phone' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_USERS_USERS_VALID_PHONE_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_VALID_PHONE_HINT'),
				'options' => DataUsers::getValidPhoneEnum(),
				'value' => DataUsers::VALID_PHONE_N,
			),
			'forbidden' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_USERS_USERS_FORBIDDEN_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_FORBIDDEN_HINT'),
				'options' => DataUsers::getForbiddenEnum(),
				'value' => DataUsers::FORBIDDEN_N,
			),
			'trash' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_USERS_USERS_TRASH_LABEL'),
				'hint' => Text::_('MOD_USERS_USERS_TRASH_HINT'),
				'options' => DataUsers::getTrashEnum(),
				'value' => DataUsers::TRASH_N,
			),
			'group_ids' => array(
				'__tid__' => 'groups',
				'__object__' => 'views\\bootstrap\\users\\UserGroupsCheckboxElement',
				'type' => 'checkbox',
				'label' => '',
				'hint' => '',
			),
			'group_id' => array(
				'__tid__' => 'main',
				'type' => 'select',
				'label' => Text::_('MOD_USERS_USERS_GROUP_ID_LABEL'),
			),
		);

		return $output;
	}

	/**
	 * 获取列表页“登录名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getLoginNameLink($data)
	{
		$params = array(
			'id' => $data['user_id'],
		);

		$url = $this->urlManager->getUrl($this->actNameView, $this->controller, $this->module, $params);
		$output = $this->html->a($data['login_name'], $url);
		return $output;
	}

	/**
	 * 获取“是否已验证邮箱”
	 * @param string $validMail
	 * @return string
	 */
	public function getValidMailLangByValidMail($validMail)
	{
		$ret = $this->getService()->getValidMailLangByValidMail($validMail);
		return $ret;
	}

	/**
	 * 获取“是否已验证手机号”
	 * @param string $validPhone
	 * @return string
	 */
	public function getValidPhoneLangByValidPhone($validPhone)
	{
		$ret = $this->getService()->getValidPhoneLangByValidPhone($validPhone);
		return $ret;
	}

	/**
	 * 获取“是否禁用”
	 * @param string $forbidden
	 * @return string
	 */
	public function getForbiddenLangByForbidden($forbidden)
	{
		$ret = $this->getService()->getForbiddenLangByForbidden($forbidden);
		return $ret;
	}

	/**
	 * 查询数据列表
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $limit = null, $offset = null)
	{
		$rules = array(
			'login_name' => 'trim',
			'user_id' => 'intval',
			'login_type' => 'trim',
			'user_name' => 'trim',
			'user_mail' => 'trim',
			'user_phone' => 'trim',
			'valid_mail' => 'trim',
			'valid_phone' => 'trim',
			'forbidden' => 'trim',
			'trash' => 'trim',
			'group_id' => 'intval'
		);

		$this->filterCleanEmpty($params, $rules);
		$ret = parent::search($this->getService(), $params, $order, $limit, $offset);
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see \library\BaseModel::findByPk()
	 */
	public function findByPk($value)
	{
		$ret = parent::findByPk($value);
		if (isset($ret['data']) && is_array($ret['data'])) {
			if (isset($ret['data']['ip_registered'])) {
				$ret['data']['ip_registered'] = long2ip($ret['data']['ip_registered']);
			}

			if (isset($ret['data']['ip_last_login'])) {
				$ret['data']['ip_last_login'] = long2ip($ret['data']['ip_last_login']);
			}

			if (isset($ret['data']['ip_last_repwd'])) {
				$ret['data']['ip_last_repwd'] = long2ip($ret['data']['ip_last_repwd']);
			}

			if (isset($ret['data']['password'])) {
				$ret['data']['password'] = '';
			}
		}

		return $ret;
	}

	/**
	 * 递归方式获取所有的组名，用|—填充子类别左边用于和父类别错位
	 * @return array
	 */
	public function getGroupIds()
	{
		return Model::getInstance('Groups')->getOptions(0, '|—');
	}

	/**
	 * 用户登录
	 * @param string $loginName
	 * @param string $password
	 * @param boolean $rememberMe
	 * @param string $history
	 * @return array
	 */
	public function login($loginName, $password, $rememberMe = false, $history = '')
	{
		$ret = $this->getService()->login($loginName, $password);

		$errNo = DataUsers::ERROR_LOGIN_UNKNOWN_WRONG;
		$errMsg = Lang::_('SRV_FILTER_USERS_LOGIN_UNKNOWN_WRONG');

		$userId = 0;
		$loginName = $password = '';

		if (isset($ret['err_no'])) {
			$errNo = (int) $ret['err_no'];
		}

		if (isset($ret['err_msg'])) {
			$errMsg = $ret['err_msg'];
		}

		if (isset($ret['user_id'])) {
			$userId = (int) $ret['user_id'];
		}

		if (isset($ret['login_name'])) {
			$loginName = $ret['login_name'];
		}

		if (isset($ret['password'])) {
			$password = $ret['password'];
		}

		if (($history = trim($history)) === '') {
			$history = Service::getInstance('Options', 'system')->getSiteUrl();
		}

		if ($errNo === DataUsers::SUCCESS_LOGIN_NUM) {
			$passwordExpiry = $rememberMe ? Cfg::getApp('password_expiry', 'login') : 0;
			$loginNameExpiry = Cfg::getApp('login_name_expiry', 'login') + mktime();

			$auth = new Authentication('login');
			$auth->setIdentity($userId, $loginName, $password, $passwordExpiry);
			$auth->getCookie()->add('unick', $loginName, $loginNameExpiry);
		}

		$ret = array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => array(
				'user_id' => $userId,
				'login_name' => $loginName,
				'remember_me' => $rememberMe,
				'history' => $history
			)
		);

		return $ret;
	}
}
