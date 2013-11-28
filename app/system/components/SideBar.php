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
 * SideBar class file
 * 页面左边导航
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SideBar.php 1 2013-04-20 17:11:06Z huan.song $
 * @package components
 * @since 1.0
 */
class SideBar extends Widget
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::run()
	 */
	public function run()
	{
		$name = isset($this->_tplVars['name']) ? $this->_tplVars['name'] : '';
		if ($name === '') {
			return ;
		}

		$output = '';

		$html = $this->getHtml();
		$urls = Cfg::getApp($name, 'sidebar', 'urls');

		$output .= $html->openTag('div', array('class' => 'list-group'));

		foreach ($urls as $nav) {
			$output .= $html->a(
				Text::_($nav['label']) . (isset($nav['icon']) ? $this->getIcon($nav['icon']) : ''), 
				$this->getUrl($nav), 
				array('class' => 'list-group-item')
			);
		}

		$output .= $html->closeTag('div') . '<!--/.list-group-->' . "\n";
		echo $output;
	}

	/**
	 * 获取Icon标签
	 * @param array $nav
	 * @return string
	 */
	public function getIcon(array $nav)
	{
		return $this->getHtml()->tag('span', array(
			'class' => 'glyphicon glyphicon-plus-sign pull-right',
			'data-toggle' => 'tooltip',
			'data-placement' => 'left',
			'data-original-title' => Text::_($nav['label']),
			'onclick' => 'return Trotri.href(\'' . $this->getUrl($nav) . '\')'
		), '');
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
