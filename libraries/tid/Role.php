<?php
/**
 * Trotri User Identity
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tid;

use tfc\ap\ErrorException;

/**
 * Role class file
 * 用户角色类
 * <pre>
 * 数据缓存文件：/data/roles/rolename.php：
 * return array (
 *   'administrator' => array (
 *     'system' => array (
 *       'site' => array (
 *         'index', 'test'
 *       ),
 *     ),
 *     'ucenter' => array (
 *       'users' => array (
 *         'login', 'logout', 'register'
 *       ),
 *     ),
 *   ),
 *   'cms' => array (
 *     'system' => array (
 *       'site' => array (
 *         'index', 'test'
 *       ),
 *     ),
 *     'ucenter' => array (
 *       'users' => array (
 *         'login', 'logout', 'register'
 *       ),
 *     ),
 *   ),
 * );
 * </pre>
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Role.php 1 2014-04-20 01:08:06Z huan.song $
 * @package tid
 * @since 1.0
 */
class Role
{
    /**
     * @var array 寄存所有的资源
     */
	protected $_resources = array();

	/**
	 * @var string 角色名
	 */
	protected $_name = null;

	/**
	 * 构造方法：初始化角色名
	 * @param string $name
	 * @throws ErrorException 如果角色名为空，抛出异常
	 */
	public function __construct($name)
	{
		if (($name = trim($name)) === '') {
			throw new ErrorException(
				'Role name must be string and not empty.'
			);
		}
	}

	/**
	 * 获取所有的资源
	 * @return array
	 */
	public function getResources()
	{
		return $this->_resources;
	}

	/**
	 * 添加一个资源
	 * @param string $appName
	 * @param string $modName
	 * @param string $ctrlName
	 * @param string $actName
	 * @return tid\Role
	 */
	public function addResource($appName, $modName, $ctrlName, $actName)
	{
		if (!$this->hasResource($appName, $modName, $ctrlName, $actName)) {
			$this->_resources[$appName][$modName][$ctrlName][$actName] = true;
		}

		return $this;
	}

	/**
	 * 删除一个资源
	 * @param string $appName
	 * @param string $modName
	 * @param string $ctrlName
	 * @param string $actName
	 * @return tid\Role
	 */
	public function removeResource($appName, $modName, $ctrlName, $actName)
	{
		if ($this->hasResource($appName, $modName, $ctrlName, $actName)) {
			unset($this->_resources[$appName][$modName][$ctrlName][$actName]);
		}

		return $this;
	}

	/**
	 * 判断资源是否存在
	 * @param string $appName
	 * @param string $modName
	 * @param string $ctrlName
	 * @param string $actName
	 * @return boolean
	 */
	public function hasResource($appName, $modName, $ctrlName, $actName)
	{
		return isset($this->_resources[$appName][$modName][$ctrlName][$actName]);
	}

	/**
	 * 清空所有的资源
	 * @return tid\Role
	 */
	public function clearResources()
	{
		$this->_resources = array();
		return $this;
	}

	/**
	 * 从角色授权数据缓存文件中加载资源
	 */
	public function loadResources()
	{
		
	}

	/**
	 * 获取角色名
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
}
