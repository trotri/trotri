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

use library\action\ViewAction;

/**
 * UsersView class file
 * 查询数据详情
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UsersView.php 1 2014-04-15 14:43:50Z Code Generator $
 * @package modules.ucenter.action.show
 * @since 1.0
 */
class UsersView extends ViewAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$this->execute('Users');
	}
}
