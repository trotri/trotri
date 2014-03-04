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

use tfc\mvc\form;
use tfc\saf\Text;

/**
 * FormBuilder class file
 * 表单处理类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FormBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package views.bootstrap.widgets
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
		// 初始化表单Action
		if (isset($this->_tplVars['action'])) {
			$this->action = $this->_tplVars['action'];
			unset($this->_tplVars['action']);
		}

		// 初始化分类标签
		$this->_tabs['main']['prompt'] = Text::_('CFG_SYSTEM_GLOBAL_VIEWTAB_MAIN_PROMPT');
		if (isset($this->_tplVars['tabs'])) {
			$this->setTabs($this->_tplVars['tabs']);
			unset($this->_tplVars['tabs']);
		}

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
	 * @return views\bootstrap\widgets\FormBuilder
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
	 * @return views\bootstrap\widgets\FormBuilder
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
	 * @return views\bootstrap\widgets\FormBuilder
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
	 * 初始化表单元素
	 * @return views\bootstrap\widgets\FormBuilder
	 */
	public function initElements()
	{
		$elements = isset($this->_tplVars['elements']) ? (array) $this->_tplVars['elements'] : array();
		if ($elements === array()) {
			return $this;
		}

		$columns = isset($this->_tplVars['columns']) ? (array) $this->_tplVars['columns'] : array();
		if ($columns === array()) {
			return $this;
		}

		foreach ($elements as $columnName => $element) {
			if (!in_array($columnName, $columns)) {
				unset($elements[$columnName]);
				continue;
			}

			if (!isset($element['__object__']) && isset($element['type'])) {
				$type = $element['type'];
				if (isset(self::$_typeObjectMap[$type])) {
					$elements[$columnName]['__object__'] = self::$_typeObjectMap[$type];
				}
			}

			if (!isset($element['__tid__'])) {
				$elements[$columnName]['__tid__'] = self::DEFAULT_TID;
			}

			if (isset($element['table'])) {
				unset($elements[$columnName]['table']);
			}

			if (isset($element['search'])) {
				unset($elements[$columnName]['search']);
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
			$className = 'views\\bootstrap\\components\\form\\' . $className;
		}

		return parent::createElement($className, $config);
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::getWidgetDirectory()
	 */
	public function getWidgetDirectory()
	{
		if ($this->_widgetDirectory === null) {
			$this->_widgetDirectory = dirname(__FILE__) . DS . 'formbuilder';
		}

		return $this->_widgetDirectory;
	}
}
