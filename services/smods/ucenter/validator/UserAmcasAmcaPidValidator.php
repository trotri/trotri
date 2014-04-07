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
 * UserAmcasAmcaPidValidator class file
 * 验证父事件ID：如果父ID<=0，表示“应用”类型事件；如果父ID>0，表示“模块”类型事件，判断该ID是否存在
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UserAmcasAmcaPidValidator.php 1 2013-03-29 16:48:06Z huan.song $
 * @package modules.ucenter.model.validator
 * @since 1.0
 */
class UserAmcasAmcaPidValidator extends Validator
{
    /**
     * @var string 默认出错后的提醒消息
     */
    protected $_message = '"%value%" was not found or be deleted.';

    /**
     * (non-PHPdoc)
     * @see tfc\validator.Validator::isValid()
     */
    public function isValid()
    {
    	$amcaPid = (int) $this->getValue();
    	if ($amcaPid === 0) {
    		return true;
    	}

 		$appAmcas = UcenterFactory::getModel('Amcas')->getAppAmcas();
 		if (isset($appAmcas[$amcaPid])) {
 			return true;
 		}

        return false;
    }
}
