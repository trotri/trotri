<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace ucenter\models;

use srv\FormProcessor;
use ucenter\library\Lang;
use ucenter\library\TableNames;
use tfc\validator\AlphaValidator;
use tfc\validator\EqualValidator;
use tfc\validator\MinLengthValidator;
use tfc\validator\MaxLengthValidator;
use tfc\validator\NumericValidator;
use tfc\validator\DbExistsValidator;
use tfc\validator\DbExists2Validator;

/**
 * FpAmcas class file
 * 业务层：表单数据处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FpAmcas.php 1 2014-04-06 14:43:06Z huan.song $
 * @package ucenter.models
 * @since 1.0
 */
class FpAmcas extends FormProcessor
{
	/**
	 * (non-PHPdoc)
	 * @see srv.FormProcessor::process()
	 */
	public function process(array $params = array(), $id = 0)
	{
		$this->id = (int) $id;
		if ($this->isUpdate() && $this->id <= 0) {
			return false;
		}

		if ($this->isInsert()) {
			if (!$this->required($params, 'amca_name', 'amca_pid', 'category')) {
				return false;
			}
		}

		if (isset($params['amca_pid'])) {
			$amcaPid = (int) $params['amca_pid'];
			if (!$this->isValid('amca_pid', $amcaPid, $this->getAmcaPidRule($amcaPid))) {
				return false;
			}
		}
		else {
			$amcaPid = $this->_object->getAmcaPidByAmcaId($this->id);
			if ($amcaPid < 0) {
				return false;
			}

			$this->amca_pid = $amcaPid;
		}

		$this->run($params, 'amca_name', 'category', 'prompt', 'sort');
		return !$this->hasError();
	}

	/**
	 * 验证“父ID”
	 * @param integer $value
	 * @return array
	 */
	public function getAmcaPidRule($value)
	{
		return array(
			'DbExistsValidator' => new DbExistsValidator($value, true, Lang::_('UCENTER_FILTER_USER_AMCAS_AMCA_PID_EXISTS'), $this->getDbProxy(), TableNames::getAmcas(), 'amca_pid')
		);
	}

	/**
	 * 验证“事件名”
	 * @param string $value
	 * @return array
	 */
	public function getAmcaNameRule($value)
	{
		if ($this->isUpdate()) {
			if ($this->_object->getAmcaNameByAmcaId($this->id) === $value) {
				return array();
			}
		}

		return array(
			'MinLengthValidator' => new MinLengthValidator($value, 2, Lang::_('UCENTER_FILTER_USER_AMCAS_AMCA_NAME_MINLENGTH')),
			'MaxLengthValidator' => new MaxLengthValidator($value, 16, Lang::_('UCENTER_FILTER_USER_AMCAS_AMCA_NAME_MAXLENGTH')),
			'AlphaValidator' => new AlphaValidator($value, true, Lang::_('UCENTER_FILTER_USER_AMCAS_AMCA_NAME_ALPHA')),
			'DbExists2Validator' => new DbExists2Validator($value, false, Lang::_('UCENTER_FILTER_USER_AMCAS_AMCA_NAME_UNIQUE'), $this->getDbProxy(), TableNames::getAmcas(), 'amca_name', 'amca_pid', $this->amca_pid)
		);
	}

	/**
	 * 验证“类型”，只能新增或编辑“模块”类型
	 * @param string $value
	 * @return array
	 */
	public function getCategoryRule($value)
	{
		return array(
			'EqualValidator' => new EqualValidator($value, DataAmcas::CATEGORY_MOD, Lang::_('UCENTER_FILTER_USER_AMCAS_CATEGORY_EQUAL'))
		);
	}

	/**
	 * 验证“提示”
	 * @param string $value
	 * @return array
	 */
	public function getPromptRule($value)
	{
		return array(
			'MinLengthValidator' => new MinLengthValidator($value, 2, Lang::_('UCENTER_FILTER_USER_AMCAS_PROMPT_MINLENGTH')),
			'MaxLengthValidator' => new MaxLengthValidator($value, 50, Lang::_('UCENTER_FILTER_USER_AMCAS_PROMPT_MAXLENGTH'))
		);
	}

	 /**
	  * 验证“排序”
	  * @param integer $value
	  * @return array
	  */
	public function getSortRule($value)
	{
		return array(
			'NumericValidator' => new NumericValidator($value, true, Lang::_('UCENTER_FILTER_USER_AMCAS_SORT_NUMERIC')),
		);
	}
}
