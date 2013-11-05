<?php
/**
 * Trotri Base Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace widgets;

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
	 * @var array 表单元素分类标签
	 */
	protected $_tabs = array(
		array('tab_id' => 'main', 'prompt' => '主要信息', 'active' => true)
	);

	public function renderTab()
	{
		$output = '';
		$html = $this->getHtml();
		$tabs = $this->getTabs();
		foreach ($tabs as $tab) {
			$attributes = $tab['active'] ? array('class' => 'active') : array();
			$output .= $html->tag('li', $attributes, $html->a($tab['prompt'], '#' . $tab['tab_id'], array('data-toggle' => 'tab')));
		}

		return $output;
	}

	public function openInput($tabId = null)
	{
		if (($tab = $this->getTabById($tabId)) === null) {
			return '';
		}

		$className = 'tab-pane fade' . ($tab['active'] ? ' active in' : '');
		return $this->getHtml()->openTag('div', array('class' => $className, 'id' => $tabId));
	}

	public function closeInput()
	{
		return $this->getHtml()->closeTag('div');
	}
}
