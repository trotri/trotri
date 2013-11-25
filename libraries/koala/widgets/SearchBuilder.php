<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace koala\widgets;

use tfc\mvc\form;
use tfc\ap\Ap;
use tfc\ap\ErrorException;

/**
 * SearchBuilder class file
 * 查询表单处理类，基于Bootstrap-CSS框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SearchBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package koala.widgets
 * @since 1.0
 */
class SearchBuilder extends form\FormBuilder
{
	/**
	 * @var string 表单的提交方式
	 */
	public $method = 'get';

	/**
	 * @var instance of koala\widgets\ElementCollections
	 */
	protected $_elementCollections = null;

	/**
	 * @var array 类型和Element关联表
	 */
	protected static $_typeObjectMap = array(
		'text'     => 'koala\\form\\SearchElement',
		'select'   => 'koala\\form\\SearchElement',
		'submit'   => 'koala\\form\\ButtonElement',
	);

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::_init()
	 */
	protected function _init()
	{
		$this->initElementCollections();
		$this->initAction();

		parent::_init();
	}

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.FormBuilder::run()
	 */
	public function run()
	{
		echo $this->openWrap(),
			 $this->openForm(), "\n",
			 $this->getButtons(),
			 $this->getHr(),
			 $this->getInputs(),
			 $this->getButtons(),
			 $this->closeForm(),
			 $this->closeWrap();
	}

	/**
	 * 获取表单元素最外层HTML开始标签
	 * @return string
	 */
	public function openWrap()
	{
		return $this->getHtml()->openTag('div', array('class' => 'list-group')) . "\n";
	}

	/**
	 * 获取表单元素最外层HTML结束标签
	 * @return string
	 */
	public function closeWrap()
	{
		return "\n" . $this->getHtml()->closeTag('div');
	}

	/**
	 * 初始化表单Action
	 * @return koala\widgets\SearchBuilder
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
				throw new ErrorException('SearchBuilder TplVars.values invalid, values must be array.');
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
	 * @return koala\widgets\SearchBuilder
	 * @throws ErrorException 如果表单元素集合类不是对象或不是ElementCollections子类，抛出异常
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
				'Property "%s.%s" is not instanceof koala\widgets\ElementCollections.', get_class($this), '_elementCollections'
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

			if (isset($columnValue['label'])) {
				if (isset($columnValue['options'])) {
					$elements[$columnName]['options'][""] = '--' . $columnValue['label'] . '--';
				}
				else {
					$elements[$columnName]['placeholder'] = $columnValue['label'];
				}
			}
		}

		parent::setElements($elements);
	}

	/**
	 * 获取分隔线
	 * @return string
	 */
	public function getHr()
	{
		return $this->getHtml()->tag('hr', array('class' => 'hr-condensed')) . "\n";
	}
}
