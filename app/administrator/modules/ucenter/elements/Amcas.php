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

use tfc\ap\Ap;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use ui\ElementCollections;
use library\UcenterFactory;

/**
 * Amcas class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-01-22 16:43:52Z huan.song $
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
				'required' => true,
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
				'callback' => array($this->uiComponents, 'getAmcaNameByAmcaPid')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$amcaPid = UcenterFactory::getModel('Amcas')->getAmcaPid();
			if ($amcaPid > 0) {
				$output = array(
					'__tid__' => 'main',
					'type' => 'hidden',
					'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_LABEL'),
					'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_HINT'),
					'value' => $amcaPid,
				);
			}
			else {
				$output = array(
					'__tid__' => 'main',
					'type' => 'hidden',
					'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_LABEL'),
					'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_HINT'),
					'value' => 0,
				);
			}
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'modules\\ucenter\\validator\\UserAmcasAmcaPidValidator' => array(true, Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_VALIDATOR')),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = array_merge(
				array(0 => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_TOP_LEVEL_LABEL')), 
				UcenterFactory::getModel('Amcas')->getAppAmcas()
			);
		}

		return $output;
	}

	/**
	 * 获取“父类型事件名”配置
	 * @param integer $type
	 * @return array
	 */
	public function getAmcaPname($type)
	{
		$output = array();
		$name = 'amca_pid';

		if ($type === self::TYPE_TABLE) {
			$output = array(
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$amcaPid = UcenterFactory::getModel('Amcas')->getAmcaPid();
			if ($amcaPid > 0) {
				$appAmcas = UcenterFactory::getModel('Amcas')->getAppAmcas();
				$output = array(
					'__tid__' => 'main',
					'type' => 'string',
					'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_LABEL'),
					'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_HINT'),
					'value' => $appAmcas[$amcaPid],
				);
			}
			else {
				$output = array(
					'__tid__' => 'main',
					'type' => 'string',
					'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_LABEL'),
					'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_HINT'),
					'value' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_PID_TOP_LEVEL_LABEL'),
				);
			}
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = array(
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
				'callback' => array($this->uiComponents, 'getAmcaNameUrl')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			if (Mvc::$action === 'create') {
				$output = array(
					'__tid__' => 'main',
					'type' => 'text',
					'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_LABEL'),
					'hint' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_HINT'),
					'required' => true,
				);
			}
			else {
				$output = array(
					'__tid__' => 'main',
					'type' => 'string',
					'label' => Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_LABEL'),
				);
			}
		}
		elseif ($type === self::TYPE_FILTER) {
			$amcaPid = UcenterFactory::getModel('Amcas')->getAmcaPid();
			$output = array(
				'Alpha' => array(true, Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_MINLENGTH')),
				'MaxLength' => array(16, Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_MAXLENGTH')),
				'modules\\ucenter\\validator\\UserAmcasAmcaNameUniqueValidator' => array($amcaPid, Text::_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_UNIQUE_VALIDATOR')),
			);
		}

		return $output;
	}

	/**
	 * 获取“提示”配置
	 * @param integer $type
	 * @return array
	 */
	public function getPrompt($type)
	{
		$output = array();
		$name = 'prompt';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_PROMPT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_PROMPT_LABEL'),
				'hint' => Text::_('MOD_UCENTER_USER_AMCAS_PROMPT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'MinLength' => array(2, Text::_('MOD_UCENTER_USER_AMCAS_PROMPT_MINLENGTH')),
				'MaxLength' => array(50, Text::_('MOD_UCENTER_USER_AMCAS_PROMPT_MAXLENGTH')),
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
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Numeric' => array(true, Text::_('MOD_UCENTER_USER_AMCAS_SORT_NUMERIC')),
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
			self::CATEGORY_APP => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_APP_LABEL'),
			self::CATEGORY_MOD => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_MOD_LABEL'),
			self::CATEGORY_CTRL => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_CTRL_LABEL'),
			self::CATEGORY_ACT => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_ACT_LABEL'),
		);

		$name = 'category';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_LABEL'),
				'callback' => array($this->uiComponents, 'getCategoryLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$amcaPid = UcenterFactory::getModel('Amcas')->getAmcaPid();
			if ($amcaPid > 0) {
				$output = array(
					'__tid__' => 'main',
					'type' => 'string',
					'label' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_LABEL'),
					'hint' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_HINT'),
					'value' => $options[self::CATEGORY_MOD],
				);
			}
			else {
				$output = array(
					'__tid__' => 'main',
					'type' => 'string',
					'label' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_LABEL'),
					'hint' => Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_HINT'),
					'value' => $options[self::CATEGORY_APP],
				);
			}
		}
		elseif ($type === self::TYPE_FILTER) {
			$formOptions = array(
				self::CATEGORY_APP => $options[self::CATEGORY_APP],
				self::CATEGORY_MOD => $options[self::CATEGORY_MOD]
			);
			$output = array(
				'InArray' => array(array_keys($formOptions), sprintf(Text::_('MOD_UCENTER_USER_AMCAS_CATEGORY_INARRAY'), implode(', ', $formOptions))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

}
