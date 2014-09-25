<?php
/**
 * Trotri
 *
 * @author	Huan Song <trotri@yeah.net>
 * @link	  http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace files\library;

use tfc\ap\Ap;
use tfc\ap\ErrorException;
use tfc\saf\Cfg;
use tfc\saf\Log;
use tfc\util\Upload;

/**
 * UploadProxy class file
 * 上传文件代理操作类
 * <pre>
 * 配置 /cfg/appname/main.php：
 * return array (
 *   'little_picture' => array(
 *     'directory' => 'little_picture/thumb', // 上传目录名，在根目录：DIR_DATA . DS . 'u'下
 *     'name_pre' => '',
 *     'name_rule' => 0, // 保存文件时的命名规则，0：原文件名、1：随机整数格式、2：随机字符串格式、3：日期和时间格式、4：日期和时间+随机整数格式、5：日期和时间+随机字符串格式、6：时间戳格式、7：时间戳+随机整数格式、8：时间戳+随机字符串格式
 *     'max_size' => 2097152, // 允许上传的文件大小最大值，单位：字节
 *     'allow_types' => array(
 *     'image/pjpeg',
 *     'image/jpeg',
 *     'image/gif',
 *     'image/png',
 *     'image/xpng',
 *     'image/wbmp',
 *     'image/bmp',
 *     'image/x-png'
 *   ),
 *   'allow_exts' => 'jpg|gif|png|bmp|zip|rar',
 *   'allow_replace_exists' => false, // 如果保存文件的地址已经存在其他文件，是否允许替换
 *   'dt_format' => 'YmdHis',
 *   'join_str' => '_',
 *   'rand_min' => 10000,
 *   'rand_max' => 99999,
 *   'rand_strlen' => 8
 * )
 *);
 * </pre>
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UploadProxy.php 1 2014-09-21 16:48:06Z huan.song $
 * @package files.library
 * @since 1.0
 */
class UploadProxy
{
	/**
	 * @var integer 上传文件成功
	 */
	const SUCCESS_UPLOAD_NUM      = 0;

	/**
	 * @var integer 参数错误
	 */
	const ERROR_REQUEST           = Upload::ERROR_REQUEST;

	/**
	 * @var integer 上传文件失败：文件大小超过最大限制
	 */
	const ERR_ABOVE_MAX_SIZE      = Upload::ERR_ABOVE_MAX_SIZE;

	/**
	 * @var integer 上传文件失败：文件类型不在可允许的范围内
	 */
	const ERR_DISALLOW_TYPE       = Upload::ERR_DISALLOW_TYPE;

	/**
	 * @var integer 上传文件失败：文件后缀名不在可允许的范围内
	 */
	const ERR_DISALLOW_EXT        = Upload::ERR_DISALLOW_EXT;

	/**
	 * @var integer 上传文件失败：保存文件的地址已经存在其他文件，并且不允许替换
	 */
	const ERR_FILE_ALREADY_EXISTS = Upload::ERR_FILE_ALREADY_EXISTS;

	/**
	 * @var integer 上传文件失败：有可能是攻击性质的上传
	 */
	const ERR_DISALLOW_UPLOAD     = Upload::ERR_DISALLOW_UPLOAD;

	/**
	 * @var integer 上传文件失败：将临时文件更新到指定目录失败
	 */
	const ERR_MOVE_UPLOADED_FILE  = Upload::ERR_MOVE_UPLOADED_FILE;

	/**
	 * @var integer 上传文件失败：未知原因
	 */
	const ERR_UPLOADED_FAILED     = Upload::ERR_UPLOADED_FAILED;

	/**
	 * @var string 配置名
	 */
	const CONFIG_NAME = 'upload';

	/**
	 * @var string 默认的根目录名
	 */
	const DEFAULT_DIR_NAME_ROOT = 'u';

	/**
	 * @var string 默认的目录名规则，由时间组成
	 */
	const DEFAULT_DIR_NAME_RULE = 'Ym/d';

	/**
	 * @var string 寄存上传配置名
	 */
	protected $_clusterName = null;

	/**
	 * @var array 寄存上传配置信息
	 */
	protected $_config = null;

	/**
	 * @var instance of tfc\util\Upload
	 */
	protected $_upload = null;

	/**
	 * @var string 根目录名
	 */
	protected $_dirNameRoot = self::DEFAULT_DIR_NAME_ROOT;

	/**
	 * @var string 目录名规则，由时间组成
	 */
	protected $_dirNameRule = self::DEFAULT_DIR_NAME_RULE;

	/**
	 * 构造方法：初始化上传配置名
	 * @param string $clusterName
	 */
	public function __construct($clusterName)
	{
		$this->_clusterName = $clusterName;
	}

	/**
	 * 检查并上传文件
	 * @param array $files
	 * @return array
	 */
	public function save(array $files)
	{
		$errNo = self::SUCCESS_UPLOAD_NUM;
		$errMsg = '';
		$fileName = '';

		$upload = $this->getUpload();
		try {
			$upload->save($files);
		}
		catch (\Exception $e) {
			$errNo = $e->getCode();
			$errMsg = $e->getMessage();
		}

		$fileName = $upload->getSavePath();
		$url = $this->getUrl($fileName);
		if ($errNo === self::SUCCESS_UPLOAD_NUM) {
			$ret = array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'file_name' => $fileName,
				'url' => $url
			);

			return $ret;
		}

		Log::warning('UploadProxy ' . $errMsg, $errNo,  __METHOD__);
		switch ($errNo) {
			case self::ERROR_REQUEST:
				$errMsg = Lang::_('SRV_FILTER_FILES_UPLOAD_ERROR_REQUEST');
				break;
			case self::ERR_ABOVE_MAX_SIZE:
				$errMsg = sprintf(Lang::_('SRV_FILTER_FILES_UPLOAD_SIZE_MAX'), $files['size'], $upload->getMaxSize());
				break;
			case self::ERR_DISALLOW_TYPE:
				$errMsg = sprintf(Lang::_('SRV_FILTER_FILES_UPLOAD_TYPE_DISALLOW'), $files['type'], implode('|', $upload->getAllowTypes()));
				break;
			case self::ERR_DISALLOW_EXT:
				$errMsg = sprintf(Lang::_('SRV_FILTER_FILES_UPLOAD_EXT_DISALLOW'), $upload->getFileExt($files['name']), implode('|', $upload->getAllowExts()));
				break;
			case self::ERR_FILE_ALREADY_EXISTS:
				$errMsg = sprintf(Lang::_('SRV_FILTER_FILES_UPLOAD_NAME_UNIQUE'), $fileName);
				break;
			case self::ERR_DISALLOW_UPLOAD:
				$errMsg = sprintf(Lang::_('SRV_FILTER_FILES_UPLOAD_POSSIBLE_ATTACK'), $fileName);
				break;
			case self::ERR_MOVE_UPLOADED_FILE:
				$errMsg = sprintf(Lang::_('SRV_FILTER_FILES_UPLOAD_MOVE_FAILED'), $fileName);
				break;
			default:
				$errMsg = Lang::_('SRV_FILTER_FILES_UPLOAD_SAVE_FAILED');
				break;
		}

		$ret = array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'file_name' => '',
			'url' => ''
		);

		return $ret;
	}

	/**
	 * 通过文件名，获取访问该文件的URL
	 * @param string $fileName
	 * @return string
	 */
	public function getUrl($fileName)
	{
		$req = Ap::getRequest();

		$url = str_replace('/webroot', '', $req->baseUrl) . str_replace(array(DIR_ROOT, '\\'), array('', '/'), $fileName);
		return $url;
	}

	/**
	 * 获取上传文件对象
	 * @return tfc\util\Upload
	 */
	public function getUpload()
	{
		if ($this->_upload === null) {
			$config = $this->getConfig();

			$nameRule      = isset($config['name_rule'])            ? (int) $config['name_rule']                : null;
			$replaceExists = isset($config['allow_replace_exists']) ? (boolean) $config['allow_replace_exists'] : null;
			$namePre       = isset($config['name_pre'])             ? trim($config['name_pre'])                 : null;
			$maxSize       = isset($config['max_size'])             ? (int) $config['max_size']                 : null;
			$allowTypes    = isset($config['allow_types'])          ? $config['allow_types']                    : null;
			$allowExts     = isset($config['allow_exts'])           ? trim($config['allow_exts'])               : null;
			$dtFormat      = isset($config['dt_format'])            ? trim($config['dt_format'])                : null;
			$joinStr       = isset($config['join_str'])             ? trim($config['join_str'])                 : null;
			$randMin       = isset($config['rand_min'])             ? (int) $config['rand_min']                 : null;
			$randMax       = isset($config['rand_max'])             ? (int) $config['rand_max']                 : null;
			$randStrlen    = isset($config['rand_strlen'])          ? (int) $config['rand_strlen']              : null;

			$upload = new Upload($this->getDirSave(), $nameRule, $replaceExists);

			$nameRule      === null || $upload->setNameRule($nameRule);
			$replaceExists === null || $upload->setAllowReplaceExists($replaceExists);
			$namePre       === null || $upload->setNamePre($namePre);
			$maxSize       === null || $upload->setMaxSize($maxSize);
			$allowTypes    === null || $upload->setAllowTypes($allowTypes);
			$allowExts     === null || $upload->setAllowExts($allowExts);
			$dtFormat      === null || $upload->setDtFormat($dtFormat);
			$joinStr       === null || $upload->setJoinStr($joinStr);
			$randMin       === null || $upload->setRandMin($randMin);
			$randMax       === null || $upload->setRandMax($randMax);
			$randStrlen    === null || $upload->setRandStrLen($randStrlen);

			$this->_upload = $upload;
		}

		return $this->_upload;
	}

	/**
	 * 获取上传配置信息
	 * @param mixed $key
	 * @return mixed
	 */
	public function getConfig($key = null)
	{
		if ($this->_config === null) {
			$config = Cfg::getApp($this->getClusterName(), self::CONFIG_NAME);
			$this->_config = $config;
		}

		if ($key === null) {
			return $this->_config;
		}

		return isset($this->_config[$key]) ? $this->_config[$key] : null;
	}

	/**
	 * 获取上传文件保存目录
	 * @return string
	 */
	public function getDirSave()
	{
		$directory = $this->getDirRoot();
		$this->mkDir($directory);

		$dirName = $this->getConfig('directory', '');
		if ($dirName !== '') {
			$dirNames = explode('/', $dirName);
			foreach ($dirNames as $value) {
				$directory .= DS . $value;
				$this->mkDir($directory);
			}
		}

		$dirNames = $this->getDirNames();
		foreach ($dirNames as $value) {
			$directory .= DS . $value;
			$this->mkDir($directory);
		}

		return $directory;
	}

	/**
	 * 通过目录名规则，获取目录名
	 * @return array
	 */
	public function getDirNames()
	{
		$ret = array();

		$dirRule = $this->getDirNameRule();
		if ($dirRule === '') {
			return $ret;
		}

		$dirNames = explode('/', date($dirRule));
		foreach ($dirNames as $value) {
			if (($value = trim($value)) !== '') {
				$ret[] = trim($value);
			}
		}

		return $ret;
	}

	/**
	 * 获取根目录
	 * @return string
	 */
	public function getDirRoot()
	{
		return DIR_DATA . DS . $this->getDirNameRoot();
	}

	/**
	 * 获取根目录名
	 * @return string
	 */
	public function getDirNameRoot()
	{
		return $this->_dirNameRoot;
	}

	/**
	 * 设置根目录名
	 * @param string $dirName
	 * @return files\library\UploadProxy
	 */
	public function setDirNameRoot($dirName)
	{
		$this->_dirNameRoot = $dirName;
		return $this;
	}

	/**
	 * 获取目录名规则
	 * @return string
	 */
	public function getDirNameRule()
	{
		return $this->_dirNameRule;
	}

	/**
	 * 设置目录名规则
	 * @param string $dirRule
	 * @return files\library\UploadProxy
	 */
	public function setDirNameRule($dirRule)
	{
		$this->_dirNameRule = trim($dirRule);
		return $this;
	}

	/**
	 * 获取上传配置名
	 * @return string
	 */
	public function getClusterName()
	{
		return $this->_clusterName;
	}

	/**
	 * 新建目录
	 * @param string $directory
	 * @throws ErrorException 如果保存上传文件的目录不存在，抛出异常
	 * @throws ErrorException 如果保存上传文件的目录没有可写权限，抛出异常
	 * @return files\library\UploadProxy
	 */
	public function mkDir($directory)
	{
		if (!is_dir($directory) && !mkdir($directory)) {
			throw new ErrorException(sprintf(
				'UploadProxy save dir "%s" is not a valid directory.', $directory
			));
		}

		if (!is_writeable($directory)) {
			throw new ErrorException(sprintf(
				'UploadProxy save dir "%s" can not writeable.', $directory
			));
		}

		is_file($directory . DS . 'index.html') || file_put_contents($directory . DS . 'index.html', '<!DOCTYPE html><title></title>');
		return $this;
	}
}
