<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\model;

use tfc\saf\Log;
use koala\Model;
use library\ErrorNo;
use library\UcenterFactory;

/**
 * UserGroups class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UserGroups.php 1 2014-02-11 15:51:13Z huan.song $
 * @package modules.ucenter.model
 * @since 1.0
 */
class UserGroups extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = UcenterFactory::getDb('UserGroups');
		parent::__construct($db);
	}

	/**
	 * 编辑多条记录
	 * @param integer $userId
	 * @param array $groupIds
	 * @return array
	 */
	public function modify($userId, $groupIds)
	{
		/*
		$userId = (int) $userId;
		if ()
		
		$a = $this->findAllByAttributes();
		
		array $attributes = array(), $order = '', $limit = 0, $offset = 0, $option = ''
		
		$groupIds = (array) $groupIds;

		*/
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
				'%s user id "%d"', $errMsg, $value
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
