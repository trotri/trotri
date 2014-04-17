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

/**
 * Mcrypt class file
 * 数据加密类，基于流加密算法
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Mcrypt.php 1 2014-04-17 16:48:06Z huan.song $
 * @package tfc.util
 * @since 1.0
 */
class Mcrypt
{
	/**
	 * @var integer 默认的随机密钥长度，取值 0-32
	 */
	const DEFAULT_RAND_KEY_LENGTH = 33;

	/**
	 * @var integer 随机密钥长度，取值 0-32
	 */
	protected $_rndKeyLen = self::DEFAULT_RAND_KEY_LENGTH;

	/**
	 * @var integer 密文有效期
	 */
	protected $_expiry = 0;

	public function decode()
	{


	}

	public function encode()
	{

	}

	/**
	 * 获取加密秘钥
	 * @param string $ciphertext
	 * @return string
	 */
	public function getCryptKey($ciphertext = '')
	{

	}

	/**
	 * 获取密文有效期
	 * @return string
	 */
	public function getExpiry()
	{
		return sprintf('%010d', $this->_expiry > 0 ? $this->_expiry + mktime() : 0);
	}

	/**
	 * 获取随机密钥
	 * @param string $ciphertext
	 * @return string
	 */
	public function getRndKey($ciphertext = '')
	{
		if ($this->_rndKeyLen <= 0) {
			return '';
		}

		if (strlen($ciphertext) > 0) {
			return substr($ciphertext, 0, $this->_rndKeyLen < 32 ? $this->_rndKeyLen : 32);
		}

		return substr($this->random(), -$this->_rndKeyLen);
	}

	/**
	 * 获取随机数
	 * @return string
	 */
	public function random()
	{
		$string = $_SERVER['SERVER_SOFTWARE'].$_SERVER['SERVER_NAME'].$_SERVER['SERVER_ADDR'].$_SERVER['SERVER_PORT'].$_SERVER['HTTP_USER_AGENT'].mt_rand().microtime();
		return md5(substr(md5($string), 6).mt_rand());
	}
}
