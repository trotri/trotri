<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library\actions;

use library\ShowAction;
use tfc\ap\Ap;
use libapp\Service;
use libapp\PageHelper;
use library\ErrorNo;

/**
 * Index abstract class file
 * Index基类，展示列表数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Index.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library.actions
 * @since 1.0
 */
abstract class Index extends ShowAction
{
	/**
	 * 执行操作：查询数据列表
	 * @param string $className
	 * @param string $moduleName
	 * @return void
	 */
	public function execute($className, $moduleName = '')
	{
		$ret = array();

		$srv = Service::getInstance($className, $moduleName);

		$params = $this->getSearchParams();
		$order = $this->getOrder();
		$limit = PageHelper::getFirstRow();
		$offset = PageHelper::getListRows();

		$ret = $srv->search($params, $order, $limit, $offset);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->err404();
		}

		$srv->setLLU($ret['paginator']);
		$this->assign('elements', $srv);
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
