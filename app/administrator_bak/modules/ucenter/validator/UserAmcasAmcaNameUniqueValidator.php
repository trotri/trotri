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
use library\UcenterFactory;

/**
 * UserAmcasAmcaNameUniqueValidator class file
 * 验证事件名：同一事件下的子事件名不能重复
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UserAmcasAmcaNameUniqueValidator.php 1 2013-03-29 16:48:06Z huan.song $
 * @package modules.ucenter.model.validator
 * @since 1.0
 */
class UserAmcasAmcaNameUniqueValidator extends Validator
{
    /**
     * @var string 默认出错后的提醒消息
     */
    protected $_message = '"%value%" from this user amcas has the same name.';

    /**
     * (non-PHPdoc)
     * @see tfc\validator.Validator::isValid()
     */
    public function isValid()
    {
    	$amcaName = $this->getValue();
    	$amcaPid = (int) $this->getOption();

    	$total = UcenterFactory::getModel('Amcas')->countByPidAndName($amcaPid, $amcaName);
        return ($total > 0) ? false : true;
    }
}
