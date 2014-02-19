<?php
/**
 * Trotri
 *
 * @author	Huan Song <trotri@yeah.net>
 * @link	  http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library;

use tfc\ap\Ap;
use tfc\ap\ErrorException;
use tfc\util\Paginator;
use tfc\saf\Cfg;
use tfc\saf\Text;

/**
 * Util class file
 * 小工具集合类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Util.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Util
{
	/**
	 * @var boolean 是否还未知当前语种。如果还未知，从RGP中取；如果RGP中未设置，从配置中取
	 */
	protected static $_unknownLanguageType = true;

	/**
	 * 通过键名获取语言内容
	 * @param string $string
	 * @param boolean $jsSafe
	 * @param boolean $interpretBackSlashes
	 * @return string
	 */
	public static function _($string, $jsSafe = false, $interpretBackSlashes = true)
	{
		if (self::$_unknownLanguageType) {
			self::$_unknownLanguageType = false;
			$type = Ap::getRequest()->getTrim('ol'); // out language type 输出语种
			if ($type !== '') {
				Text::setLanguageType($type);
			}
		}

		return Text::_($string, $jsSafe, $interpretBackSlashes);
	}

	/**
	 * 获取当前页码
	 * @return integer
	 */
	public static function getPageNo()
	{
		$pageVar = self::getPageVar();
		$pageNo = Ap::getRequest()->getInteger($pageVar);
		$pageNo = max($pageNo, 1);
		return $pageNo;
	}

	/**
	 * 获取从$_GET或$_POST中取当前页的键名
	 * @return string
	 */
	public static function getPageVar()
	{
		try {
			$pageVar = Cfg::getApp('page_var', 'paginator');
		}
		catch (ErrorException $e) {
			$pageVar = Paginator::DEFAULT_PAGE_VAR;
		}

		return $pageVar;
	}
}
