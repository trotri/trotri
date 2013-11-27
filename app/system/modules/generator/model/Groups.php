<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\model;

use koala\Model;
use helper\Util;

/**
 * Generators class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Generators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Generators extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = Util::getDb('groups', 'generator');
		parent::__construct($db);
	}

	

	/**
	 * 获取业务辅助类
	 * @return koala\widgets\ElementCollections
	 */
	public function getHelper()
	{
		return Util::getHelper('groups', 'generator');
	}
}
