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

use tfc\ap\Ap;
use tfc\ap\Registry;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use library\Model;
use library\ErrorNo;
use library\PageHelper;

/**
 * Amcas class file
 * 用户可访问的事件
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-04-06 14:43:07Z Code Generator $
 * @package modules.ucenter.model
 * @since 1.0
 */
class Amcas extends Model
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
	 * 获取amca_pid值
	 * @return integer
	 */
	public function getAmcaPid()
	{
		$amcaPid = Ap::getRequest()->getInteger('amca_pid');
		if ($amcaPid <= 0) {
			$id = Ap::getRequest()->getInteger('id');
			if ($id > 0) {
				$amcaPid = $this->getColById('amca_pid', $id);
			}
		}

		if ($amcaPid <= 0) {
			$apps = $this->getData()->getAppEnum();
			$amcaPid = array_shift(array_keys($apps));
		}

		return $amcaPid;
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getElementsRender()
	 */
	public function getElementsRender()
	{
		$amcaPid = $this->getAmcaPid();
		$data = $this->getData();
		$output = array(
			'amca_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_ID_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_ID_HINT'),
				'search' => array(
					'type' => 'text',
				),
			),
			'amca_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'amca_pid' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_HINT'),
				'value' => $amcaPid,
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'amca_pname' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PNAME_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PNAME_HINT'),
				'value' => $this->getAmcaNameByAmcaId($amcaPid),
				'disabled' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'prompt' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_PROMPT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_PROMPT_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'sort' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_SORT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_SORT_HINT'),
				'required' => true,
				'search' => array(
					'type' => 'text',
				),
			),
			'category' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_HINT'),
				'options' => $data->getEnum('category'),
				'value' => $data::CATEGORY_MOD,
				'disabled' => true,
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
		$params = array('id' => $data['amca_id']);
		$componentsBuilder = PageHelper::getComponentsBuilder();

		$modifyIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconModify(),
			'url' => $this->getUrl(self::ACT_MODIFY, Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_MODIFY'),
		));

		$removeIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconRemove(),
			'url' => $this->getUrl(self::ACT_REMOVE, Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncDialogRemove(),
			'title' => Text::_('CFG_SYSTEM_GLOBAL_REMOVE'),
		));

		$output = '' . $modifyIcon . $removeIcon;
		return $output;
	}

	/**
	 * 获取所有的应用提示
	 * @return array
	 */
	public function getAppPrompts()
	{
		$name = __METHOD__;
		if (!Registry::has($name)) {
			$data = $this->getService()->getAppPrompts();
			Registry::set($name, $data);
		}

		return Registry::get($name);
	}

	/**
	 * 通过父ID，获取所有的子事件
	 * @param integer $pid
	 * @return array
	 */
	public function findAllByPid($pid)
	{
		return $this->getService()->findAllByPid($pid);
	}

	/**
	 * 获取模块和控制器类型数据
	 * @param integer $appId
	 * @return array
	 */
	public function findModCtrls($appId)
	{
		return $this->getService()->findModCtrls($appId);
	}

	/**
	 * 通过amca_id获取amca_name值
	 * @param integer $value
	 * @return string
	 */
	public function getAmcaNameByAmcaId($value)
	{
		return $this->getColById('amca_name', $value);
	}

	/**
	 * 验证是否是应用类型
	 * @param integer $value
	 * @return boolean
	 */
	public function isAppById($value)
	{
		return $this->getService()->isAppById($value);
	}

}
