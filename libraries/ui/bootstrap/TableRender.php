<?php
/**
 * Trotri Ui
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace ui\bootstrap;

use tfc\mvc\Mvc;

/**
 * TableRender class file
 * 列表渲染类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TableRender.php 1 2013-05-18 14:58:59Z huan.song $
 * @package ui.bootstrap
 * @since 1.0
 */
class TableRender
{
	/**
	 * 获取美化版“是|否”选择项表单元素
	 * @param integer $id
	 * @param string $name
	 * @param string $value
	 * @param string $url
	 * @return string
	 */
	public function getSwitch($id, $name, $value = 'n', $url = '')
	{
		$attributes = array(
			'id'             => 'label_switch_' . $name . '_' . $id,
			'name'           => 'label_switch',
			'class'          => 'make-switch switch-small',
			'data-on-label'  => self::_('UI_BOOTSTRAP_YES'),
			'data-off-label' => self::_('UI_BOOTSTRAP_NO'),
		);

		$html = Mvc::getView()->getHtml();
		$ret = $html->tag('div', $attributes, $html->checkbox($name, $value, ($value === 'y')));
	}

	/**
	 * 获取Glyphicons图标按钮和工具提示
	 * @param string $type
	 * @param string $url
	 * @param string $func
	 * @param string $title
	 * @param string $placement
	 * @return string
	 */
	public static function getGlyphicon($type, $url, $func, $title, $placement = 'left')
	{
		$url = self::applyHttpReturn($url);
		$click = $func . '(\'' . $url . '\')';
		$attributes = array(
			'class'               => 'glyphicon glyphicon-' . $type,
			'data-toggle'         => 'tooltip',
			'data-placement'      => $placement,
			'data-original-title' => $title,
			'onclick'             => 'return ' . $click . ';'
		);

		return self::getHtml()->tag('span', $attributes, '');
	}
}
