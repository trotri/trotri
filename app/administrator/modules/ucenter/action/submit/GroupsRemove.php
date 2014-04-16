<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\action\submit;

use library\action\base\RemoveAction;

/**
 * GroupsRemove class file
 * 删除数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GroupsRemove.php 1 2014-04-10 17:43:20Z Code Generator $
 * @package modules.ucenter.action.submit
 * @since 1.0
 */
class GroupsRemove extends RemoveAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$this->execute('Groups');
	}
}