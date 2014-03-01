<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace views\bootstrap\widgets;

use tfc\mvc\Widget;
use tfc\mvc\Mvc;
use tfc\saf\Cfg;
use tfc\saf\Text;
use library\Util;

/**
 * PaginatorBuilder class file
 * 分页处理类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: PaginatorBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package views.bootstrap.widgets
 * @since 1.0
 */
class PaginatorBuilder extends Widget
{
	/**
	 * @var string 样式名
	 */
	public $className = 'pagination';

	/**
	 * @var string 被禁用按钮的样式名
	 */
	public $disabledClassName = 'disabled';

	/**
	 * @var string 当前页按钮的样式名
	 */
	public $activeClassName = 'active';

	/**
	 * @var tfc\mvc\UrlManager URL管理类
	 */
	protected $_urlManager = null;

	/**
	 * @var string 链接地址的前半部分，拼接上“当前开始查询的行数”就是完整的链接
	 */
	protected $_preUrl = '';

	/**
	 * @var string 从$_GET或$_POST中获取当前开始查询的行数的键名
	 */
	protected $_firstRowVar = '';

	/**
	 * @var integer 每页展示的页码数
	 */
	protected $_listPages = 0;

	/**
	 * @var integer 每页展示的行数
	 */
	protected $_listRows = 0;

	/**
	 * @var integer 当前开始查询的行数
	 */
	protected $_firstRow = 0;

	/**
	 * @var integer 总页码数
	 */
	protected $_totalPages = 0;

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::run()
	 */
	public function run()
	{
		$totalRows = isset($this->_tplVars['total']) ? (int) $this->_tplVars['total'] : 0; // 总的记录数
		if ($totalRows <= 0) {
			return null;
		}

		$this->_urlManager  = $this->getUrlManager();              // URL管理类
		$this->_firstRowVar = Util::getFirstRowVar();              // 从$_GET或$_POST中获取当前开始查询的行数的键名
		$this->_listPages   = $this->getListPages();               // 每页展示的页码数
		$this->_listRows    = $this->getListRows();                // 每页展示的行数
		$this->_firstRow    = $this->getFirstRow();                // 当前开始查询的行数
		$this->_totalPages  = ceil($totalRows / $this->_listRows); // 总页码数

		$attributes = $this->getAttributes(); // Request参数
		if ($this->_listRows !== (int) Cfg::getApp('list_rows', 'paginator')) {
			$listRowsVar = Util::getListRowsVar(); // 从$_GET或$_POST中获取每页展示的行数的键名
			$attributes[$listRowsVar] = $this->_listRows;
		}

		$this->_preUrl = $this->_urlManager->getUrl(Mvc::$action, Mvc::$controller, Mvc::$module, $attributes); // 链接地址的前半部分，拼接上“当前开始查询的行数”就是完整的链接

		$html = $this->getHtml();
		$disabledAttribute = array('class' => $this->disabledClassName);
		$activeAttribute = array('class' => $this->activeClassName);
		$prevPageLabel = Text::_('CFG_SYSTEM_GLOBAL_PAGE_PREV');
		$nextPageLabel = Text::_('CFG_SYSTEM_GLOBAL_PAGE_NEXT');

		$currPage  = floor($this->_firstRow / $this->_listRows) + 1;    // 当前页码
		$currPage  = min($currPage, $this->_totalPages);
		$endPage   = $this->_totalPages;                                // 最后一页
		$prevPage  = ($currPage > 1) ? $currPage - 1 : 1;               // 上一页
		$nextPage  = ($currPage < $endPage) ? $currPage + 1 : $endPage; // 下一页
		$firstPage = ceil($currPage - $this->_listPages / 2);           // 当前分页列表的第一页
		$firstPage = max($firstPage, 1);
		$lastPage  = $firstPage + $this->_listPages;                    // 当前分页列表的最后一页
		$lastPage  = min($lastPage, $endPage);
		$firstPage = $lastPage - $this->_listPages;
		$firstPage = max($firstPage, 1);

		$prevLink  = $html->a($prevPageLabel, $this->getUrlByPageNo($prevPage));
		$nextLink  = $html->a($nextPageLabel, $this->getUrlByPageNo($nextLink));

		$prevElement = $html->tag('li', (($currPage <= 1) ? $disabledAttribute : array()), $prevLink);
		$nextElement = $html->tag('li', (($currPage >= $endPage) ? $disabledAttribute : array()), $nextLink);

		$listElements = '';
		for ($pageNo = $firstPage; $pageNo <= $lastPage; $pageNo++) {
			$listElements .= $html->tag('li', (($pageNo === $currPage) ? $activeAttribute : array()), $html->a($pageNo, $this->getUrlByPageNo($pageNo)));
		}

		echo $html->tag('ul', array('class' => $this->className), $prevElement . $listElements . $nextElement);
		echo '<!-- /.pagination -->';
	}

	/**
	 * 通过页码获取当前页的URL
	 * @param integer $pageNo
	 * @return string
	 */
	public function getUrlByPageNo($pageNo)
	{
		return $this->_urlManager->applyParams($this->_preUrl, array($this->_firstRowVar => $this->getFirstRowByPageNo($pageNo)));
	}

	/**
	 * 通过页码获取当前开始查询的行数
	 * @param integer $pageNo
	 * @return integer
	 */
	public function getFirstRowByPageNo($pageNo)
	{
		return ($pageNo - 1) * $this->_listRows;
	}

	/**
	 * 获取分页参数：Request参数
	 * @return array
	 */
	public function getAttributes()
	{
		$attributes = isset($this->_tplVars['attributes']) ? (array) $this->_tplVars['attributes'] : array();
		$order = isset($this->_tplVars['order']) ? trim($this->_tplVars['order']) : '';
		if ($order !== '') {
			$attributes['order'] = $attributes;
		}

		return $attributes;
	}

	/**
	 * 获取分页参数：每页展示的页码数
	 * @return integer
	 */
	public function getListPages()
	{
		$listPages = (int) Cfg::getApp('list_pages', 'paginator');
		$listPages = max($listPages, 1);
		return $listPages;
	}

	/**
	 * 获取分页参数：当前开始查询的行数
	 * @return integer
	 */
	public static function getFirstRow()
	{
		$firstRow = isset($this->_tplVars['offset']) ? (int) $this->_tplVars['offset'] : 0;
		if ($firstRow > 0) {
			return $firstRow;
		}

		return 0;
	}

	/**
	 * 获取分页参数：每页展示的行数
	 * @return integer
	 */
	public function getListRows()
	{
		$listRows = isset($this->_tplVars['limit']) ? (int) $this->_tplVars['limit'] : 0;
		if ($listRows > 0) {
			return $listRows;
		}

		$listRows = (int) Cfg::getApp('list_rows', 'paginator');
		$listRows = max($listRows, 1);
		return $listRows;
	}
}
