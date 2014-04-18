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
 * 可逆的加密方法类，基于流加密算法
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
	const DEFAULT_RND_KEY_LEN = 8;

	/**
	 * @var integer 随机密钥长度，取值 0-32。
	 * 如果值等于0，会造成Reused Key Attack
	 * 如果数值过小，会造成弱IV（Initialization Vector），有暴力破解的风险
	 */
	protected $_rndKeyLen = self::DEFAULT_RND_KEY_LEN;

	/**
	 * @var integer 密文有效期
	 */
	protected $_expiry = 0;

	/**
	 * @var string 加密密钥
	 */
	protected $_cryptKey = '';

	/**
	 * @var string 签名密钥
	 */
	protected $_signKey = '';

	/**
	 * 构造方法：初始化加密密钥、签名密钥
	 * @param string $cryptKey
	 * @param integer $rndKeyLen
	 * @param integer $expiry
	 */
	public function __construct($key, $expiry = 0, $rndKeyLen = self::DEFAULT_RND_KEY_LEN)
	{
		
	}

	/**
	 * 解密运算
	 * @param string $ciphertext
	 * @return string
	 */
	public function decode($ciphertext)
	{
		$rndKey = $this->getRndKey($ciphertext);
		$cryptKey = $this->getCryptKey($rndKey);

		$string = base64_decode(substr($ciphertext, strlen($rndKey)));
		$string = $this->xorCalc($string, $cryptKey);
		$plaintext = substr($string, 26);

		$expiry = $this->getExpiry($string);
		if ($expiry > 0 && $expiry <= mktime()) {
			return false;
		}

		if ($this->getSign('', $string) !== $this->getSign($plaintext)) {
			return false;
		}

		return $plaintext;
	}

	/**
	 * 加密运算
	 * @param string $plaintext
	 * @return string
	 */
	public function encode($plaintext)
	{
		$rndKey = $this->getRndKey();
		$cryptKey = $this->getCryptKey($rndKey);
		$string = $this->getExpiry() . $this->getSignKey() . $plaintext;
		$string = $this->xorCalc($string, $cryptKey);
		return $rndKey.str_replace('=', '', base64_encode($string));
	}

	/**
	 * 异或位运算
	 * @param string $string “密文” 或者 由“有效期{0-10}”、“签名密钥{10-26}”、“原字符串”组成的字符串
	 * @param string $cryptKey
	 * @return string
	 */
	public function xorCalc($string, $cryptKey)
	{
		$ret = '';

		$strLen = strlen($string);
		$iv = $this->getIv($cryptKey);
		for ($a = $j = $i = 0; $i < $strLen; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $iv[$a]) % 256;
			$tmp = $iv[$a];
			$iv[$a] = $iv[$j];
			$iv[$j] = $tmp;
			$ret .= chr(ord($string[$i]) ^ ($iv[($iv[$a] + $iv[$j]) % 256]));
		}

		return $ret;
	}

	/**
	 * 通过加密密钥，获取初始化向量 Initialization Vector
	 * @param string $cryptKey
	 * @return array
	 */
	public function getIv($cryptKey)
	{
		$ret = array();

		$keyLen = strlen($cryptKey);

		$rndKey = array();
		for ($i = 0; $i <= 255; $i++) {
			$rndKey[$i] = ord($cryptKey[$i % $keyLen]);
		}

		$ret = range(0, 255);
		for ($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $ret[$i] + $rndKey[$i]) % 256;
			$tmp = $ret[$i];
			$ret[$i] = $ret[$j];
			$ret[$j] = $tmp;
		}

		return $ret;
	}

	/**
	 * 获取原始明文的签名，防止明文被篡改
	 * @param string $plaintext 原始明文
	 * @param string $string 由“有效期{0-10}”、“签名密钥{10-26}”、“原字符串”组成
	 * @return string
	 */
	public function getSign($plaintext, $string = '')
	{
		if ($string) {
			return substr($string, 10, 16);
		}

		return md5($plaintext . $this->getSignKey(), true);
	}

	/**
	 * 获取签名密钥
	 * @return string
	 */
	public function getSignKey()
	{
		return md5($this->_signKey);
	}

	/**
	 * 获取加密密钥
	 * @param string $rndKey
	 * @return string
	 */
	public function getCryptKey($rndKey)
	{
		$cryptKey = md5($this->_cryptKey);
		return md5(substr($cryptKey, 0, 16) . md5($cryptKey . $rndKey));
	}

	/**
	 * 获取加密有效期
	 * @param string $string 由“有效期{0-10}”、“签名密钥{10-26}”、“原字符串”组成
	 * @return string
	 */
	public function getExpiry($string = '')
	{
		if ($string) {
			return substr($string, 0, 10);
		}

		return sprintf('%010d', $this->_expiry > 0 ? $this->_expiry + mktime() : 0);
	}

	/**
	 * 获取随机密钥，令密文无规律，即便原文和密钥完全相同，加密结果也会每次不同。
	 * @param string $ciphertext 由“随机密钥{0-rndKeyLen}”、“密文”组成
	 * @return string
	 */
	public function getRndKey($ciphertext = '')
	{
		if ($this->_rndKeyLen <= 0) {
			return '';
		}

		if ($ciphertext) {
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
