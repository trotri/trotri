<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\submit;

use library\action\ModifyAction;
use library\Model;

/**
 * GroupsModify class file
 * 编辑数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GroupsModify.php 1 2014-04-04 14:53:06Z Code Generator $
 * @package modules.builder.action.submit
 * @since 1.0
 */
class GroupsModify extends ModifyAction
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
