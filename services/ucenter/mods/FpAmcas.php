<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace ucenter\mods;

use tfc\validator\DbExists2Validator;

use srv\FormProcessor;
use ucenter\library\Lang;
use tfc\validator\AlphaValidator;
use tfc\validator\EqualValidator;
use tfc\validator\MinLengthValidator;
use tfc\validator\MaxLengthValidator;
use tfc\validator\NumericValidator;
use tfc\validator\DbExistsValidator;

/**
 * FpAmcas class file
 * 业务层：表单数据处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FpAmcas.php 1 2014-04-06 14:43:06Z huan.song $
 * @package ucenter.mods
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
		if ($this->isInsert()) {
			if (!$this->required($params, 'amca_name', 'amca_pid', 'category')) {
				return false;
			}
		}
		else {
			if (($amcaId = (int) $id) <= 0) {
				return false;
			}
		}

		if (isset($params['amca_pid'])) {
			$amcaPid = (int) $params['amca_pid'];
			if (!$this->isValidAmcaPid($amcaPid)) {
				return false;
			}
		}
		else {
			$amcaPid = $this->_object->getAmcaPidByAmcaId($amcaId);
			if ($amcaPid < 0) {
				return false;
			}
		}

		if (isset($params['amca_name'])) {
			$this->isValidAmcaName($params['amca_name'], $amcaId, $amcaPid);
		}

		$this->run($params, 'category', 'prompt', 'sort');
		return !$this->hasError();
	}

	/**
	 * 验证“父ID”
	 * @param integer $value
	 * @return boolean
	 */
	public function getAmcaPidRule($value)
	{
		return array(
			'DbExistsValidator' => new DbExistsValidator($value, true, Lang::_('FILTER_USER_AMCAS_AMCA_PID_EXISTS'), $this->getDbProxy(), 'amcas', 'amca_pid')
		);
	}

	/**
	 * 验证“事件名”
	 * @param string $value
	 * @param integer $amcaId
	 * @param integer $amcaPid
	 * @return array
	 */
	public function getAmcaNameRule($value, $amcaId, $amcaPid)
	{
		return array(
			'MinLengthValidator' => new MinLengthValidator($value, 2, Lang::_('FILTER_USER_AMCAS_AMCA_NAME_MINLENGTH')),
			'MaxLengthValidator' => new MaxLengthValidator($value, 16, Lang::_('FILTER_USER_AMCAS_AMCA_NAME_MAXLENGTH')),
			'AlphaValidator' => new AlphaValidator($value, true, Lang::_('FILTER_USER_AMCAS_AMCA_NAME_ALPHA')),
			'DbExists2Validator' => new DbExists2Validator($value, true, Lang::_('FILTER_USER_AMCAS_AMCA_NAME_UNIQUE'), $this->getDbProxy(), 'amcas', 'amca_name', 'amca_pid', $amcaPid)
		);
	}

	/**
	 * 验证“类型”，只能新增或编辑“模块”类型
	 * @param string $value
	 * @return boolean
	 */
	public function getCategoryRule($value)
	{
		return array(
			'EqualValidator' => new EqualValidator($value, DataAmcas::CATEGORY_MOD, Lang::_('FILTER_USER_AMCAS_CATEGORY_EQUAL'))
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
			'MinLengthValidator' => new MinLengthValidator($value, 2, Lang::_('FILTER_USER_AMCAS_PROMPT_MINLENGTH')),
			'MaxLengthValidator' => new MaxLengthValidator($value, 50, Lang::_('FILTER_USER_AMCAS_PROMPT_MAXLENGTH'))
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
			'NumericValidator' => new NumericValidator($value, true, Lang::_('FILTER_USER_AMCAS_SORT_NUMERIC')),
		);
	}
}
