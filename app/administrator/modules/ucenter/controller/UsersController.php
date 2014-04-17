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
 * UsersController class file
 * 用户管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UsersController.php 1 2014-04-15 14:43:50Z Code Generator $
 * @package modules.ucenter.controller
 * @since 1.0
 */
class UsersController extends BaseController
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Controller::actions()
	 */
	public function actions()
	{
		return array(
			'index'        => 'modules\\ucenter\\action\\show\\UsersIndex',
			'trashindex'   => 'modules\\ucenter\\action\\show\\UsersTrashIndex',
			'view'         => 'modules\\ucenter\\action\\show\\UsersView',
			'create'       => 'modules\\ucenter\\action\\submit\\UsersCreate',
			'modify'       => 'modules\\ucenter\\action\\submit\\UsersModify',
			'remove'       => 'modules\\ucenter\\action\\submit\\UsersRemove',
			'singlemodify' => 'modules\\ucenter\\action\\submit\\UsersSingleModify',
			'trash'        => 'modules\\ucenter\\action\\submit\\UsersTrash',
			'login'        => 'modules\\ucenter\\action\\show\\UsersLogin',
		);
	}
}
