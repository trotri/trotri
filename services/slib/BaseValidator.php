<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace slib;

use tfc\ap\ErrorException;
use tfc\validator\Validator;
use tfc\saf\Log;

/**
 * BaseValidator class file
 * 业务层：数据验证基类，当验证类需要传入更多参数时使用，如：验证登录名是否唯一、验证邮箱是否存在
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseValidator.php 1 2014-04-10 16:48:06Z huan.song $
 * @package slib
 * @since 1.0
 */
abstract class BaseValidator extends Validator
{
	/**
	 * @var smods\Mod 寄存业务层的model类实例
	 */
	public static $object = null;

	/**
	 * @var string 操作类型：insert、update
	 */
	public static $opType = '';

	/**
	 * @var integer 主键ID
	 */
	public static $id = 0;

	/**
	 * @var integer 父ID
	 */
	public static $pid = 0;

	/**
	 * 验证数据格式
	 * @return boolean
	 */
	public abstract function runValid();

	/**
	 * (non-PHPdoc)
	 * @see tfc\validator.Validator::isValid()
	 */
	public function isValid()
	{
		if (($object = self::$object) === null) {
			throw new ErrorException('BaseValidator self::$object is null.');
		}

		if (!is_object($object)) {
			throw new ErrorException('BaseValidator self::$object is not object type.');
		}

		if (!$object instanceof BaseModel) {
			throw new ErrorException('BaseValidator self::$object is not instance of slib\BaseModel.');
		}

		if (($opType = self::$opType) === '') {
			throw new ErrorException('BaseValidator self::$opType is empty.');
		}

		if (!$object->isOpTypeInsert($opType) && !$object->isOpTypeUpdate($opType)) {
			throw new ErrorException(sprintf(
				'BaseValidator self::$op_type "%s" invalid.', $opType
			));
		}

		if ($object->isOpTypeUpdate($opType)) {
			self::$id = (int) self::$id;
			if (self::$id <= 0) {
				Log::warning(sprintf(
					'self::$op_type "%s", self::$id "%d" must be at most zero.', $opType, self::$id
				), ErrorNo::ERROR_SYSTEM_RUN_ERR, __METHOD__);
				return false;
			}
		}

		self::$pid = (int) self::$pid;
		if (self::$pid < 0) {
			Log::warning(sprintf(
				'self::$pid "%d" must be at most or equal zero.', self::$pid
			), ErrorNo::ERROR_SYSTEM_RUN_ERR, __METHOD__);
			return false;
		}

		return $this->runValid();
	}
}
