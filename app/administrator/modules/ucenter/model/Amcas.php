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
use tfc\ap\Singleton;
use tfc\ap\Registry;
use tfc\mvc\Mvc;
use tfc\saf\Log;
use koala\Model;
use library\Url;
use library\ErrorNo;
use library\UcenterFactory;

/**
 * Amcas class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-01-22 16:43:52Z huan.song $
 * @package modules.ucenter.model
 * @since 1.0
 */
class Amcas extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = UcenterFactory::getDb('Amcas');
		parent::__construct($db);
	}

	/**
	 * 查询模块和控制器类型数据
	 * @param integer $appId
	 * @return array
	 */
	public function findModCtrls($appId)
	{
		$data = array();

		$ret = $this->findAllByAttributes(array('amca_pid' => (int) $appId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$appAmcas = $ret['data'];
		foreach ($appAmcas as $rows) {
			$ret = $this->findAllByAttributes(array('amca_pid' => $rows['amca_id']), 'sort');
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				return $ret;
			}

			$ctrlAmcas = $ret['data'];
			$data[] = $rows;
			foreach ($ctrlAmcas as $rows) {
				$rows['amca_name'] = ' ---- ' . $rows['amca_name'];
				$data[] = $rows;
			}
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => $this->_('ERROR_MSG_SUCCESS_SELECT'),
			'data' => $data
		);
	}

	/**
	 * 获取所有数据
	 * @return array
	 */
	public function findPairsByRecur()
	{
		$amcas = array();

		$ret = $this->findAllByAttributes(array('amca_pid' => 0), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $amcas;
		}

		$apps = $ret['data'];
		foreach ($apps as $app) {
			$ret = $this->findAllByAttributes(array('amca_pid' => $app['amca_id']), 'sort');
			$app['rows'] = $mods = array();
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$mods = $ret['data'];
			}

			foreach ($mods as $mod) {
				$ret = $this->findAllByAttributes(array('amca_pid' => $mod['amca_id']), 'sort');
				$mod['rows'] = $ctrls = array();
				if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
					$ctrls = $ret['data'];
				}

				foreach ($ctrls as $ctrl) {
					$ret = $this->findAllByAttributes(array('amca_pid' => $ctrl['amca_id']), 'sort');
					$ctrl['rows'] = $acts = array();
					if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
						$acts = $ret['data'];
					}

					foreach ($acts as $act) {
						$ctrl['rows'][$act['amca_name']] = $act;
					}

					$mod['rows'][$ctrl['amca_name']] = $ctrl;
				}

				$app['rows'][$mod['amca_name']] = $mod;
			}

			$amcas[$app['amca_name']] = $app;
		}

		return $amcas;
	}

	/**
	 * 新增一条记录，只能增加“应用”和“模块”类型事件
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		if (isset($params['amca_pid'])) {
			$amcaPid = (int) $params['amca_pid'];
			$params['category'] = ($amcaPid > 0) ? 'mod' : 'app';
		}

		return $this->insert($params);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		unset($params['amca_name']);
		unset($params['category']);
		unset($params['amca_pid']);
		return $this->updateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = UcenterFactory::getElements('Amcas');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'amca_name' => $elements->getAmcaName($type),
			'prompt' => $elements->getPrompt($type),
			'category' => $elements->getCategory($type),
			'amca_pid' => $elements->getAmcaPid($type),
			'sort' => $elements->getSort($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = UcenterFactory::getElements('Amcas');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'prompt' => $elements->getPrompt($type),
			'sort' => $elements->getSort($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getCleanRulesBeforeValidator()
	 */
	public function getCleanRulesBeforeValidator()
	{
		$output = array(
			'amca_name' => array($this, 'cleanXss'),
			'prompt' => array($this, 'cleanXss'),
		);

		return $output;
	}

	/**
	 * 通过amca_id获取category值
	 * @param integer $value
	 * @return string
	 */
	public function getCategoryByAmcaId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('category', $value);
			$category = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['category'];
			Registry::set($name, $category);
		}

		return Registry::get($name);
	}

	/**
	 * 通过amca_id获取amca_name值
	 * @param integer $value
	 * @return string
	 */
	public function getAmcaNameByAmcaId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('amca_name', $value);
			$amcaName = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['amca_name'];
			Registry::set($name, $amcaName);
		}

		return Registry::get($name);
	}

	/**
	 * 通过amca_id获取amca_pid值
	 * @param integer $value
	 * @return integer
	 */
	public function getAmcaPidByAmcaId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('amca_pid', $value);
			$amcaPid = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['amca_pid'];
			Registry::set($name, $amcaPid);
		}

		return Registry::get($name);
	}

	/**
	 * 获取所有的应用名
	 * @return array
	 */
	public function getAppAmcas()
	{
		$name = __METHOD__;
		if (!Registry::has($name)) {
			$ret = $this->findPairsByAttributes(array('amca_id', 'prompt'), array('category' => 'app'), 'sort');
			$data = array();
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$data = $ret['data'];
			}

			Registry::set($name, $data);
		}

		return Registry::get($name);
	}

	/**
	 * 通过父ID和事件名统计记录数
	 * @param integer $amcaPid
	 * @param string $amcaName
	 * @return integer
	 */
	public function countByPidAndName($amcaPid, $amcaName)
	{
		$ret = $this->countByAttributes(array(
			'amca_pid' => (int) $amcaPid,
			'amca_name' => $amcaName
		));

		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			return $ret['total'];
		}

		return false;
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

		return $amcaPid;
	}

	/**
	 * 同步用户事件
	 * @param integer $amcaId
	 * @return void
	 */
	public function synch($amcaId)
	{
		echo 'Synch Start ...<br/>';
		$modId = (int) $amcaId;
		if ($modId <= 0) {
			Log::errExit(__LINE__, 'amca_id must be a integer.');
		}

		$ret = $this->findByPk($modId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, $ret['err_msg']);
		}

		if ($ret['data']['category'] !== 'mod') {
			Log::errExit(__LINE__, sprintf(
				'user amcas (amca_id=%d) category must be "mod"', $modId
			));
		}

		$modName = $ret['data']['amca_name'];
		$appId = $ret['data']['amca_pid'];

		$ret = $this->findByPk($appId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, $ret['err_msg']);
		}

		$appName = $ret['data']['amca_name'];
		$fileAmcas = $this->refCtrlFiles($appName, $modName);

		echo 'Synch Ctrl Start ...<br/>';
		$ctrlAnalyser = $this->_getCtrlAnalyser($modId, $fileAmcas['ctrl_amcas']);
		$this->_synchAnalyser($ctrlAnalyser);
		echo 'Synch Ctrl End ...<br/>';

		$ret = $this->findPairsByAttributes(array('amca_name', 'amca_id'), array('amca_pid' => $modId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, $ret['err_msg']);
		}

		echo 'Synch Act Start ...<br/>';
		foreach ($ret['data'] as $ctrlName => $ctrlId) {
			if (!isset($fileAmcas['act_amcas'][$ctrlName])) {
				continue;
			}

			echo 'Synch "' . $ctrlName . '" Act Start ...<br/>';
			$actAnalyser = $this->_getActAnalyser($ctrlId, $fileAmcas['act_amcas'][$ctrlName]);
			$this->_synchAnalyser($actAnalyser);
			echo 'Synch "' . $ctrlName . '" Act End ...<br/>';
		}
		echo 'Synch Act End ...<br/>';

		echo 'Synch End ...<br/>';

		$url = Url::getUrl('index', Mvc::$controller, Mvc::$module, array('app_id' => $appId));
		echo '<a href="' . $url . '">Go Back !!!</a>';
	}

	/**
	 * 分析数据，获取对行动的增删改
	 * @param integer $ctrlId
	 * @param array $fileAmcas
	 * @return array
	 */
	protected function _getActAnalyser($ctrlId, $fileAmcas)
	{
		$ctrlId = (int) $ctrlId;
		$ret = $this->findAllByAttributes(array('amca_pid' => $ctrlId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, $ret['err_msg']);
		}

		$dbAmcas = array();
		foreach ($ret['data'] as $rows) {
			$dbAmcas[$rows['amca_name']] = $rows;
		}

		$ret = array('insert' => array(), 'update' => array(), 'delete' => array());

		foreach ($fileAmcas as $actName => $fileAmca) {
			if (isset($dbAmcas[$actName])) {
				if ($dbAmcas[$actName]['prompt'] != $fileAmca['prompt']
					|| $dbAmcas[$actName]['sort'] != $fileAmca['sort']) {
					$ret['update'][$dbAmcas[$actName]['amca_id']] = $fileAmca;
				}
			}
			else {
				$fileAmca['amca_pid'] = $ctrlId;
				$ret['insert'][] = $fileAmca;
			}
		}

		foreach ($dbAmcas as $actName => $dbAmca) {
			if (!isset($fileAmcas[$actName])) {
				$ret['delete'][] = $dbAmca['amca_id'];
			}
		}

		return $ret;
	}

	/**
	 * 分析数据，获取对控制器的增删改
	 * @param integer $modId
	 * @param array $fileAmcas
	 * @return array
	 */
	protected function _getCtrlAnalyser($modId, $fileAmcas)
	{
		$modId = (int) $modId;
		$ret = $this->findAllByAttributes(array('amca_pid' => $modId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, $ret['err_msg']);
		}

		$dbAmcas = array();
		foreach ($ret['data'] as $rows) {
			$dbAmcas[$rows['amca_name']] = $rows;
		}

		$ret = array('insert' => array(), 'update' => array(), 'delete' => array());

		foreach ($fileAmcas as $ctrlName => $fileAmca) {
			if (isset($dbAmcas[$ctrlName])) {
				if ($dbAmcas[$ctrlName]['prompt'] != $fileAmca['prompt']
					|| $dbAmcas[$ctrlName]['sort'] != $fileAmca['sort']) {
					$ret['update'][$dbAmcas[$ctrlName]['amca_id']] = $fileAmca;
				}
			}
			else {
				$fileAmca['amca_pid'] = $modId;
				$ret['insert'][] = $fileAmca;
			}
		}

		foreach ($dbAmcas as $ctrlName => $dbAmca) {
			if (!isset($fileAmcas[$ctrlName])) {
				$ret['delete'][] = $dbAmca['amca_id'];
			}
		}

		return $ret;
	}

	/**
	 * 通过分析结果，同步控制器信息
	 * @param array $analyser
	 * @return void
	 */
	protected function _synchAnalyser($analyser)
	{
		foreach ($analyser['insert'] as $attributes) {
			$ret = $this->getDb()->insert($attributes);
			if ($ret === false || $ret <= 0) {
				Log::errExit(sprintf(
					'%s, attributes "%s"', $this->_('ERROR_MSG_ERROR_DB_INSERT'), serialize($attributes)
				));
			}

			echo 'Insert "' . $attributes['amca_name'] . '" ...<br/>';
		}

		foreach ($analyser['update'] as $amcaId => $attributes) {
			$ret = $this->getDb()->updateByPk($amcaId, $attributes);
			if ($ret === false) {
				Log::errExit(sprintf(
					'%s pk "%d", attributes "%s"', $this->_('ERROR_MSG_ERROR_DB_UPDATE'), $amcaId, serialize($attributes)
				));
			}

			echo 'Update "' . $attributes['amca_name'] . '" ...<br/>';
		}

		foreach ($analyser['delete'] as $amcaId) {
			$ret = $this->getDb()->deleteByPk($amcaId);
			if ($ret === false) {
				Log::errExit(sprintf(
					'%s pk "%d"', $this->_('ERROR_MSG_ERROR_DB_DELETE'), $amcaId
				));
			}

			echo 'Delete "' . $amcaId . '" ...<br/>';
		}
	}

	/**
	 * 通过分析文件，获取所有的控制器信息
	 * @param string $appName
	 * @param string $modName
	 * @return array
	 */
	public function refCtrlFiles($appName, $modName)
	{
		$ret = array();
		$ctrlSort = 0;

		$fileManager = Singleton::getInstance('tfc\util\FileManager');
		$directory = DIR_ROOT . DS . 'app' . DS . $appName . DS . 'modules' . DS . $modName . DS . 'controller';
		if (!$fileManager->isDir($directory)) {
			Log::errExit(__LINE__, sprintf(
				'Ctrl Path "%s" is not a valid directory.', $directory
			));
		}

		$filePaths = $fileManager->scanDir($directory);
		foreach ($filePaths as $filePath) {
			$ctrlName = basename($filePath, '.php');
			if ($ctrlName === 'index.html') {
				continue;
			}

			$clsName = 'modules\\' . $modName . '\\controller\\' . $ctrlName;
			require_once $filePath;
			$reflector = new \ReflectionClass($clsName);

			$ctrlPrompt = preg_replace('/.+class\s+file\s+\*\s+(\S+)\s+\*\s+\@author.+/is', '\\1', $reflector->getDocComment());

			$actAmcas = array();
			$actSort = 0;
			$methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC);
			foreach ($methods as $method) {
				$class = $method->getDeclaringClass()->getShortName();
				if ($class !== $ctrlName) {
					continue;
				}

				$actName = $method->getName();
				$actPrompt = preg_replace('/.*\*\*\s+\*\s+(\S+)\s+\*.*/is', '\\1', $method->getDocComment());
				$actAmcas[$actName] = array(
					'amca_name' => $actName,
					'prompt' => $actPrompt,
					'sort' => ++$actSort,
					'category' => 'act',
				);
			}

			$ret['ctrl_amcas'][$ctrlName] = array(
				'amca_name' => $ctrlName,
				'prompt' => $ctrlPrompt,
				'sort' => ++$ctrlSort,
				'category' => 'ctrl',
			);

			$ret['act_amcas'][$ctrlName] = $actAmcas;
		}

		return $ret;
	}

}
