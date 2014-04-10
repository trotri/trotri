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
 * UserGroupsGroupPidExists class file
 * 验证用户组父ID是否存在
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UserGroupsGroupPidExists.php 1 2013-03-29 16:48:06Z huan.song $
 * @package smods.ucenter.validator
 * @since 1.0
 */
class UserGroupsGroupPidExists extends BaseValidator
{
	/**
	 * @var string 默认出错后的提醒消息
	 */
	protected $_message = '"%value%" from this user groups has the group pid not exists.';

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseValidator::runValid()
	 */
	public function runValid()
	{
		
	}
}
