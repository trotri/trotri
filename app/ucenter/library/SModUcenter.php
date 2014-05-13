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

use srv\SModFactory;

/**
 * SModUcenter class file
 * 模型类单例管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SModUcenter.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class SModUcenter
{
	/**
	 * @var string 业务名
	 */
	const SRV_NAME = 'ucenter';

	/**
	 * 根据类名获取类的实例，适用于类的构造方法没有参数，如果类的构造方法有参数，不能只通过类名区分不同的类
	 * @param string $modName
	 * @return instance of srv\Model
	 */
	public static function getInstance($modName)
	{
		return SModFactory::getInstance($modName, self::SRV_NAME);
	}
}
