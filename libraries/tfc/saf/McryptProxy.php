<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tfc\saf;

use tfc\ap\ErrorException;
use tfc\util\Mcrypt;

/**
 * McryptProxy class file
 * 可逆的加密方法代理类，基于流加密算法
 * <pre>
 * 配置 /cfg/key/cluster.php：
 * return array (
 *   'authentication' => array (
 *     'crypt' => string,   // 加密密钥
 *     'sign' => string,    // 签名密钥
 *     'expiry' => integer, // 缺省的密文有效期，如果等于0，表示永久有效
 *     'rnd_len' => integer // 随机密钥长度，取值 0-32
 *   ),
 *   'site' => array (
 *     'crypt' => string,   // 加密密钥
 *     'sign' => string,    // 签名密钥
 *     'expiry' => integer, // 缺省的密文有效期，如果等于0，表示永久有效
 *     'rnd_len' => integer // 随机密钥长度，取值 0-32
 *   )
 * );
 * </pre>
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: McryptProxy.php 1 2014-04-20 01:08:06Z huan.song $
 * @package tfc.saf
 * @since 1.0
 */
class McryptProxy
{
	/**
	 * @var string 寄存密钥配置名
	 */
	protected $_clusterName = null;

	/**
	 * @var array 寄存密钥配置信息
	 */
	protected $_config = null;

	/**
	 * @var instance of tfc\util\Mcrypt
	 */
	protected $_mcrypt = null;

	/**
	 * 构造方法：初始化密钥配置名
	 * @param string $clusterName
	 */
	public function __construct($clusterName)
	{
		$this->_clusterName = $clusterName;
	}

	/**
	 * 解密运算
	 * @param string $ciphertext
	 * @return string
	 */
	public function decode($ciphertext)
	{
		$mcrypt = $this->getMcrypt();
		return $mcrypt->decode($ciphertext);
	}

	/**
	 * 加密运算
	 * @param string $plaintext
	 * @param integer $expiry
	 * @return string
	 */
	public function encode($plaintext, $expiry = null)
	{
		$mcrypt = $this->getMcrypt();
		if ($expiry === null) {
			$expiry = $this->getExpiry();
		}

		return $mcrypt->encode($plaintext, $expiry);
	}

	/**
	 * 获取Mcrypt对象
	 * @return tfc\util\Mcrypt
	 */
	public function getMcrypt()
	{
		if ($this->_mcrypt === null) {
			$this->_mcrypt = new Mcrypt($this->getCrypt(), $this->getSign(), $this->getRndLen());
		}

		return $this->_mcrypt;
	}

	/**
     * 获取加密密钥
     * @return string
     */
    public function getCrypt()
    {
        return $this->getConfig('crypt');
    }

    /**
     * 获取签名密钥
     * @return string
     */
    public function getSign()
    {
    	return $this->getConfig('sign');
    }

    /**
     * 获取缺省的密文有效期
     * @return integer
     */
    public function getExpiry()
    {
    	return $this->getConfig('expiry');
    }

    /**
     * 获取随机密钥长度
     * @return integer
     */
    public function getRndLen()
    {
    	return $this->getConfig('rnd_len');
    }

	/**
	 * 获取密钥配置信息
	 * @return mixed
	 * @throws ErrorException 如果配置信息中没有指定加密密钥、签名密钥、缺省的密文有效期或随机密钥长度，抛出异常
	 */
	public function getConfig($key = null)
	{
		if ($this->_config === null) {
			$config = Cfg::getKey($this->getClusterName());
			if (!isset($config['crypt']) || !isset($config['sign']) || !isset($config['expiry']) || !isset($config['rnd_len'])) {
				throw new ErrorException(sprintf(
					'McryptProxy no entry is registered for key: crypt|sign|expiry|rnd_len in db config "%s"', serialize($config)
				));
			}
			$this->_config = $config;
		}

		if ($key === null) {
			return $this->_config;
		}

		return isset($this->_config[$key]) ? $this->_config[$key] : null;
	}

	/**
	 * 获取密钥配置名
	 * @return string
	 */
	public function getClusterName()
	{
		return $this->_clusterName;
	}
}
