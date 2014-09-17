<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

return array(
	array(
		0 => array(
			'label' => 'CFG_SYSTEM_URLS_POSTS_INDEX_INDEX',
			'm' => 'posts', 'c' => 'posts', 'a' => 'index'
		),
		1 => array(
			'label' => 'CFG_SYSTEM_URLS_POSTS_INDEX_INDEX',
			'm' => 'posts', 'c' => 'posts', 'a' => 'index',
			'icon' => array(
				'label' => 'CFG_SYSTEM_URLS_POSTS_INDEX_CREATE',
				'm' => 'posts', 'c' => 'posts', 'a' => 'create'
			)
		),
		2 => array(
			'label' => 'CFG_SYSTEM_URLS_POSTS_CATEGORIES_INDEX',
			'm' => 'posts', 'c' => 'categories', 'a' => 'index',
			'icon' => array(
				'label' => 'CFG_SYSTEM_URLS_POSTS_CATEGORIES_CREATE',
				'm' => 'posts', 'c' => 'categories', 'a' => 'create',
			)
		),
		3 => array(
			'label' => 'CFG_SYSTEM_URLS_POSTS_MODULES_INDEX',
			'm' => 'posts', 'c' => 'modules', 'a' => 'index',
		),
	),
	array(
		0 => array(
			'label' => 'CFG_SYSTEM_URLS_PASSPORT',
			'url' => 'passport.php?r=users/users/index'
		)
	),
	array(
		1 => array(
			'label' => 'CFG_SYSTEM_URLS_PROGRAMMER',
			'url' => 'programmer.php?r=builder/builders/index'
		)
	),
);
