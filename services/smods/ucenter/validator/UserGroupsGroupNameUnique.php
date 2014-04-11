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
use slib\ErrorNo;

/**
 * UserGroupsGroupNameUnique class file
 * 验证组名：组名不能重复
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UserGroupsGroupNameUnique.php 1 2013-03-29 16:48:06Z huan.song $
 * @package smods.ucenter.validator
 * @since 1.0
 */
class UserGroupsGroupNameUnique extends BaseValidator
{
	/**
	 * @var smods\Mod 寄存业务层的model类实例
	 */
	public static $object = null;

	/**
	 * @var string 操作类型：insert、update
	 */
	public static $opType = '';

	/**
	 * @var integer 主键ID
	 */
	public static $id = 0;

	/**
	 * @var string 默认出错后的提醒消息
	 */
	protected $_message = '"%value%" from this user groups has the same group name.';

	/**
	 * (non-PHPdoc)
	 * @see tfc\validator.Validator::isValid()
	 */
	public function isValid()
	{
		$object = self::$object;
		$opType = trim(self::$opType);
		$id     = (int) self::$id;

		$this->objectIsValid($object);
		$this->opTypeIsValid($object, $opType);
		$this->idIsValid($object, $opType, $id);

		$groupName = $this->getValue();
		if (($groupName = trim($groupName)) === '') {
			return false;
		}

		if ($object->isOpTypeUpdate($opType)) {
			$dbGroupName = $object->getGroupNameById($id);
			// 组名没有变更，不做检查
			if ($dbGroupName === $groupName) {
				return true;
			}
		}

		$ret = $object->findByGroupName($groupName);
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			return false;
		}

		return true;
	}
}
