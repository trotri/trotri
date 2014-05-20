<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\validators;

use library\actions;
use libapp\Service;

/**
 * Modify class file
 * 编辑数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Modify.php 1 2014-04-05 22:11:12Z Code Generator $
 * @package modules.builder.action.validators
 * @since 1.0
 */
class Modify extends actions\Modify
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$srvValidators = Service::getInstance('Validators');
		$fieldId = $srvValidators->getFieldId();
		if ($fieldId <= 0) {
			$this->err404();
		}

		$srvFields = Service::getInstance('Fields');
		$builderId = $srvFields->getBuilderIdByFieldId($fieldId);
		if ($builderId <= 0) {
			$this->err404();
		}

		$messageEnum = $srvValidators->getMessageEnum();
		$optionCategoryEnum = $srvFields->getOptionCategoryEnum();

		$this->assign('field_id', $fieldId);
		$this->assign('builder_id', $builderId);
		$this->assign('message_enum', json_encode($messageEnum));
		$this->assign('option_category_enum', json_encode($optionCategoryEnum));
		$this->execute('Validators');
	}
}
