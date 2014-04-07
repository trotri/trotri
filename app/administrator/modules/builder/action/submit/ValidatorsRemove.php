<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\submit;

use library\action\base\RemoveAction;

/**
 * ValidatorsRemove class file
 * 删除数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ValidatorsRemove.php 1 2014-04-05 22:11:12Z Code Generator $
 * @package modules.builder.action.submit
 * @since 1.0
 */
class ValidatorsRemove extends RemoveAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$this->execute('Validators');
	}
}
