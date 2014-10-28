<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace system\services;

use libsrv\AbstractService;
use tfc\util\FileManager;
use tfc\saf\Log;
use libapp\ErrorNo;

/**
 * Tools class file
 * 业务层：业务处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Tools.php 1 2014-08-19 00:15:56Z Code Generator $
 * @package system.services
 * @since 1.0
 */
class Tools extends AbstractService
{
	/**
	 * @var instance of system\services\Tools
	 */
	protected static $_instance = null;

	/**
	 * 获取本类的实例化对象
	 * @return system\services\Tools
	 */
	public static function getInstance()
	{
		if (self::$_instance === null) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * 清理缓存
	 * @return boolean
	 */
	public static function cacheclear()
	{
		$fileManager = new FileManager();

		$directory = DIR_DATA_RUNTIME_ENTITIES;
		if (!$fileManager->rmDir($directory)) {
			Log::warning(sprintf(
				'Tools Cache clear Failed, Directory: "%s"', $directory
			), ErrorNo::ERROR_CACHE_DELETE,  __METHOD__);
			return false;
		}

		$directory = DIR_DATA_RUNTIME_ROLES;
		if (!$fileManager->rmDir($directory)) {
			Log::warning(sprintf(
				'Tools Cache clear Failed, Directory: "%s"', $directory
			), ErrorNo::ERROR_CACHE_DELETE,  __METHOD__);
			return false;
		}

		return true;
	}

}
