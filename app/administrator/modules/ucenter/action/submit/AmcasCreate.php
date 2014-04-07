<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\action\submit;

use library\action\CreateAction;
use library\Model;

/**
 * AmcasCreate class file
 * 新增数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: AmcasCreate.php 1 2014-04-06 14:43:08Z Code Generator $
 * @package modules.ucenter.action.submit
 * @since 1.0
 */
class AmcasCreate extends CreateAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$mod = Model::getInstance('Amcas');

		$appId = $mod->getAmcaPid();
		if (!$mod->isAppById($appId)) {
			$this->err404();
		}

		$this->execute('Amcas');
	}
}
