<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv;

/**
 * Model abstract class file
 * 业务层：模型基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Model.php 1 2013-05-18 14:58:59Z huan.song $
 * @package srv
 * @since 1.0
 */
abstract class Model
{
	/**
	 * @var array 寄存所有错误信息
	 */
	protected $_errors = array();
}
