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

use library\action\base\RemoveAction;

/**
 * AmcasRemove class file
 * 删除数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: AmcasRemove.php 1 2014-04-06 14:43:08Z Code Generator $
 * @package modules.ucenter.action.submit
 * @since 1.0
 */
class AmcasRemove extends RemoveAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$this->execute('Amcas');
	}
}
