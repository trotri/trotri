<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\user\service;

use tfc\ap\Ap;
use tfc\ap\Singleton;
use tfc\saf\Text;
use tfc\saf\Log;
use app\Service;
use ucenter\models\DataAmcas;
use ucenter\db\Amcas AS DbAmcas;
use library\SModUcenter;
use library\ErrorNo;

/**
 * Amcas class file
 * 用户可访问的事件
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-04-06 14:43:07Z huan.song $
 * @package modules.user.service
 * @since 1.0
 */
class Amcas extends Service
{
	/**
	 * @var instance of ucenter\models\Amcas
	 */
	protected $_modAmcas = null;

	/**
	 * 初始化业务层模型类
	 */
	public function _init()
	{
		$this->_modAmcas = SModUcenter::getInstance('Amcas');
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
				$amcaPid = $this->getAmcaPidByAmcaId($id);
			}
		}

		if ($amcaPid <= 0) {
			$apps = array_keys($this->findAppPrompts());
			$amcaPid = array_shift($apps);
		}

		return $amcaPid;
	}

	/**
	 * (non-PHPdoc)
	 * @see app.Elements::getElementsRender()
	 */
	public function getElementsRender()
	{
		$output = array(
			'amca_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_USER_USER_AMCAS_AMCA_ID_LABEL'),
				'hint' => Text::_('MOD_USER_USER_AMCAS_AMCA_ID_HINT'),
			),
			'amca_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_USER_USER_AMCAS_AMCA_NAME_LABEL'),
				'hint' => Text::_('MOD_USER_USER_AMCAS_AMCA_NAME_HINT'),
				'required' => true,
			),
			'amca_pid' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_USER_USER_AMCAS_AMCA_PID_LABEL'),
				'hint' => Text::_('MOD_USER_USER_AMCAS_AMCA_PID_HINT'),
				'required' => true,
			),
			'amca_pname' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_USER_USER_AMCAS_AMCA_PNAME_LABEL'),
				'hint' => Text::_('MOD_USER_USER_AMCAS_AMCA_PNAME_HINT'),
				'disabled' => true,
			),
			'prompt' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_USER_USER_AMCAS_PROMPT_LABEL'),
				'hint' => Text::_('MOD_USER_USER_AMCAS_PROMPT_HINT'),
				'required' => true,
			),
			'sort' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_USER_USER_AMCAS_SORT_LABEL'),
				'hint' => Text::_('MOD_USER_USER_AMCAS_SORT_HINT'),
				'required' => true,
			),
			'category' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_USER_USER_AMCAS_CATEGORY_LABEL'),
				'hint' => Text::_('MOD_USER_USER_AMCAS_CATEGORY_HINT'),
				'options' => DataAmcas::getCategoryEnum(),
				'value' => DataAmcas::CATEGORY_MOD,
				'disabled' => true,
			),
		);

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
		);

		$url = $this->urlManager->getUrl($this->actNameView, $this->controller, $this->module, $params);
		$output = $this->html->a($data['amca_name'], $url);
		return $output;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
		return $this->findByAmcaId($value);
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $amcaId
	 * @return array
	 */
	public function findByAmcaId($amcaId)
	{
		$ret = $this->callFetchMethod($this->_modAmcas, 'findByAmcaId', array($amcaId));
		return $ret;
	}

	/**
	 * 获取所有的应用提示
	 * @return array
	 */
	public function findAppPrompts()
	{
		return $this->_modAmcas->findAppPrompts();
	}

	/**
	 * 通过父ID，获取所有的子事件
	 * @param integer $amcaPid
	 * @return array
	 */
	public function findAllByAmcaPid($amcaPid)
	{
		$ret = $this->callFetchMethod($this->_modAmcas, 'findAllByAmcaPid', array($amcaPid));
		return $ret;
	}

	/**
	 * 获取模块和控制器类型数据
	 * @param integer $appId
	 * @return array
	 */
	public function findModCtrls($appId)
	{
		$ret = $this->callFetchMethod($this->_modAmcas, 'findModCtrls', array($appId, ' ---- '));
		return $ret;
	}

	/**
	 * 递归模式获取所有数据
	 * @return array
	 */
	public function findAllByRecur()
	{
		$ret = $this->callFetchMethod($this->_modAmcas, 'findAllByRecur');
		return $ret;
	}

	/**
	 * 通过事件ID，获取事件名
	 * @param integer $amcaId
	 * @return string
	 */
	public function getAmcaNameByAmcaId($amcaId)
	{
		return $this->_modAmcas->getAmcaNameByAmcaId($amcaId);
	}

	/**
	 * 通过事件ID，获取类型
	 * @param integer $amcaId
	 * @return string
	 */
	public function getCategoryByAmcaId($amcaId)
	{
		return $this->_modAmcas->getCategoryByAmcaId($amcaId);
	}

	/**
	 * 通过事件ID，获取类型
	 * @param integer $amcaId
	 * @return string
	 */
	public function getCategoryLangByAmcaId($amcaId)
	{
		return $this->_modAmcas->getCategoryLangByAmcaId($amcaId);
	}

	/**
	 * 通过类型，获取类型名
	 * @param string $category
	 * @return string
	 */
	public function getCategoryLangByCategory($category)
	{
		return $this->_modAmcas->getCategoryLangByCategory($category);
	}

	/**
	 * 验证是否是应用类型
	 * @param string $category
	 * @return boolean
	 */
	public function isApp($category)
	{
		return $this->_modAmcas->isApp($category);
	}

	/**
	 * 验证是否是模块类型
	 * @param string $category
	 * @return boolean
	 */
	public function isMod($category)
	{
		return $this->_modAmcas->isMod($category);
	}

	/**
	 * 验证是否是控制器类型
	 * @param string $category
	 * @return boolean
	 */
	public function isCtrl($category)
	{
		return $this->_modAmcas->isCtrl($category);
	}

	/**
	 * 验证是否是行动类型
	 * @param string $category
	 * @return boolean
	 */
	public function isAct($category)
	{
		return $this->_modAmcas->isAct($category);
	}

	/**
	 * 通过事件ID，获取提示
	 * @param integer $amcaId
	 * @return string
	 */
	public function getPromptByAmcaId($amcaId)
	{
		return $this->_modAmcas->getPromptByAmcaId($amcaId);
	}

	/**
	 * 通过事件ID，获取父事件ID
	 * @param integer $amcaId
	 * @return integer
	 */
	public function getAmcaPidByAmcaId($amcaId)
	{
		return $this->_modAmcas->getAmcaPidByAmcaId($amcaId);
	}

	/**
	 * 通过事件ID，获取父事件名
	 * @param integer $amcaId
	 * @return string
	 */
	public function getAmcaPnameByAmcaId($amcaId)
	{
		return $this->_modAmcas->getAmcaPnameByAmcaId($amcaId);
	}

	/**
	 * 通过父ID和事件名统计记录数
	 * @param integer $amcaPid
	 * @param string $amcaName
	 * @return integer
	 */
	public function countByPidAndName($amcaPid, $amcaName)
	{
		return $this->_modAmcas->countByPidAndName($amcaPid, $amcaName);
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return array
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$params['category'] = DataAmcas::CATEGORY_MOD;
		$ret = $this->callCreateMethod($this->_modAmcas, 'create', $params, $ignore);
		return $ret;
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $amcaId
	 * @param array $params
	 * @return array
	 */
	public function modify($amcaId, array $params = array())
	{
		$ret = $this->callModifyMethod($this->_modAmcas, 'modify', $amcaId, $params);
		return $ret;
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $amcaId
	 * @return array
	 */
	public function remove($amcaId)
	{
		$ret = $this->callRemoveMethod($this->_modAmcas, 'remove', $amcaId);
		return $ret;
	}

	/**
	 * 通过分析控制器文件，获取指定模块的控制器信息，并入库
	 * @param integer $amcaId
	 * @return void
	 */
	public function synch($amcaId)
	{
		Log::echoTrace('Synch Begin ...');

		// 从数据库中读取模块数据
		Log::echoTrace('Query mod from table Begin ...');
		$ret = $this->findByAmcaId($amcaId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query mod from table Failed!');
		}
		$mod = $ret['data'];
		if (!$this->isMod($mod['category'])) {
			Log::errExit(__LINE__, 'Amcas must be "mod" category!');
		}
		Log::echoTrace('Query mod from table Successfully');

		// 从数据库中读取应用数据
		Log::echoTrace('Query app from table Begin ...');
		$ret = $this->findByAmcaId($mod['amca_pid']);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query app from table Failed!');
		}
		$app = $ret['data'];
		Log::echoTrace('Query app from table Successfully');

		$appName = $app['amca_name'];
		$modName = $mod['amca_name'];
		$modId = $mod['amca_id'];

		// 从数据库中读取控制器数据
		Log::echoTrace('Query ctrls from table Begin ...');
		$ret = $this->findAllByAmcaPid($modId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query ctrls from table Failed!');
		}
		$dbCtrls = array();
		foreach ($ret['data'] as $rows) {
			$dbCtrls[$rows['amca_name']] = $rows;
		}
		Log::echoTrace('Query ctrls from table Successfully');

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
				'category' => DataAmcas::CATEGORY_CTRL
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

		$dbAmcas = new DbAmcas();
		Log::echoTrace('Import to db Begin ...');
		foreach ($amcas['insert'] as $attributes) {
			$ret = $dbAmcas->create($attributes);
			if (!$ret) {
				Log::errExit(__LINE__, sprintf('Insert to table "%s" Failed!', $attributes['amca_name']));
			}

			Log::echoTrace(sprintf('Insert into table "%s" Successfully', $attributes['amca_name']));
		}

		foreach ($amcas['update'] as $amcaId => $attributes) {
			$ret = $dbAmcas->modify($amcaId, $attributes);
			if (!$ret) {
				Log::errExit(__LINE__, sprintf('Update table "%s" Failed!', $attributes['amca_name']));
			}

			Log::echoTrace(sprintf('Update table "%s" Successfully', $attributes['amca_name']));
		}

		foreach ($amcas['delete'] as $amcaId) {
			$ret = $dbAmcas->remove($amcaId);
			if (!$ret) {
				Log::errExit(__LINE__, sprintf('Delete from table "%d" Failed!', $amcaId));
			}

			Log::echoTrace(sprintf('Delete from "%d" Successfully', $amcaId));
		}

		Log::echoTrace('Import to db Successfully');
		Log::echoTrace('Synch Successfully');
	}
}
