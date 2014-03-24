<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\submit;

use library\action\ModifyAction;
use library\Model;

/**
 * FieldsModify class file
 * 编辑数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FieldsModify.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.action.submit
 * @since 1.0
 */
class FieldsModify extends ModifyAction
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
