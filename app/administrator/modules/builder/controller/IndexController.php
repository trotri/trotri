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
			'index'        => 'modules\\builder\\action\\show\\BuildersIndex',
			'trashindex'   => 'modules\\builder\\action\\show\\BuildersTrashIndex',
			'view'         => 'modules\\builder\\action\\show\\BuildersView',
			'create'       => 'modules\\builder\\action\\submit\\BuildersCreate',
			'modify'       => 'modules\\builder\\action\\submit\\BuildersModify',
			'remove'       => 'modules\\builder\\action\\submit\\BuildersRemove',
			'singlemodify' => 'modules\\builder\\action\\submit\\BuildersSingleModify',
			'trash'        => 'modules\\builder\\action\\submit\\BuildersTrash',
		);
	}
}
