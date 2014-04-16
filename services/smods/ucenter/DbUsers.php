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

use slib\BaseDb;

/**
 * DbUsers class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DbUsers.php 1 2014-04-15 14:43:50Z Code Generator $
 * @package smods.ucenter
 * @since 1.0
 */
class DbUsers extends BaseDb
{
	/**
	 * 构造方法：初始化表名
	 * @param integer $tableNum
	 */
	public function __construct($tableNum = -1)
	{
		parent::__construct('users', $tableNum);
	}

	/**
	 * 查询数据
	 * @param array $attributes
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(array $attributes = array(), $order, $limit, $offset)
	{
		$commandBuilder = $this->getCommandBuilder();
		$tblprefix = $this->getDbProxy()->getTblprefix();

		$command = 'SELECT SQL_CALC_FOUND_ROWS `u`.*, `g`.`group_id` FROM `' . $tblprefix . 'users` AS `u`';
		$command .= ' LEFT JOIN `' . $tblprefix . 'user_usergroups_map` AS `g`';
		$command .= ' ON `u`.`user_id` = `g`.`user_id`';

		$condition = '1';
		foreach ($attributes as $columnName => $value) {
			$alias = ($columnName === 'group_id') ? '`g`' : '`u`';
			$condition .= ' AND ' . $alias . '.' . $commandBuilder->quoteColumnName($columnName) . ' = ' . $commandBuilder::PLACE_HOLDERS;
		}

		$command = $commandBuilder->applyCondition($command, $condition);
		$command = $commandBuilder->applyOrder($command, $order);
		$command = $commandBuilder->applyLimit($command, $limit, $offset);

		return $this->getDbProxy()->fetchAll($command, $attributes);
	}

}
