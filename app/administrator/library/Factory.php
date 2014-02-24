<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use tfc\ap\Singleton;
use tfc\saf\DbProxy;

/**
 * Factory class file
 * 对象工厂类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Factory.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Factory
{
	/**
	 * 获取业务处理层类
	 * @param string $className
	 * @param string $moduleName
	 * @return tdo\Model
	 */
	public static function getModel($className, $moduleName)
	{
		$className = 'modules\\' . $moduleName . '\\model\\' . $className;
		return Singleton::getInstance($className);
	}
}
