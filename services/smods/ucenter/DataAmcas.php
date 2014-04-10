<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\ucenter;

use tfc\ap\Registry;
use slib\BaseData;
use slib\Model;
use smods\ucenter\ModAmcas;

/**
 * DataAmcas class file
 * 业务层：数据管理类，寄存常量、选项、验证规则
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataAmcas.php 1 2014-04-06 14:43:06Z Code Generator $
 * @package smods.ucenter
 * @since 1.0
 */
class DataAmcas extends BaseData
{
	/**
	 * @var string 类型：app
	 */
	const CATEGORY_APP = 'app';

	/**
	 * @var string 类型：mod
	 */
	const CATEGORY_MOD = 'mod';

	/**
	 * @var string 类型：ctrl
	 */
	const CATEGORY_CTRL = 'ctrl';

	/**
	 * @var string 类型：act
	 */
	const CATEGORY_ACT = 'act';

	/**
	 * 获取“应用”所有选项
	 * @return array
	 */
	public function getAppEnum()
	{
		static $enum = null;
		if ($enum === null) {
			$mod = Model::getInstance('Amcas', 'ucenter', $this->getLanguage());
			$enum = $mod->getAppPrompts();
		}

		return $enum;
	}

	/**
	 * 获取“类型”所有选项
	 * @return array
	 */
	public function getCategoryEnum()
	{
		return array(
			self::CATEGORY_APP => $this->_('MOD_UCENTER_USER_AMCAS_ENUM_CATEGORY_APP'),
			self::CATEGORY_MOD => $this->_('MOD_UCENTER_USER_AMCAS_ENUM_CATEGORY_MOD'),
			self::CATEGORY_CTRL => $this->_('MOD_UCENTER_USER_AMCAS_ENUM_CATEGORY_CTRL'),
			self::CATEGORY_ACT => $this->_('MOD_UCENTER_USER_AMCAS_ENUM_CATEGORY_ACT'),
		);
	}

	/**
	 * 获取“事件父ID”验证规则
	 * @return array
	 */
	public function getAmcaPidRule()
	{
		$enum = $this->getAppEnum();
		return array(
			'InArray' => array(
				array_keys($enum), 
				sprintf($this->_('MOD_UCENTER_USER_AMCAS_AMCA_PID_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“事件名”验证规则
	 * @return array
	 */
	public function getAmcaNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_MINLENGTH')),
			'MaxLength' => array(16, $this->_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_MAXLENGTH')),
			'smods\\ucenter\\validator\\UserAmcasAmcaNameUnique' => array(true, $this->_('MOD_UCENTER_USER_AMCAS_AMCA_NAME_UNIQUE'))
		);
	}

	/**
	 * 获取“提示”验证规则
	 * @return array
	 */
	public function getPromptRule()
	{
		return array(
			'MinLength' => array(2, $this->_('MOD_UCENTER_USER_AMCAS_PROMPT_MINLENGTH')),
			'MaxLength' => array(50, $this->_('MOD_UCENTER_USER_AMCAS_PROMPT_MAXLENGTH')),
		);
	}

	/**
	 * 获取“排序”验证规则
	 * @return array
	 */
	public function getSortRule()
	{
		return array(
			'Numeric' => array(true, $this->_('MOD_UCENTER_USER_AMCAS_SORT_NUMERIC')),
		);
	}

	/**
	 * 获取“类型”验证规则
	 * @return array
	 */
	public function getCategoryRule()
	{
		return array(
			'Equal' => array(self::CATEGORY_MOD, $this->_('MOD_UCENTER_USER_AMCAS_CATEGORY_EQUAL')),
		);
	}

}
