<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace posts\services;

use libsrv\FormProcessor;
use tfc\validator;
use posts\library\Lang;
use posts\library\TableNames;

/**
 * FpModules class file
 * 业务层：表单数据处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FpModules.php 1 2014-09-11 16:41:01Z Code Generator $
 * @package posts.services
 * @since 1.0
 */
class FpModules extends FormProcessor
{
	/**
	 * (non-PHPdoc)
	 * @see \libsrv\FormProcessor::_process()
	 */
	protected function _process(array $params = array())
	{
		if ($this->isInsert()) {
			if (!$this->required($params, 'module_name', 'module_tblname', 'forbidden', 'description')) {
				return false;
			}
		}

		$this->isValids($params, 'module_name', 'module_tblname', 'forbidden', 'description');
		return !$this->hasError();
	}

	/**
	 * (non-PHPdoc)
	 * @see \libsrv\FormProcessor::_cleanPreProcess()
	 */
	protected function _cleanPreProcess(array $params)
	{
		if ($this->isUpdate()) {
			if (isset($params['module_tblname'])) { unset($params['module_tblname']); }
		}

		$rules = array(
			'builder_name' => 'trim',
			'module_name' => 'trim',
			'module_tblname' => 'trim',
			'forbidden' => 'trim',
		);

		$ret = $this->clean($rules, $params);
		return $ret;
	}

	/**
	 * 获取“模型名称”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getModuleNameRule($value)
	{
		return array(
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_POST_MODULES_MODULE_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_POST_MODULES_MODULE_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“类别表名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getModuleTblnameRule($value)
	{
		return array(
			'AlphaNum' => new validator\AlphaNumValidator($value, true, Lang::_('SRV_FILTER_POST_MODULES_MODULE_TBLNAME_ALPHANUM')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_POST_MODULES_MODULE_TBLNAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 30, Lang::_('SRV_FILTER_POST_MODULES_MODULE_TBLNAME_MAXLENGTH')),
			'DbExists' => new validator\DbExistsValidator($value, false, Lang::_('SRV_FILTER_POST_MODULES_MODULE_TBLNAME_UNIQUE'), $this->getDbProxy(), TableNames::getModules(), 'module_tblname')
		);
	}

	/**
	 * 获取“是否禁用”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getForbiddenRule($value)
	{
		$enum = DataModules::getForbiddenEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POST_MODULES_FORBIDDEN_INARRAY'), implode(', ', $enum))),
		);
	}

}
