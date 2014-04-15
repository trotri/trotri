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

use tfc\validator\MailValidator;
use tfc\validator\AlphaNumValidator;
use slib\BaseValidator;
use slib\ErrorNo;
use slib\validator\PhoneValidator;

/**
 * UsersLoginName class file
 * 验证登录名：登录名格式验证
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UsersLoginName.php 1 2013-03-29 16:48:06Z huan.song $
 * @package smods.ucenter.validator
 * @since 1.0
 */
class UsersLoginName extends BaseValidator
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
	 * @var integer 父ID
	 */
	public static $pid = 0;

	/**
	 * @var string 默认出错后的提醒消息
	 */
	protected $_message = '"%value%" from this users has the same login name.';

	/**
	 * (non-PHPdoc)
	 * @see tfc\validator.Validator::isValid()
	 */
	public function isValid()
	{
		$object = self::$object;
		$opType = trim(self::$opType);

		$this->objectIsValid($object);
		$this->opTypeIsValid($object, $opType);

		$loginName = $this->getValue();
		if (($loginName = trim($loginName)) === '') {
			return false;
		}

		$loginType = $object->getLoginType($loginName);

		if ($object->isMailLogin($loginType)) {
			$mailValidator = new MailValidator($loginName, true, $object->_('MOD_UCENTER_USERS_LOGIN_NAME_MAIL'));
			if (!$mailValidator->isValid()) {
				$this->setMessage($object->_('MOD_UCENTER_USERS_LOGIN_NAME_MAIL'));
				return false;
			}
		}
    	elseif ($object->isPhoneLogin($loginType)) {
    		$phoneValidator = new PhoneValidator($loginName, true, $object->_('MOD_UCENTER_USERS_LOGIN_NAME_PHONE'));
    		if (!$phoneValidator->isValid()) {
    			$this->setMessage($object->_('MOD_UCENTER_USERS_LOGIN_NAME_PHONE'));
    			return false;
    		}
    	}
    	else {
    		if (strpos($loginName, '@') || is_numeric($loginName)) {
    			$this->setMessage($object->_('MOD_UCENTER_USERS_LOGIN_NAME_ALPHANUM'));
    			return false;
    		}

    		$alphaNumValidator = new AlphaNumValidator($loginName, true, $object->_('MOD_UCENTER_USERS_LOGIN_NAME_ALPHANUM'));
    		if (!$alphaNumValidator->isValid()) {
    			$this->setMessage($object->_('MOD_UCENTER_USERS_LOGIN_NAME_ALPHANUM'));
    			return false;
    		}
    	}

    	return true;
	}
}
