<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\db;

use library\UcenterFactory;

use library\Db;

/**
 * Users class file
 * 数据库操作层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Users.php 1 2014-02-11 15:23:39Z huan.song $
 * @package modules.ucenter.db
 * @since 1.0
 */
class Users extends Db
{
	/**
	 * 构造方法：初始化表名
	 */
	public function __construct()
	{
		parent::__construct('users');
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
		$tblUsers = $this->getQuoteTableName();
		$tblAliasUsers = $commandBuilder->quoteColumnName('u');
		$tblGroups = UcenterFactory::getDb('UserGroups')->getQuoteTableName();
		$tblAliasGroups = $commandBuilder->quoteColumnName('g');
		$columnPk = $commandBuilder->quoteColumnName('user_id');
		$columnNames = $commandBuilder->quoteColumnNames($this->getTableSchema()->columnNames);
		if (($index = array_search($columnPk, $columnNames)) !== false) {
			unset($columnNames[$index]);
		}

		$command = 'SELECT SQL_CALC_FOUND_ROWS ' . $tblAliasUsers . '.' . $columnPk . ', ' . implode(', ', $columnNames) . ' FROM ' . $tblUsers . ' AS ' . $tblAliasUsers;
		$command .= ' LEFT JOIN ' . $tblGroups . ' AS ' . $tblAliasGroups . ' ON ' . $tblAliasUsers . '.' . $columnPk . ' = ' . $tblAliasGroups . '.' . $columnPk;

		$condition = '1';
		foreach ($attributes as $columnName => $value) {
			$alias = ($columnName === 'group_id') ? $tblAliasGroups : $tblAliasUsers;
			$condition .= ' AND ' . $alias . '.' . $commandBuilder->quoteColumnName($columnName) . ' = ' . $commandBuilder::PLACE_HOLDERS;
		}

		$command = $commandBuilder->applyCondition($command, $condition);
		$command = $commandBuilder->applyOrder($command, $order);
		$command = $commandBuilder->applyLimit($command, $limit, $offset);

		return $this->getDbProxy()->fetchAll($command, $attributes);
	}

}
