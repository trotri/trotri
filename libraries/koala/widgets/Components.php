<?php
/**
 * Trotri Koala
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace koala\widgets;

use tfc\ap\Singleton;

/**
 * Components class file
 * 页面小组件类，基于Bootstrap-CSS框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Components.php 1 2013-05-18 14:58:59Z huan.song $
 * @package koala.widgets
 * @since 1.0
 */
class Components
{
	/**
	 * @var string Glyphicons图标：列表按钮
	 */
	const GLYPHICON_INDEX = 'list';

	/**
	 * @var string Glyphicons图标：加号按钮
	 */
	const GLYPHICON_CREATE = 'plus-sign';

	/**
	 * @var string Glyphicons图标：编辑铅笔按钮
	 */
	const GLYPHICON_PENCIL = 'pencil';

	/**
	 * @var string Glyphicons图标：回收站按钮
	 */
	const GLYPHICON_TRASH = 'trash';

	/**
	 * @var string Glyphicons图标：彻底删除
	 */
	const GLYPHICON_REMOVE = 'remove-sign';

	/**
	 * @var instance of tfc\mvc\Html
	 */
	protected static $_html = null;

	/**
	 * 获取美化版“是|否”选择项表单元素
	 * @param integer $id
	 * @param string $name
	 * @param string $value
	 * @return string
	 */
	public static function getSwitch($id, $name, $value = 'n')
	{
		$attributes = array(
			'id'             => 'label_switch_' . $name . '_' . $id,
			'name'           => 'label_switch',
			'class'          => 'make-switch switch-small',
			'data-on-label'  => '是',
			'data-off-label' => '否',
		);

		$html = self::getHtml();
		return $html->tag('div', $attributes, $html->checkbox($name, $value, ($value === 'y')));
	}

	/**
	 * 获取Glyphicons图标按钮和工具提示
	 * @param string $type
	 * @param string $onclick
	 * @param string $title
	 * @param string $placement
	 * @return string
	 */
	public static function getGlyphicon($type, $onclick, $title, $placement = 'left')
	{
		$attributes = array(
			'class'               => 'glyphicon glyphicon-' . $type,
			'data-toggle'         => 'tooltip',
			'data-placement'      => $placement,
			'data-original-title' => $title,
			'onclick'             => 'return ' . $onclick . ';'
		);

		return self::getHtml()->tag('span', $attributes, '');
	}

	/**
	 * 获取页面辅助类
	 * @return tfc\mvc\Html
	 */
	public static function getHtml()
	{
		if (self::$_html === null) {
			self::$_html = Singleton::getInstance('tfc\\mvc\\Html');
		}

		return self::$_html;
	}
}
