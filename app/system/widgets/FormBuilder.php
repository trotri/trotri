<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace widgets;

use tfc\ap\ErrorException;
use tfc\mvc\form;

/**
 * FormBuilder class file
 * 表单处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FormBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package widgets
 * @since 1.0
 */
class FormBuilder extends form\FormBuilder
{
	/**
	 * @var array 寄存表单属性
	 */
	public $attributes = array('class' => 'form-horizontal');

	/**
	 * @var array Input表单元素分类标签
	 */
	protected $_tabs = array(
		'main' => array('tid' => 'main', 'prompt' => '主要信息', 'active' => true)
	);

	/**
	 * @var instance of modules\module\form
	 */
	protected $_form = null;

	/**
	 * @var array 类型和Element关联表
	 */
	protected static $_typeObjectMap = array(
		'text' => 'InputElement',
		'password' => 'InputElement',
		'file' => 'InputElement',
		'button' => 'ButtonElement',
		'hidden' => 'HiddenElement',
		'checkbox' => 'ICheckboxElement',
		'radio' => 'IRadioElement',
		'switch' => 'SwitchElement',
		'textarea' => 'TextareaElement',
	);

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::_init()
	 */
	protected function _init()
	{
		if (isset($this->_tplVars['form'])) {
			$this->_form = $this->_tplVars['form'];
		}

		if (!is_object($this->_form)) {
			throw new ErrorException(sprintf(
				'Property "%s.%s" must be a object.', 'FormBuilder', '_form'
			));
		}

		parent::_init();

		if (isset($this->_tplVars['tabs'])) {
			$this->setTabs($this->_tplVars['tabs']);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::run()
	 */
	public function run()
	{
		$this->assign('tabs', $this->getTabs());
		parent::run();
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
	 * @return widgets\FormBuilder
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
	 * @return widgets\FormBuilder
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
		static $formType = 1;

		foreach ($elements as $name => $element) {
			if (is_int($name) && is_string($element)) {
				$method = 'get' . str_replace('_', '', $element);
				if (!method_exists($this->_form, $method)) {
					throw new ErrorException(sprintf(
						'Method "%s.%s" was not exists.', get_class($this->_form), $method
					));
				}

				$elements[$name] = $this->_form->$method($formType);
				if (!isset($elements[$name]['name'])) {
					$elements[$name]['name'] = $element;
				}

				$element = $elements[$name];
			}

			if (!isset($element['__object__']) && isset($element['type'])) {
				$type = $element['type'];
				if (isset(self::$_typeObjectMap[$type])) {
					$elements[$name]['__object__'] = self::$_typeObjectMap[$type];
				}
			}

			if (!isset($element['__tid__'])) {
				$elements[$name]['__tid__'] = 'main';
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
		$className = 'library\\form\\' . $className;
		return parent::createElement($className, $config);
	}
}
