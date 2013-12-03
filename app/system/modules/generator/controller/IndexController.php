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
use helper\Util;
use library\ErrorNo;
use tfc\saf\Text;

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
	 * 构造方法：初始化业务辅助类
	 */
	public function __construct()
	{
		$this->elementCollections = Util::getElements('generators', 'generator');
	}

	/**
	 * 数据列表
	 * @return void
	 */
	public function indexAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$pageNo = Util::getCurrPage();

		$params = $req->getQuery();
		$params['trash'] = 'n';

		$ret = Util::getModel('generators', 'generator')->search($pageNo, $params);
		$this->render($ret);
	}

	/**
	 * 回收站数据列表
	 * @return void
	 */
	public function trashindexAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$pageNo = Util::getCurrPage();
	
		$params = $req->getQuery();
		$params['trash'] = 'y';

		$ret = Util::getModel('generators', 'generator')->search($pageNo, $params);
		$this->render($ret);
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
		if ($do == 'post') {
			$ret = Util::getModel('generators', 'generator')->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$this->forward($ret);
			}
		}

		$this->render($ret);
	}

	/**
	 * 编辑数据
	 * @return void
	 */
	public function modifyAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = Util::getModel('generators', 'generator');

		$id = $req->getInteger('id');
		$do = $req->getParam('do');
		if ($do == 'post') {
			$ret = $mod->modifyByPk($id, $req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				$this->forward($ret);
			}

			$ret['data'] = $req->getPost();
		}
		else {
			$ret = $mod->findByPk($id);
		}

		$ret['id'] = $id;
		$this->render($ret);
	}

	/**
	 * 编辑单个字段
	 * @return void
	 */
	public function singlemodifyAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = Util::getModel('generators', 'generator');

		$id = $req->getInteger('id');
		$columnName = $req->getTrim('column_name', '');
		$value = $req->getParam('value', '');

		$ret = $mod->updateByPk($id, array($columnName => $value));
		$this->forward($ret);
	}

	/**
	 * 批量编辑单个字段
	 * @return void
	 */
	public function batchsinglemodifyAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = Util::getModel('generators', 'generator');

		$ids = explode(',', $req->getParam('ids'));
		$columnName = $req->getTrim('column_name', '');
		$value = $req->getParam('value', '');

		$ret = $mod->batchupdateByPk($ids, array($columnName => $value));
		$this->forward($ret);
	}

	/**
	 * 移至回收站
	 * @return void
	 */
	public function trashAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = Util::getModel('generators', 'generator');

		$id = $req->getInteger('id');
		$ret = $mod->trashByPk($id);
		$this->forward($ret);
	}

	/**
	 * 批量移至回收站
	 * @return void
	 */
	public function batchtrashAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = Util::getModel('generators', 'generator');

		$ids = explode(',', $req->getParam('ids'));
		$ret = $mod->batchTrashByPk($ids);
		$this->forward($ret);
	}

	/**
	 * 删除数据
	 * @return void
	 */
	public function removeAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = Util::getModel('generators', 'generator');

		$id = $req->getInteger('id');
		$ret = $mod->deleteByPk($id);
		$this->forward($ret);
	}

	/**
	 * 批量删除数据
	 * @return void
	 */
	public function batchremoveAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = Util::getModel('generators', 'generator');

		$ids = explode(',', $req->getParam('ids'));
		$ret = $mod->batchdeleteByPk($ids);
		$this->forward($ret);
	}

	/**
	 * 数据详情
	 * @return void
	 */
	public function viewAction()
	{
	}
}
