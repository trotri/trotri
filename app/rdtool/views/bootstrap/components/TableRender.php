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
	 * @var 模板解析类、URL管理类、页面辅助类、模型名、控制器名、方法名、缺省的列表页方法名、缺省的详情页方法名、缺省的新增数据方法名、缺省的编辑数据方法名
	 */
	public
		$view,
		$urlManager,
		$html,
		$module,
		$controller,
		$action,
		$actNameList,
		$actNameView,
		$actNameCreate,
		$actNameModify;

	/**
	 * 构造方法，初始化模板解析类、URL管理类、页面辅助类、模型名、控制器名、方法名、缺省的列表页方法名、缺省的详情页方法名、缺省的新增数据方法名、缺省的编辑数据方法名
	 * @param app\Elements $elements
	 */
	public function __construct(Elements $elements)
	{
		$this->elements_object = $elements;

		$this->view = $this->elements_object->view;
		$this->urlManager = $this->elements_object->urlManager;
		$this->html = $this->elements_object->html;
		$this->module = $this->elements_object->module;
		$this->controller = $this->elements_object->controller;
		$this->action = $this->elements_object->action;
		$this->actNameList = $this->elements_object->actNameList;
		$this->actNameView = $this->elements_object->actNameView;
		$this->actNameCreate = $this->elements_object->actNameCreate;
		$this->actNameModify = $this->elements_object->actNameModify;
	}
}
