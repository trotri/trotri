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

use tfc\ap\Ap;
use library\action\ModifyAction;
use library\Model;

/**
 * GroupsPermissionModify class file
 * 编辑“权限设置”字段
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GroupsPermissionModify.php 1 2014-04-10 17:43:20Z Code Generator $
 * @package modules.ucenter.action.submit
 * @since 1.0
 */
class GroupsPermissionModify extends ModifyAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = Model::getInstance('Groups');
		$id = $req->getInteger('id');
		if ($this->isPost()) {
			
		}

		$mod = Model::getInstance('Groups');

		$amcas = $mod->getAmcas($id);

		$this->assign('id', $id);
		$this->assign('amcas', $amcas);
		$this->assign('elements', $mod->getElementsRender());
		$this->render();
	}
}
