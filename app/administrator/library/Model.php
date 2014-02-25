<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use tfc\ap\Ap;
use tfc\mvc\Mvc;
use slib\Service;

/**
 * Model class file
 * 模型基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Model.php 1 2013-03-29 16:48:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Model
{
	/**
	 * @var instance of slib\BaseModel 获取业务层模型类的实例
	 */
	protected $_service = null;

	/**
	 * @var instance of slib\BaseData 获取数据管理类的实例
	 */
	protected $_data = null;

	/**
	 * @var array 寄存所有调用过的模型类实例
	 */
	protected static $_instances = array();

	/**
	 * 获取模型类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @return instance of slib\BaseModel
	 */
	public static function getInstance($className, $moduleName)
	{
		$className = 'modules\\' . strtolower($moduleName) . '\\model\\' . $className;
		if (!isset(self::$_instances[$className])) {
			self::$_instances[$className] = new $className();
		}

		return self::$_instances[$className];
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
	 * 获取所有的表单元素，需要子类重写此方法
	 * @return array
	 */
	public function getElements()
	{
		return array();
	}

	/**
	 * 获取链接标签：<a href=""></a>
	 * @param string $content
	 * @param string $href
	 * @param array $attributes
	 * @return string
	 */
	public function a($content, $href = '#', $attributes = array())
	{
		return $this->getHtml()->a($content, $href, $attributes);
	}

	/**
	 * 通过路由类型，获取URL
	 * 如果指定了Action，但没指定Controller，则Controller默认为当前Controller
	 * 如果指定了Controller，但没指定Module，则Module默认为当前Module
	 * @param string $action
	 * @param string $controller
	 * @param string $module
	 * @param array $params
	 * @return string
	 */
	public function getUrl($action = '', $controller = '', $module = '', array $params = array())
	{
		return $this->getUrlManager()->getUrl($action, $controller, $module, $params);
	}

	/**
     * 获取页面辅助类
     * @return tfc\mvc\Html
     */
	public function getHtml()
	{
		return Mvc::getView()->getHtml();
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
	 * 获取业务层模型类的实例
	 * @param integer $tableNum
	 * @return instance of slib\BaseModel
	 */
	public function getService($tableNum = -1)
	{
		if ($this->_service === null) {
			list($m, $moduleName, $n, $className) = explode('\\', __CLASS__);
			$this->_service = Service::getModel($className, $moduleName, Ap::getLanguageType(), $tableNum);
		}

		return $this->_service;
	}

	/**
	 * 获取数据管理类的实例
	 * @return instance of slib\BaseData
	 */
	public function getData()
	{
		if ($this->_data === null) {
			list($m, $moduleName, $n, $className) = explode('\\', __CLASS__);
			$this->_data = Service::getData($className, $moduleName, Ap::getLanguageType());
		}

		return $this->_data;
	}
}
