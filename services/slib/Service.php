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
use tfc\util\Language;

/**
 * Service class file
 * 业务层入口类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Service.php 1 2013-03-29 16:48:06Z huan.song $
 * @package slib
 * @since 1.0
 */
class Service
{
	/**
	 * @var string 缺省的语言种类
	 */
	const DEFAULT_LANGUAGE_TYPE = 'zh-CN';

	/**
	 * @var array 支持的语言种类
	 */
	protected static $_languageTypes = array('zh-CN', 'en-GB');

	/**
	 * 获取模型类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @param string $languageType
	 * @param integer $tableNum
	 * @return instance of slib\BaseModel
	 */
	public static function getModel($className, $moduleName, $languageType = '', $tableNum = -1)
	{
		$language = self::getLanguage($languageType);
		return Model::getInstance($className, $moduleName, $language, $tableNum);
	}

	/**
	 * 获取数据管理类的实例
	 * @param string $className
	 * @param string $moduleName
	 * @param string $languageType
	 * @return instance of slib\BaseData
	 */
	public static function getData($className, $moduleName, $languageType = '')
	{
		$language = self::getLanguage($languageType);
		return Data::getInstance($className, $moduleName, $language);
	}

	/**
	 * 获取语言国际化管理类实例
	 * @param string $languageType
	 * @return instance of slib\Language
	 * @throws ErrorException 如果语言种类不被支持，抛出异常
	 */
	public static function getLanguage($languageType = '')
	{
		if (($languageType = trim($languageType)) === '') {
			$languageType = self::DEFAULT_LANGUAGE_TYPE;
		}

		if (!in_array($languageType, self::$_languageTypes)) {
			throw new ErrorException(sprintf(
				'Service is unable to find the requested language type "%s".', $languageType
			));
		}

		$baseDir = DIR_SERVICES . DS . 'slangs';
		$language = Language::getInstance($languageType, $baseDir);
		return $language;
	}
}
