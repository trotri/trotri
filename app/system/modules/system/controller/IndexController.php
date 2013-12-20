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
 * IndexController class file
 * 系统控制器
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: IndexController.php 1 2013-02-08 00:48:06Z huan.song $
 * @package modules.generator.controller
 * @since 1.0
 */
class IndexController extends BaseController
{
	/**
	 * @var string 页面首次渲染的布局名
	 */
	public $layoutName = 'column1';

	/**
	 * 404错误
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function err404Action()
	{
		$this->render();
	}
}
