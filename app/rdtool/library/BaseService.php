<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use libapp;
use libsrv\Clean;

/**
 * BaseService abstract class file
 * 业务层基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseService.php 1 2013-05-18 14:58:59Z huan.song $
 * @package library
 * @since 1.0
 */
abstract class BaseService extends libapp\BaseService
{
	/**
	 * 过滤数组（只保留指定的字段）、清理数据并且清除空数据（空字符，负数）
	 * @param array $attributes
	 * @param array $rules
	 * @return void
	 */
	protected function filterCleanEmpty(array &$attributes = array(), array $rules = array())
	{
		$this->filterAttributes($attributes, array_keys($rules));
		$attributes = Clean::rules($rules, $attributes);
		foreach ($rules as $columnName => $funcName) {
			if (!isset($attributes[$columnName])) {
				continue;
			}

			if ($funcName === 'trim' && $attributes[$columnName] === '') {
				unset($attributes[$columnName]);
				continue;
			}

			if ($funcName === 'intval' && $attributes[$columnName] < 0) {
				unset($attributes[$columnName]);
				continue;
			}
		}
	}
}
