<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace s_user\library;

use srv;

/**
 * TableName class file
 * 表名管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TableName.php 1 2013-04-05 01:08:06Z huan.song $
 * @package s_user.library
 * @since 1.0
 */
class TableName extends srv\TableName
{
	/**
	 * @var string 数据库配置名
	 */
	protected static $_clusterName = Constant::DB_CLUSTER;

	/**
	 * 获取“用户可访问的事件表”表名
	 * @return string
	 */
	public static function getAmcas()
	{
		return self::getTblprefix() . 'user_amcas';
	}
}
