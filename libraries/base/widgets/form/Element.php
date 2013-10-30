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
 * Element abstract class file
 * 表单元素基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Element.php 1 2013-10-30 23:11:59Z huan.song $
 * @package base.widgets.form
 * @since 1.0
 */
abstract class Element
{	
	/**
	 * @var string 文本输入类表单元素，如：text、textarea、password等
	 */
	const CATEGORY_TEXT = 'text';

	/**
	 * @var string 选项类表单元素，如：radio、checkbox、select等
	 */
	const CATEGORY_OPTION = 'option';

	/**
	 * @var string 按钮类表单元素，如：button、submit、reset等
	 */
	const CATEGORY_BUTTON = 'button';

	/**
	 * @var array 寄存所有的表单元素大类型
	 */
	public static $categories = array (
		self::CATEGORY_TEXT,
		self::CATEGORY_OPTION,
		self::CATEGORY_BUTTON
	);

	/**
	 * @var string 表单元素所属的大类型
	 */
	public $category = '';

	/**
	 * @var string 类型
	 */
	public $type = '';

	/**
	 * @var string 名称
	 */
	public $name = '';

	/**
	 * @var string 默认值
	 */
	public $value = '';

	/**
	 * @var string Label
	 */
	public $label = '';

	/**
	 * @var boolean 是否必填
	 */
	public $required = false;

	/**
	 * @var string 用户输入提示
	 */
	public $prompt = '';

	/**
	 * @var string 错误提示
	 */
	public $error = '';

	public function run()
	{
		$html = '<div class="form-group ">';
  		$html .= '<label class="col-lg-2 control-label">' . $this->label . ($this->required ? '*' : '') . '</label>';
  		$html .= '<div class="col-lg-4">';
    	$html .= '<input type="text" class="form-control input-sm" name="generator_name">';
  		$html .= '</div>';
  		$html .= '<span class="control-label"></span>';
		$html .= '</div>';
	}

	/**
	 * 验证表单元素所属的大类型是否是文本输入类
	 * @return boolean
	 */
	public function isCategoryText()
	{
		return $this->category === self::CATEGORY_TEXT;
	}

	/**
	 * 验证表单元素所属的大类型是否是选项类
	 * @return boolean
	 */
	public function isCategoryOption()
	{
		return $this->category === self::CATEGORY_OPTION;
	}

	/**
	 * 验证表单元素所属的大类型是否是按钮类
	 * @return boolean
	 */
	public function isCategoryButton()
	{
		return $this->category === self::CATEGORY_BUTTON;
	}
}
