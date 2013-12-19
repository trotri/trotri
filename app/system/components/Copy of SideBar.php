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

		// 菜单最外围开始标签
		$output .= $html->openTag('div', array('class' => 'list-group'));

		// 菜单列表
		foreach ($urls as $menu) {
			$label = isset($menu['label']) ? $menu['label'] : '';
			$output .= $html->a(
				Text::_($label) . (isset($menu['icon']) ? $this->getIcon($menu['icon']) : ''), 
				$this->getUrl($menu), 
				$this->getAttributes($menu)
			);
		}

		// 菜单最外围结束标签
		$output .= $html->closeTag('div') . '<!--/.list-group-->' . "\n";
		echo $output;
	}

	/**
	 * 获取Icon标签
	 * @param array $cfg
	 * @return string
	 */
	public function getIcon(array $cfg)
	{
		$label = isset($cfg['label']) ? $cfg['label'] : '';
		return $this->getHtml()->tag('span', array(
			'class'               => 'glyphicon glyphicon-plus-sign pull-right',
			'data-toggle'         => 'tooltip',
			'data-placement'      => 'left',
			'data-original-title' => Text::_($label),
			'onclick' => 'return Trotri.href(\'' . $this->getUrl($cfg) . '\')'
		), '');
	}

	/**
	 * 通过导航配置获取<a>标签的属性
	 * @param array $cfg
	 * @param boolean $isDropdown
	 * @return array
	 */
	public function getAttributes(array $cfg, $isDropdown = false)
	{
		$isActive = $this->isActive($cfg);
		$className = 'list-group-item' . ($isActive ? ' active' : '');
		return array('class' => $className);
	}

	/**
	 * 通过导航配置判断当前链接是否是Active状态
	 * @param array $cfg
	 * @return boolean
	 */
	public function isActive(array $cfg)
	{
		$mod  = isset($cfg['m']) ? $cfg['m'] : '';
		$ctrl = isset($cfg['c']) ? $cfg['c'] : '';
		$act  = isset($cfg['a']) ? $cfg['a'] : '';
		return ($mod === Mvc::$module && $ctrl === Mvc::$controller && $act === Mvc::$action);
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
