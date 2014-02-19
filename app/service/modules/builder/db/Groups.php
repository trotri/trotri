<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\db;

use library\Db;

/**
 * Groups class file
 * 数据库操作层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2014-01-19 13:18:49Z huan.song $
 * @package modules.builder.db
 * @since 1.0
 */
class Groups extends Db
{
	/**
	 * 构造方法：初始化表名
	 */
	public function __construct()
	{
		parent::__construct('builder_field_groups');
	}

}
