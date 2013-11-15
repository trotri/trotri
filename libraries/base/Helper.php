<?php
/**
 * Trotri Base Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace base;

/**
 * Helper abstract class file
 * 业务辅助层基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Helper.php 1 2013-05-18 14:58:59Z huan.song $
 * @package base
 * @since 1.0
 */
abstract class Helper
{
	/**
	 * 获取新增数据的验证规则
	 * @return array
	 */
	public function getInsertRules()
	{
	}

	/**
	 * 获取编辑数据的验证规则
	 * @return array
	 */
	public function getUpdateRules()
	{
	}

	/**
	 * 获取验证数据前的清理规则
	 * @return array
	 */
	public function getBeforeValidatorCleanRules()
	{
	}

	/**
	 * 获取验证数据前的清理规则
	 * @return array
	 */
	public function getAfterValidatorCleanRules()
	{
	}
}
