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

use app\Elements;

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
	 * @var app\Elements 表单元素管理类
	 */
	public $elements_object = null;

	/**
	 * @var 业务处理类、模板解析类、URL管理类、页面辅助类、模型名、控制器名、方法名、列表页方法名
	 */
	public
		$srv,
		$view,
		$urlManager,
		$html,
		$module,
		$controller,
		$action;

	/**
	 * 构造方法，初始化表单元素管理类、业务处理类、模板解析类、URL管理类、页面辅助类、模型名、控制器名、方法名
	 * @param app\Elements $elements
	 */
	public function __construct(Elements $elements)
	{
		$this->elements_object = $elements;

		$this->srv = $this->elements_object->srv;
		$this->view = $this->elements_object->view;
		$this->urlManager = $this->elements_object->urlManager;
		$this->html = $this->elements_object->html;
		$this->module = $this->elements_object->module;
		$this->controller = $this->elements_object->controller;
		$this->action = $this->elements_object->action;
	}
}
