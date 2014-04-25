<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

return array (
	'charset' => 'utf-8', // 不区分大小写
	'language' => 'zh-CN', // 区分大小写
	'view' => array (
		'skin_name' => 'bootstrap',
		'charset' => 'utf-8',
		'tpl_extension' => '.php',
		'version' => '1.0',
	),
	'paginator' => array (
		'page_var' => 'paged', // 从$_GET或$_POST中获取当前页的键名
		'list_rows_var' => 'limit', // 从$_GET或$_POST中获取每页展示的行数的键名
		'list_rows' => 3, // 每页展示的行数
		'list_pages' => 4, // 每页展示的页码数
	),
	'authentication' => array (
		'name' => 'tua',           // Cookie名
		'expiry' => 86400,         // 缺省的Cookie有效期
		'domain' => '.trotri.com', // Cookie的有效域名
		'path' => '/',             // Cookie的有效服务器路径。缺省：/
		'secure' => 0,             // 0：HTTP和HTTPS协议都可传输；1：只通过加密的HTTPS协议传输。缺省：0
		'httponly' => true,        // TRUE：只能通过HTTP协议访问；FALSE：HTTP协议和脚本语言都可访问，容易造成XSS攻击。缺省：TRUE
	),
	'navbar' => require_once 'navbar.php',
);
