<?php
/**
 * Trotri Foundation Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tfc\util;

use tfc\ap\ErrorException;

/**
 * FileManager class file
 * 文件管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FileManager.php 1 2013-03-29 16:48:06Z huan.song $
 * @package tfc.util
 * @since 1.0
 */
class FileManager
{
	/**
	 * 新建目录
	 * @param string $fileName
	 * @param integer $mode 文件权限，8进制
	 * @param boolean $recursive 递归创建所有目录
	 * @param resource $context
	 * @return boolean
	 */
	public function mkDir($fileName, $mode = 0777, $recursive = false, $context = null)
	{
		if ($this->isDir($fileName)) {
			$filePerms = $this->filePerms($fileName);
			if ($filePerms === $mode) {
				return true;
			}

			return $this->chmod($fileName, $mode);
		}

		@mkdir($fileName, $mode, $recursive, $context);
		return $this->isDir($fileName);
	}

	/**
	 * 删除目录，会同时删除目录中所有文件
	 * @param string $fileName
	 * @return boolean
	 */
	public function rmDir($fileName)
	{
		if (!$this->isDir($fileName)) {
			return true;
		}

		if ($this->clearDir($fileName)) {
			@rmdir($fileName);
			return !$this->isDir($fileName);
		}

		return false;
	}

	/**
	 * 删除目录中所有文件
	 * @param string $fileName
	 * @return boolean
	 */
	public function clearDir($fileName)
	{
		if ($this->isEmpty($fileName)) {
			return true;
		}

		
	}

	/**
	 * 获取目录中所有文件
	 * @param string $fileName
	 * @return array
	 */
	public function scanDir($fileName)
	{
		
	}

	/**
	 * 判断目录是否为空
	 * @param string $fileName
	 * @return boolean
	 */
	public function isEmpty($fileName)
	{
		if (!$this->isDir($fileName)) {
			return true;
		}

		$dh = opendir($fileName);
		while (($fileName = readdir($dh)) !== false) {
			if ($fileName !== '.' && $fileName !== '..' ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * 判断给定文件名是否是一个目录
	 * @param string $fileName
	 * @return boolean
	 */
	public function isDir($fileName)
	{
		return is_dir($fileName);
	}

	/**
	 * 改变文件权限
	 * @param string $fileName
	 * @param integer $mode 文件权限，8进制
	 * @return boolean
	 */
	public function chmod($fileName , $mode)
	{
		$ret = chmod($fileName, $mode);
		return $ret;
	}

	/**
	 * 获取文件权限
	 * @param string $fileName
	 * @return integer|false
	 */
	public function filePerms($fileName)
	{
		$ret = fileperms($fileName);
		if ($ret) {
			$ret = substr(sprintf('%o', $ret), -4);
			$ret = octdec($ret);
		}

		return $ret;
	}
	
	
}
