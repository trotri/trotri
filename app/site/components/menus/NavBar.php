<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace components\menus;

use libapp\Component;
use components\menus\helpers\Constant;
use components\menus\helpers\Menus;

/**
 * NavBar class file
 * 页面顶端导航
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: NavBar.php 1 2013-04-20 17:11:06Z huan.song $
 * @package components.menus
 * @since 1.0
 */
class NavBar extends Component
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\Widget::run()
	 */
	public function run()
	{
		$output = '';
		$typeKey = Constant::TYPE_KEY_NAVBAR;

		$html = $this->getHtml();
		$menus = Menus::findRows($typeKey);

		$divider = $html->tag('li', array('class' => 'divider'), '');

		if ($menus && is_array($menus)) {
			foreach ($menus as $rows) {
				if ($rows['data'] && is_array($rows['data'])) {
					$output .= $html->openTag('li', array('class' => 'dropdown'));
					$output .= $this->a($rows, true);
					$output .= $html->openTag('ul', array('class' => 'dropdown-menu'));
					foreach ($rows['data'] as $_) {
						$output .= $html->tag('li', array(), $this->a($_));
						$output .= $divider;
					}

					$output = substr($output, 0, -strlen($divider));
					$output .= $html->closeTag('ul');
				}
				else {
					$output .= $html->openTag('li');
					$output .= $this->a($rows);
				}

				$output .= $html->closeTag('li');
			}
		}

		$this->assign('menus',  $output);
		$this->display();
	}

	/**
	 * 获取A标签
	 * @param array $data
	 * @param boolean $isDropdown
	 * @return string
	 */
	public function a(array &$data, $isDropdown = false)
	{
		$html    = $this->getHtml();
		$url     = isset($data['menu_url'])  ? $data['menu_url']  : '#';
		$content = isset($data['menu_name']) ? $data['menu_name'] : '';

		if ($isDropdown) {
			$content .= ' ' . $html->tag('b', array('class' => 'caret'), '');
		}

		return $html->a($content, $url, $this->getAttributes($data, $isDropdown));
	}

	/**
	 * 获取A标签的属性
	 * @param array $data
	 * @param boolean $isDropdown
	 * @return array
	 */
	public function getAttributes(array &$data, $isDropdown = false)
	{
		$target = isset($data['attr_target']) ? $data['attr_target'] : '';
		$title  = isset($data['attr_title'])  ? $data['attr_title']  : '';
		$rel    = isset($data['attr_rel'])    ? $data['attr_rel']    : '';
		$class  = isset($data['attr_class'])  ? $data['attr_class']  : '';
		$style  = isset($data['attr_style'])  ? $data['attr_style']  : '';

		$attributes = array();

		if ($isDropdown) {
			$class = ltrim($class . ' dropdown-toggle');
			$attributes['data-toggle'] = 'dropdown';
		}

		if ($target !== '') {
			$attributes['target'] = $target;
		}

		if ($title !== '') {
			$attributes['title'] = $title;
		}

		if ($rel !== '') {
			$attributes['rel'] = $rel;
		}

		if ($class !== '') {
			$attributes['class'] = $class;
		}

		if ($style !== '') {
			$attributes['style'] = $style;
		}

		return $attributes;
	}
}
