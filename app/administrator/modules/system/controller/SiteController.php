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
 * SiteController class file
 * 系统首页
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SiteController.php 1 2014-01-06 16:47:52Z huan.song $
 * @package modules.system.controller
 * @since 1.0
 */
class SiteController extends BaseController
{
	/**
	 * @var string 页面首次渲染的布局名
	 */
	public $layoutName = 'column1';

	/**
	 * 首页
	 * @return void
	 */
	public function indexAction()
	{
		$this->render();
	}

	/**
	 * About
	 * @return void
	 */
	public function aboutAction()
	{
		$this->render();
	}

	/**
	 * 404错误
	 * @return void
	 */
	public function err404Action()
	{
		$this->render();
	}
}
