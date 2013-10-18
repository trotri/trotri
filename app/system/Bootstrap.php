<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

use tfc\ap;
use tfc\mvc\Mvc;

/**
 * Bootstrap class file
 * 程序引导类，在项目入口处执行，会依次执行类中以_init开头的方法，初始化项目参数
 * @author auto create
 * @version $Id: Bootstrap.php 1 2013-04-11 12:06:30Z create.auto $
 * @package system
 * @since 1.0
 */
class Bootstrap extends ap\Bootstrap
{
	/**
	 * 初始化默认的module、controller和action名
	 * @return void
	 */
	public function _initDefaultRouter()
	{
		$router = Mvc::getRouter();
		$router->setDefaultModule('generator')
			   ->setDefaultController('Index')
			   ->setDefaultAction('index');
	}

    /**
     * 初始化缓存
     * @return void
     */
    public function _initCache()
    {
    }

    /**
     * 初始化模板解析类
     * @return void
     */
    public function _initView()
    {
    }

    /**
     * 初始化路由规则
     * @return void
     */
    public function _initRoutes()
    {
    }
}
