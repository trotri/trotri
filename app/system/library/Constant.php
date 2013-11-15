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

/**
 * Constant class file
 * 常用常量类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Constant.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library
 * @since 1.0
 */
class Constant
{
	/**
	 * @var integer 业务辅助层：表格类型
	 */
	const M_H_TYPE_TABLE = 1;

	/**
	 * @var integer 业务辅助层：表单类型
	 */
	const M_H_TYPE_FORM = 2;

	/**
	 * @var integer 业务辅助层：验证规则类型
	 */
	const M_H_TYPE_RULE = 3;

	/**
	 * @var string 数据库配置名
	 */
	const DB_CLUSTER            = 'system';

}
