<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\ui\bootstrap;

use ui\bootstrap\Components;
use tfc\ap\Ap;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Url;
use library\UcenterFactory;

/**
 * Users class file
 * 页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Users.php 1 2014-02-11 15:33:01Z huan.song $
 * @package modules.ucenter.ui.bootstrap
 * @since 1.0
 */
class Users
{
	/**
	 * 获取表单的“保存”按钮
	 * @return array
	 */
	public function getButtonSave()
	{
		return Components::getButtonSave();
	}

	/**
	 * 获取表单的“保存并关闭”按钮
	 * @return array
	 */
	public function getButtonSaveClose()
	{
		return Components::getButtonSaveClose();
	}

	/**
	 * 获取表单的“保存并新建”按钮
	 * @return array
	 */
	public function getButtonSaveNew()
	{
		return Components::getButtonSaveNew();
	}

	/**
	 * 获取表单的“取消”按钮
	 * @return array
	 */
	public function getButtonCancel()
	{
		$url = Url::getUrl('index', Mvc::$controller, Mvc::$module);
		return Components::getButtonCancel($url);
	}

	/**
	 * 获取操作图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getOperate($data)
	{
		$params = array(
			'id' => $data['user_id'],
		);

		$modifyUrl = Url::getUrl('modify', Mvc::$controller, Mvc::$module, $params);
		$modifyIcon = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modifyUrl, Components::JSFUNC_HREF, Text::_('CFG_SYSTEM_GLOBAL_MODIFY'));

		$removeUrl = Url::getUrl('remove', Mvc::$controller, Mvc::$module, $params);
		$removeIcon = Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $removeUrl, Components::JSFUNC_DIALOGREMOVE, Text::_('CFG_SYSTEM_GLOBAL_REMOVE'));

		$ret = $modifyIcon . $removeIcon;
		return $ret;
	}

	/**
	 * 获取列表页“登录名：邮箱|用户名|手机号”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getLoginNameUrl($data)
	{
		$params = array('id' => $data['user_id']);

		return Components::getHtml()->a($data['login_name'], Url::getUrl('modify', Mvc::$controller, Mvc::$module, $params));
	}

	/**
	 * 获取列表页“是否已验证邮箱”美化版“是|否”选择项表单元素
	 * @param array $data
	 * @return string
	 */
	public function getValidMailSwitchLabel($data)
	{
		$params = array(
			'id' => $data['user_id'],
			'column_name' => 'valid_mail'
		);

		$modifyUrl = Url::getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$ret = Components::getSwitch($data['user_id'], 'valid_mail', $data['valid_mail'], $modifyUrl);
		return $ret;
	}

	/**
	 * 获取列表页“是否已验证手机号”美化版“是|否”选择项表单元素
	 * @param array $data
	 * @return string
	 */
	public function getValidPhoneSwitchLabel($data)
	{
		$params = array(
			'id' => $data['user_id'],
			'column_name' => 'valid_phone'
		);

		$modifyUrl = Url::getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$ret = Components::getSwitch($data['user_id'], 'valid_phone', $data['valid_phone'], $modifyUrl);
		return $ret;
	}

	/**
	 * 获取列表页“是否禁用”美化版“是|否”选择项表单元素
	 * @param array $data
	 * @return string
	 */
	public function getForbiddenSwitchLabel($data)
	{
		$params = array(
			'id' => $data['user_id'],
			'column_name' => 'forbidden'
		);

		$modifyUrl = Url::getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$ret = Components::getSwitch($data['user_id'], 'forbidden', $data['forbidden'], $modifyUrl);
		return $ret;
	}

}
