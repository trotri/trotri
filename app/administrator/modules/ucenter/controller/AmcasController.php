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
 * AmcasController class file
 * 用户可访问的事件
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: AmcasController.php 1 2014-04-06 14:43:07Z Code Generator $
 * @package modules.ucenter.controller
 * @since 1.0
 */
class AmcasController extends BaseController
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Controller::actions()
	 */
	public function actions()
	{
		return array(
			'index'        => 'modules\\ucenter\\action\\show\\AmcasIndex',
			'view'         => 'modules\\ucenter\\action\\show\\AmcasView',
			'create'       => 'modules\\ucenter\\action\\submit\\AmcasCreate',
			'modify'       => 'modules\\ucenter\\action\\submit\\AmcasModify',
			'remove'       => 'modules\\ucenter\\action\\submit\\AmcasRemove',
			'singlemodify' => 'modules\\ucenter\\action\\submit\\AmcasSingleModify',
		);
	}
}
