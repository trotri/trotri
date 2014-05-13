<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\user\action\amcas;

use library\actions;
use tfc\ap\Ap;
use app\ErrorNo;
use modules\user\service\Amcas;

/**
 * Index class file
 * 查询数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Index.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.user.action.amcas
 * @since 1.0
 */
class Index extends actions\Show
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$req = Ap::getRequest();
		$srv = new Amcas();

		$apps = $srv->findAppPrompts();
		if ($apps === array()) {
			$this->err404();
		}

		$appId = $req->getInteger('app_id');
		if ($appId === 0) {
			$row = array_keys(array_slice($apps, 0, 1, true));
			$appId = array_shift($row);
		}

		if (!isset($apps[$appId])) {
			$this->err404();
		}

		$prompt = $apps[$appId];
		unset($apps[$appId]);
		$apps = array($appId => $prompt) + $apps;

		$ret = $srv->findModCtrls($appId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->err404();
		}

		$srv->setLLU(array('app_id' => $appId));

		$this->assign('elements', $srv);
		$this->assign('app_id', $appId);
		$this->assign('apps', $apps);
		$this->render($ret);
	}
}
