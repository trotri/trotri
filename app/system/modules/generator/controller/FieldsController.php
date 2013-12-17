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
		$mod = GeneratorFactory::getModel('Fields');
		$generatorId = $req->getInteger('generator_id');
		$pageNo = $this->getCurrPage();

		$ret = $mod->findIndexByAttributes(array('generator_id' => $generatorId), '', $pageNo);

		$ret['generator_id'] = $generatorId;

		Mvc::getView()->assign('elementCollections', GeneratorFactory::getElements('Fields'));
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
		$mod = GeneratorFactory::getModel('Fields');
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

		Mvc::getView()->assign('elementCollections', GeneratorFactory::getElements('Fields'));
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
