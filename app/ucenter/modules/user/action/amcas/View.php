<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\user\action\amcas;

use tfc\mvc\Mvc;
use library\actions;
use srv\user\mods\Amcas;

/**
 * View class file
 * 查询数据详情
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: View.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.user.action.amcas
 * @since 1.0
 */
class View extends actions\Show
{
	/**
	 * @var string 页面首次渲染的布局名
	 */
	public $layoutName = 'column2';

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$viw = Mvc::getView();
		$tplName = $this->getDefaultTplName();

		$this->assignSystem();
		$this->assignUrl();
		$this->assignLanguage();

		$viw->display($tplName);
	}
}
