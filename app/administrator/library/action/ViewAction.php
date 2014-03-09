<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library\action;

use tfc\ap\Ap;
use library\action\base\ShowAction;
use library\Model;

/**
 * ViewAction abstract class file
 * ViewAction基类，用于查询数据详情
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ViewAction.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library.action
 * @since 1.0
 */
abstract class ViewAction extends ShowAction
{
	/**
	 * 执行操作：查询数据详情
	 * @param string $className
	 * @param string $moduleName
	 * @return void
	 */
	public function execute($className, $moduleName = '')
	{
		$ret = array();
		$req = Ap::getRequest();
		$mod = Model::getInstance($className, $moduleName);

		$ret = $mod->findByPk($this->getPk());

		$this->assign('tabs', $mod->getViewTabsRender());
		$this->assign('elements', $mod->getElementsRender());
		$this->render($ret);
	}

	/**
	 * 获取ID值
	 * @return integer
	 */
	public function getPk()
	{
		return Ap::getRequest()->getInteger('id');
	}
}
