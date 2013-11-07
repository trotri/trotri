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

use tfc\mvc\Widget;

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
	 * @var boolean 表格首列是否需要全选按钮
	 */
	public $checkedToggle = true;

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::run()
	 */
	public function run()
	{
		
	}
	
	/**
	 * 获取Html表格元素：<tbody></tbody>
	 * @return string
	 */
	public function getTbody()
	{
		
	}
	
	/**
	 * 获取Html表格元素：<tr></tr>
	 * @param array $data
	 * @return string
	 */
	public function getTr($data)
	{
		
	}
	
	/**
	 * 获取Html表格元素：<thead></thead>
	 * @return string
	 */
	public function getThead()
	{
		$html = "<thead><tr>\n";
		foreach ($this->_tplVars['columns'] as $columnName => $columns) {
			if (is_int($columnName) && is_string($columns)) {
				$columnName = $columns;
				$columns = array();
			}

			if (isset($columns['name'])) {
				$columnName = $columns['name'];
			}

			$label = isset($columns['label']) ? $columns['label'] : '';
			if ($label === '' && isset($this->_attributes[$columnName]['label'])) {
				$label = $this->_attributes[$columnName]['label'];
			}
				
			$attributes = isset($columns['attributes']) ? (array) $columns['attributes'] : array();
			$html .= $this->getHtml()->tag('td', $attributes, $label);
		}

		$html .= "\n</tr></thead>\n";
		return $html;
	}
	
	/**
	 * 获取Html表格元素：<tfoot></tfoot>
	 * @return string
	 */
	public function getTfoot()
	{
		
	}
}
