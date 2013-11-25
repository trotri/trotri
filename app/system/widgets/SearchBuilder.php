<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace koala\widgets;

use tfc\mvc\Widget;

/**
 * FormBuilder class file
 * 表单处理类，基于Bootstrap-CSS框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FormBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package koala.widgets
 * @since 1.0
 */
class SearchBuilder extends Widget
{
	public $className = 'form-control input-sm';

	public function getText($name, $value, $label)
	{
		return $this->getHtml()->text($name, $value, array('class' => $this->className, 'placeholder' => $label));
	}

	public function getSelect($name, $data, $value, $label)
	{
		$html = $this->getHtml();
		$output = '';
		$output .= $html->openSelect($name, array('class' => $this->className));
		$output .= $html->options($data, $value);
		$output .= $html->closeSelect();
		return $output;
	}

	public function getHr()
	{
		return $this->getHtml()->tag('hr', array('class' => 'hr-condensed'));
	}	
}
