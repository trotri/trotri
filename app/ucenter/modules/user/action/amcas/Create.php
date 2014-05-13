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
use modules\user\service\Amcas AS SrvAmcas;
use modules\user\elements\Amcas AS EleAmcas;

/**
 * Create class file
 * 新增数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Create.php 1 2014-04-06 14:43:08Z Code Generator $
 * @package modules.user.action.amcas
 * @since 1.0
 */
class Create extends actions\Create
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$ret = array();

		$req = Ap::getRequest();
		$srv = new SrvAmcas();
		$ele = new EleAmcas($srv);
		$submitType = new SubmitType();

		$amcaPid = $req->getInteger('amca_pid');
		if ($amcaPid <= 0) {
			$this->err404();
		}

		if ($submitType->isPost()) {
			$ret = $srv->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				if ($submitType->isTypeSave()) {
					$this->forward('modify', Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($submitType->isTypeSaveNew()) {
					$this->forward('create', Mvc::$controller, Mvc::$module, array('amca_pid' => $amcaPid));
				}
				elseif ($submitType->isTypeSaveClose()) {
					$url = $this->applyParams($ele->getLLU(), $ret);
					$this->redirect($url);
				}
			}
		}

		if (!$srv->isApp($srv->getCategoryByAmcaId($amcaPid))) {
			$this->err404();
		}

		$this->assign('elements', $ele);
		$this->assign('amca_pid', $amcaPid);
		$this->render($ret);
	}
}
