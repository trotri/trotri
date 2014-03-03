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
use tfc\util\Paginator;
use tfc\saf\Cfg;
use views\ComponentsBuilder;

/**
 * PageHelper class file
 * 页面辅助类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: PageHelper.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class PageHelper
{
	/**
	 * @var views\ComponentsBuilder 创建页面小组件类，用于创建按钮、图标等
	 */
	protected static $_componentsBuilder;

	/**
	 * 获取创建页面小组件类，用于创建按钮、图标等
	 * @return views\ComponentsBuilder
	 */
	public static function getComponentsBuilder()
	{
		if (self::$_componentsBuilder === null) {
			$skinName = Mvc::getView()->skinName;
			$componentsBuilder = 'views\\bootstrap\\components\\Builder';
			if (!class_exists($componentsBuilder)) {
				throw new ErrorException(sprintf(
					'PageHelper is unable to find the requested components builder "%s".', $componentsBuilder
				));
			}

			$instance = new $componentsBuilder();
			if (!$instance instanceof ComponentsBuilder) {
				throw new ErrorException(sprintf(
					'PageHelper Class "%s" is not instanceof views\ComponentsBuilder.', $componentsBuilder
				));
			}

			self::$_componentsBuilder = $instance;
		}

		return self::$_componentsBuilder;
	}

	/**
	 * 获取上一个页面链接
	 * @return string
	 */
	public static function getHttpReferer()
	{
		$referer = Ap::getRequest()->getTrim('http_referer');
		if ($referer !== '') {
			return $referer;
		}

		return Ap::getRequest()->getServer('HTTP_REFERER');
	}

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
	 * 在URL后拼接“最后一次访问的列表页链接”
	 * @param string $url
	 * @return string
	 */
	public static function applyLastIndexUrl($url)
	{
		if (($lastIndexUrl = self::getLastIndexUrl()) !== '') {
			$url = Mvc::getView()->getUrlManager()->applyParams($url, array('last_index_url' => $lastIndexUrl));
		}

		return $url;
	}

	/**
	 * 通过Service查询后的分页信息，设置最后一次访问的列表页链接
	 * <pre>
	 * 参数格式：
	 * $params = array(
	 *     'attributes' => array(),
	 *     'order' => '',
	 *     'limit' => 0,
	 *     'offset' => 0,
	 *     'total' => 0
	 * );
	 * </pre>
	 * @param array $params
	 * @return void
	 */
	public static function setLastIndexUrlBySrv(array $params = array())
	{
		$attributes = isset($params['attributes']) ? (array) $params['attributes'] : array();
		$order      = isset($params['order']) ? trim($params['order']) : '';
		$limit      = isset($params['limit']) ? (int) $params['limit'] : 0;
		$offset     = isset($params['offset']) ? (int) $params['offset'] : 0;

		if ($order !== '') {
			$attributes['order'] = $order;
		}

		if ($limit > 0) {
			if ($limit !== (int) Cfg::getApp('list_rows', 'paginator')) {
				$attributes[self::getListRowsVar()] = $limit;
			}

			$offset = max($offset, 0);
			$attributes[self::getPageVar()] = floor($offset / $limit) + 1;
		}

		self::setLastIndexUrl($attributes);
	}

	/**
	 * 获取分页参数：当前开始查询的行数
	 * @return integer
	 */
	public static function getFirstRow()
	{
		$firstRow = (self::getCurrPage() - 1) * self::getListRows();
		$firstRow = max($firstRow, 0);
		return $firstRow;
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
	 * 获取从$_GET或$_POST中获取每页展示的行数的键名
	 * @return string
	 */
	public static function getListRowsVar()
	{
		try {
			$listRowsVar = Cfg::getApp('list_rows_var', 'paginator');
		}
		catch (ErrorException $e) {
			$listRowsVar = 'limit';
		}

		return $listRowsVar;
	}

	/**
	 * 获取当前页码
	 * @return integer
	 */
	public static function getCurrPage()
	{
		$pageVar = self::getPageVar();
		$currPage = Ap::getRequest()->getInteger($pageVar);
		$currPage = max($currPage, 1);
		return $currPage;
	}

	/**
	 * 获取从$_GET或$_POST中获取当前页的键名
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
