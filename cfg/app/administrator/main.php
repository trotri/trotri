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
		'list_rows' => 10, // 每页展示的行数
		'list_pages' => 4, // 每页展示的页码数
	),
	'navbar' => require_once 'navbar.php',
);
