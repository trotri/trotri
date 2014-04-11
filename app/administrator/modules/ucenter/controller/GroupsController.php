<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\controller;

use library\BaseController;

/**
 * GroupsController class file
 * 用户组
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GroupsController.php 1 2014-04-10 17:43:20Z Code Generator $
 * @package modules.ucenter.controller
 * @since 1.0
 */
class GroupsController extends BaseController
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Controller::actions()
	 */
	public function actions()
	{
		return array(
			'index'            => 'modules\\ucenter\\action\\show\\GroupsIndex',
			'view'             => 'modules\\ucenter\\action\\show\\GroupsView',
			'create'           => 'modules\\ucenter\\action\\submit\\GroupsCreate',
			'modify'           => 'modules\\ucenter\\action\\submit\\GroupsModify',
			'remove'           => 'modules\\ucenter\\action\\submit\\GroupsRemove',
			'singlemodify'     => 'modules\\ucenter\\action\\submit\\GroupsSingleModify',
			'permissionmodify' => 'modules\\ucenter\\action\\submit\\GroupsPermissionModify',
		);
	}
}
