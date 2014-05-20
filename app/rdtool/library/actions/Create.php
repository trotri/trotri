<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library\actions;

use library\ShowAction;
use tfc\ap\Ap;
use tfc\mvc\Mvc;
use libapp\Service;
use libapp\SubmitType;
use library\ErrorNo;

/**
 * Create abstract class file
 * Create基类，新增数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Create.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library.actions
 * @since 1.0
 */
abstract class Create extends ShowAction
{
	/**
	 * 执行操作：新增数据
	 * @param string $className
	 * @param string $moduleName
	 * @return void
	 */
	public function execute($className, $moduleName = '')
	{
		$ret = array();

		$req = Ap::getRequest();
		$srv = Service::getInstance($className, $moduleName);
		$submitType = new SubmitType();
		if ($submitType->isPost()) {
			$ret = $srv->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				if ($submitType->isTypeSave()) {
					$this->forward($srv->actNameModify, Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($submitType->isTypeSaveNew()) {
					$this->forward($srv->actNameCreate, Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($submitType->isTypeSaveClose()) {
					$url = $this->applyParams($srv->getLLU(), $ret);
					$this->redirect($url);
				}
			}
		}

		$this->assign('elements', $srv);
		$this->render($ret);
	}
}
