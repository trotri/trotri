<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\submit;

use library\action\ModifyAction;
use library\Model;

/**
 * ValidatorsModify class file
 * 编辑数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ValidatorsModify.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.action.submit
 * @since 1.0
 */
class ValidatorsModify extends ModifyAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$modValidators = Model::getInstance('Validators');
		$fieldId = $modValidators->getFieldId();
		if ($fieldId <= 0) {
			$this->err404();
		}

		$modFields = Model::getInstance('Fields');
		$builderId = $modFields->getBuilderIdByFieldId($fieldId);
		if ($builderId <= 0) {
			$this->err404();
		}

		$messageEnum = $modValidators->getMessageEnum();
		$optionCategoryEnum = $modValidators->getOptionCategoryEnum();

		$this->assign('field_id', $fieldId);
		$this->assign('builder_id', $builderId);
		$this->assign('message_enum', json_encode($messageEnum));
		$this->assign('option_category_enum', json_encode($optionCategoryEnum));
		$this->execute('Validators');
	}
}
