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
use tfc\ap\Singleton;
use tfc\mvc\Mvc;
use tfc\saf\Log;
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

		$params = array('amca_pid' => $this->getAmcaPid());
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
				'table' => array(
					'callback' => array($this, 'getAmcaNameLink')
				),
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
				'value' => $this->getAmcaNameById($amcaPid),
				'disabled' => true,
				'table' => array(
					'callback' => array($this, 'getAmcaPnameTblColumn')
				),
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
				'table' => array(
					'callback' => array($this, 'getCategoryTblColumn')
				),
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
		if (!$this->isMod($data['category'])) {
			return '';
		}

		$params = array(
			'id' => $data['amca_id'],
			'last_index_url' => $this->getLastIndexUrl()
		);

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

		$synchIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconTool(),
			'url' => $this->getUrl('synch', Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('MOD_UCENTER_URLS_AMCAS_CTRLSYNCH'),
		));

		$output = $modifyIcon . $removeIcon . $synchIcon;
		return $output;
	}

	/**
	 * 获取列表页“事件名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getAmcaNameLink($data)
	{
		$params = array(
			'id' => $data['amca_id'],
			'last_index_url' => $this->getLastIndexUrl()
		);

		$url = $this->getUrl(self::ACT_VIEW, Mvc::$controller, Mvc::$module, $params);
		$output = $this->a($data['amca_name'], $url);
		return $output;
	}

	/**
	 * 获取列表页“父事件名”选项
	 * @param array $data
	 * @return string
	 */
	public function getAmcaPnameTblColumn($data)
	{
		return $this->getAmcaNameById($data['amca_pid']);
	}

	/**
	 * 获取列表页“类型”选项
	 * @param array $data
	 * @return string
	 */
	public function getCategoryTblColumn($data)
	{
		$enum = $this->getCategoryEnum();
		return isset($enum[$data['category']]) ? $enum[$data['category']] : $data['category'];
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
	public function getAmcaNameById($value)
	{
		return $this->getColById('amca_name', $value);
	}

	/**
	 * 获取“类型”所有选项
	 * @return array
	 */
	public function getCategoryEnum()
	{
		static $enum = null;
		if ($enum === null) {
			$enum = $this->getData()->getEnum('category');
		}

		return $enum;
	}

	/**
	 * 获取“应用”所有选项
	 * @return array
	 */
	public function getAppEnum()
	{
		static $enum = null;
		if ($enum === null) {
			$enum = $this->getData()->getEnum('app');
		}

		return $enum;
	}

	/**
	 * 验证是否是模块类型
	 * @param string $value
	 * @return boolean
	 */
	public function isMod($value)
	{
		return $this->getService()->isMod($value);
	}

	/**
	 * 通过分析控制器文件，获取指定模块的控制器信息，并入库
	 * @param integer $amcaId
	 * @return void
	 */
	public function synch($amcaId)
	{
		$data = $this->getData();

		Log::echoTrace('Synch Begin ...');

		// 从数据库中读取模块数据
		Log::echoTrace('Query mod from tr_user_amcas Begin ...');
		$ret = $this->findByPk($amcaId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query mod from tr_user_amcas Failed!');
		}
		$mod = $ret['data'];
		if ($mod['category'] !== $data::CATEGORY_MOD) {
			Log::errExit(__LINE__, 'Amcas must be "mod" category!');
		}
		Log::echoTrace('Query mod from tr_user_amcas Successfully');

		// 从数据库中读取应用数据
		Log::echoTrace('Query app from tr_user_amcas Begin ...');
		$ret = $this->findByPk($mod['amca_pid']);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query app from tr_user_amcas Failed!');
		}
		$app = $ret['data'];
		Log::echoTrace('Query app from tr_user_amcas Successfully');

		$appName = $app['amca_name'];
		$modName = $mod['amca_name'];
		$modId = $mod['amca_id'];

		// 从数据库中读取控制器数据
		Log::echoTrace('Query ctrls from tr_user_amcas Begin ...');
		$ret = $this->findAllByPid($modId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query ctrls from tr_user_amcas Failed!');
		}
		$dbCtrls = array();
		foreach ($ret['data'] as $rows) {
			$dbCtrls[$rows['amca_name']] = $rows;
		}
		Log::echoTrace('Query ctrls from tr_user_amcas Successfully');

		// 从文件中读取控制器数据
		Log::echoTrace('Query ctrls from files Begin ...');
		$fileManager = Singleton::getInstance('tfc\util\FileManager');
		$directory = DIR_ROOT . DS . 'app' . DS . $appName . DS . 'modules' . DS . $modName . DS . 'controller';
		if (!$fileManager->isDir($directory)) {
			Log::errExit(__LINE__, sprintf(
				'Ctrl Path "%s" is not a valid directory.', $directory
			));
		}

		$ctrls = array();
		$sort = 0;

		$filePaths = $fileManager->scanDir($directory);
		foreach ($filePaths as $filePath) {
			$ctrlName = basename($filePath, '.php');
			if ($ctrlName === 'index.html') {
				continue;
			}

			$clsName = 'modules\\' . $modName . '\\controller\\' . $ctrlName;
			require_once $filePath;
			$reflector = new \ReflectionClass($clsName);

			$amcaName = strtolower(substr($ctrlName,0, -10));
			$prompt = preg_replace('/.+class\s+file\s+\*\s+(\S+)\s+\*\s+\@author.+/is', '\\1', $reflector->getDocComment());
			$ctrls[$amcaName] = array(
				'amca_pid' => $modId,
				'amca_name' => $amcaName,
				'prompt' => $prompt,
				'sort' => $sort++,
				'category' => $data::CATEGORY_CTRL
			);
		}

		Log::echoTrace('Query ctrls from files Successfully');

		Log::echoTrace('Analyser db and files Begin ...');
		$amcas = array('insert' => array(), 'update' => array(), 'delete' => array());
		foreach ($ctrls as $amcaName => $rows) {
			if (isset($dbCtrls[$amcaName])) {
				if ($dbCtrls[$amcaName]['prompt'] != $rows['prompt']
					|| $dbCtrls[$amcaName]['sort'] != $rows['sort']) {
					$amcas['update'][$dbCtrls[$amcaName]['amca_id']] = $rows;
				}
			}
			else {
				$amcas['insert'][] = $rows;
			}
		}

		foreach ($dbCtrls as $amcaName => $rows) {
			if (!isset($ctrls[$amcaName])) {
				$amcas['delete'][] = $rows['amca_id'];
			}
		}
		Log::echoTrace('Analyser db and files Successfully');

		Log::echoTrace('Import to db Begin ...');
		foreach ($amcas['insert'] as $attributes) {
			$ret = $this->getService()->insert($attributes);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				Log::errExit(__LINE__, sprintf('Insert to tr_user_amcas "%s" Failed!', $attributes['amca_name']));
			}

			Log::echoTrace(sprintf('Insert into tr_user_amcas "%s" Successfully', $attributes['amca_name']));
		}

		foreach ($amcas['update'] as $amcaId => $attributes) {
			$ret = $this->getService()->updateByPk($amcaId, $attributes);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				Log::errExit(__LINE__, sprintf('Update tr_user_amcas "%s" Failed!', $attributes['amca_name']));
			}

			Log::echoTrace(sprintf('Update tr_user_amcas "%s" Successfully', $attributes['amca_name']));
		}

		foreach ($amcas['delete'] as $amcaId) {
			$ret = $this->getService()->deleteByPk($amcaId);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				Log::errExit(__LINE__, sprintf('Delete from tr_user_amcas "%d" Failed!', $amcaId));
			}

			Log::echoTrace(sprintf('Delete from "%d" Successfully', $amcaId));
		}

		Log::echoTrace('Import to db Successfully');

		Log::echoTrace('Synch Successfully');
	}

}
