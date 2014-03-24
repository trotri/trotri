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

use library\action\IndexAction;
use library\Model;
use library\ErrorNo;

/**
 * SchemaIndex class file
 * 查询数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SchemaIndex.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.action.show
 * @since 1.0
 */
class SchemaIndex extends IndexAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$ret = array();

		$mod = Model::getInstance('Schema');
		$tableNames = $mod->getTableNames();

		\tfc\saf\debug_dump($tableNames);

		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->err404();
		}

		$this->assign('elements', $mod->getElementsRender());
		$this->render($ret);
	}
}
