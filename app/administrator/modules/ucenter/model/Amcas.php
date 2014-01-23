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
use tfc\saf\Log;
use koala\Model;
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
			'amca_pid' => $elements->getAmcaPid($type),
			'amca_name' => $elements->getAmcaName($type),
			'prompt' => $elements->getPrompt($type),
			'sort' => $elements->getSort($type),
			'category' => $elements->getCategory($type),
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
			'amca_name' => $elements->getAmcaName($type),
			'prompt' => $elements->getPrompt($type),
			'sort' => $elements->getSort($type),
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
	 * 获取所有的应用名
	 * @return array
	 */
	public function getAppAmcas()
	{
		$ret = $this->findPairsByAttributes(array('amca_id', 'prompt'), array('category' => 'app'), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return array();
		}

		return $ret['data'];
	}

	/**
	 * 同步用户事件
	 * @param integer $amcaId
	 * @return void
	 */
	public function synch($amcaId)
	{
		header('Content-Type: text/html; charset=utf-8');

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
		$ctrls = $this->getCtrlFiles($appName, $modName);
		
		\tfc\saf\debug_dump($ctrls);
	}

	/**
	 * 通过分析文件，获取所有的控制器
	 * @param string $appName
	 * @param string $modName
	 * @return array
	 */
	public function getCtrlFiles($appName, $modName)
	{
		$ret = array();

		$fileManager = Singleton::getInstance('tfc\util\FileManager');
		$directory = DIR_ROOT . DS . 'app' . DS . $appName . DS . 'modules' . DS . $modName . DS . 'controller';
		if (!$fileManager->isDir($directory)) {
			Log::errExit(__LINE__, sprintf(
				'Ctrl Path "%s" is not a valid directory.', $directory
			));
		}

		$filePaths = $fileManager->scanDir($directory);
		foreach ($filePaths as $filePath) {
			$clsName = basename($filePath, '.php');
			if ($clsName === 'index.html') {
				continue;
			}

			if (!($stream = @fopen($filePath, 'r', false))) {
				Log::errExit(__LINE__, sprintf(
					'File "%s" cannot be opened with mode "r"', $filePath
				));
			}

			$isCtrlAmcaName = false;
			while (!feof($stream)) {
				$line = trim(fgets($stream));

				if ($isCtrlAmcaName) {
					$ctrlAmcaName = trim(trim($line, '*'));
					$isCtrlAmcaName = false;
				}

				if (preg_match('/\*\s+' . $clsName . '\s+class\s+file/', $line) ) {
					$isCtrlAmcaName = true;
				}

			}

			fclose($stream);
		}

		return $ret;
	}

}
