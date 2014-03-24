<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\show;

use tfc\ap\Ap;
use library\action\IndexAction;
use library\Model;

/**
 * ValidatorsIndex class file
 * 查询数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ValidatorsIndex.php 1 2014-01-18 14:19:29Z huan.song $ 
 * @package modules.builder.action.show
 * @since 1.0
 */
class ValidatorsIndex extends IndexAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$fieldId = Ap::getRequest()->getInteger('field_id');
		if ($fieldId <= 0) {
			$this->err404();
		}

		$mod = Model::getInstance('Fields');
		$builderId = $mod->getBuilderIdByFieldId($fieldId);
		if ($builderId <= 0) {
			$this->err404();
		}

		$this->assign('field_id', $fieldId);
		$this->assign('builder_id', $builderId);

		Ap::getRequest()->setParam('order', 'sort');
		$this->execute('Validators');
	}
}
