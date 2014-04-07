<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\show;

use library\action\ViewAction;
use library\Model;

/**
 * FieldsView class file
 * 查询数据详情
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FieldsView.php 1 2014-04-05 00:37:20Z Code Generator $
 * @package modules.builder.action.show
 * @since 1.0
 */
class FieldsView extends ViewAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$mod = Model::getInstance('Fields');
		$builderId = $mod->getBuilderId();
		if ($builderId <= 0) {
			$this->err404();
		}

		$this->assign('builder_id', $builderId);
		$this->execute('Fields');
	}
}
