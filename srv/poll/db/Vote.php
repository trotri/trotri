<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace poll\db;

use tdo\AbstractDb;
use poll\library\Constant;
use poll\library\TableNames;

/**
 * Vote class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Vote.php 1 2014-12-05 17:47:10Z Code Generator $
 * @package poll.db
 * @since 1.0
 */
class Vote extends AbstractDb
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = Constant::DB_CLUSTER;

	/**
	 * 通过投票ID和会员ID，获取会员投票日志
	 * @param integer $pollId
	 * @param integer $memberId
	 * @return array
	 */
	public function getMemberLogs($pollId, $memberId)
	{
		if (($pollId = (int) $pollId) <= 0) {
			return false;
		}

		if (($memberId = (int) $memberId) <= 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getPollMemberLogs();
		$sql = 'SELECT `log_id`, `poll_id`, `member_id`, `option_ids`, `join_count`, `ts_last_modified`, `ip_last_modified` FROM `' . $tableName . '` WHERE `member_id` = ? AND `poll_id` = ?';
		return $this->fetchAssoc($sql, array('member_id' => $memberId, 'poll_id' => $pollId));
	}

	/**
	 * 通过投票ID和游客IP，获取游客投票日志
	 * @param integer $pollId
	 * @param integer $visitorIp
	 * @return array
	 */
	public function getVisitorLogs($pollId, $visitorIp)
	{
		if (($pollId = (int) $pollId) <= 0) {
			return false;
		}

		if (($visitorIp = (int) $visitorIp) < 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getPollVisitorLogs();
		$sql = 'SELECT `log_id`, `poll_id`, `visitor_ip`, `option_ids`, `join_count`, `ts_last_modified` FROM `' . $tableName . '` WHERE `visitor_ip` = ? AND `poll_id` = ?';
		return $this->fetchAssoc($sql, array('visitor_ip' => $visitorIp, 'poll_id' => $pollId));
	}

	/**
	 * 投票-支持会员或游客、支持单选或多选
	 * @param integer $pollId
	 * @param array|integer $optIds
	 * @param integer $visitorIp
	 * @param integer $memberId
	 * @param integer $joinCount
	 * @return boolean
	 */
	public function addVote($pollId, $optIds, $visitorIp, $memberId, $joinCount)
	{
		if (($pollId = (int) $pollId) <= 0) {
			return false;
		}

		$tmpOptIds = (array) $optIds; $optIds = array();
		foreach ($tmpOptIds as $value) {
			if (($value = (int) $value) > 0 && !in_array($value, $optIds)) {
				$optIds[] = $value;
			}
		}

		if ($optIds === array()) {
			return false;
		}

		$visitorIp = (int) $visitorIp;

		$memberId = max((int) $memberId, 0);

		$commands = array();
		$tableName = $this->getTblprefix() . TableNames::getPolloptions();

		foreach ($optIds as $value) {
			$commands[] = array(
				'sql' => 'UPDATE `' . $tableName . '` SET `votes` = `votes` + 1 WHERE `option_id` = ?',
				'params' => $value
			);
		}

		$optIds = implode(',', $optIds);
		$joinCount = max((int) $joinCount, 1);
		$nowTime = time();

		if ($memberId > 0) {
			$tableName = $this->getTblprefix() . TableNames::getPollMemberLogs();
			$commands[] = array(
				'sql' => 'REPLACE `' . $tableName . '` SET `member_id` = ?, `poll_id` = ?, `option_ids` = ?, `join_count` = ?, `ts_last_modified` = ?, `ip_last_modified` = ?',
				'params' => array(
					'member_id' => $memberId,
					'poll_id' => $pollId,
					'option_ids' => $optIds,
					'join_count' => $joinCount,
					'ts_last_modified' => $nowTime,
					'ip_last_modified' => $visitorIp,
				)
			);
		}
		else {
			$tableName = $this->getTblprefix() . TableNames::getPollVisitorLogs();
			$commands[] = array(
				'sql' => 'REPLACE `' . $tableName . '` SET `visitor_ip` = ?, `poll_id` = ?, `option_ids` = ?, `join_count` = ?, `ts_last_modified` = ?',
				'params' => array(
					'visitor_ip' => $visitorIp,
					'poll_id' => $pollId,
					'option_ids' => $optIds,
					'join_count' => $joinCount,
					'ts_last_modified' => $nowTime,
				)
			);
		}

		return $this->doTransaction($commands);
	}
}
