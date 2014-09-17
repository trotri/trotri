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
			'label' => 'CFG_SYSTEM_URLS_BUILDER_INDEX_INDEX',
			'm' => 'builder', 'c' => 'builders', 'a' => 'index'
		),
		1 => array(
			'label' => 'CFG_SYSTEM_URLS_BUILDER_INDEX_INDEX',
			'm' => 'builder', 'c' => 'builders', 'a' => 'index',
			'icon' => array(
				'label' => 'CFG_SYSTEM_URLS_BUILDER_INDEX_CREATE',
				'm' => 'builder', 'c' => 'builders', 'a' => 'create'
			)
		),
		2 => array(
			'label' => 'CFG_SYSTEM_URLS_BUILDER_TYPES_INDEX',
			'm' => 'builder', 'c' => 'types', 'a' => 'index',
			'icon' => array(
				'label' => 'CFG_SYSTEM_URLS_BUILDER_TYPES_CREATE',
				'm' => 'builder', 'c' => 'types', 'a' => 'create',
			)
		),
		3 => array(
			'label' => 'CFG_SYSTEM_URLS_BUILDER_TBLNAMES_INDEX',
			'm' => 'builder', 'c' => 'tblnames', 'a' => 'index',
		),
	),
	array(
		0 => array(
			'label' => 'CFG_SYSTEM_URLS_ADMINISTRATOR',
			'url' => 'administrator.php?r=posts/posts/index'
		)
	),
	array(
		0 => array(
			'label' => 'CFG_SYSTEM_URLS_PASSPORT',
			'url' => 'passport.php?r=users/users/index'
		)
	),
);
