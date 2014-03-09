<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\show;

use library\action\ViewAction;

/**
 * BuilderView class file
 * 生成代码-查询数据详情
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BuilderView.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.action.show
 * @since 1.0
 */
class BuilderView extends ViewAction
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
