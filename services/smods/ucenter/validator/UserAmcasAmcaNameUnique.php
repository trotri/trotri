<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\ucenter\validator;

use tfc\ap\Registry;
use tfc\saf\Log;
use tfc\validator\Validator;
use slib\ErrorNo;
use smods\ucenter\ModAmcas;

/**
 * UserAmcasAmcaNameUnique class file
 * 验证事件名：同一事件下的子事件名不能重复
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: UserAmcasAmcaNameUnique.php 1 2013-03-29 16:48:06Z huan.song $
 * @package smods.ucenter.validator
 * @since 1.0
 */
class UserAmcasAmcaNameUnique extends Validator
{
	/**
	 * @var string 全局变量的键名，在全局变量中设置UserAmcasAmcaNameUnique验证类需要的参数
	 */
	const USERAMCAS_AMCANAME_UNIQUE = 'VALIDATOR_USERAMCAS_AMCANAME_UNIQUE';

	/**
	 * @var string 默认出错后的提醒消息
	 */
	protected $_message = '"%value%" from this user amcas has the same name.';

	/**
	 * (non-PHPdoc)
	 * @see tfc\validator.Validator::isValid()
	 */
	public function isValid()
	{
		$name = 'VALIDATOR_USERAMCAS_AMCANAME_UNIQUE';
		if (!Registry::has($name)) {
			Log::warning(sprintf(
				'Registry "%s" not exists.', $name
			), ErrorNo::ERROR_SYSTEM_RUN_ERR, __METHOD__);
			return false;
		}

		$params = Registry::get($name);
		if (!is_array($params)) {
			Log::warning(sprintf(
				'Registry "%s" must be array.', $name
			), ErrorNo::ERROR_SYSTEM_RUN_ERR, __METHOD__);
			return false;
		}

		$object = isset($params['object']) ? $params['object'] : null;
		if (!$object instanceof ModAmcas) {
			Log::warning(sprintf(
				'Registry "%s" object is not instanceof smods\ucenter\ModAmcas.', $name
			), ErrorNo::ERROR_SYSTEM_RUN_ERR, __METHOD__);
			return false;
		}

		$opType = isset($params['op_type']) ? $params['op_type'] : '';
		if (!$object->isOpTypeInsert($opType) && !$object->isOpTypeUpdate($opType)) {
			Log::warning(sprintf(
				'Registry "%s" op_type invalid.', $name
			), ErrorNo::ERROR_SYSTEM_RUN_ERR, __METHOD__);
			return false;
		}

		if (!isset($params['amca_pid'])) {
			Log::warning(sprintf(
				'Registry "%s" amca_pid not exists.', $name
			), ErrorNo::ERROR_SYSTEM_RUN_ERR, __METHOD__);
			return false;
		}

		if ($object->isOpTypeUpdate($opType) && !isset($params['amca_id'])) {
			Log::warning(sprintf(
				'Registry "%s" op_type "%s", amca_id not exists.', $name, $opType
			), ErrorNo::ERROR_SYSTEM_RUN_ERR, __METHOD__);
			return false;
		}

		$amcaName = $this->getValue();
		if (($amcaName = trim($amcaName)) === '') {
			return false;
		}

		if ($object->isOpTypeUpdate($opType)) {
			if (($amcaId = (int) $params['amca_id']) < 0) {
				return false;
			}

			$ret = $object->getByPk('amca_name', $amcaId);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				return false;
			}

			if ($ret['amca_name'] === $amcaName) {
				return true;
			}
		}

		if (($amcaPid = (int) $params['amca_pid']) < 0) {
			return false;
		}

		$total = $object->countByPidAndName($amcaPid, $amcaName);
		return ($total > 0) ? false : true;
	}
}
