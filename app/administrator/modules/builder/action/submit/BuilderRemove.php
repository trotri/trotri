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

use library\action\base\RemoveAction;
use tfc\ap\Ap;
use library\Model;

/**
 * BuilderRemove class file
 * 生成代码-删除数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BuilderRemove.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.action.submit
 * @since 1.0
 */
class BuilderRemove extends RemoveAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$ret = array();

		$req = Ap::getRequest();
		$mod = Model::getInstance('Builders', 'builder');

		$id = $req->getInteger('id');
		$ret = $mod->deleteByPk($id);
		$this->httpLastIndexUrl($ret);
	}
}
