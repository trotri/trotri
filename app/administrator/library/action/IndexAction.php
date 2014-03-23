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
use library\ErrorNo;

/**
 * IndexAction abstract class file
 * IndexAction基类，用于查询列表数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: IndexAction.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library.action
 * @since 1.0
 */
abstract class IndexAction extends ShowAction
{
	/**
	 * 执行操作：查询列表
	 * @param string $className
	 * @param string $moduleName
	 * @return void
	 */
	public function execute($className, $moduleName = '')
	{
		$ret = array();

		$mod = Model::getInstance($className, $moduleName);

		$params = $this->getSearchParams();
		if (($order = $this->getOrder()) !== '') {
			$ret = $mod->search($params, $order);
		}
		else {
			$ret = $mod->search($params);
		}

		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->err404();
		}

		$this->setLastIndexUrl($ret['paginator']);		
		$this->assign('elements', $mod->getElementsRender());
		$this->render($ret);
	}

	/**
	 * 获取查询参数
	 * @return array
	 */
	public function getSearchParams()
	{
		$req = Ap::getRequest();
		$ret = array_merge($req->getQuery(), $req->getParams());
		return $ret;
	}

	/**
	 * 获取排序参数
	 * @return array
	 */
	public function getOrder()
	{
		return Ap::getRequest()->getTrim('order', '');
	}
}
