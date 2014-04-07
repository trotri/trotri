<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\action\show;

use tfc\ap\Ap;
use library\action\IndexAction;
use library\Model;
use library\ErrorNo;

/**
 * AmcasIndex class file
 * 查询数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: AmcasIndex.php 1 2014-04-06 14:43:07Z Code Generator $
 * @package modules.ucenter.action.show
 * @since 1.0
 */
class AmcasIndex extends IndexAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$req = Ap::getRequest();
		$mod = Model::getInstance('Amcas');

		$apps = $mod->getData()->getAppEnum();
		$appId = $mod->getAmcaPid();

		if (!isset($apps[$appId])) {
			$this->err404();
		}

		$prompt = $apps[$appId];
		unset($apps[$appId]);
		$apps = array($appId => $prompt) + $apps;

		$ret = $mod->findModCtrls($appId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->err404();
		}

		$this->assign('app_id', $appId);
		$this->assign('apps', $apps);
		$this->assign('elements', $mod->getElementsRender());
		$this->render($ret);
	}
}
