<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace s_user\db;

use srv\Db;
use s_user\library\Constant;
use s_user\library\TableName;

/**
 * Amcas class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-04-06 14:43:06Z Code Generator $
 * @package s_user.db
 * @since 1.0
 */
class Amcas extends Db
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = Constant::DB_CLUSTER;

	/**
	 * 通过主键，查询一条记录
	 * @param integer $amcaId
	 * @return array
	 */
	public function findByAmcaId($amcaId)
	{
		if (($amcaId = (int) $amcaId) <= 0) {
			return false;
		}

		$tableName = TableName::getAmcas();
		$sql = 'SELECT `amca_id`, `amca_pid`, `amca_name`, `prompt`, `sort`, `category` FROM `' . $tableName . '` WHERE `amca_id` = ?';
		return $this->fetch($sql, $amcaId);
	}

	/**
	 * 获取所有的应用提示
	 * @return array
	 */
	public function findAppPrompts()
	{
		$tableName = TableName::getAmcas();
		$sql = 'SELECT `amca_id`, `prompt` FROM `' . $tableName . '` WHERE `category` = ? ORDER BY `sort`';
		return $this->fetchPairs($sql, 'app');
	}

	/**
	 * 通过父ID，获取所有的子事件
	 * @param integer $amcaPid
	 * @return array
	 */
	public function findAllByAmcaPid($amcaPid)
	{
		if (($amcaPid = (int) $amcaPid) <= 0) {
			return false;
		}

		$tableName = TableName::getAmcas();
		$sql = 'SELECT `amca_id`, `amca_pid`, `amca_name`, `prompt`, `sort`, `category` FROM `' . $tableName . '` WHERE `amca_pid` = ? ORDER BY `sort`';
		return $this->fetchAll($sql, $amcaPid);
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
			foreach ($mods as $mRows) {
				$data[] = $mRows;

				$ctrls = $this->findAllByAmcaPid($mRows['amca_id']);
				if ($ctrls && is_array($ctrls)) {
					foreach ($ctrls as $cRows) {
						$cRows['amca_name'] = $padStr . $cRows['amca_name'];
						$data[] = $cRows;
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
	 * 通过父ID和事件名统计记录数
	 * @param integer $amcaPid
	 * @param string $amcaName
	 * @return integer
	 */
	public function countByPidAndName($amcaPid, $amcaName)
	{
		if (($amcaPid = (int) $amcaPid) <= 0 || ($amcaName = trim($amcaName)) === '') {
			return false;
		}

		$tableName = TableName::getAmcas();
		$sql = 'SELECT COUNT(*) FROM `' . $tableName . '` WHERE `amca_pid` = ? AND `amca_name` = ?';
		$params = array(
			'amca_pid' => $amcaPid,
			'amca_name' => $amcaName
		);

		return $this->fetchColumn($sql, $params);
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		if (!isset($params['amca_pid']) || !isset($params['amca_name']) || !isset($params['category'])) {
			return false;
		}

		if (($amcaPid = (int) $params['amca_pid']) < 0) {
			return false;
		}

		if (($amcaName = trim($params['amca_name'])) === '') {
			return false;
		}

		if (($category = trim($params['category'])) === '') {
			return false;
		}

		$sort = isset($params['sort']) ? (int) $params['sort'] : 0;
		if ($sort < 0) {
			return false;
		}

		$prompt = isset($params['prompt']) ? trim($params['prompt']) : '';

		$tableName = TableName::getAmcas();
		$attributes = array(
			'amca_pid' => $amcaPid,
			'amca_name' => $amcaName,
			'prompt' => $prompt,
			'sort' => $sort,
			'category' => $category
		);

		$sql = $this->getCommandBuilder()->createInsert($tableName, array_keys($attributes));
		return $this->insert($sql, $attributes);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $amcaId
	 * @param array $params
	 * @return array
	 */
	public function modify($amcaId, array $params = array())
	{
		if (($amcaId = (int) $amcaId) <= 0) {
			return false;
		}

		$attributes = array();

		if (isset($params['amca_pid'])) {
			if (($amcaPid = (int) $params['amca_pid']) < 0) {
				return false;
			}

			$attributes['amca_pid'] = $amcaPid;
		}

		if (isset($params['amca_name'])) {
			if (($amcaName = trim($params['amca_name'])) === '') {
				return false;
			}

			$attributes['amca_name'] = $amcaName;
		}

		if (isset($params['prompt'])) {
			$attributes['prompt'] = trim($params['prompt']);
		}

		if (isset($params['sort'])) {
			if (($sort = (int) $params['sort']) < 0) {
				return false;
			}

			$attributes['sort'] = $sort;
		}

		if (isset($params['category'])) {
			if (($category = trim($params['category'])) === '') {
				return false;
			}

			$attributes['category'] = $category;
		}

		if ($attributes === array()) {
			return false;
		}

		$tableName = TableName::getAmcas();
		$sql = $this->getCommandBuilder()->createUpdate($tableName, array_keys($attributes), '`amca_id` = ?');
		$attributes['amca_id'] = $amcaId;
		return $this->update($sql, $attributes);
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $amcaId
	 * @return boolean
	 */
	public function remove($amcaId)
	{
		if (($amcaId = (int) $amcaId) <= 0) {
			return false;
		}

		$tableName = TableName::getAmcas();
		$sql = $this->getCommandBuilder()->createDelete($tableName, '`amca_id` = ?');
		return $this->delete($sql, $amcaId);
	}

}
