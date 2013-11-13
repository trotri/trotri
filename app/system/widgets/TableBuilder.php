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
	 * @var array 所有的列信息
	 */
	protected $_columns = null;

	/**
	 * @var instance of modules\module\helper
	 */
	protected $_helper = null;

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::run()
	 */
	public function run()
	{
		if (isset($this->_tplVars['checkedToggle'])) {
			$this->checkedToggle = trim($this->_tplVars['checkedToggle']);
		}

		if (isset($this->_tplVars['helper'])) {
			$this->_helper = $this->_tplVars['helper'];
		}

		if (!is_object($this->_helper)) {
			throw new ErrorException(sprintf(
				'Property "%s.%s" must be a object.', 'TableBuilder', '_helper'
			));
		}

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
	 */
	public function getTr($data)
	{
		$html = $this->getHtml();

		$output = $html->openTag('tr') . "\n";
		if ($this->checkedToggle !== '') {
			$output .= $html->tag('td', array(), $html->checkbox('checked_toggle', $this->checkedToggle . '[]')) . "\n";
		}

		$columns = $this->getColumns();

		foreach ($columns as $columnName => $columnValue) {
			if (isset($data[$columnName])) {
				$value = $data[$columnName];
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
		if ($this->checkedToggle !== '') {
			$output .= $html->tag('th', array(), $html->checkbox('checked_toggle', $this->checkedToggle . '[]')) . "\n";
		}

		$columns = $this->getColumns();
		foreach ($columns as $columnName => $columnValue) {
			$attributes = isset($columns['attributes']) ? (array) $columns['attributes'] : array();
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
	 * 获取所有的列信息
	 * @return array
	 * @throws ErrorException 如果列信息为空并且helper中没有获取列信息的方法，抛出异常
	 */
	public function getColumns()
	{
		if ($this->_columns !== null) {
			return $this->_columns;
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

		return $this->_columns;
	}
}
