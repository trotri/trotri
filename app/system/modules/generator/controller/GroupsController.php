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
use library\ErrorNo;
use library\Url;
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
		$view = Mvc::getView();
		$mod = GeneratorFactory::getModel('Groups');
		$ele = GeneratorFactory::getElements('Groups');
		$generatorId = $req->getInteger('generator_id');
		$pageNo = Url::getCurrPage();

		$params = array('generator_id' => $generatorId);
		$ret = $mod->search($params, 'sort', $pageNo);

		$view->assign('elementCollections', $ele);
		$view->assign('generator_id', $generatorId);
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
		$view = Mvc::getView();
		$mod = GeneratorFactory::getModel('Groups');
		$ele = GeneratorFactory::getElements('Groups');
		$generatorId = $req->getInteger('generator_id');

		if ($this->isPost()) {
			$ret = $mod->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$ret['generator_id'] = $generatorId;
				if ($this->isSubmitTypeSave()) {
					$ret['http_referer'] = Url::getUrl('index', 'groups', 'generator');
					Url::forward('modify', 'groups', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveNew()) {
					Url::forward('create', 'groups', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveClose()) {
					Url::forward('index', 'groups', 'generator', $ret);
				}
			}
		}

		$view->assign('elementCollections', $ele);
		$view->assign('generator_id', $generatorId);
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
		$view = Mvc::getView();
		$mod = GeneratorFactory::getModel('Groups');
		$ele = GeneratorFactory::getElements('Groups');
		$httpReferer = Url::getReferer();
		$generatorId = $req->getInteger('generator_id');

		$id = $req->getInteger('id');
		if ($this->isPost()) {
			$ret = $mod->modifyByPk($id, $req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$ret['generator_id'] = $generatorId;
				if ($this->isSubmitTypeSave()) {
					$ret['http_referer'] = Url::getUrl('index', 'groups', 'generator');
					Url::forward('modify', 'groups', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveNew()) {
					Url::forward('create', 'groups', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveClose()) {
					if ($httpReferer) {
						Url::referer($ret);
					}
					else {
						Url::forward('index', 'groups', 'generator', $ret);
					}
				}
			}

			$ret['data'] = $req->getPost();
		}
		else {
			$ret = $mod->findByPk($id);
		}

		$view->assign('elementCollections', $ele);
		$view->assign('generator_id', $generatorId);
		$view->assign('id', $id);
		$view->assign('http_referer', $httpReferer);
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
		Url::referer($ret);
	}

	/**
	 * 数据详情
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function viewAction()
	{
	}
}
