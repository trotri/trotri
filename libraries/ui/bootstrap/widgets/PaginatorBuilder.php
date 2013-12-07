<?php
/**
 * Trotri Ui
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace ui\bootstrap\widgets;

use ui\bootstrap\Components;

use tfc\mvc\Widget;
use tfc\ap\ErrorException;
use tfc\util\Paginator;
use tfc\saf\Cfg;

/**
 * PaginatorBuilder class file
 * 分页处理类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: PaginatorBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package ui.bootstrap.widgets
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
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::run()
	 */
	public function run()
	{
		$paginator = $this->getPaginator();
		if ($paginator === null) {
			return ;
		}

		$html = $this->getHtml();
		$disabledAttribute = array('class' => $this->disabledClassName);
		$activeAttribute = array('class' => $this->activeClassName);
		$prevPage = Components::_('UI_BOOTSTRAP_PAGE_PREV');
		$nextPage = Components::_('UI_BOOTSTRAP_PAGE_NEXT');
		$pages = $paginator->getPages();

		$link = $html->a($prevPage, $paginator->getUrl($pages['prev']));
		$prev = $html->tag('li', (($pages['curr'] <= 1) ? $disabledAttribute : array()), $link);

		$link = $html->a($nextPage, $paginator->getUrl($pages['next']));
		$next = $html->tag('li', (($pages['curr'] >= $pages['end']) ? $disabledAttribute : array()), $link);

		$lists = '';
		for ($pageNo = $pages['first']; $pageNo <= $pages['last']; $pageNo++) {
			$link = $html->a($pageNo, $paginator->getUrl($pageNo));
			$lists .= $html->tag('li', (($pageNo == $pages['curr']) ? $activeAttribute : array()), $link);
		}

		echo $html->tag('ul', array('class' => $this->className), $prev . $lists . $next);
		echo '<!-- /.pagination -->';
	}

	/**
	 * 获取分页处理类
	 * @return tfc\util\Paginator
	 */
	public function getPaginator()
	{
		$totalRows = isset($this->_tplVars['total_rows']) ? (int) $this->_tplVars['total_rows'] : 0;
		if ($totalRows <= 0) {
			return null;
		}

		$paginator = new Paginator($totalRows);
		try {
			$pageVar = Cfg::getApp('page_var', 'paginator');
			$paginator->setPageVar($pageVar);
		}
		catch (ErrorException $e) {}

		$listRows = isset($this->_tplVars['list_rows']) ? (int) $this->_tplVars['list_rows'] : 0;
		if ($listRows > 0) {
			$paginator->setListRows($listRows);
		}

		$currPage = isset($this->_tplVars['curr_page']) ? (int) $this->_tplVars['curr_page'] : 0;
		if ($currPage > 0) {
			$paginator->setCurrPage($currPage);
		}

		if (isset($this->_tplVars['url'])) {
			$paginator->setUrl($this->_tplVars['url']);
		}

		return $paginator;
	}
}
