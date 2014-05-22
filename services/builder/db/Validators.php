<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace builder\db;

use tdo\DynamicDb;
use builder\library\Constant;

/**
 * Validators class file
 * 数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Validators.php 1 2014-04-06 14:43:06Z huan.song $
 * @package builder.db
 * @since 1.0
 */
class Validators extends DynamicDb
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = Constant::DB_CLUSTER;

}
