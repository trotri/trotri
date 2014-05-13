<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\user\action\amcas;

use library\actions;
use tfc\ap\Ap;
use tfc\mvc\Mvc;
use library\ErrorNo;
use library\SubmitType;
use modules\user\service\Amcas;

/**
 * Modify class file
 * 编辑数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Modify.php 1 2014-04-10 17:43:20Z Code Generator $
 * @package modules.user.action.amcas
 * @since 1.0
 */
class Modify extends actions\Modify
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$ret = array();

		$req = Ap::getRequest();
		$srv = new Amcas();
		$submitType = new SubmitType();

		$id = $req->getInteger('id');
		if ($id <= 0) {
			$this->err404();
		}

		if ($submitType->isPost()) {
			$ret = $srv->modify($id, $req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				if ($submitType->isTypeSave()) {
					$this->forward('modify', Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($submitType->isTypeSaveNew()) {
					$this->forward('create', Mvc::$controller, Mvc::$module, array('amca_pid' => $req->getInteger('amca_pid')));
				}
				elseif ($submitType->isTypeSaveClose()) {
					$url = $this->applyParams($srv->getLLU(), $ret);
					$this->redirect($url);
				}
			}

			$ret['data'] = $req->getPost();
		}
		else {
			$ret = $srv->findByAmcaId($id);
		}

		$this->assign('elements', $srv);
		$this->assign('id', $id);
		$this->render($ret);
	}
}
