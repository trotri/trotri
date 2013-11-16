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
use tfc\mvc\Widget;
use base\Helper;
use library\Constant;

/**
 * TableBuilder class file
 * 表格处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TableBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package widgets
 * @since 1.0
 */
class TableBuilder extends Widget
{
	/**
	 * @var array 寄存表格属性
	 */
	public $attributes = array('class' => 'table table-striped table-hover');

	/**
	 * @var string 表格首列全选按钮Value值，为空则不需要全选按钮
	 */
	public $checkedToggle = '';

	/**
	 * @var boolean 表格首列是否需要全选按钮
	 */
	protected $_hasCheckedToggle = false;

	/**
	 * @var array 所有的列信息
	 */
	protected $_columns = array();

	/**
	 * @var instance of base\helper
	 */
	protected $_helper = null;

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::run()
	 */
	public function run()
	{
		$this->initHelper();
		$this->initCheckedToggle();
		$this->initColumns();

		echo $this->getHtml()->openTag('table', $this->attributes) . "\n";
		echo $this->getThead();
		echo $this->getTbody();
		echo $this->getHtml()->closeTag('table') . "\n";
	}

	/**
	 * 获取Html表格元素：<tbody></tbody>
	 * @return string
	 */
	public function getTbody()
	{
		$html = $this->getHtml();

		$output = $html->openTag('tbody') . "\n";
		foreach ($this->_tplVars['data'] as $row) {
			$output .= $this->getTr($row);
		}

		$output .= $html->closeTag('tbody') . "\n";
		return $output;
	}

	/**
	 * 获取Html表格元素：<tr></tr>
	 * @param array $data
	 * @return string
	 * @throws ErrorException 如果表格首列需要全选按钮并且checkbox值不存在，抛出异常
	 */
	public function getTr($data)
	{
		$html = $this->getHtml();

		$output = $html->openTag('tr') . "\n";
		if ($this->_hasCheckedToggle) {
			if (!isset($data[$this->checkedToggle])) {
				throw new ErrorException(sprintf(
					'TableBuilder is unable to find the checked toggle value by key "%s".', $this->checkedToggle
				));
			}

			$output .= $html->tag('td', array(), $html->checkbox($this->checkedToggle . '[]', $data[$this->checkedToggle])) . "\n";
		}

		foreach ($this->_columns as $columnName => $columnValue) {
			if (isset($columnValue['callback'])) {
				$value = @call_user_func($columnValue['callback'], &$data);
			}
			elseif (isset($data[$columnName])) {
				$value = $data[$columnName];
			}
			else {
				$value = '';
			}

			$output .= $html->tag('td', array(), $value) . "\n";
		}

		$output .= $html->closeTag('tr') . "\n";
		return $output;
	}

	/**
	 * 获取Html表格元素：<thead></thead>
	 * @return string
	 */
	public function getThead()
	{
		$html = $this->getHtml();

		$output = $html->openTag('thead') . $html->openTag('tr') . "\n";
		if ($this->_hasCheckedToggle) {
			$output .= $html->tag('th', array(), $html->checkbox('checked_toggle', $this->checkedToggle . '[]')) . "\n";
		}

		foreach ($this->_columns as $columnName => $columnValue) {
			$attributes = isset($columnValue['attributes']) ? (array) $columnValue['attributes'] : array();
			$output .= $html->tag('th', $attributes, $columnValue['label']);
		}

		$output .= "\n" . $html->closeTag('tr') . $html->closeTag('thead') . "\n";
		return $output;
	}

	/**
	 * 获取Html表格元素：<tfoot></tfoot>
	 * @return string
	 */
	public function getTfoot()
	{
		
	}

	/**
	 * 初始化所有的列信息
	 * @return widgets\TableBuilder
	 * @throws ErrorException 如果模板参数columns不存在或不是数组，抛出异常
	 * @throws ErrorException 如果列信息为空并且helper中没有获取列信息的方法，抛出异常
	 */
	public function initColumns()
	{
		if (!isset($this->_tplVars['columns'])) {
			throw new ErrorException('TableBuilder TplVars.columns was not defined.');
		}

		if (!is_array($this->_tplVars['columns'])) {
			throw new ErrorException('TableBuilder TplVars.columns invalid, columns must be array.');
		}

		$this->_columns = array();
		foreach ($this->_tplVars['columns'] as $columnName => $columnValue) {
			if (is_int($columnName) && is_string($columnValue)) {
				$method = 'get' . str_replace('_', '', $columnValue);
				if (!method_exists($this->_helper, $method)) {
					throw new ErrorException(sprintf(
						'Method "%s.%s" was not exists.', get_class($this->_helper), $method
					));
				}

				$columnName = $columnValue;
				$columnValue = $this->_helper->$method(Constant::M_H_TYPE_TABLE);
			}

			if (isset($columnValue['name'])) {
				$columnName = $columnValue['name'];
			}

			if (!isset($columnValue['label'])) {
				$columnValue['label'] = '';
			}

			$this->_columns[$columnName] = $columnValue;
		}

		return $this;
	}

	/**
	 * 初始化表格首列全选按钮
	 * @return widgets\TableBuilder
	 */
	public function initCheckedToggle()
	{
		if (isset($this->_tplVars['checkedToggle'])) {
			$this->checkedToggle = trim($this->_tplVars['checkedToggle']);
			unset($this->_tplVars['checkedToggle']);
		}

		if ($this->checkedToggle !== '') {
			$this->_hasCheckedToggle = true;
		}

		return $this;
	}

	/**
	 * 初始化业务辅助类
	 * @return widgets\TableBuilder
	 * @throws ErrorException 如果类的属性"_helper"不是对象，抛出异常
	 */
	public function initHelper()
	{
		if (isset($this->_tplVars['helper'])) {
			$this->_helper = $this->_tplVars['helper'];
			unset($this->_tplVars['helper']);
		}

		if (!is_object($this->_helper)) {
			throw new ErrorException(sprintf(
				'Property "%s.%s" must be a object.', get_class($this), '_helper'
			));
		}

		if (!$this->_helper instanceof Helper) {
			throw new ErrorException(sprintf(
				'Property "%s.%s" is not instanceof base\Helper.', get_class($this), '_helper'
			));
		}

		return $this;
	}
}
