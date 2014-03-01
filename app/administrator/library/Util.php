<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use tfc\ap\Ap;
use tfc\ap\ErrorException;
use tfc\mvc\Mvc;
use tfc\saf\Cfg;

/**
 * Util class file
 * 小工具包集合类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Util.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Util
{
	/**
	 * 获取最后一次访问的列表页链接
	 * @return string
	 */
	public static function getLastIndexUrl()
	{
		return Ap::getRequest()->getTrim('last_index_url');
	}

	/**
	 * 设置最后一次访问的列表页链接
	 * @param array $params
	 * @return void
	 */
	public static function setLastIndexUrl(array $params = array())
	{
		$url = Mvc::getView()->getUrlManager()->getUrl(Mvc::$action, Mvc::$controller, Mvc::$module, $params);
		Ap::getRequest()->setParam('last_index_url', $url);
	}

	/**
	 * 获取分页参数：当前开始查询的行数
	 * @return integer
	 */
	public static function getFirstRow()
	{
		$firstRowVar = self::getFirstRowVar();
		$firstRow = Ap::getRequest()->getInteger($firstRowVar);
		if ($firstRow > 0) {
			return $firstRow;
		}

		return 0;
	}

	/**
	 * 获取分页参数：每页展示的行数
	 * @return integer
	 */
	public static function getListRows()
	{
		$listRowsVar = self::getListRowsVar();
		$listRows = Ap::getRequest()->getInteger($listRowsVar);
		if ($listRows > 0) {
			return $listRows;
		}

		$listRows = (int) Cfg::getApp('list_rows', 'paginator');
		$listRows = max($listRows, 1);
		return $listRows;
	}

	/**
	 * 获取从$_GET或$_POST中获取当前开始查询的行数的键名
	 * @return string
	 */
	public static function getFirstRowVar()
	{
		try {
			$firstRowVar = Cfg::getApp('first_row_var', 'paginator');
		}
		catch (ErrorException $e) {
			$firstRowVar = 'offset';
		}

		return $firstRowVar;
	}

	/**
	 * 获取从$_GET或$_POST中获取每页展示的行数的键名
	 * @return string
	 */
	public static function getListRowsVar()
	{
		try {
			$listRowsVar = Cfg::getApp('page_var', 'paginator');
		}
		catch (ErrorException $e) {
			$listRowsVar = 'limit';
		}

		return $listRowsVar;
	}
}
