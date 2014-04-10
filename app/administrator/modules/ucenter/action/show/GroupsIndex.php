<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\action\show;

use tfc\ap\Ap;
use library\action\IndexAction;
use library\Model;

/**
 * GroupsIndex class file
 * 查询数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GroupsIndex.php 1 2014-04-10 17:43:20Z Code Generator $
 * @package modules.ucenter.action.show
 * @since 1.0
 */
class GroupsIndex extends IndexAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$mod = Model::getInstance('Groups');

		$ret = $mod->findLists();

		$this->assign('elements', $mod->getElementsRender());
		$this->render($ret);
	}
}
