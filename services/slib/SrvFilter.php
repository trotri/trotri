<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace slib;

use tfc\ap\Singleton;
use tfc\saf\Log;

/**
 * SrvFilter class file
 * 业务层：数据验证和清理类
 * <pre>
 * 全部 ErrorNo => ErrorMsg
 * SUCCESS_NUM => ERROR_MSG_SUCCESS_VALIDATE
 * ERROR_VALIDATE => ERROR_MSG_ERROR_VALIDATE
 * </pre>
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SrvFilter.php 1 2013-05-18 14:58:59Z huan.song $
 * @package slib
 * @since 1.0
 */
class SrvFilter extends BaseService
{
	/**
	 * 运行验证处理类
	 * @param array $rules
	 * @param array $attributes
	 * @param boolean $required
	 * @return array
	 */
	public function run(array $rules, array $attributes, $required = true)
	{
		$filter = Singleton::getInstance('tfc\\validator\\Filter');
		$ret = $filter->run($rules, $attributes, $required);
		if ($ret) {
			return array(
				'err_no' => ErrorNo::SUCCESS_NUM,
				'err_msg' => $this->_('ERROR_MSG_SUCCESS_VALIDATE')
			);
		}

		$errNo = ErrorNo::ERROR_VALIDATE;
		$errMsg = $this->_('ERROR_MSG_ERROR_VALIDATE');
		$errors = $filter->getErrors(true);
		Log::warning(sprintf(
			'%s attributes "%s", errors "%s", required "%d"', $errMsg, serialize($attributes), serialize($errors), $required
		), $errNo, __METHOD__);
		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'errors' => $errors
		);
	}

	/**
	 * 验证参数是否为空
	 * @param array $attributes
	 * @return array
	 */
	public function isEmptyAttributes(array $attributes = array())
	{
		if ($attributes) {
			return array(
				'err_no' => ErrorNo::SUCCESS_NUM,
				'err_msg' => $this->_('ERROR_MSG_SUCCESS_VALIDATE')
			);
		}

		$errNo = ErrorNo::ERROR_VALIDATE;
		$errMsg = $this->_('ERROR_MSG_ERROR_VALIDATE');
		$errors = array('__system__' => 'attributes is empty');
		Log::warning(sprintf(
			'%s attributes empty, errors "%s"', $errMsg, serialize($errors)
		), $errNo, __METHOD__);
		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'errors' => $errors
		);
	}

	/**
	 * 基于配置清理表单提交的数据
	 * @param array $rules
	 * @param array $attributes
	 * @return array
	 */
	public function clean(array $rules, array $attributes)
	{
		return Singleton::getInstance('tfc\\validator\\Filter')->clean($rules, $attributes);
	}

	/**
	 * 通过过滤数组，只保留指定的字段名
	 * 如果没有指定要保留的字段名，则通过表的字段过滤
	 * @param array $attributes
	 * @param mixed $columnNames
	 * @param boolean $autoIncrement
	 * @return void
	 */
	public function filterAttributes(array &$attributes = array(), $columnNames = null, $autoIncrement = true)
	{
		if ($columnNames === null) {
			$this->getDb()->filterAttributes($attributes, $autoIncrement);
		}
		else {
			$columnNames = (array) $columnNames;
			foreach ($attributes as $key => $value) {
				if (!in_array($key, $columnNames)) {
					unset($attributes[$key]);
				}
			}
		}
	}

	/**
	 * 通过过滤数组，删除指定的字段名
	 * @param array $attributes
	 * @param mixed $columnNames
	 * @return void
	 */
	public function removeAttributes(array &$attributes = array(), $columnNames)
	{
		$columnNames = (array) $columnNames;
		foreach ($columnNames as $columnName) {
			if (isset($attributes[$columnName])) {
				unset($attributes[$columnName]);
			}
		}
	}
}
