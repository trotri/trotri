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

use tfc\ap\Ap;
use library\action\base\SubmitAction;
use library\Model;

/**
 * BuildersGc class file
 * 通过Builders数据生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BuildersGc.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.action.submit
 * @since 1.0
 */
class BuildersGc extends SubmitAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$id = Ap::getRequest()->getInteger('id');
		$mod = Model::getInstance('Builders');
		$mod->gc($id);
	}
}
