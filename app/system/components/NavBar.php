<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace components;

use tfc\mvc\Widget;
use tfc\mvc\Mvc;
use tfc\saf\Cfg;
use tfc\saf\Text;

/**
 * NavBar class file
 * 页面顶端导航
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: NavBar.php 1 2013-04-20 17:11:06Z huan.song $
 * @package components
 * @since 1.0
 */
class NavBar extends Widget
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::run()
	 */
	public function run()
	{
		$output = '';

		$html = $this->getHtml();
		$urls = Cfg::getApp('navbar', 'urls');
		foreach ($urls as $menus) {
			$main = array_shift($menus);
			if (!is_array($main)) {
				continue;
			}

			// 主菜单
			if (!$menus) {
				$output .= $html->tag('li', $this->getAttributes($main, false), $this->a($main)) . "\n";
				continue;
			}

			// 主菜单外开始标签
			$output .= $html->openTag('li', $this->getAttributes($main, true)) . "\n";
			$output .= $this->a($main, true) . "\n";

			// 下拉子菜单外开始标签
			$output .= $html->openTag('ul', array('class' => 'dropdown-menu')) . "\n";

			// 下拉子菜单列表
			$total = count($menus);
			$curr = 0;
			foreach ($menus as $menu) {
				$output .= $html->tag('li', array(), $this->a($menu)) . "\n";
				if (++$curr < $total) {
					$output .= $html->tag('li', array('class' => 'divider'), '') . "\n";
				}
			}

			// 下拉子菜单外结束标签
			$output .= $html->closeTag('ul') . "\n";

			// 主菜单外结束标签
			$output .= $html->closeTag('li') . "\n";
		}

		$this->assign('menus', $output);
		$this->display();
	}

	/**
	 * 通过导航信息获取A标签
	 * @param array $cfg
	 * @param boolean $isDropdown
	 * @return string
	 */
	public function a(array $cfg, $isDropdown = false)
	{
		$html = $this->getHtml();
		$url = $this->getUrl($cfg);
		$label = isset($cfg['label']) ? $cfg['label'] : '';
		if ($isDropdown) {
			return $html->a(
				Text::_($label) . ' ' . $html->tag('b', array('class' => 'caret'), ''),
				$url,
				array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown')
			);
		}

		return $html->a(Text::_($label), $url);
	}

	/**
	 * 通过导航配置获取<li>标签的属性
	 * @param array $cfg
	 * @param boolean $isDropdown
	 * @return array
	 */
	public function getAttributes(array $cfg, $isDropdown = false)
	{
		$isActive = $this->isActive($cfg);
		$className = ($isDropdown ? 'dropdown ' : '') . ($isActive ? 'active' : '');
		if (($className = trim($className)) !== '') {
			return array('class' => $className);
		}

		return array();
	}

	/**
	 * 通过导航配置判断当前链接是否是Active状态
	 * @param array $cfg
	 * @return boolean
	 */
	public function isActive(array $cfg)
	{
		$mod = isset($cfg['m']) ? $cfg['m'] : '';
		return ($mod === Mvc::$module);
	}

	/**
	 * 通过导航配置获取链接
	 * @param array $cfg
	 * @return string
	 */
	public function getUrl(array $cfg)
	{
		$mod    = isset($cfg['m'])      ? $cfg['m'] : '';
		$ctrl   = isset($cfg['c'])      ? $cfg['c'] : '';
		$act    = isset($cfg['a'])      ? $cfg['a'] : '';
		$params = isset($cfg['params']) ? (array) $cfg['params'] : array();

		return $this->getUrlManager()->getUrl($act, $ctrl, $mod, $params);
	}
}
