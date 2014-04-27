<?php
/**
 * Trotri User Identity
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tid;

use tfc\saf\Cookie;

use tfc\ap\Ap;
use tfc\ap\ErrorException;

/**
 * Authentication class file
 * 用户身份认证类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Authentication.php 1 2014-04-20 01:08:06Z huan.song $
 * @package tid
 * @since 1.0
 */
class Authentication
{
	/**
	 * @var integer 默认的Cookie名
	 */
	const DEFAULT_COOKIE_NAME = 'tid';

	/**
	 * @var integer 默认的Cookie有效期
	 */
	const DEFAULT_COOKIE_EXPIRY = 0;

	/**
	 * @var string Cookie配置名
	 */
	protected $_cookieClusterName = '';

	/**
	 * @var string Cookie名
	 */
	protected $_cookieName = '';

	/**
	 * @var instance of tfc\saf\Cookie
	 */
	protected $_cookie = null;

	/**
	 * @var array 寄存用户身份信息
	 */
	protected $_identity = null;

	/**
	 * 构造方法：初始化Cookie配置名和Cookie名
	 * @param string $cookieClusterName
	 * @param string $cookieName
	 * @throws ErrorException 如果Cookie配置名为空，抛出异常
	 * @throws ErrorException 如果Cookie名为空，抛出异常
	 */
	public function __construct($cookieClusterName, $cookieName = null)
	{
		if (($cookieClusterName = trim($cookieClusterName)) === '') {
			throw new ErrorException(
				'Authentication cookie cluster name must be string and not empty.'
			);
		}

		if ($cookieName === null) {
			$cookieName = self::DEFAULT_COOKIE_NAME;
		}

		if (($cookieName = trim($cookieName)) === '') {
			throw new ErrorException(
				'Authentication cookie name must be string and not empty.'
			);
		}

		$this->_cookieClusterName = $cookieClusterName;
		$this->_cookieName = $cookieName;
	}

	/**
	 * 从Cookie中获取用户身份
	 * @return array
	 */
	public function getIdentity()
	{
		
	}

	/**
	 * 向Cookie中设置用户身份
	 * @param integer $userId
	 * @param string $userName
	 * @param string $password
	 * @param integer $expiry
	 * @return boolean
	 */
	public function setIdentity($userId, $userName, $password, $expiry = 0)
	{
		if (($userId = (int) $userId) < 0) {
			throw new ErrorException(sprintf(
				'Authentication user id "%d" must be greater than 0.', $userId
			));
        }

        if (($userName = trim($userName)) === '') {
        	throw new ErrorException(
        		'Authentication user name must be string and not empty.'
        	);
        }

        $password = trim($password);

        if (($expiry = (int) $expiry) < 0) {
        	throw new ErrorException(sprintf(
        		'Authentication expiry "%d" must be greater and equal than 0.', $expiry
        	));
        }

        if ($expiry > 0) {
        	$expiry += mktime();
        }

        $ip = Ap::getRequest()->getClientIp();
        $value = $userId . "\t" . $userName . "\t" . $password . "\t" . $ip . "\t" . $expiry . "\t" . mktime();
        return $this->getCookie()->add($this->getCookieName(), $value, $expiry);
	}

	/**
	 * 移除Cookie中的用户身份
	 * @return boolean
	 */
	public function clearIdentity()
	{
		 
	}

	/**
	 * Cookie中是否存在用户身份
	 * @return boolean
	 */
	public function hasIdentity()
	{
		 
	}

	/**
	 * 获取Cookie管理类
	 * @return tfc\saf\Cookie
	 */
	public function getCookie()
	{
		if ($this->_cookie === null) {
			$this->_cookie = new Cookie($this->getCookieClusterName());
		}

		return $this->_cookie;
	}

	/**
	 * 获取Cookie配置名
	 * @return string
	 */
	public function getCookieClusterName()
	{
		return $this->_cookieClusterName;
	}

	/**
	 * 获取Cookie名
	 * @return string
	 */
	public function getCookieName()
	{
		return $this->_cookieName;
	}
}
