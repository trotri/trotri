<?php
namespace components;

use tfc\mvc\Widget;
use tfc\saf\Cfg;

/**
 * NavBar class file
 * 页面顶端导航
 * @author 宋欢 <iphper@yeah.net>
 * @version $Id: NavBar.php 1 2013-04-20 17:11:06Z huan.song $
 * @package components
 * @since 1.0
 */
class NavBar extends Widget
{
	/**
	 * 执行Widget类，输出内容
	 * @return void
	 */
	public function run()
	{
		$this->assign($this->getView()->urls);
		$this->display();
	}
}
