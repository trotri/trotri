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
 * ValidatorsController class file
 * 表单字段验证
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ValidatorsController.php 1 2014-04-05 22:11:11Z Code Generator $
 * @package modules.builder.controller
 * @since 1.0
 */
class ValidatorsController extends BaseController
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Controller::actions()
	 */
	public function actions()
	{
		return array(
			'index'        => 'modules\\builder\\action\\show\\ValidatorsIndex',
			'view'         => 'modules\\builder\\action\\show\\ValidatorsView',
			'create'       => 'modules\\builder\\action\\submit\\ValidatorsCreate',
			'modify'       => 'modules\\builder\\action\\submit\\ValidatorsModify',
			'remove'       => 'modules\\builder\\action\\submit\\ValidatorsRemove',
			'singlemodify' => 'modules\\builder\\action\\submit\\ValidatorsSingleModify',
		);
	}
}
