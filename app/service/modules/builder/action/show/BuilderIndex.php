<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\show;

use library\BaseAction;

/**
 * IndexController class file
 * 生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: IndexController.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.controller
 * @since 1.0
 */
class BuilderIndex extends BaseAction
{
	public function actions()
	{
		return array(
			'index'        => 'modules\\builder\\action\\show\\categories\\ListAction',
			'view'         => 'modules\\builder\\action\\show\\categories\\RemoveAction',
			'create'       => 'modules\\builder\\action\\submit\\categories\\AddAction',
			'modify'       => 'modules\\builder\\action\\submit\\categories\\EditAction',
			'remove'       => 'modules\\builder\\action\\submit\\categories\\RemoveAction',
			'singlemodify' => 'modules\\builder\\action\\submit\\categories\\RemoveAction',
		);
	}
}
