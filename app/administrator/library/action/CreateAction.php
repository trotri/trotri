<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library\action;

use tfc\ap\Ap;
use tfc\mvc\Mvc;
use library\action\base\SubmitAction;
use library\Model;
use library\ErrorNo;

/**
 * CreateAction abstract class file
 * CreateAction基类，用于新增数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: CreateAction.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library.action
 * @since 1.0
 */
abstract class CreateAction extends SubmitAction
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
		$mod = Model::getInstance($className, $moduleName);
		if ($this->isPost()) {
			$ret = $mod->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				if ($this->isSubmitTypeSave()) {
					$this->forward($mod::ACT_MODIFY, Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($this->isSubmitTypeSaveNew()) {
					$this->forward($mod::ACT_CREATE, Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($this->isSubmitTypeSaveClose()) {
					$this->forward($mod::ACT_INDEX, Mvc::$controller, Mvc::$module, $ret);
				}
			}
		}

		$this->assign('tabs', $mod->getViewTabsRender());
		$this->assign('elements', $mod->getElementsRender());
		$this->render($ret);
	}
}
