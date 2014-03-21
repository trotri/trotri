<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\controller;

use library\BaseController;

/**
 * TypesController class file
 * 表单字段类型
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TypesController.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.controller
 * @since 1.0
 */
class TypesController extends BaseController
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Controller::actions()
	 */
	public function actions()
	{
		return array(
			'index'        => 'modules\\builder\\action\\show\\TypesIndex',
			'view'         => 'modules\\builder\\action\\show\\TypesView',
			'create'       => 'modules\\builder\\action\\submit\\TypesCreate',
			'modify'       => 'modules\\builder\\action\\submit\\TypesModify',
			'remove'       => 'modules\\builder\\action\\submit\\TypesRemove',
		);
	}
}
