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

use tfc\ap\ErrorException;
use tfc\mvc\form;
use ui\ElementCollections;
use ui\bootstrap\Components;

/**
 * FormBuilder class file
 * 表单处理类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FormBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package ui.bootstrap.widgets
 * @since 1.0
 */
class FormBuilder extends form\FormBuilder
{
	/**
	 * @var string 默认的分类标签
	 */
	const DEFAULT_TID = 'main';

	/**
	 * @var array 寄存表单属性
	 */
	public $attributes = array('class' => 'form-horizontal');

	/**
	 * @var array Input表单元素分类标签
	 */
	protected $_tabs = array(
		'main' => array('tid' => 'main', 'prompt' => 'Main', 'active' => true)
	);

	/**
	 * @var instance of ui\ElementCollections
	 */
	protected $_elementCollections = null;

	/**
	 * @var array 类型和Element关联表
	 */
	protected static $_typeObjectMap = array(
		'text'     => 'InputElement',
		'password' => 'InputElement',
		'file'     => 'InputElement',
		'button'   => 'ButtonElement',
		'hidden'   => 'HiddenElement',
		'checkbox' => 'ICheckboxElement',
		'radio'    => 'IRadioElement',
		'switch'   => 'SwitchElement',
		'textarea' => 'TextareaElement',
		'select'   => 'InputElement',
		'string'   => 'StringElement'
	);

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::_init()
	 */
	protected function _init()
	{
		$this->initElementCollections();
		$this->initAction();
		$this->initTabs();

		parent::_init();
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::run()
	 */
	public function run()
	{
		$this->assign('tabs', $this->getTabs());
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
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::getInputs()
	 */
	public function getInputs()
	{
		$output = array();
		$tabs = $this->getTabs();
		foreach ($tabs as $tid => $tab) {
			$output[$tid] = $this->getInputsByTid($tid);
		}

		return $output;
	}

	/**
	 * 获取所有Input表单元素分类标签
	 * @return array
	 */
	public function getTabs()
	{
		return $this->_tabs;
	}

	/**
	 * 设置多个Input表单元素分类标签
	 * @param array $tabs
	 * @return ui\bootstrap\widgets\FormBuilder
	 */
	public function setTabs(array $tabs = array())
	{
		foreach ($tabs as $tid => $tab) {
			$prompt = isset($tab['prompt']) ? $tab['prompt'] : '';
			$active = isset($tab['active']) ? $tab['active'] : false;
			$this->addTab($tid, $prompt, $active);
		}

		return $this;
	}

	/**
     * 清除所有的分类标签
     * @return ui\bootstrap\widgets\FormBuilder
     */
	public function clearTabs()
	{
		$this->_tabs = array();
		return $this;
	}

	/**
	 * 通过分类ID获取Input表单元素分类标签
	 * @param string $tid
	 * @return array
	 */
	public function getTabByTid($tid)
	{
		return $this->hasTab($tid) ? $this->_tabs[$tid] : null;
	}

	/**
	 * 添加或修改Input表单元素分类标签
	 * @param string $tid
	 * @param string $prompt
	 * @param boolean $active
	 * @return ui\bootstrap\widgets\FormBuilder
	 */
	public function addTab($tid, $prompt, $active = false)
	{
		if (($tid = trim($tid)) === '') {
			return $this;
		}

		$this->_tabs[$tid] = array(
			'tid' => $tid,
			'prompt' => $prompt,
			'active' => (boolean) $active
		);

		return $this;
	}

	/**
	 * 通过分类ID判断该表单元素分类标签是否已经存在
	 * @param string $tid
	 * @return boolean
	 */
	public function hasTab($tid)
	{
		return isset($this->_tabs[$tid]);
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
				$columnValue = $this->_elementCollections->getElement(ElementCollections::TYPE_FORM, $_tmpColumnName);
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

			if (!isset($columnValue['__tid__'])) {
				$elements[$columnName]['__tid__'] = self::DEFAULT_TID;
			}
		}

		parent::setElements($elements);
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::createElement()
	 */
	public function createElement($className, array $config = array())
	{
		if (strpos($className, '\\') === false) {
			$className = 'ui\\bootstrap\\form\\' . $className;
		}

		return parent::createElement($className, $config);
	}

	/**
	 * 初始化表单Action
	 * @return ui\bootstrap\widgets\FormBuilder
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
	 * 初始化分类标签
	 * @return ui\bootstrap\widgets\FormBuilder
	 */
	public function initTabs()
	{
		$this->_tabs['main']['prompt'] = Components::_('UI_BOOTSTRAP_VIEWTAB_MAIN_PROMPT');

		if (isset($this->_tplVars['tabs'])) {
			$this->setTabs($this->_tplVars['tabs']);
			unset($this->_tplVars['tabs']);
		}
		else {
			$tabs = $this->_elementCollections->getViewTabsRender();
			if (is_array($tabs)) {
				$this->setTabs($tabs);
			}
		}

		return $this;
	}

	/**
	 * 初始化表单元素集合类
	 * @return ui\bootstrap\widgets\FormBuilder
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
	 * @see tfc\mvc.Widget::getWidgetDirectory()
	 */
	public function getWidgetDirectory()
	{
		if ($this->_widgetDirectory === null) {
			$this->_widgetDirectory = dirname(__FILE__) . DS . 'views' . DS . 'formbuilder';
		}

		return $this->_widgetDirectory;
	}
}
