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
	 * 获取公用RGP参数，并设置到对象工厂类中
	 * @return array
	 */
	public static function initRequestArgs()
	{
		$od = Ap::getRequest()->getTrim('od');
		if ($od !== '') {
			$od = strtoupper($od);
			if (in_array($od, Factory::$dataTypes)) {
				Factory::$od = $od;
			}
			else {
				return array(
					'err_no' => ErrorNo::ERROR_REQUEST,
					'err_msg' => Text::_('ERROR_MSG_ERROR_REQUEST_OD_ERR'),
				);
			}
		}

		$ie = Ap::getRequest()->getTrim('ie');
		if ($ie !== '') {
			$ie = strtoupper($ie);
			if (in_array($ie, Factory::$encoders)) {
				Factory::$ie = $ie;
			}
			else {
				return array(
					'err_no' => ErrorNo::ERROR_REQUEST,
					'err_msg' => Text::_('ERROR_MSG_ERROR_REQUEST_IE_ERR'),
				);
			}
		}

		$ol = Ap::getRequest()->getTrim('ol');
		if ($ol !== '') {
			$ol = strtolower(substr($ol, 0, 2)) . '_' . strtoupper(substr($ol, -2));
			if (in_array($ol, Factory::$encoders)) {
				Factory::$ol = $ol;
			}
			else {
				return array(
					'err_no' => ErrorNo::ERROR_REQUEST,
					'err_msg' => Text::_('ERROR_MSG_ERROR_REQUEST_OL_ERR'),
				);
			}
		}

		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => Text::_('ERROR_MSG_SUCCESS_NUM'),
		);
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
