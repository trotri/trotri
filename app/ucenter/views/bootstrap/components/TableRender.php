<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace views\bootstrap\components;

/**
 * TableRender class file
 * 表格渲染基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TableRender.php 1 2013-05-18 14:58:59Z huan.song $
 * @package views.bootstrap.components
 * @since 1.0
 */
class TableRender
{
	/**
	 * @var 模板解析类、业务类、URL管理类、页面辅助类、模型名、控制器名、方法名
	 */
	public
		$view,
		$srv,
		$urlManager,
		$html,
		$module,
		$controller,
		$action;

	/**
	 * 构造方法，初始化模板解析类、业务类、URL管理类、页面辅助类、模型名、控制器名、方法名
	 * @param unknown_type $view
	 */
	public function __construct($view)
	{
		$this->view = $view;
		if (isset($this->view->srv)) {
			$this->srv = $this->view->srv;
		}

		$this->urlManager = $this->view->getUrlManager();
		$this->html = $this->view->getHtml();
		$this->module = $this->view->module;
		$this->controller = $this->view->controller;
		$this->action = $this->view->action;
	}
}
