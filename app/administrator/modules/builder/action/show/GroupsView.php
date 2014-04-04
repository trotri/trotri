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

use library\action\ViewAction;
use library\Model;

/**
 * GroupsView class file
 * 查询数据详情
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GroupsView.php 1 2014-04-04 14:53:06Z Code Generator $
 * @package modules.builder.action.show
 * @since 1.0
 */
class GroupsView extends ViewAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$mod = Model::getInstance('Groups');
		$builderId = $mod->getBuilderId();
		if ($builderId <= 0) {
			$this->err404();
		}

		$this->assign('builder_id', $builderId);
		$this->execute('Groups');
	}
}
