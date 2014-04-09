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

use tfc\ap\Ap;
use library\action\base\SubmitAction;
use library\Model;

/**
 * AmcasSynch class file
 * 同步控制器
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: AmcasSynch.php 1 2014-04-06 14:43:08Z Code Generator $
 * @package modules.ucenter.action.submit
 * @since 1.0
 */
class AmcasSynch extends SubmitAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$id = Ap::getRequest()->getInteger('id');
		$mod = Model::getInstance('Amcas');
		$mod->synch($id);
	}
}
