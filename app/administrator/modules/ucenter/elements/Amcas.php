<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\elements;

use tfc\saf\Text;
use ui\ElementCollections;
use library\UcenterFactory;

/**
 * Amcas class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-01-06 16:47:52Z huan.song $
 * @package modules.ucenter.elements
 * @since 1.0
 */
class Amcas extends ElementCollections
{
	/**
	 * @var string category：app
	 */
	const CATEGORY_APP = 'app';

	/**
	 * @var string category：mod
	 */
	const CATEGORY_MOD = 'mod';

	/**
	 * @var string category：ctrl
	 */
	const CATEGORY_CTRL = 'ctrl';

	/**
	 * @var string category：act
	 */
	const CATEGORY_ACT = 'act';

	/**
	 * @var ui\bootstrap\Components 页面小组件类
	 */
	public $uiComponents = null;

	/**
	 * 构造方法：初始化页面小组件类
	 */
	public function __construct()
	{
		$this->uiComponents = UcenterFactory::getUi('Amcas');
	}

	/**
	 * (non-PHPdoc)
	 * @see ui.ElementCollections::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
		);

		return $output;
	}

	/**
	 * 获取“主键ID”配置
	 * @param integer $type
	 * @return array
	 */
	public function getAmcaId($type)
	{
		$output = array();
		$name = 'amca_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_ID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_ID_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_ID_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“父ID”配置
	 * @param integer $type
	 * @return array
	 */
	public function getAmcaPid($type)
	{
		$output = array();
		$name = 'amca_pid';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'checkbox',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array(), Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_INARRAY')),
			);
		}

		return $output;
	}

	/**
	 * 获取“事件名”配置
	 * @param integer $type
	 * @return array
	 */
	public function getAmcaName($type)
	{
		$output = array();
		$name = 'amca_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array('', Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_MINLENGTH')),
				'MaxLength' => array(16, Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“排序”配置
	 * @param integer $type
	 * @return array
	 */
	public function getSort($type)
	{
		$output = array();
		$name = 'sort';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_SORT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_SORT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_SORT_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(0, Text::_('MOD_UCENTER_USER_AMCAS_SORT_NUMERIC')),
			);
		}

		return $output;
	}

	/**
	 * 获取“类型，app：应用、mod：模块、ctrl：控制器、act：行动”配置
	 * @param integer $type
	 * @return array
	 */
	public function getCategory($type)
	{
		$output = array();
		$options = array(
			self::CATEGORY_APP => self::CATEGORY_APP,
			self::CATEGORY_MOD => self::CATEGORY_MOD,
			self::CATEGORY_CTRL => self::CATEGORY_CTRL,
			self::CATEGORY_ACT => self::CATEGORY_ACT,
		);

		$name = 'category';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_HINT'),
				'options' => $options,
				'value' => self::CATEGORY_APP,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_INARRAY')),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'select',
				'placeholder' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_LABEL'),
			);
		}

		return $output;
	}

}
