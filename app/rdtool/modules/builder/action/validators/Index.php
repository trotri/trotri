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
use tfc\ap\Ap;
use app\SrvFactory;

/**
 * Index class file
 * 查询数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Index.php 1 2014-04-05 22:11:12Z Code Generator $
 * @package modules.builder.action.validators
 * @since 1.0
 */
class Index extends actions\Index
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

		$srv = SrvFactory::getInstance('Fields');
		$builderId = $srv->getBuilderIdByFieldId($fieldId);
		if ($builderId <= 0) {
			$this->err404();
		}

		$this->assign('field_id', $fieldId);
		$this->assign('builder_id', $builderId);

		Ap::getRequest()->setParam('order', 'sort');
		$this->execute('Validators');
	}
}
