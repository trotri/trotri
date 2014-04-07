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
 * DbAmcas class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DbAmcas.php 1 2014-04-06 14:43:06Z Code Generator $
 * @package smods.ucenter
 * @since 1.0
 */
class DbAmcas extends BaseDb
{
	/**
	 * 构造方法：初始化表名
	 * @param integer $tableNum
	 */
	public function __construct($tableNum = -1)
	{
		parent::__construct('user_amcas', $tableNum);
	}

}
