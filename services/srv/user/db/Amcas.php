<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv\user\db;

use srv\library\Db;
use srv\user\library\Constant;
use srv\user\library\TableNames;

/**
 * Amcas class file
 * 数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-04-06 14:43:06Z huan.song $
 * @package srv.user.db
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

		$tableName = $this->getTblprefix() . TableNames::getAmcas();
		$sql = 'SELECT ';
		$sql .= '`a`.`amca_id`, `a`.`amca_pid`, `a`.`amca_name`, `a`.`prompt`, `a`.`sort`, `a`.`category`, `b`.`amca_name` AS `amca_pname`, `b`.`prompt` AS `pprompt` ';
		$sql .= 'FROM `' . $tableName . '` AS `a` LEFT JOIN `' . $tableName . '` AS `b` ';
		$sql .= 'ON `a`.`amca_pid` = `b`.`amca_id` WHERE `a`.`amca_id` = ?';

		return $this->fetch($sql, $amcaId);
	}

	/**
	 * 获取所有的应用提示
	 * @return array
	 */
	public function findAppPrompts()
	{
		$tableName = $this->getTblprefix() . TableNames::getAmcas();
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

		$tableName = $this->getTblprefix() . TableNames::getAmcas();
		$sql = 'SELECT `amca_id`, `amca_pid`, `amca_name`, `prompt`, `sort`, `category` FROM `' . $tableName . '` WHERE `amca_pid` = ? ORDER BY `sort`';
		return $this->fetchAll($sql, $amcaPid);
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

		$tableName = $this->getTblprefix() . TableNames::getAmcas();
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
	 * @param boolean $ignore
	 * @return integer|false
	 */
	public function create(array $params = array(), $ignore = false)
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

		$tableName = $this->getTblprefix() . TableNames::getAmcas();
		$attributes = array(
			'amca_pid' => $amcaPid,
			'amca_name' => $amcaName,
			'prompt' => $prompt,
			'sort' => $sort,
			'category' => $category
		);

		$sql = $this->getCommandBuilder()->createInsert($tableName, array_keys($attributes), $ignore);
		return $this->insert($sql, $attributes);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $amcaId
	 * @param array $params
	 * @return integer|false
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

		$tableName = $this->getTblprefix() . TableNames::getAmcas();
		$sql = $this->getCommandBuilder()->createUpdate($tableName, array_keys($attributes), '`amca_id` = ?');
		$attributes['amca_id'] = $amcaId;
		return $this->update($sql, $attributes);
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $amcaId
	 * @return integer|false
	 */
	public function remove($amcaId)
	{
		if (($amcaId = (int) $amcaId) <= 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getAmcas();
		$sql = $this->getCommandBuilder()->createDelete($tableName, '`amca_id` = ?');
		return $this->delete($sql, $amcaId);
	}

}
