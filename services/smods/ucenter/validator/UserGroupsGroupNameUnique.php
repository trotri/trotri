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
	 * @var string 默认出错后的提醒消息
	 */
	protected $_message = '"%value%" from this user groups has the same group name.';

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseValidator::runValid()
	 */
	public function runValid()
	{
		
	}
}
