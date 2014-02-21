<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\model;

use library\Model;
use library\BuilderFactory;
use library\ErrorNo;
use modules\builder\data;

/**
 * Types class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Types.php 1 2014-01-07 18:07:20Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Types extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = BuilderFactory::getDb('Types');
		parent::__construct($db);
	}
}
