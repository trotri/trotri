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

/**
 * Authentication class file
 * 用户身份认证类
 * <pre>
 * 配置 /cfg/key/cluster.php：
 * return array (
 *   'administrator' => array (
 *     'cookie' => string,  // Cookie名
 *     'crypt' => string,   // 加密密钥
 *     'sign' => string,    // 签名密钥
 *     'expiry' => integer, // 密文有效期，如果等于0，表示永久有效
 *     'rnd_len' => integer // 随机密钥长度，取值 0-32
 *   ),
 *   'site' => array (
 *     'cookie' => string,  // Cookie名
 *     'crypt' => string,   // 加密密钥
 *     'sign' => string,    // 签名密钥
 *     'expiry' => integer, // 密文有效期，如果等于0，表示永久有效
 *     'rnd_len' => integer // 随机密钥长度，取值 0-32
 *   )
 * );
 * </pre>
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Authentication.php 1 2014-04-20 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Authentication
{
	/**
	 * @var string 寄存Ral配置名
	 */
	protected $_clusterName = null;

	protected static $_mcrypt = null;

	public static function getMcrypt()
	{
		if (self::$_mcrypt === null) {
			$cryptKey  = Cfg::getApp('crypt_key', 'authentication');
			$signKey   = Cfg::getApp('sign_key', 'authentication');
			$expiry    = (int) Cfg::getApp('expiry', 'authentication');
			$rndKeyLen = (int) Cfg::getApp('rnd_key_len', 'authentication');
			
			var_dump($cryptKey);
			var_dump($signKey);
			var_dump($expiry);
			var_dump($rndKeyLen);
		}
	}
}
