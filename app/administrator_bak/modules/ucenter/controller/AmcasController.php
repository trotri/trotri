<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\controller;

use tfc\util\Encoder;

use library\BaseController;
use tfc\ap\Ap;
use tfc\mvc\Mvc;
use library\ErrorNo;
use library\Url;
use library\UcenterFactory;

/**
 * AmcasController class file
 * 用户可访问的事件
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: AmcasController.php 1 2014-01-22 16:43:52Z huan.song $
 * @package modules.ucenter.controller
 * @since 1.0
 */
class AmcasController extends BaseController
{
	/**
	 * 查询数据列表
	 * @return void
	 */
	public function indexAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$viw = Mvc::getView();
		$mod = UcenterFactory::getModel('Amcas');
		$ele = UcenterFactory::getElements('Amcas');
		$appId = $req->getInteger('app_id');
		$appAmcas = $mod->getAppAmcas();
		if ($appId <= 0) {
			$appId = array_shift(array_keys($appAmcas));
		}

		if (!isset($appAmcas[$appId])) {
			Url::err404();
		}

		$ret = $mod->findModCtrls($appId);
		$return = Url::getUrl(Mvc::$action, Mvc::$controller, Mvc::$module, array('app_id' => $appId));
		Ap::getRequest()->setParam('http_return', $return);

		$viw->assign('element_collections', $ele);
		$viw->assign('app_id', $appId);
		$viw->assign('app_amcas', $appAmcas);
		$viw->assign('http_return', $return);
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
		$viw = Mvc::getView();
		$mod = UcenterFactory::getModel('Amcas');
		$ele = UcenterFactory::getElements('Amcas');
		$amcaPid = UcenterFactory::getModel('Amcas')->getAmcaPid();
		$appAmcas = $mod->getAppAmcas();
		if ($amcaPid > 0 && !isset($appAmcas[$amcaPid])) {
			Url::err404();
		}

		if ($this->isPost()) {
			$ret = $mod->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				if ($this->isSubmitTypeSave()) {
					Url::forward('modify', Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($this->isSubmitTypeSaveNew()) {
					Url::forward('create', Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($this->isSubmitTypeSaveClose()) {
					$ret['app_id'] = $amcaPid;
					Url::forward('index', Mvc::$controller, Mvc::$module, $ret);
				}
			}
		}

		$viw->assign('element_collections', $ele);
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
		$viw = Mvc::getView();
		$mod = UcenterFactory::getModel('Amcas');
		$ele = UcenterFactory::getElements('Amcas');

		$id = $req->getInteger('id');
		$appId = UcenterFactory::getModel('Amcas')->getAmcaPid();
		if ($appId <= 0) {
			$appId = $id;
		}

		$httpReturn = Url::getHttpReturn();
		if ($httpReturn === '') {
			$httpReturn = Url::getUrl('index', Mvc::$controller, Mvc::$module, array('app_id' => $appId));
		}

		if ($this->isPost()) {
			$ret = $mod->modifyByPk($id, $req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				if ($this->isSubmitTypeSave()) {
					$ret['http_return'] = $httpReturn;
					Url::forward('modify', Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($this->isSubmitTypeSaveNew()) {
					Url::forward('create', Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($this->isSubmitTypeSaveClose()) {
					$url = Url::applyParams($httpReturn, $ret);
					Url::redirect($url);
				}
			}

			$ret['data'] = $req->getPost();
		}
		else {
			$ret = $mod->findByPk($id);
		}

		$options = $ele->getCategory($ele::TYPE_OPTIONS);
		$ret['data']['category'] = isset($options[$ret['data']['category']]) ? $options[$ret['data']['category']] : '';

		$options = $ele->getAmcaPid($ele::TYPE_OPTIONS);
		$ret['data']['amca_pid'] = isset($options[$ret['data']['amca_pid']]) ? $options[$ret['data']['amca_pid']] : '';

		$viw->assign('element_collections', $ele);
		$viw->assign('id', $id);
		$this->render($ret);
	}

	/**
	 * 删除数据
	 * @return void
	 */
	public function removeAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = UcenterFactory::getModel('Amcas');

		$id = $req->getInteger('id');
		$ret = $mod->deleteByPk($id);
		Url::httpReturn($ret);
	}

	/**
	 * 编辑单个字段
	 * @return void
	 */
	public function singlemodifyAction()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = UcenterFactory::getModel('Amcas');

		$id = $req->getInteger('id');
		$columnName = $req->getTrim('column_name', '');
		$value = $req->getParam('value', '');
		$ret = $mod->updateByPk($id, array($columnName => $value));
		Url::httpReturn($ret);
	}

	/**
	 * 浏览行动类型数据
	 * @return void
	 */
	public function actsviewAction()
	{
		$req = Ap::getRequest();
		$viw = Mvc::getView();
		$mod = UcenterFactory::getModel('Amcas');
		$ele = UcenterFactory::getElements('Amcas');

		$ctrlId = $req->getInteger('ctrl_id');
		$ret = $mod->findByPk($ctrlId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->display($ret);
		}

		$ctrlAmcas = $ret['data'];
		$ret = $mod->findAllByAttributes(array('amca_pid' => (int) $ctrlId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->display($ret);
		}

		$body = $viw->widget(
			'ui\bootstrap\widgets\TableBuilder',
			array(
				'elementCollections' => $ele,
				'data' => $ret['data'],
				'columns' => array('amca_name', 'prompt', 'sort', 'amca_id')
			), array(), true
		);

		$this->display(array(
			'title' => $ctrlAmcas['prompt'] . ' ' . $ctrlAmcas['amca_name'],
			'body' => $body
		));
	}

	/**
	 * 查询数据详情
	 * @return void
	 */
	public function viewAction()
	{
	}

	/**
	 * 同步用户事件
	 * @return void
	 */
	public function synchAction()
	{
		$req = Ap::getRequest();

		$mod = UcenterFactory::getModel('Amcas');
		$id = $req->getInteger('id');

		$mod->synch($id);
	}
}
