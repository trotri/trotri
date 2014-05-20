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
 * View class file
 * 查询数据详情
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: View.php 1 2014-04-05 22:11:12Z Code Generator $
 * @package modules.builder.action.validators
 * @since 1.0
 */
class View extends actions\View
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

		$this->assign('field_id', $fieldId);
		$this->assign('builder_id', $builderId);
		$this->execute('Validators');
	}
}
