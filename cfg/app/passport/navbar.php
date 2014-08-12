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
			'label' => 'CFG_SYSTEM_URLS_USERS_INDEX_INDEX',
			'm' => 'users', 'c' => 'users', 'a' => 'index'
		),
		1 => array(
			'label' => 'CFG_SYSTEM_URLS_USERS_INDEX_INDEX',
			'm' => 'users', 'c' => 'users', 'a' => 'index',
			'icon' => array(
				'label' => 'CFG_SYSTEM_URLS_USERS_INDEX_CREATE',
				'm' => 'users', 'c' => 'users', 'a' => 'create'
			)
		),
		2 => array(
			'label' => 'CFG_SYSTEM_URLS_USERS_GROUPS_INDEX',
			'm' => 'users', 'c' => 'groups', 'a' => 'index',
			'icon' => array(
				'label' => 'CFG_SYSTEM_URLS_USERS_GROUPS_CREATE',
				'm' => 'users', 'c' => 'groups', 'a' => 'create',
			)
		),
		3 => array(
			'label' => 'CFG_SYSTEM_URLS_USERS_AMCAS_INDEX',
			'm' => 'users', 'c' => 'amcas', 'a' => 'index',
		),
	),
	array(
		0 => array(
			'label' => 'CFG_SYSTEM_URLS_PROGRAMMER',
			'url' => 'programmer.php?r=builder/builders/index'
		)
	),
);
