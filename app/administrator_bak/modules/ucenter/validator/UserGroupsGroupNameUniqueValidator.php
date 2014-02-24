<?php
/**
 * Trotri Foundation Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\validator;

use tfc\validator\Validator;
use library\ErrorNo;
use library\UcenterFactory;

/**
 * UserGroupsGroupNameUniqueValidator class file
 * 验证组名：组名不能重复
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UserGroupsGroupNameUniqueValidator.php 1 2013-03-29 16:48:06Z huan.song $
 * @package modules.ucenter.model.validator
 * @since 1.0
 */
class UserGroupsGroupNameUniqueValidator extends Validator
{
    /**
     * @var string 默认出错后的提醒消息
     */
    protected $_message = '"%value%" from this user groups has the same name.';

    /**
     * (non-PHPdoc)
     * @see tfc\validator.Validator::isValid()
     */
    public function isValid()
    {
    	$mod = UcenterFactory::getModel('Groups');
		$groupName = $this->getValue();
		$groupId = (int) $this->getOption();
		if ($groupId > 0) {
			$ret = $mod->getByPk('group_name', $groupId);
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM && $ret['group_name'] === $groupName) {
				return true;
			}
		}

		$total = $mod->countByGroupName($groupName);
		return ($total > 0) ? false : true;
    }
}
