<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use tfc\ap\Ap;
use tfc\mvc\Mvc;
use tfc\mvc\Action;

/**
 * BaseAction abstract class file
 * Action基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseAction.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
abstract class BaseAction extends Action
{
	/**
	 * @var array 项目支持的语言种类
	 */
	protected $_languageTypes = array('zh-CN', 'en-GB');

	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Action::_init()
	 */
	protected function _init()
	{
		$this->_initLanguageType();
	}

	/**
	 * 初始化输出的语言种类
	 * @return void
	 */
	protected function _initLanguageType()
	{
		// 从RGP中获取‘ol’的值（output language type），并验证是否合法
		$languageType = Ap::getRequest()->getTrim('ol');
		if ($languageType !== '') {
			if (in_array($languageType, $this->_languageTypes)) {
				// 以RGP中指定的输出语种为主
				Ap::setLanguageType($languageType);
			}
		}
	}

	/**
	 * 获取URL管理类
	 * @return tfc\mvc\UrlManager
	 */
	public function getUrlManager()
	{
		return Mvc::getView()->getUrlManager();
	}

	/**
	 * 通过Service查询后的分页信息，设置最后一次访问的列表页链接
	 * <pre>
	 * 参数格式：
	 * $params = array(
	 *     'attributes' => array(),
	 *     'order' => '',
	 *     'limit' => 0,
	 *     'offset' => 0,
	 *     'total' => 0
	 * );
	 * </pre>
	 * @param array $params
	 * @return void
	 */
	public function setLastIndexUrl(array $params = array())
	{
		PageHelper::setLastIndexUrlBySrv($params);
	}

	/**
	 * 页面重定向到最后一次访问的列表页
	 * @param array $params
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public function httpLastIndexUrl(array $params = array(), $message = '', $delay = 0)
	{
		$url = $this->getUrlManager()->applyParams(PageHelper::getLastIndexUrl(), $params);
		$this->redirect($url, $message, $delay);
	}

	/**
	 * 页面重定向到上一个页面
	 * @param array $params
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public function httpReferer(array $params = array(), $message = '', $delay = 0)
	{
		$url = $this->getUrlManager()->applyParams(PageHelper::getHttpReferer(), $params);
		$this->redirect($url, $message, $delay);
	}

	/**
	 * 页面重定向到当前页面
	 * @param array $params
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public function refresh($params = array(), $message = '', $delay = 0)
	{
		$url = $this->getUrlManager()->applyParams($this->getUrlManager()->getRequestUri(), $params);
		$this->redirect($url, $message, $delay);
	}

	/**
	 * 页面重定向到指定的链接
	 * @param string $url
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public function redirect($url, $message = '', $delay = 0)
	{
		Ap::getResponse()->redirect($url, $message, $delay);
		exit;
	}

	/**
	 * 页面重定向到指定的路由
	 * @param string $action
	 * @param string $controller
	 * @param string $module
	 * @param array $params
	 * @param string $message
	 * @param integer $delay
	 * @return void
	 */
	public function forward($action = '', $controller = '', $module = '', array $params = array(), $message = '', $delay = 0)
	{
		$url = $this->getUrlManager()->getUrl($action, $controller, $module, $params);
		$this->redirect($url, $message, $delay);
	}

	/**
	 * 页面重定向到404页面
	 * @return void
	 */
	public function err404()
	{
		$this->forward('err404', 'index', 'system');
	}
}
