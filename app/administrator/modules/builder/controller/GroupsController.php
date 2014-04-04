<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\controller;

use library\BaseController;

/**
 * GroupsController class file
 * 表单字段组
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GroupsController.php 1 2014-04-04 14:53:06Z Code Generator $
 * @package modules.builder.controller
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
			'index'        => 'modules\\builder\\action\\show\\GroupsIndex',
			'view'         => 'modules\\builder\\action\\show\\GroupsView',
			'create'       => 'modules\\builder\\action\\submit\\GroupsCreate',
			'modify'       => 'modules\\builder\\action\\submit\\GroupsModify',
			'remove'       => 'modules\\builder\\action\\submit\\GroupsRemove',
			'singlemodify' => 'modules\\builder\\action\\submit\\GroupsSingleModify',
		);
	}
}
