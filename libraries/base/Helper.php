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

use tfc\ap\Singleton;

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
	 * @var string 列表GlyphIcon
	 */
	const GLYPHICON_INDEX = 'list';

	/**
	 * @var string 加号GlyphIcon
	 */
	const GLYPHICON_CREATE = 'plus-sign';

	/**
	 * @var string 编辑笔GlyphIcon
	 */
	const GLYPHICON_PENCIL = 'pencil';

	/**
	 * @var string 回收站GlyphIcon
	 */
	const GLYPHICON_TRASH = 'trash';

	/**
	 * @var instance of tfc\mvc\Html
	 */
	protected $_html = null;

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

	/**
	 * 获取美化版“是|否”选择项表单元素
	 * @return string
	 */
	public function getSwitchLabel($name, $value = 'n')
	{
		static $attributes = array(
			'id'             => 'label-switch',
			'class'          => 'make-switch switch-small',
			'data-on-label'  => '是',
			'data-off-label' => '否'
		);

		$html = $this->getHtml();
		return $html->tag('div', $attributes, $html->radio($name, $value, ($value === 'y')));
	}

	/**
	 * 获取图标按钮
	 * @param string $type
	 * @param string $url
	 * @param string $title
	 * @param string $placement
	 * @return string
	 */
	public function getGlyphicon($type, $onclick, $title, $placement = 'left')
	{
		$attributes = array(
			'class'               => 'glyphicon glyphicon-' . $type,
			'data-toggle'         => 'tooltip',
			'data-placement'      => $placement,
			'data-original-title' => $title,
			'onclick'             => 'return ' . $onclick . ';'
		);

		return $this->getHtml()->tag('span', $attributes, '');
	}

	/**
	 * 获取页面辅助类
	 * @return tfc\mvc\Html
	 */
	public function getHtml()
	{
		if ($this->_html === null) {
			$this->_html = Singleton::getInstance('\\tfc\\mvc\\Html');
		}

		return $this->_html;
	}
}
