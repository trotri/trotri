<?php
namespace components;

use tfc\mvc\Widget;

/**
 * AlertBar class file
 * 页面警告栏
 * @author 宋欢 <iphper@yeah.net>
 * @version $Id: AlertBar.php 1 2013-04-20 17:11:06Z huan.song $
 * @package components
 * @since 1.0
 */
class AlertBar extends Widget
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Widget::run()
	 */
	public function run()
	{
		$errNo = $this->getView()->err_no;
		$errMsg = $this->getView()->err_msg;

		if ($errMsg != '') {
			echo '<div id="alert_bar" class="alert alert-', ($errNo > 0 ? 'danger' : 'success'), '">', $errMsg, '</div>';
		}
	}
}
