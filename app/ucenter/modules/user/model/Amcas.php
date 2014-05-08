<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\user\model;

use tfc\mvc\Mvc;
use tfc\saf\ErrorNo;
use app\SrvFactory;
use srv\user\mods\DataAmcas;

/**
 * Amcas class file
 * 用户可访问的事件
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-04-06 14:43:07Z huan.song $
 * @package modules.ucenter.model
 * @since 1.0
 */
class Amcas
{
	/**
	 * @var instance of srv\user\mods\Amcas
	 */
	protected $_srvAmcas = null;

	/**
	 * 构造方法：初始化业务层模型类
	 */
	public function __construct()
	{
		$this->_srvAmcas = SrvFactory::getInstance('Amcas', 'user');
	}

	/**
	 * 获取Input表单元素分类标签
	 * @return array
	 */
	public function getViewTabsRender()
	{
		$output = array(
		);

		return $output;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $amcaId
	 * @return array
	 */
	public function findByAmcaId($amcaId)
	{
		return $this->_srvAmcas->findByAmcaId($amcaId);
	}

	/**
	 * 获取所有的应用提示
	 * @return array
	 */
	public function findAppPrompts()
	{
		$ret = $this->_srvAmcas->findAppPrompts();
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			return $ret['data'];
		}

		return array();
	}

	/**
	 * 通过父ID，获取所有的子事件
	 * @param integer $amcaPid
	 * @return array
	 */
	public function findAllByAmcaPid($amcaPid)
	{
		return $this->_srvAmcas->findAllByAmcaPid($amcaPid);
	}

	/**
	 * 获取模块和控制器类型数据
	 * @param integer $appId
	 * @return array
	 */
	public function findModCtrls($appId)
	{
		return $this->_srvAmcas->findModCtrls($appId, ' ---- ');
	}

	/**
	 * 递归模式获取所有数据
	 * @return array
	 */
	public function findAllByRecur()
	{
		return $this->_srvAmcas->findAllByRecur();
	}

	/**
	 * 通过事件ID，获取事件名
	 * @param integer $amcaId
	 * @return string
	 */
	public function getAmcaNameByAmcaId($amcaId)
	{
		return $this->_srvAmcas->getAmcaNameByAmcaId($amcaId);
	}

	/**
	 * 通过父ID和事件名统计记录数
	 * @param integer $amcaPid
	 * @param string $amcaName
	 * @return integer
	 */
	public function countByPidAndName($amcaPid, $amcaName)
	{
		return $this->_srvAmcas->countByPidAndName($amcaPid, $amcaName);
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return array
	 */
	public function create(array $params = array(), $ignore = false)
	{
		return $this->_srvAmcas->create($params, $ignore);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $amcaId
	 * @param array $params
	 * @return array
	 */
	public function modify($amcaId, array $params = array())
	{
		return $this->_srvAmcas->modify($amcaId, $params);
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $amcaId
	 * @return array
	 */
	public function remove($amcaId)
	{
		return $this->_srvAmcas->remove($amcaId);
	}

	/**
	 * 获取列表页“事件名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getAmcaNameLink($data)
	{
		$params = array(
			'id' => $data['amca_id'],
		);

		$url = Mvc::getView()->getUrlManager()->getUrl('view', Mvc::$controller, Mvc::$module, $params);
		$output = Mvc::getView()->getHtml()->a($data['amca_name'], $url);
		return $output;
	}

	/**
	 * 获取列表页“父事件名”选项
	 * @param array $data
	 * @return string
	 */
	public function getAmcaPnameTblColumn($data)
	{
		return $this->getAmcaNameByAmcaId($data['amca_pid']);
	}

	/**
	 * 获取列表页“类型”选项
	 * @param array $data
	 * @return string
	 */
	public function getCategoryTblColumn($data)
	{
		$enum = DataAmcas::getCategoryEnum();
		return isset($enum[$data['category']]) ? $enum[$data['category']] : $data['category'];
	}
}
