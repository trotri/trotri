<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\show;

use tfc\ap\Ap;
use library\action\IndexAction;

/**
 * TypesIndex class file
 * 查询数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TypesIndex.php 1 2014-04-04 13:49:20Z Code Generator $
 * @package modules.builder.action.show
 * @since 1.0
 */
class TypesIndex extends IndexAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		Ap::getRequest()->setParam('order', 'sort');
		$this->execute('Types');
	}
}
