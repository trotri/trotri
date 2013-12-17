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
 * TypesController class file
 * 字段类型控制器
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TypesController.php 1 2013-02-08 00:48:06Z huan.song $
 * @package modules.generator.controller
 * @since 1.0
 */
class TypesController extends BaseController
{
	/**
	 * 数据列表
	 * @author 宋欢 <trotri@yeah.net>
	 */
	public function indexAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = GeneratorFactory::getModel('Types');
		$pageNo = $this->getCurrPage();

		$ret = $mod->findIndexByAttributes(array(), 'sort', $pageNo);
		Mvc::getView()->assign('elementCollections', GeneratorFactory::getElements('Types'));
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
		$mod = GeneratorFactory::getModel('Types');

		if ($this->isPost()) {
			$ret = $mod->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				if ($this->isSubmitTypeSave()) {
					$ret['http_referer'] = Url::getUrl('index', 'types', 'generator');
					Url::forward('modify', 'types', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveNew()) {
					Url::forward('create', 'types', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveClose()) {
					Url::forward('index', 'types', 'generator', $ret);
				}
			}
		}

		Mvc::getView()->assign('elementCollections', GeneratorFactory::getElements('Types'));
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
		$mod = GeneratorFactory::getModel('Types');
		$httpReferer = Url::getReferer();

		$id = $req->getInteger('id');
		if ($this->isPost()) {
			$ret = $mod->modifyByPk($id, $req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				if ($this->isSubmitTypeSave()) {
					Url::forward('modify', 'types', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveNew()) {
					Url::forward('create', 'types', 'generator', $ret);
				}
				elseif ($this->isSubmitTypeSaveClose()) {
					if ($httpReferer) {
						Url::referer($ret);
					}
					else {
						Url::forward('index', 'types', 'generator', $ret);
					}
				}
			}

			$ret['data'] = $req->getPost();
		}
		else {
			$ret = $mod->findByPk($id);
		}

		$ret['id'] = $id;
		$ret['http_referer'] = $httpReferer;

		Mvc::getView()->assign('elementCollections', GeneratorFactory::getElements('Types'));
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
		$mod = GeneratorFactory::getModel('Types');

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
