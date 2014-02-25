<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\system\controller;

use library\BaseController;

/**
 * ToolsController class file
 * 系统工具
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ToolsController.php 1 2014-01-06 16:47:52Z huan.song $
 * @package modules.system.controller
 * @since 1.0
 */
class ToolsController extends BaseController
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Controller::actions()
	 */
	public function actions()
	{
		return array(
			'cacheclear'        => 'modules\\system\\action\\submit\\ToolsCacheClear',
		);
	}
}
