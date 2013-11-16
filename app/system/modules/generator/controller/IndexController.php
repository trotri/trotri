<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\controller;

use library\BaseController;
use tfc\ap\Ap;
use library\Util;
use library\ErrorNo;

/**
 * IndexController class file
 * 生成代码控制器
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: IndexController.php 1 2013-02-08 00:48:06Z huan.song $
 * @package modules.generator.controller
 * @since 1.0
 */
class IndexController extends BaseController
{
	/**
	 * 数据列表
	 * @return void
	 */
	public function indexAction()
	{
		$ret = Util::getModel('Generators', 'generator')->findAll();
		$this->render($ret);
	}

	/**
	 * 数据详情
	 * @return void
	 */
	public function viewAction()
	{
	}

	/**
	 * 新增数据
	 * @return void
	 */
	public function createAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$do = $req->getParam('do');
		$submitType = $req->getParam('submit_type');

		if ($do == 'post') {
			$ret = Util::getModel('Generators', 'generator')->create($req->getPost());
		}

		$this->render($ret);
	}

	/**
	 * 编辑数据
	 * @return void
	 */
	public function modifyAction()
	{
	}

	/**
	 * 移至回收站
	 * @return void
	 */
	public function trashAction()
	{
	}

	/**
	 * 删除数据
	 * @return void
	 */
	public function removeAction()
	{
	}
}
