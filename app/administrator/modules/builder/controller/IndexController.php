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
 * IndexController class file
 * 生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: IndexController.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.controller
 * @since 1.0
 */
class IndexController extends BaseController
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Controller::actions()
	 */
	public function actions()
	{
		return array(
			'index'        => 'modules\\builder\\action\\show\\BuilderIndex',
			'trashindex'   => 'modules\\builder\\action\\show\\BuilderTrashIndex',
			'view'         => 'modules\\builder\\action\\show\\BuilderView',
			'create'       => 'modules\\builder\\action\\submit\\BuilderCreate',
			'modify'       => 'modules\\builder\\action\\submit\\BuilderModify',
			'remove'       => 'modules\\builder\\action\\submit\\BuilderRemove',
			'singlemodify' => 'modules\\builder\\action\\submit\\BuilderSingleModify',
			'trash'        => 'modules\\builder\\action\\submit\\BuilderTrash',
			'restore'      => 'modules\\builder\\action\\submit\\BuilderTrash',
		);
	}
}
