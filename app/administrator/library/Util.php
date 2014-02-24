<?php
/**
 * Trotri
 *
 * @author	Huan Song <trotri@yeah.net>
 * @link	  http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use tfc\ap\Ap;
use tfc\ap\ErrorException;
use tfc\util\Paginator;
use tfc\saf\Cfg;
use tfc\saf\Text;

/**
 * Util class file
 * 小工具集合类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Util.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Util
{
	/**
	 * 获取分页参数：当前开始查询行数
	 * @return string
	 */
	public static function getFirstRow()
	{
		$pageNo = self::getPageNo();
		$listRows = self::getListRows();
		$firstRow = ($pageNo - 1) * $listRows;
		return $firstRow;
	}

	/**
	 * 从$_GET或$_POST中获取分页参数：每页展示的行数
	 * @return string
	 */
	public static function getListRows()
	{
		$listRows = Ap::getRequest()->getInteger('limit');
		if ($listRows > 0) {
			return $listRows;
		}

		$listRows = (int) Cfg::getApp('list_rows', 'paginator');
		$listRows = max($listRows, 1);
		return $listRows;
	}

	/**
	 * 从$_GET或$_POST中获取分页参数：当前页码
	 * @return integer
	 */
	public static function getPageNo()
	{
		$pageVar = self::getPageVar();
		$pageNo = Ap::getRequest()->getInteger($pageVar);
		$pageNo = max($pageNo, 1);
		return $pageNo;
	}

	/**
	 * 获取分页参数：用于从$_GET或$_POST中取当前页的键名
	 * @return string
	 */
	public static function getPageVar()
	{
		try {
			$pageVar = Cfg::getApp('page_var', 'paginator');
		}
		catch (ErrorException $e) {
			$pageVar = Paginator::DEFAULT_PAGE_VAR;
		}

		return $pageVar;
	}
}
