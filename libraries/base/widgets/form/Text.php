<?php
/**
 * Trotri Base Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace base\widgets\form;

/**
 * Text class file
 * 表单Element：<input type="text">
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Text.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.widgets.form
 * @since 1.0
 */
class Text
{
	/**
	 * @var string 表单元素类型
	 */
	public $type = '';
	
	/**
	 * @var string Label
	 */
	public $label = '';
	
	/**
	 * @var string 表单元素名
	 */
	public $name = '';
	
	/**
	 * @var string 用户输入提示
	 */
	public $prompt = '';
	
	/**
	 * @var string 表单默认值
	 */
	public $value = '';
	
	/**
	 * @var string 错误提示
	 */
	public $error = '';
}
