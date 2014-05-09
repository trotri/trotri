<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace ucenter\mods;

use srv\Model;
use ucenter\library\Constant;
use ucenter\library\TableNames;
use ucenter\db\Amcas AS DbAmcas;

/**
 * Amcas class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-04-06 14:43:06Z huan.song $
 * @package ucenter.mods
 * @since 1.0
 */
class Amcas extends Model
{
	/**
	 * @var instance of ucenter\db\Amcas
	 */
	protected $_dbAmcas = null;

	/**
	 * 构造方法：初始化数据库操作类
	 */
	public function __construct()
	{
		$this->_dbAmcas = new DbAmcas();
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $amcaId
	 * @return array
	 */
	public function findByAmcaId($amcaId)
	{
		$row = $this->_dbAmcas->findByAmcaId($amcaId);
		return $row;
	}

	/**
	 * 获取所有的应用提示
	 * @return array
	 */
	public function findAppPrompts()
	{
		$rows = $this->_dbAmcas->findAppPrompts();
		return $rows;
	}

	/**
	 * 通过父ID，获取所有的子事件
	 * @param integer $amcaPid
	 * @return array
	 */
	public function findAllByAmcaPid($amcaPid)
	{
		$rows = $this->_dbAmcas->findAllByAmcaPid($amcaPid);
		return $rows;
	}

	/**
	 * 获取模块和控制器类型数据
	 * @param integer $appId
	 * @param string $padStr
	 * @return array
	 */
	public function findModCtrls($appId, $padStr = ' ---- ')
	{
		$data = array();

		$mods = $this->findAllByAmcaPid($appId);
		if ($mods && is_array($mods)) {
			foreach ($mods as $modRows) {
				$data[] = $modRows;

				$ctrls = $this->findAllByAmcaPid($modRows['amca_id']);
				if ($ctrls && is_array($ctrls)) {
					foreach ($ctrls as $ctrlRows) {
						$ctrlRows['amca_name'] = $padStr . $ctrlRows['amca_name'];
						$data[] = $ctrlRows;
					}
				}
			}
		}

		return $data;
	}

	/**
	 * 递归模式获取所有数据
	 * @return array
	 */
	public function findAllByRecur()
	{
		$data = array();

		$apps = $this->findAllByAmcaPid(0);
		if ($apps && is_array($apps)) {
			foreach ($apps as $appRow) {
				$appRow['rows'] = array();

				$mods = $this->findAllByAmcaPid($appRow['amca_id']);
				if ($mods && is_array($mods)) {
					foreach ($mods as $modRow) {
						$modRow['rows'] = array();

						$ctrls = $this->findAllByAmcaPid($modRow['amca_id']);
						if ($ctrls && is_array($ctrls)) {
							foreach ($ctrls as $ctrlRow) {
								$ctrlRow['rows'] = array();

								$acts = $this->findAllByAmcaPid($ctrlRow['amca_id']);
								if ($acts && is_array($acts)) {
									foreach ($acts as $actRow) {
										$ctrlRow['rows'][$actRow['amca_name']] = $actRow;
									}
								}

								$modRow['rows'][$ctrlRow['amca_name']] = $ctrlRow;
							}
						}

						$appRow['rows'][$modRow['amca_name']] = $modRow;
					}
				}

				$data[$appRow['amca_name']] = $appRow;
			}
		}

		return $data;
	}

	/**
	 * 通过事件ID，获取事件名
	 * @param integer $amcaId
	 * @return string
	 */
	public function getAmcaNameByAmcaId($amcaId)
	{
		$row = $this->findByAmcaId($amcaId);
		if (is_array($row)) {
			return isset($row['amca_name']) ? $row['amca_name'] : '';
		}

		return '';
	}

	/**
	 * 通过事件ID，获取类型
	 * @param integer $amcaId
	 * @return string
	 */
	public function getCategoryByAmcaId($amcaId)
	{
		$row = $this->findByAmcaId($amcaId);
		if (is_array($row)) {
			return isset($row['category']) ? $row['category'] : '';
		}

		return '';
	}

	/**
	 * 通过事件ID，获取类型
	 * @param integer $amcaId
	 * @return string
	 */
	public function getCategoryLangByAmcaId($amcaId)
	{
		$row = $this->findByAmcaId($amcaId);
		if (is_array($row) && isset($row['category'])) {
			$enum = DataAmcas::getCategoryEnum();
			return isset($enum[$row['category']]) ? $enum[$row['category']] : '';
		}

		return '';
	}

	/**
	 * 通过事件ID，获取提示
	 * @param integer $amcaId
	 * @return string
	 */
	public function getPromptByAmcaId($amcaId)
	{
		$row = $this->findByAmcaId($amcaId);
		if (is_array($row)) {
			return isset($row['prompt']) ? $row['prompt'] : '';
		}

		return '';
	}

	/**
	 * 通过事件ID，获取父事件ID
	 * @param integer $amcaId
	 * @return integer
	 */
	public function getAmcaPidByAmcaId($amcaId)
	{
		$row = $this->findByAmcaId($amcaId);
		if (is_array($row)) {
			return isset($row['amca_pid']) ? $row['amca_pid'] : -1;
		}

		return -1;
	}

	/**
	 * 通过事件ID，获取父事件名
	 * @param integer $amcaId
	 * @return string
	 */
	public function getAmcaPnameByAmcaId($amcaId)
	{
		$amcaPid = $this->getAmcaPidByAmcaId($amcaId);
		if ($amcaPid >= 0) {
			return $this->getAmcaNameByAmcaId($amcaPid);
		}

		return '';
	}

	/**
	 * 通过父ID和事件名统计记录数
	 * @param integer $amcaPid
	 * @param string $amcaName
	 * @return integer
	 */
	public function countByPidAndName($amcaPid, $amcaName)
	{
		$total = $this->_dbAmcas->countByPidAndName($amcaPid, $amcaName);
		return $total;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return integer
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$fpAmcas = new FpAmcas($this, FpAmcas::OP_TYPE_INSERT);
		
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $amcaId
	 * @param array $params
	 * @return array
	 */
	public function modify($amcaId, array $params = array())
	{
		$fpAmcas = new FpAmcas($this, FpAmcas::OP_TYPE_UPDATE);
		return $this->callModifyMethod($this->_dbAmcas, 'modify', $amcaId, $params, $fpAmcas);
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $amcaId
	 * @return integer
	 */
	public function remove($amcaId)
	{
		$rowCount = $this->_dbAmcas->remove($amcaId);
		return $rowCount;
	}
}
