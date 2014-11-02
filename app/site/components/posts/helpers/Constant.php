<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace components\posts\helpers;

/**
 * Constant class file
 * 常量类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Constant.php 1 2013-04-20 17:11:06Z huan.song $
 * @package components.posts.helpers
 * @since 1.0
 */
class Constant
{
	/**
	 * @var string 查询条件：头条
	 */
	const FIND_TYPE_HEAD = 'head';

	/**
	 * @var string 查询条件：推荐
	 */
	const FIND_TYPE_RECOMMEND = 'recommend';

	/**
	 * @var string 查询条件：类别ID
	 */
	const FIND_TYPE_CATID = 'catid';

	/**
	 * @var array 所有查询条件
	 */
	public static $findTypes = array(
		self::FIND_TYPE_HEAD,
		self::FIND_TYPE_RECOMMEND,
		self::FIND_TYPE_CATID
	);

}
