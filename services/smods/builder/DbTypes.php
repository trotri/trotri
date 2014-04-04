<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\builder;

use slib\BaseDb;

/**
 * DbTypes class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DbTypes.php 1 2014-04-04 13:49:20Z Code Generator $
 * @package smods.builder
 * @since 1.0
 */
class DbTypes extends BaseDb
{
	/**
	 * 构造方法：初始化表名
	 * @param integer $tableNum
	 */
	public function __construct($tableNum = -1)
	{
		parent::__construct('builder_types', $tableNum);
	}

}
