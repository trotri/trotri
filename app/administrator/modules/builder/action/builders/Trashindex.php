<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\builders;

use library\actions;
use tfc\ap\Ap;

/**
 * Trashindex class file
 * 查询回收站数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Trashindex.php 1 2014-05-26 19:25:19Z Code Generator $
 * @package modules.builder.action.builders
 * @since 1.0
 */
class Trashindex extends actions\Index
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		Ap::getRequest()->setParam('trash', 'y');
		$this->execute('Builders');
	}
}
