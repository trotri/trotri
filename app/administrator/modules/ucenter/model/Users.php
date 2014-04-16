<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\model;

use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Model;
use library\ErrorNo;
use library\PageHelper;

/**
 * Users class file
 * 用户管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Users.php 1 2014-04-15 14:43:50Z Code Generator $
 * @package modules.ucenter.model
 * @since 1.0
 */
class Users extends Model
{
	/**
	 * @var string 查询列表数据Action名
	 */
	const ACT_INDEX = 'index';

	/**
	 * @var string 数据详情Action名
	 */
	const ACT_VIEW = 'view';

	/**
	 * @var string 新增数据Action名
	 */
	const ACT_CREATE = 'create';

	/**
	 * @var string 编辑数据Action名
	 */
	const ACT_MODIFY = 'modify';

	/**
	 * @var string 删除数据Action名
	 */
	const ACT_REMOVE = 'remove';

	/**
	 * @var string 移至回收站Action名
	 */
	const ACT_TRASH = 'trash';

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getLastIndexUrl()
	 */
	public function getLastIndexUrl()
	{
		if (($lastIndexUrl = parent::getLastIndexUrl()) !== '') {
			return $lastIndexUrl;
		}

		$params = array();
		return $this->getUrl(self::ACT_INDEX, Mvc::$controller, Mvc::$module, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getViewTabsRender()
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
	 * (non-PHPdoc)
	 * @see library.Model::getElementsRender()
	 */
	public function getElementsRender()
	{
		$data = $this->getData();
		$isModify = (Mvc::$action === self::ACT_MODIFY) ? true : false;
		$groups = Model::getInstance('Groups')->findPairs();
		$output = array(
			'user_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_UCENTER_USERS_USER_ID_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_USER_ID_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'login_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_LOGIN_NAME_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_LOGIN_NAME_HINT'),
				'required' => $isModify ? false : true,
				'readonly' => $isModify ? true : false,
				'table' => array(
					'callback' => array($this, 'getLoginNameLink')
				),
				'search' => array(
					'type' => 'text',
				),
			),
			'login_type' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_UCENTER_USERS_LOGIN_TYPE_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_LOGIN_TYPE_HINT'),
				'options' => $data->getEnum('login_type'),
				'value' => $data::LOGIN_TYPE_MAIL,
				'search' => array(
					'type' => 'select',
				),
			),
			'password' => array(
				'__tid__' => 'main',
				'type' => 'password',
				'label' => Text::_('MOD_UCENTER_USERS_PASSWORD_LABEL'),
				'hint' => $isModify ? Text::_('MOD_UCENTER_USERS_PASSWORD_MODIFY_HINT') : Text::_('MOD_UCENTER_USERS_PASSWORD_HINT'),
				'required' => $isModify ? false : true,
				'search' => array(
					'type' => 'text',
				),
			),
			'repassword' => array(
				'__tid__' => 'main',
				'type' => 'password',
				'label' => Text::_('MOD_UCENTER_USERS_REPASSWORD_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_REPASSWORD_HINT'),
				'required' => $isModify ? false : true,
				'search' => array(
					'type' => 'text',
				),
			),
			'salt' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_SALT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_SALT_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'user_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_USER_NAME_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_USER_NAME_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'user_mail' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_USER_MAIL_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_USER_MAIL_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'user_phone' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_USER_PHONE_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_USER_PHONE_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'dt_registered' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_DT_REGISTERED_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_DT_REGISTERED_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'dt_last_login' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_DT_LAST_LOGIN_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_DT_LAST_LOGIN_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'dt_last_repwd' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_DT_LAST_REPWD_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_DT_LAST_REPWD_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'ip_registered' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_IP_REGISTERED_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_IP_REGISTERED_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'ip_last_login' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_IP_LAST_LOGIN_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_IP_LAST_LOGIN_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'ip_last_repwd' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_IP_LAST_REPWD_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_IP_LAST_REPWD_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'login_count' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_LOGIN_COUNT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_LOGIN_COUNT_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'repwd_count' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USERS_REPWD_COUNT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_REPWD_COUNT_HINT'),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'valid_mail' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_UCENTER_USERS_VALID_MAIL_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_VALID_MAIL_HINT'),
				'options' => $data->getEnum('valid_mail'),
				'value' => $data::VALID_MAIL_N,
				'table' => array(
					'callback' => array($this, 'getValidMailTblColumn')
				),
				'search' => array(
					'type' => 'select',
				),
			),
			'valid_phone' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_UCENTER_USERS_VALID_PHONE_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_VALID_PHONE_HINT'),
				'options' => $data->getEnum('valid_phone'),
				'value' => $data::VALID_PHONE_N,
				'table' => array(
					'callback' => array($this, 'getValidPhoneTblColumn')
				),
				'search' => array(
					'type' => 'select',
				),
			),
			'forbidden' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_UCENTER_USERS_FORBIDDEN_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_FORBIDDEN_HINT'),
				'options' => $data->getEnum('forbidden'),
				'value' => $data::FORBIDDEN_N,
				'table' => array(
					'callback' => array($this, 'getForbiddenTblColumn')
				),
				'search' => array(
					'type' => 'select',
				),
			),
			'trash' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_UCENTER_USERS_TRASH_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USERS_TRASH_HINT'),
				'options' => $data->getEnum('trash'),
				'value' => $data::TRASH_N,
				'search' => array(
					'type' => 'select',
				),
			),
			'group_ids' => array(
				'__tid__' => 'groups',
				'__object__' => 'views\\bootstrap\\ucenter\\UsersGroupsCbElement',
				'type' => 'checkbox',
				'label' => '',
				'hint' => '',
				'options' => $groups,
				'search' => array(
					'type' => 'select',
				),
			),
			'_button_save_' => PageHelper::getComponentsBuilder()->getButtonSave(),
			'_button_save2close_' => PageHelper::getComponentsBuilder()->getButtonSaveClose(),
			'_button_save2new_' => PageHelper::getComponentsBuilder()->getButtonSaveNew(),
			'_button_cancel_' => PageHelper::getComponentsBuilder()->getButtonCancel(array('url' => $this->getLastIndexUrl())),
			'_button_history_back_' => PageHelper::getComponentsBuilder()->getButtonHistoryBack(array('url' => $this->getLastIndexUrl())),
			'_operate_' => array(
				'label' => Text::_('CFG_SYSTEM_GLOBAL_OPERATE'),
				'table' => array(
					'callback' => array($this, 'getOperate')
				)
			),
		);

		return $output;
	}

	/**
	 * 获取操作图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getOperate($data)
	{
		$params = array('id' => $data['user_id']);
		$componentsBuilder = PageHelper::getComponentsBuilder();

		$modifyIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconModify(),
			'url' => $this->getUrl(self::ACT_MODIFY, Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_MODIFY'),
		));

		$trashIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconRemove(),
			'url' => $this->getUrl(self::ACT_TRASH, Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncDialogRemove(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_REMOVE'),
		));

		$output = '' . $modifyIcon . $trashIcon;
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
			'last_index_url' => $this->getLastIndexUrl()
		);

		$url = $this->getUrl(self::ACT_VIEW, Mvc::$controller, Mvc::$module, $params);
		$output = $this->a($data['login_name'], $url);
		return $output;
	}

	/**
	 * 获取列表页“是否已验证邮箱”选项
	 * @param array $data
	 * @return string
	 */
	public function getValidMailTblColumn($data)
	{
		$params = array(
			'id' => $data['user_id'],
			'column_name' => 'valid_mail',
			'last_index_url' => $this->getLastIndexUrl()
		);

		$url = $this->getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$output = PageHelper::getComponentsBuilder()->getSwitch(array(
			'id' => $data['user_id'],
			'name' => 'valid_mail',
			'value' => $data['valid_mail'],
			'href' => $url
		));

		return $output;
	}

	/**
	 * 获取列表页“是否已验证手机号”选项
	 * @param array $data
	 * @return string
	 */
	public function getValidPhoneTblColumn($data)
	{
		$params = array(
			'id' => $data['user_id'],
			'column_name' => 'valid_phone',
			'last_index_url' => $this->getLastIndexUrl()
		);

		$url = $this->getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$output = PageHelper::getComponentsBuilder()->getSwitch(array(
			'id' => $data['user_id'],
			'name' => 'valid_phone',
			'value' => $data['valid_phone'],
			'href' => $url
		));

		return $output;
	}

	/**
	 * 获取列表页“是否禁用”选项
	 * @param array $data
	 * @return string
	 */
	public function getForbiddenTblColumn($data)
	{
		$params = array(
			'id' => $data['user_id'],
			'column_name' => 'forbidden',
			'last_index_url' => $this->getLastIndexUrl()
		);

		$url = $this->getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$output = PageHelper::getComponentsBuilder()->getSwitch(array(
			'id' => $data['user_id'],
			'name' => 'forbidden',
			'value' => $data['forbidden'],
			'href' => $url
		));

		return $output;
	}

}
