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

use tfc\mvc\form;
use tfc\ap\Ap;
use tfc\ap\ErrorException;
use ui\ElementCollections;
use ui\bootstrap\Components;

/**
 * SearchBuilder class file
 * 查询表单处理类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SearchBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package ui.bootstrap.widgets
 * @since 1.0
 */
class SearchBuilder extends form\FormBuilder
{
	/**
	 * @var string 表单的提交方式
	 */
	public $method = 'get';

	/**
	 * @var instance of ui\ElementCollections
	 */
	protected $_elementCollections = null;

	/**
	 * @var array 类型和Element关联表
	 */
	protected static $_typeObjectMap = array(
		'text'     => 'ui\\bootstrap\\form\\SearchElement',
		'select'   => 'ui\\bootstrap\\form\\SearchElement',
		'hidden'   => 'ui\\bootstrap\\form\\HiddenElement',
	);

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::_init()
	 */
	protected function _init()
	{
		$this->initAction();
		$this->initElementCollections();

		parent::_init();
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::run()
	 */
	public function run()
	{
		parent::run();
		$this->displayJs();
	}

	/**
	 * 将JS内容输出到浏览器
	 * @return void
	 */
	public function displayJs()
	{
		$this->assign('id', $this->getId());
		$this->display($this->getJsName());
	}

	/**
	 * 初始化表单Action
	 * @return ui\bootstrap\widgets\SearchBuilder
	 */
	public function initAction()
	{
		if (isset($this->_tplVars['action'])) {
			$this->action = $this->_tplVars['action'];
			unset($this->_tplVars['action']);
		}

		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::initValues()
	 */
	public function initValues()
	{
		if (isset($this->_tplVars['values'])) {
			if (!is_array($this->_tplVars['values'])) {
				throw new ErrorException('FormBuilder TplVars.values invalid, values must be array.');
			}

			$this->values = $this->_tplVars['values'];
			unset($this->_tplVars['values']);
		}
		else {
			$this->values = Ap::getRequest()->getQuery();
		}

		return $this;
	}

	/**
	 * 初始化表单元素集合类
	 * @return ui\bootstrap\widgets\SearchBuilder
	 * @throws ErrorException 如果表单元素集合类不是对象或不是ui\ElementCollections子类，抛出异常
	 */
	public function initElementCollections()
	{
		if (isset($this->_tplVars['elementCollections'])) {
			$this->_elementCollections = $this->_tplVars['elementCollections'];
			unset($this->_tplVars['elementCollections']);
		}

		if (!is_object($this->_elementCollections)) {
			throw new ErrorException(sprintf(
				'Property "%s.%s" must be a object.', get_class($this), '_elementCollections'
			));
		}

		if (!$this->_elementCollections instanceof ElementCollections) {
			throw new ErrorException(sprintf(
				'Property "%s.%s" is not instanceof ui\ElementCollections.', get_class($this), '_elementCollections'
			));
		}

		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::setElements()
	 */
	public function setElements(array $elements = array())
	{
		foreach ($elements as $columnName => $columnValue) {
			if (is_int($columnName) && is_string($columnValue)) {
				$_tmpColumnName = $columnValue;
				$columnValue = $this->_elementCollections->getElement(ElementCollections::TYPE_SEARCH, $_tmpColumnName);
				if (!isset($columnValue['name'])) {
					$columnValue['name'] = $_tmpColumnName;
				}

				$elements[$columnName] = $columnValue;
			}

			if (!isset($columnValue['__object__']) && isset($columnValue['type'])) {
				$type = $columnValue['type'];
				if (isset(self::$_typeObjectMap[$type])) {
					$elements[$columnName]['__object__'] = self::$_typeObjectMap[$type];
				}
			}

			if (isset($columnValue['options']) && isset($columnValue['placeholder'])) {
				$elements[$columnName]['options'] = array("" => '--' . $columnValue['placeholder'] . '--') + $columnValue['options'];
			}
		}

		// 设置查询按钮
		$elements['button_search'] = array(
			'type' => 'button',
			'__object__' => 'ui\\bootstrap\\form\\ButtonElement',
			'label' => Components::_('UI_BOOTSTRAP_SEARCH'),
			'glyphicon' => 'search',
			'class' => 'btn btn-primary btn-block'
		);

		parent::setElements($elements);
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::getWidgetDirectory()
	 */
	public function getWidgetDirectory()
	{
		if ($this->_widgetDirectory === null) {
			$this->_widgetDirectory = dirname(__FILE__) . DS . 'views' . DS . 'searchbuilder';
		}

		return $this->_widgetDirectory;
	}
}
