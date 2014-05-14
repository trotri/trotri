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
 * Sftp class file
 * 远程文件管理类，未测试
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Sftp.php 1 2013-03-29 16:48:06Z huan.song $
 * @package tfc.util
 * @since 1.0
 */
class Sftp
{
	/**
	 * @var resource 当前连接的服务器资源
	 */
	protected $_ssh = null;

	/**
	 * @var resource 从SSH2服务中获取的子系统
	 */
	protected $_system = null;

	/**
     * @var string 服务器名称或IP地址
     */
    protected $_host;

    /**
     * @var integer 服务器端口号
     */
    protected $_port;

	/**
	 * @var string 服务器用户名
	 */
	protected $_username;

	/**
	 * @var string 服务器密码
	 */
	protected $_password;

	/**
	 * 构造方法：初始化服务器名称或IP地址、服务器端口号、服务器用户名、服务器密码
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param integer $port
	 */
	public function __construct($host, $username, $password, $port = 22)
	{
		$this->setHost($host);
		$this->setPort($port);
		$this->setUsername($username);
		$this->setPassword($password);
	}

	/**
	 * 初始化SSH，连接服务器并验证服务器用户名和服务器密码
	 * @return tfc\util\Sftp
	 * @throws ErrorException 如果连接服务器失败，抛出异常
	 * @throws ErrorException 如果用户名和密码不正确，抛出异常
	 */
	public function open()
	{
		if ($this->getIsConnected()) {
			return $this;
		}

		$host = $this->getHost();
		$port = $this->getPort();
		$ssh = @ssh2_connect($host, $port);
		if (!$ssh) {
			throw new ErrorException(sprintf(
                'Sftp unable to connect to the server, host "%s", port "%d".', $host, $port
            ));
		}
		$this->_ssh = $ssh;

		$username = $this->getUsername();
		$password = $this->getPassword();		
		if (!@ssh2_auth_password($this->_ssh, $username, $password)) {
			throw new ErrorException(sprintf(
				'Sftp Auth login failed, host "%s", port "%d" username "%s", password "%s".', $host, $port, $username, $password
			));
		}

		$system = ssh2_sftp($this->_ssh);
		if (!$system) {
			throw new ErrorException(sprintf(
				'Sftp Initialize SFTP subsystem failed, host "%s", port "%d" username "%s", password "%s".', $host, $port, $username, $password
			));
		}
		$this->_system = $system;

		return $this;
	}

	/**
	 * 关闭服务器
	 * @return tfc\util\Sftp
	 */
	public function close()
	{
		$this->_ssh = null;
		$this->_system = null;
		return $this;
	}

	/**
	 * 获取连接服务器的状态
	 * @return boolean
	 */
	public function getIsConnected()
	{
		return (is_resource($this->_ssh) && is_resource($this->_system));
	}

	/**
	 * 将本地服务器文件上传到远程服务器
	 * @param string $source
	 * @param string $dest
	 * @return boolean
	 */
	public function upload($source, $dest)
	{
		$stream = @fopen("ssh2.sftp://{$this->_system}{$dest}", 'w');
		if (!$stream) {
			throw new ErrorException(sprintf(
				'Sftp Remote Path "%s" cannot be opened with mode "w"', $dest
			));
			return false;
		}

		$data = @file_get_contents($source);
		if ($data === false) {
			throw new ErrorException(sprintf(
				'Sftp Local Path "%s" cannot be opened with mode "r"', $source
			));
			return false;
		}

		if (@fwrite($stream, $data) === false) {
			throw new ErrorException(sprintf(
				'Sftp Upload Local "%s" to Remote "%s" failed', $source, $dest
			));
			return false;
		}

		@fclose($stream);
		return true;
	}

	/**
	 * 将远程服务器文件下载本地服务器
	 * @param string $source
	 * @param string $dest
	 * @return boolean
	 */
	public function download($source, $dest)
	{
		$stream = @fopen("ssh2.sftp://{{$this->_system}}{$source}", 'r');
		if (!$stream) {
			throw new ErrorException(sprintf(
				'Sftp Remote Path "%s" cannot be opened with mode "r"', $source
			));
			return false;
		}

		$data = '';
		while (!@feof($stream)) {
			$data .= @fgets($stream);
		}

		@fclose($stream);

		$size = file_put_contents($dest, $data);
		if ($size <= 0) {
			throw new ErrorException(sprintf(
				'Sftp Download Remote "%s" to Local "%s" failed', $source, $dest
			));
			return false;
		}

		return true;
	}

	/**
	 * 重命名一个文件或目录
	 * @param string $oldName
	 * @param string $newName
	 * @return boolean
	 */
	public function rename($oldName, $newName)
	{
		if (!$this->fileExists($oldName) || $this->fileExists($newName)) {
			return false;
		}

		@ssh2_sftp_rename($sftp, $oldName, $newName);
		if (!$this->fileExists($oldName) && $this->fileExists($newName)) {
			return true;
		}

		return false;
	}

	/**
	 * 拷贝目录
	 * @param string $source
	 * @param string $dest
	 * @return boolean
	 */
	public function copy($source, $dest)
	{
		$stream = @ssh2_exec($this->_ssh, '/bin/cp -fr ' . $source . '/* ' . $dest . '/');
		$errStream = @ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
		stream_set_blocking($errStream, true);
		$errStr = stream_get_contents($errStream);
		fclose($errStream);
		if ($errStr == '') {
			return true;
		}

		return false;
	}

	/**
	 * 新建目录
	 * @param string $directory
	 * @param boolean $recursive 递归创建所有目录
	 * @return boolean
	 */
	public function mkDir($directory, $recursive = false)
	{
		if ($this->isFile($directory)) {
            return false;
        }

        if ($this->isDir($directory)) {
            return true;
        }

        if ($recursive) {
        	if (strpos($directory, '/') !== false) {
        		$rows = explode('/', $directory);
        		$dirName = '';
        		foreach ($rows as $row) {
        			$dirName .= '/' . $row;
        			if (!$this->fileExists($dirName)) {
        				@ssh2_sftp_mkdir($this->_system, $dirName);
        			}
        		}
        	}
        }
        else {
        	@ssh2_sftp_mkdir($this->_system, $directory);
        }

        return $this->isDir($directory);
	}

	/**
	 * 删除目录
	 * @param string $directory
	 * @return boolean
	 */
	public function rmDir($directory)
	{
		if ($this->isFile($directory)) {
			return false;
		}

		if (!$this->isDir($directory)) {
			return true;
		}

		@ssh2_sftp_rmdir($this->_system, $directory);
		return !$this->isDir($directory);
	}

	/**
	 * 删除文件
	 * @param string $fileName
	 * @return boolean
	 */
	public function unlink($fileName)
	{
		if ($this->isDir($fileName)) {
			return false;
		}

		if ($this->isFile($fileName)) {
			@ssh2_sftp_unlink($this->_system, $fileName);
			return !$this->isFile($fileName);
		}

		return true;
	}

	/**
	 * 获取目录中的文件
	 * @param string $directory
	 * @param boolean $recursive 是否递归获取所有目录
	 * @return array
	 */
	public function scanDir($directory, $recursive = false)
	{
		$ret = array();
		if (!$this->isDir($directory)) {
			return $ret;
		}

		$dh = opendir("ssh2.sftp://{$this->_system}{$directory}");
		while (($fileName = readdir($dh)) !== false) {
			if ($fileName === '.' || $fileName === '..' ) {
				continue;
			}

			$ret[] = $fileName = $directory . DIRECTORY_SEPARATOR . $fileName;
			if ($recursive && $this->isDir($fileName)) {
				$ret[] = $this->scanDir($fileName, $recursive);
			}
		}

		closedir($dh);
		return $ret;
	}

	/**
	 * 判断目录是否为空，如果目录不存在或不是目录，则返回null
	 * @param string $directory
	 * @return boolean
	 */
	public function isEmpty($directory)
	{
		if (!$this->isDir($directory)) {
			return null;
		}

		$ret = true;
		$dh = opendir("ssh2.sftp://{$this->_system}{$directory}");
		while (($fileName = readdir($dh)) !== false) {
			if ($fileName !== '.' && $fileName !== '..' ) {
				$ret = false;
				break;
			}
		}

		closedir($dh);
		return $ret;
	}

	/**
	 * 检查文件或目录是否存在
	 * @param string $fileName
	 * @return boolean
	 */
	public function fileExists($fileName)
	{
		return file_exists("ssh2.sftp://{$this->_system}{$fileName}");
	}

	/**
	 * 判断给定文件名是否是一个目录
	 * @param string $fileName
	 * @return boolean
	 */
	public function isDir($fileName)
	{
		return is_dir("ssh2.sftp://{$this->_system}{$fileName}");
	}

	/**
	 * 判断给定文件名是否是一个文件
	 * @param string $fileName
	 * @return boolean
	 */
	public function isFile($fileName)
	{
		return is_file("ssh2.sftp://{$this->_system}{$fileName}");
	}

	/**
	 * 获取文件或目录的信息
	 * @param string $fileName
	 * @return array
	 */
	public function fileStat($fileName)
	{
		return @ssh2_sftp_stat($this->_system, $fileName);
	}

	/**
	 * 获取文件的Md5值
	 * @param string $fileName
	 * @return string
	 */
	public function md5File($fileName)
	{
		$stream = @ssh2_exec($this->_ssh, 'md5sum ' . $fileName);
		stream_set_blocking($stream, true);
		$contents = stream_get_contents($stream);
		fclose($stream);

		list($md5Sum, $fileName) = explode(' ', $contents);
		return $md5Sum;
	}

	/**
	 * 解压tgz文件
	 * @param string $fileName
	 * @param string $directory
	 * @return boolean
	 */
	public function tgzUnpack($fileName, $directory)
	{
		$stream = @ssh2_exec($this->_ssh, 'tar -zxf ' . $fileName . ' -C ' . $directory);
		$errStream = @ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
		stream_set_blocking($errStream, true);
		$errStr = stream_get_contents($errStream);
		fclose($errStr);
		if ($errStr == '') {
			return true;
		}

		return false;
	}

	/**
	 * 获取服务器名称或IP地址
	 * @return string
	 */
	public function getHost()
	{
		return $this->_host;
	}

	/**
	 * 设置服务器名称或IP地址
	 * @param string $host
	 * @return tfc\util\Sftp
	 */
	public function setHost($host)
	{
		$this->_host = $host;
		return $this;
	}

	/**
	 * 获取服务器端口号
	 * @return integer
	 */
	public function getPort()
	{
		return $this->_port;
	}

	/**
	 * 设置服务器端口号
	 * @param integer $port
	 * @return tfc\util\Sftp
	 */
	public function setPort($port)
	{
		$this->_port = (int) $port;
		return $this;
	}

	/**
	 * 获取服务器用户名
	 * @return string
	 */
	public function getUsername()
	{
		return $this->_username;
	}

	/**
	 * 设置服务器用户名
	 * @param string $username
	 * @return tfc\util\Sftp
	 */
	public function setUsername($username)
	{
		$this->_username = $username;
		return $this;
	}

	/**
	 * 获取服务器密码
	 * @return string
	 */
	public function getPassword()
	{
		return $this->_password;
	}

	/**
	 * 设置服务器密码
	 * @param string $password
	 * @return tfc\util\Sftp
	 */
	public function setPassword($password)
	{
		$this->_password = $password;
		return $this;
	}
}
