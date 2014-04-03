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

use library\action\CreateAction;
/**
 * BuildersCreate class file
 * 新增数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BuildersCreate.php 1 2014-04-03 17:53:20Z Code Generator $
 * @package modules.builder.action.submit
 * @since 1.0
 */
class BuildersCreate extends CreateAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$this->execute('Builders');
	}
}
