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
 * FieldsController class file
 * 表单字段
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FieldsController.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.controller
 * @since 1.0
 */
class FieldsController extends BaseController
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Controller::actions()
	 */
	public function actions()
	{
		return array(
			'index'        => 'modules\\builder\\action\\show\\FieldsIndex',
			'view'         => 'modules\\builder\\action\\show\\FieldsView',
			'create'       => 'modules\\builder\\action\\submit\\FieldsCreate',
			'modify'       => 'modules\\builder\\action\\submit\\FieldsModify',
			'remove'       => 'modules\\builder\\action\\submit\\FieldsRemove',
			'singlemodify' => 'modules\\builder\\action\\submit\\FieldsSingleModify',
		);
	}
}