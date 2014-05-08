<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv\user\mods;

use srv\library\FormProcessor;
use srv\library\Text;

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
 * @package srv.user.mods
 * @since 1.0
 */
class FpAmcas extends FormProcessor
{
	/**
	 * (non-PHPdoc)
	 * @see srv\library.FormProcessor::process()
	 */
	public function process(array $params = array(), $id = 0)
	{
		if (($amcaId = (int) $id) <= 0) {
			return false;
		}

		$amcaPid = 0;
		if (isset($params['amca_pid'])) {
			$amcaPid = (int) $params['amca_pid'];
		}
		else {
			if ($this->isUpdate()) {
				$amcas = $this->_object->findByAmcaId($amcaId);
				if ($amcas && isset($amcas['amca_pid'])) {
					$amcaPid = $amcas['amca_pid'];
				}
				else {
					return false;
				}
			}
		}

		$amcaName = isset($params['amca_name']) ? trim($params['amca_name']) : '';
		$prompt = isset($params['prompt']) ? trim($params['prompt']) : '';
		$category = isset($params['category']) ? trim($params['category']) : DataAmcas::CATEGORY_MOD;
		$sort = isset($params['sort']) ? (int) $params['sort'] : 0;

		$this->isValidAmcaPid($amcaPid);
		$this->isValidAmcaName($amcaName, $amcaId, $amcaPid);
		$this->isValidPrompt($prompt);
		$this->isValidCategory($category);
		$this->isValidSort($sort);

		return !$this->hasError();
	}

	/**
	 * 验证“父ID”
	 * @param integer $amcaPid
	 * @return boolean
	 */
	public function isValidAmcaPid($amcaPid)
	{
		if ($amcaPid !== 0) {
			$dbProxy = $this->_object->getDbProxy();
			$errMsg = Text::_('MOD_USER_USER_AMCAS_AMCA_PID_EXISTS');
			$columnName = 'amca_pid';

			$validator = new DbExistsValidator($amcaPid, true, $errMsg, $dbProxy, 'amcas', 'amca_pid');
			if (!$validator->isValid()) {
				$this->addError($columnName, $validator->getMessage());
				return false;
			}
		}

		$this->amca_pid = $amcaPid;
		return true;
	}

	/**
	 * 验证“事件名”
	 * @param string $amcaName
	 * @param integer $amcaId
	 * @param integer $amcaPid
	 * @return boolean
	 */
	public function isValidAmcaName($amcaName, $amcaId, $amcaPid)
	{
		if ($this->isUpdate()) {
			if ($amcaName === '') {
				return true;
			}

			if ($this->_object->getAmcaNameByAmcaId($amcaId) === $amcaName) {
				return true;
			}
		}

		$columnName = 'amca_name';

		$validator = new MinLengthValidator($amcaName, 2, Text::_('MOD_USER_USER_AMCAS_AMCA_NAME_MINLENGTH'));
		if (!$validator->isValid()) {
			$this->addError($columnName, $validator->getMessage());
			return false;
		}

		$validator = new MaxLengthValidator($amcaName, 16, Text::_('MOD_USER_USER_AMCAS_AMCA_NAME_MAXLENGTH'));
		if (!$validator->isValid()) {
			$this->addError($columnName, $validator->getMessage());
			return false;
		}

		$validator = new AlphaValidator($amcaName, true, Text::_('MOD_USER_USER_AMCAS_AMCA_NAME_ALPHA'));
		if (!$validator->isValid()) {
			$this->addError($columnName, $validator->getMessage());
			return false;
		}

		if ($this->_object->countByPidAndName($amcaPid, $amcaName) > 0) {
			$this->addError($columnName, Text::_('MOD_USER_USER_AMCAS_AMCA_NAME_UNIQUE'));
		}

		$this->amca_name = strtolower($amcaName);
		return true;
	}

	/**
	 * 验证“类型”，只能新增或编辑“模块”类型
	 * @param string $category
	 * @return boolean
	 */
	public function isValidCategory($category)
	{
		if ($this->isUpdate() && $category === '') {
			return true;
		}

		$columnName = 'category';

		$validator = new EqualValidator($category, DataAmcas::CATEGORY_MOD, Text::_('MOD_USER_USER_AMCAS_CATEGORY_EQUAL'));
		if (!$validator->isValid()) {
			$this->addError($columnName, $validator->getMessage());
			return false;
		}

		$this->category = $category;
		return true;
	}

	/**
	 * 验证“提示”
	 * @param string $prompt
	 * @return boolean
	 */
	public function isValidPrompt($prompt)
	{
		if ($this->isUpdate() && $prompt === '') {
			return true;
		}

		$columnName = 'prompt';

		$validator = new MinLengthValidator($prompt, 2, Text::_('MOD_USER_USER_AMCAS_PROMPT_MINLENGTH'));
		if (!$validator->isValid()) {
			$this->addError($columnName, $validator->getMessage());
			return false;
		}

		$validator = new MaxLengthValidator($prompt, 50, Text::_('MOD_USER_USER_AMCAS_PROMPT_MAXLENGTH'));
		if (!$validator->isValid()) {
			$this->addError($columnName, $validator->getMessage());
			return false;
		}

		$this->prompt = $prompt;
		return true;
	}

	/**
	 * 验证“排序”
	 * @param integer $sort
	 * @return boolean
	 */
	public function isValidSort($sort)
	{
		$columnName = 'sort';

		$validator = new NumericValidator($sort, true, Text::_('MOD_USER_USER_AMCAS_SORT_NUMERIC'));
		if (!$validator->isValid()) {
			$this->addError($columnName, $validator->getMessage());
			return false;
		}

		$this->sort = $sort;
		return true;
	}

}
