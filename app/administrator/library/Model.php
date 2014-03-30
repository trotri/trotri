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
	 * @var string 项目名
	 */
	protected $_moduleName = '';

	/** 
	 * @var string 模型类名
	 */
	protected $_className = '';

	/**
	 * @var array 寄存所有调用过的模型类实例
	 */
	protected static $_instances = array();

	/**
	 * 构造方法：初始化项目名和模型类名
	 */
	public function __construct()
	{
		list($tmp1, $this->_moduleName, $tmp2, $this->_className) = explode('\\', get_class($this));
	}

	/**
	 * 获取模型类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @return instance of library\Model
	 */
	public static function getInstance($className, $moduleName = '')
	{
		if (($moduleName = trim($moduleName)) === '') {
			$moduleName = Mvc::$module;
		}

		$className = 'modules\\' . strtolower($moduleName) . '\\model\\' . strtolower($className);
		if (!isset(self::$_instances[$className])) {
			self::$_instances[$className] = new $className();
		}

		return self::$_instances[$className];
	}

	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $limit = null, $offset = null)
	{
		if ($limit === null) {
			$limit = PageHelper::getListRows();
		}

		if ($offset === null) {
			$offset = PageHelper::getFirstRow();
		}

		return $this->getService()->search($params, $order, $limit, $offset);
	}

	/**
	 * 通过主键，查询一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
		return $this->getService()->findByPk($value);
	}

	/**
	 * 通过主键，从持久化记录中获取某个列的值。不支持联合主键
	 * 多用于View层数据展示
	 * @param string $columnName
	 * @param integer $value
	 * @return array
	 */
	public function getColById($columnName, $value)
	{
		return $this->getService()->getColById($columnName, $value);
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		return $this->getService()->create($params);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		return $this->getService()->modifyByPk($value, $params);
	}

	/**
	 * 通过主键，将一条记录移至回收站。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function trashByPk($value)
	{
		return $this->getService()->trashByPk($value, 'trash', 'y');
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $values
	 * @return array
	 */
	public function batchTrashByPk(array $values)
	{
		return $this->getService()->batchTrashByPk($values, 'trash', 'y');
	}

	/**
	 * 通过主键，从回收站还原一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function restoreByPk($value)
	{
		return $this->getService()->restoreByPk($value, 'trash', 'n');
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $values
	 * @return array
	 */
	public function batchRestoreByPk(array $values)
	{
		return $this->getService()->batchRestoreByPk($values, 'trash', 'n');
	}

	/**
	 * 通过主键，删除一条记录。不支持联合主键
	 * @param integer $value
	 * @return array
	 */
	public function deleteByPk($value)
	{
		return $this->getService()->deleteByPk($value);
	}

	/**
	 * 通过主键，删除多条记录。不支持联合主键
	 * @param array $values
	 * @return array
	 */
	public function batchDeleteByPk(array $values)
	{
		return $this->getService()->batchDeleteByPk($values);
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

	/**
	 * 获取最后一次访问的列表页链接
	 * @return string
	 */
	public function getLastIndexUrl()
	{
		return PageHelper::getLastIndexUrl();
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
	 * 获取模型类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @return instance of library\Model
	 */
	public function getModel($className, $moduleName = '')
	{
		if (($moduleName = trim($moduleName)) === '') {
			$moduleName = $this->_moduleName;
		}

		return Model::getInstance($className, $moduleName);
	}

	/**
	 * 获取业务层模型类的实例
	 * @param integer $tableNum
	 * @return instance of slib\BaseModel
	 */
	public function getService($tableNum = -1)
	{
		if ($this->_service === null) {
			$this->_service = Service::getModel($this->_className, $this->_moduleName, Ap::getLanguageType(), $tableNum);
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
			$this->_data = Service::getData($this->_className, $this->_moduleName, Ap::getLanguageType());
		}

		return $this->_data;
	}
}
