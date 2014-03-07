<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\submit;

use library\action\CreateAction;
use tfc\ap\Ap;
use tfc\mvc\Mvc;
use library\Model;
use library\ErrorNo;

/**
 * BuilderCreate class file
 * 生成代码-新增数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BuilderCreate.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.action.submit
 * @since 1.0
 */
class BuilderCreate extends CreateAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = Model::getInstance('Builders');
		if ($this->isPost()) {
			$ret = $mod->create($req->getPost());
			if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
				if ($this->isSubmitTypeSave()) {
					$this->forward('modify', Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($this->isSubmitTypeSaveNew()) {
					$this->forward('create', Mvc::$controller, Mvc::$module, $ret);
				}
				elseif ($this->isSubmitTypeSaveClose()) {
					$this->forward('index', Mvc::$controller, Mvc::$module, $ret);
				}
			}
		}

		$this->assign('tabs', $mod->getViewTabsRender());
		$this->assign('elements', $mod->getElementsRender());
		$this->render($ret);
	}
}
