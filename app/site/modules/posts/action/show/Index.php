<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\posts\action\show;

use library\ShowAction;
use tfc\ap\Ap;
use tfc\mvc\Mvc;
use libapp\Model;
use libapp\PageHelper;
use library\UrlHelper;

/**
 * Index class file
 * 文档列表页面
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Index.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.posts.action.show
 * @since 1.0
 */
class Index extends ShowAction
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		$req = Ap::getRequest();
		$viw = Mvc::getView();

		$catId = $req->getInteger('catid');
		if ($catId <= 0) {
			$this->err404();
		}

		$order = $req->getTrim('order', '');
		$dt = $req->getTrim('dt', '');
		$pageVar = PageHelper::getPageVar();
		$paged = PageHelper::getCurrPage();

		$category = Model::getInstance('Categories', 'posts')->findByPk($catId);
		if (!$category || !is_array($category)) {
			$this->err404();
		}

		$tplName = isset($category['tpl_list']) ? Mvc::$module . DS . $category['tpl_list'] : '';
		if ($tplName === '') {
			$this->err500();
		}

		$viw->assign('system_meta_title', isset($category['meta_title']) ? $category['meta_title'] : '');
		$viw->assign('system_meta_keywords', isset($category['meta_keywords']) ? $category['meta_keywords'] : '');
		$viw->assign('system_meta_description', isset($category['meta_description']) ? $category['meta_description'] : '');
		$viw->assign('url', UrlHelper::getInstance()->getPostIndex($category));

		$mod = Model::getInstance('Posts', 'posts');
		$ret = $mod->findListByCatId($catId, $dt, $order, $paged);

		$this->assign('category', $category);
		$this->render($ret, $tplName);
	}
}
