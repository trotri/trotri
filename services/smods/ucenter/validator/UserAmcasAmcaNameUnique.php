<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\ucenter\validator;

use slib\BaseValidator;

/**
 * UserAmcasAmcaNameUnique class file
 * 验证事件名：同一事件下的子事件名不能重复
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UserAmcasAmcaNameUnique.php 1 2013-03-29 16:48:06Z huan.song $
 * @package smods.ucenter.validator
 * @since 1.0
 */
class UserAmcasAmcaNameUnique extends BaseValidator
{
	/**
	 * @var string 默认出错后的提醒消息
	 */
	protected $_message = '"%value%" from this user amcas has the same name.';

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseValidator::runValid()
	 */
	public function runValid()
	{
		$amcaName = $this->getValue();
		if (($amcaName = trim($amcaName)) === '') {
			return false;
		}

		$object = self::$object;
		if ($object->isOpTypeUpdate(self::$opType)) {
			$dbAmcaName = $object->getAmcaNameById(self::$id);
			// 事件名没有变更，不做检查
			if ($dbAmcaName === $amcaName) {
				return true;
			}
		}

		$total = $object->countByPidAndName(self::$pid, $amcaName);
		return ($total > 0) ? false : true;
	}
}
