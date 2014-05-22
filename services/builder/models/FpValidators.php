<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace builder\models;

use libsrv\FormProcessor;
use libsrv\Clean;
use builder\library\Lang;

use tfc\validator\AlphaValidator;
use tfc\validator\AlphaNumValidator;
use tfc\validator\MinLengthValidator;
use tfc\validator\MaxLengthValidator;
use tfc\validator\MailValidator;
use tfc\validator\NotEmptyValidator;
use tfc\validator\InArrayValidator;

/**
 * FpValidators class file
 * 业务层：表单数据处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FpValidators.php 1 2014-04-03 16:16:03Z Code Generator $
 * @package builder.models
 * @since 1.0
 */
class FpValidators extends FormProcessor
{
}
