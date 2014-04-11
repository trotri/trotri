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
	 * 验证全局变量：object是否有效
	 * @param slib\BaseModel $object
	 * @return void
	 * @throws ErrorException 如果object不是slib\BaseModel的子类，抛出异常
	 */
	public function objectIsValid($object = null)
	{
		if ($object === null) {
			throw new ErrorException('BaseValidator self::$object is null.');
		}

		if (!is_object($object)) {
			throw new ErrorException('BaseValidator self::$object is not object type.');
		}

		if (!$object instanceof BaseModel) {
			throw new ErrorException('BaseValidator self::$object is not instance of slib\BaseModel.');
		}
	}

	/**
	 * 验证全局变量：opType是否有效
	 * @param slib\BaseModel $object
	 * @param string $opType
	 * @return void
	 * @throws ErrorException 如果opType不等于insert或update，抛出异常
	 */
	public function opTypeIsValid(BaseModel $object, $opType = '')
	{
		if ($opType === '') {
			throw new ErrorException('BaseValidator self::$opType is empty.');
		}

		if (!$object->isOpTypeInsert($opType) && !$object->isOpTypeUpdate($opType)) {
			throw new ErrorException(sprintf(
				'BaseValidator self::$op_type "%s" invalid.', $opType
			));
		}
	}

	/**
	 * 验证全局变量：id是否有效
	 * @param slib\BaseModel $object
	 * @param string $opType
	 * @param integer $id
	 * @return void
	 * @throws ErrorException 如果新增时id<0或者编辑时id<=0，抛出异常
	 */
	public function idIsValid(BaseModel $object, $opType = '', $id)
	{
		if (($id = (int) $id) < 0) {
			throw new ErrorException(sprintf(
				'BaseValidator self::$id "%d" must be at most or equal zero.', $id
			));
		}

		if ($object->isOpTypeUpdate($opType) && $id === 0) {
			throw new ErrorException(sprintf(
				'BaseValidator self::$op_type "%s", self::$id "%d" must be at most zero.', $opType, $id
			));
		}
	}

	/**
	 * 验证全局变量：pid是否有效
	 * @param integer $pid
	 * @return void
	 * @throws ErrorException 如果pid<=0，抛出异常
	 */
	public function pidIsValid($pid)
	{
		if (($pid = (int) $pid) < 0) {
			throw new ErrorException(sprintf(
				'BaseValidator self::$pid "%d" must be at most or equal zero.', $pid
			));
		}
	}
}
