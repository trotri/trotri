<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\ucenter;

use tfc\util\Language;
use tfc\saf\Log;
use slib\BaseModel;
use slib\Data;
use slib\ErrorNo;

/**
 * ModUserGroups class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModUserGroups.php 1 2014-04-16 11:28:21Z Code Generator $
 * @package smods.ucenter
 * @since 1.0
 */
class ModUserGroups extends BaseModel
{
	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param tfc\util\Language $language
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct(Language $language, $tableNum = -1)
	{
		$db = new DbUserGroups($tableNum);
		parent::__construct($db, $language);
	}

	/**
	 * 通过用户ID和用户组ID，刷新该用户所有分组
	 * @param integer $userId
	 * @param array $groupIds
	 * @return array
	 */
	public function modify($userId, $groupIds)
	{
		$userId = (int) $userId;
		if ($userId <= 0 || !is_array($groupIds)) {
			$errNo = ErrorNo::ERROR_ARGS_UPDATE;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_UPDATE');
			Log::warning(sprintf(
				'%s user_id "%d", group_ids "%s"', $errMsg, $userId, serialize($groupIds)
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'user_id' => $userId,
				'group_ids' => $groupIds
			);
		}

		$ret = $this->findGroupIdsByUserId($userId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$ret['user_id'] = $userId;
			$ret['group_ids'] = $groupIds;
			return $ret;
		}

		$olds = $ret['data'];
		$news = array();
		foreach ($groupIds as $value) {
			if (($value = (int) $value) > 0) {
				$news[] = $value;
			}
		}

		$groupIdCreates = array_diff($news, $olds);
		$groupIdRemoves = array_diff($olds, $news);

		$rowCountCreate = $this->getDb()->batchCreate($userId, $groupIdCreates);
		$rowCountRemove = $this->getDb()->batchRemove($userId, $groupIdRemoves);

		$totalCreate = count($groupIdCreates);
		$totalRemove = count($groupIdRemoves);

		$errorCreate = $totalCreate - $rowCountCreate;
		$errorRemove = $totalRemove - $rowCountRemove;
		if ($errorCreate > 0 || $errorRemove > 0) {
			$errNo = ErrorNo::ERROR_DB_UPDATE;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_UPDATE');
			Log::warning(sprintf(
				'%s user_id "%d", group_ids "%s", Create {total "%d", success "%d", error "%d"}, Remove {total "%d", success "%d", error "%d"}',
				$errMsg, $userId, serialize($groupIds), $totalCreate, $rowCountCreate, $errorCreate, $totalRemove, $rowCountRemove, $errorRemove
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'user_id' => $userId,
				'group_ids' => $groupIds
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = $this->_('ERROR_MSG_SUCCESS_UPDATE');
		Log::notice(sprintf(
			'%s user_id "%d", group_ids "%s", Create {total "%d", success "%d", error "%d"}, Remove {total "%d", success "%d", error "%d"}',
			$errMsg, $userId, serialize($groupIds), $totalCreate, $rowCountCreate, $errorCreate, $totalRemove, $rowCountRemove, $errorRemove
		), $errNo, __METHOD__);

		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'user_id' => $userId,
			'group_ids' => $groupIds
		);
	}

	/**
	 * 通过用户ID，获取用户组ID
	 * @param integer $value
	 * @return array
	 */
	public function findGroupIdsByUserId($value)
	{
		$value = (int) $value;
		if ($value <= 0) {
			$errNo = ErrorNo::ERROR_ARGS_SELECT;
			$errMsg = $this->_('ERROR_MSG_ERROR_ARGS_SELECT');
			Log::warning(sprintf(
				'%s user_id "%d"', $errMsg, $value
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$ret = $this->findColumnsByAttributes(array('group_id'), array('user_id' => $value));
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$data = array();
		foreach ($ret['data'] as $row) {
			$data[] = (int) $row['group_id'];
		}

		$ret['data'] = $data;
		return $ret;
	}
}