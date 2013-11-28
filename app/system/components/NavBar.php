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
		foreach ($urls as $navs) {
			$nav = array_shift($navs);
			if (!is_array($nav)) {
				continue;
			}

			if (!$navs) {
				$output .= $html->tag('li', array(), $this->a($nav)) . "\n";
				continue;
			}

			$output .= $html->openTag('li', array('class' => 'dropdown')) . "\n";
			$output .= $this->a($nav, true) . "\n";

			$output .= $html->openTag('ul', array('class' => 'dropdown-menu')) . "\n";

			foreach ($navs as $nav) {
				$output .= $html->tag('li', array(), $this->a($nav)) . "\n";
				$output .= $html->tag('li', array('class' => 'divider'), '') . "\n";
			}

			$output .= $html->closeTag('ul') . "\n";
			$output .= $html->closeTag('li') . "\n";
		}

		$this->assign('navs', $output);
		$this->display();
	}

	/**
	 * 通过导航信息获取A标签
	 * @param array $nav
	 * @param boolean $isDropdown
	 * @return string
	 */
	public function a(array $nav, $isDropdown = false)
	{
		$html = $this->getHtml();
		$url = $this->getUrl($nav);
		if ($isDropdown) {
			return $html->a(
				Text::_($nav['label']) . ' ' . $html->tag('b', array('class' => 'caret'), ''),
				$url,
				array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown')
			);
		}

		return $html->a(Text::_($nav['label']), $url);
	}

	/**
	 * 通过导航信息获取链接
	 * @param array $nav
	 * @return string
	 */
	public function getUrl(array $nav)
	{
		$mod = isset($nav['m']) ? $nav['m'] : '';
		$ctrl = isset($nav['c']) ? $nav['c'] : '';
		$act = isset($nav['a']) ? $nav['a'] : '';
		$params = isset($nav['p']) ? (array) $nav['p'] : array();

		return $this->getUrlManager()->getUrl($act, $ctrl, $mod, $params);
	}
}
