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

/**
 * BuilderTrashIndex class file
 * 生成代码-查询回收站数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BuilderTrashIndex.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.action.show
 * @since 1.0
 */
class BuilderTrashIndex extends IndexAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		Ap::getRequest()->setParam('trash', 'y');
		$this->execute('Builders');
	}
}
