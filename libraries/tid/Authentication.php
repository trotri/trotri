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
	 * @var integer 默认的Cookie有效期
	 */
	const DEFAULT_COOKIE_EXPIRY = 864000;

    /**
     * @var array 寄存用户身份信息
     */
    protected $_identity = null;

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
     * @return boolean
     */
    public function setIdentity($userId, $userName)
    {
    	
    }
}
