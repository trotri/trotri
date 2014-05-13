<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace app;

use tfc\ap\HttpCookie;
use tfc\mvc\Mvc;

/**
 * Elements abstract class file
 * 表单元素管理基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Elements.php 1 2013-05-18 14:58:59Z huan.song $
 * @package app
 * @since 1.0
 */
abstract class Elements
{
	/**
	 * @var string 存放最后一次访问的列表页链接的Cookie名
	 */
	const LLU_COOKIE_NAME = 'last_list_url';

	/**
	 * @var string 缺省的列表页方法名
	 */
	const DEFAULT_ACT_NAME_LIST = 'index';

	/**
	 * @var string 缺省的新增数据方法名
	 */
	const DEFAULT_ACT_NAME_CREATE = 'create';

	/**
	 * @var string 缺省的编辑数据方法名
	 */
	const DEFAULT_ACT_NAME_MODIFY = 'modify';

	/**
	 * @var 业务处理类、模板解析类、URL管理类、页面辅助类、模型名、控制器名、方法名、列表页方法名
	 */
	public
		$view,
		$urlManager,
		$html,
		$module,
		$controller,
		$action,
		$actNameList = self::DEFAULT_ACT_NAME_LIST,
		$actNameCreate = self::DEFAULT_ACT_NAME_CREATE,
		$actNameModify = self::DEFAULT_ACT_NAME_MODIFY;

	/**
	 * 构造方法，初始化业务处理类、模板解析类、URL管理类、页面辅助类、模型名、控制器名、方法名
	 * @param app\Service $srv
	 */
	public function __construct()
	{
		$this->view = Mvc::getView();
		$this->urlManager = $this->view->getUrlManager();
		$this->html = $this->view->getHtml();
		$this->module = Mvc::$module;
		$this->controller = Mvc::$controller;
		$this->action = Mvc::$action;
	}

	/**
	 * 获取缺省的最后一次访问的列表页链接
	 * @return string
	 */
	public function getLLUDefault()
	{
		return $this->urlManager->getUrl($this->actNameList, $this->controller, $this->module);
	}

	/**
	 * 获取最后一次访问的列表页链接
	 * @return string
	 */
	public function getLLU()
	{
		$value = HttpCookie::get(self::LLU_COOKIE_NAME);
		if ($value !== null && strpos($value, '__') !== false) {
			list($router, $url) = explode('__', $value);
			if ($router === $this->module . '_' . $this->controller . '_' . $this->actNameList) {
				return base64_decode($url);
			}
		}

		return $this->getLLUDefault();
	}

	/**
	 * 设置最后一次访问的列表页链接
	 * @param array $params
	 * @return void
	 */
	public function setLLU(array $params = array())
	{
		$url = $this->urlManager->getUrl($this->actNameList, $this->controller, $this->module, $params);
		$router = $this->module . '_' . $this->controller . '_' . $this->actNameList;
		$value = $router . '__' . str_replace('=', '', base64_encode($url));
		HttpCookie::add(self::LLU_COOKIE_NAME, $value);
	}

	/**
	 * 获取Input表单元素分类标签，需要子类重写此方法
	 * @return array
	 */
	public function getViewTabsRender()
	{
		return array();
	}

	/**
	 * 获取表单元素配置，需要子类重写此方法
	 * @return array
	 */
	public function getElementsRender()
	{
		return array();
	}
}
