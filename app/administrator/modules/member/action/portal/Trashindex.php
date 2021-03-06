<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\member\action\portal;

use library\actions;
use tfc\ap\Ap;

/**
 * Trashindex class file
 * 查询回收站数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Trashindex.php 1 2014-11-26 21:46:18Z Code Generator $
 * @package modules.member.action.portal
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
		$this->execute('Portal');
	}
}
