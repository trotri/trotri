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
 * FieldsController class file
 * 字段控制器
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FieldsController.php 1 2013-02-08 00:48:06Z huan.song $
 * @package modules.generator.controller
 * @since 1.0
 */
class FieldsController extends BaseController
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
		$mod = GeneratorFactory::getModel('Fields');
		$ele = GeneratorFactory::getElements('Fields');
		$generatorId = $req->getInteger('generator_id');
		$pageNo = $this->getCurrPage();

		$ret = $mod->findIndexByAttributes(array('generator_id' => $generatorId), '', $pageNo);

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
		$mod = GeneratorFactory::getModel('Fields');
		$ele = GeneratorFactory::getElements('Fields');
		$generatorId = $req->getInteger('generator_id');

		if ($this->isPost()) {
			$ret = $mod->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$ret['generator_id'] = $generatorId;
				if ($this->isSubmitTypeSave()) {
					$ret['http_referer'] = Url::getUrl('index', 'fields', 'generator');
					Url::forward('modify', 'fields', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveNew()) {
					Url::forward('create', 'fields', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveClose()) {
					Url::forward('index', 'fields', 'generator', $ret);
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
		$mod = GeneratorFactory::getModel('Fields');
		$ele = GeneratorFactory::getElements('Fields');
		$httpReferer = Url::getReferer();
		$generatorId = $req->getInteger('generator_id');

		$id = $req->getInteger('id');
		if ($this->isPost()) {
			$ret = $mod->modifyByPk($id, $req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$ret['generator_id'] = $generatorId;
				if ($this->isSubmitTypeSave()) {
					$ret['http_referer'] = Url::getUrl('index', 'fields', 'generator');
					Url::forward('modify', 'fields', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveNew()) {
					Url::forward('create', 'fields', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveClose()) {
					if ($httpReferer) {
						Url::referer($ret);
					}
					else {
						Url::forward('index', 'fields', 'generator', $ret);
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
		$mod = GeneratorFactory::getModel('Fields');

		$id = $req->getInteger('id');
		$ret = $mod->deleteByPk($id);
		Url::referer($ret);
	}

	/**
	 * 编辑单个字段
	 * @return void
	 */
	public function singlemodifyAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = GeneratorFactory::getModel('Fields');

		$id = $req->getInteger('id');
		$columnName = $req->getTrim('column_name', '');
		$value = $req->getParam('value', '');
		$ret = $mod->updateByPk($id, array($columnName => $value));
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
