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
use library\ErrorNo;
use helper\Util;

/**
 * GroupsController class file
 * 字段组控制器
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GroupsController.php 1 2013-02-08 00:48:06Z huan.song $
 * @package modules.generator.controller
 * @since 1.0
 */
class GroupsController extends BaseController
{
	/**
	 * 构造方法：初始化业务辅助类
	 */
	public function __construct()
	{
		$this->helper = Util::getHelper('groups', 'generator');
	}

	/**
	 * 数据列表
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function indexAction()
	{
		$ret = array();

		$req = Ap::getRequest();

		$generatorId = $req->getInteger('generator_id');
		$ret = Util::getModel('groups', 'generator')->findIndexByAttributes(array('generator_id' => $generatorId), 'sort');

		$this->render($ret);
	}

	/**
	 * 新增数据
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function createAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$do = $req->getParam('do');
		if ($do == 'post') {
			$ret = Util::getModel('groups', 'generator')->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$this->forward($ret);
			}
		}

		$this->render($ret);
	}

	/**
	 * 编辑数据
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function modifyAction()
	{
	}

	/**
	 * 删除数据
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function removeAction()
	{
	}

	/**
	 * 数据详情
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function viewAction()
	{
	}
}
