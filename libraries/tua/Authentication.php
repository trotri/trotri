<?php
/**
 * Trotri User Authorize
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tua;

/**
 * Authentication class file
 * 用户身份认证类
 * <pre>
 * 配置 /cfg/key/cluster.php：
 * return array (
 *   'authentication' => array (
 *     'name' => 'tua',           // Cookie名
 *		'expiry' => 86400,         // 缺省的Cookie有效期
 *		'domain' => '.trotri.com', // Cookie的有效域名
 *		'path' => '/',             // Cookie的有效服务器路径。缺省：/
 *		'secure' => 0,             // 0：HTTP和HTTPS协议都可传输；1：只通过加密的HTTPS协议传输。缺省：0
 *		'httponly' => true,        // TRUE：只能通过HTTP协议访问；FALSE：HTTP协议和脚本语言都可访问，容易造成XSS攻击。缺省：TRUE
 *	),
 * );
 * </pre>
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Authentication.php 1 2014-04-20 01:08:06Z huan.song $
 * @package tua
 * @since 1.0
 */
class Authentication
{
	/**
	 * @var string 获取Cookie信息的配置名
	 */
	const COOKIE_CONFIG = 'authentication';

	
	
}
