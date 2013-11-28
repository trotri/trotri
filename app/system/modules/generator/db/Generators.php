<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\db;

use library\Db;

/**
 * Generators class file
 * 数据库操作层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Generators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.db
 * @since 1.0
 */
class Generators extends Db
{
	/**
	 * 构造方法：初始化表名操作类
	 */
	public function __construct()
	{
		parent::__construct('generators');
	}
}
