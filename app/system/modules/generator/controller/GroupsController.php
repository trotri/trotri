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
use tfc\mvc\Mvc;
use helper\Util;
use library\ErrorNo;
use library\GeneratorFactory;

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
	 * 数据列表
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function indexAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = GeneratorFactory::getModel('Groups');
		$pageNo = $this->getCurrPage();

		$generatorId = $req->getInteger('generator_id');
		$ret = $mod->findIndexByAttributes(array('generator_id' => $generatorId), 'sort', $pageNo);
		$ret['generator_id'] = $generatorId;

		Mvc::getView()->assign('elementCollections', GeneratorFactory::getElements('Groups'));
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
		$mod = GeneratorFactory::getModel('Groups');

		$do = $req->getParam('do');
		if ($do == 'post') {
			$ret = $mod->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				
			}
		}

		Mvc::getView()->assign('elementCollections', GeneratorFactory::getElements('Groups'));
		$this->render($ret);
	}

	/**
	 * 编辑数据
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function modifyAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = GeneratorFactory::getModel('Groups');

		$id = $req->getInteger('id');
		$do = $req->getParam('do');
		if ($do == 'post') {
			$ret = $mod->modifyByPk($id, $req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				
			}

			$ret['data'] = $req->getPost();
		}
		else {
			$ret = $mod->findByPk($id);
		}

		$ret['id'] = $id;
		Mvc::getView()->assign('elementCollections', GeneratorFactory::getElements('Groups'));
		$this->render($ret);
	}

	/**
	 * 删除数据
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function removeAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = GeneratorFactory::getModel('Groups');

		$id = $req->getInteger('id');
		$ret = $mod->deleteByPk($id);
	}

	/**
	 * 数据详情
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function viewAction()
	{
	}
}
