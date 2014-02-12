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

use tfc\saf\Text;
use tfc\validator\Validator;
use tfc\validator\MailValidator;
use library\validator\PhoneValidator;
use library\Auth;

/**
 * UsersLoginNameValidator class file
 * 验证事件名：同一事件下的子事件名不能重复
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UsersLoginNameValidator.php 1 2013-03-29 16:48:06Z huan.song $
 * @package modules.ucenter.model.validator
 * @since 1.0
 */
class UsersLoginNameValidator extends Validator
{
    /**
     * (non-PHPdoc)
     * @see tfc\validator.Validator::isValid()
     */
    public function isValid()
    {
    	$loginName = $this->getValue();
		$loginType = Auth::getLoginType($loginName);
		if (Auth::isMailLogin($loginType)) {
			$mailValidator = new MailValidator($loginName, true, Text::_('MOD_UCENTER_USERS_LOGIN_NAME_MAIL'));
			if (!$mailValidator->isValid()) {
				$this->setMessage(Text::_('MOD_UCENTER_USERS_LOGIN_NAME_MAIL'));
				return false;
			}
		}
    	elseif (Auth::isPhoneLogin($loginType)) {
    		$phoneValidator = new PhoneValidator($loginName, true, Text::_('MOD_UCENTER_USERS_LOGIN_NAME_PHONE'));
    		if (!$phoneValidator->isValid()) {
    			$this->setMessage(Text::_('MOD_UCENTER_USERS_LOGIN_NAME_PHONE'));
    			return false;
    		}
    	}
    	else {
    		if (strpos($loginName, '@') || is_numeric($loginName)) {
    			$this->setMessage(Text::_('MOD_UCENTER_USERS_LOGIN_NAME_WRONG'));
    			return false;
    		}
    	}

    	return true;
    }
}
