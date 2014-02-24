<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\builder;

use slib\BaseDb;

/**
 * DbBuilders class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DbBuilders.php 1 2014-01-18 14:19:29Z huan.song $
 * @package smods.builder
 * @since 1.0
 */
class DbBuilders extends BaseDb
{
	/**
	 * 构造方法：初始化表名
	 * @param integer $tableNum
	 */
	public function __construct($tableNum = -1)
	{
		parent::__construct('builders', $tableNum);
	}
}
