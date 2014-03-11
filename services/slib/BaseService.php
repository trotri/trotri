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

use tfc\util\Language;

/**
 * BaseService abstract class file
 * 业务层基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseService.php 1 2013-03-29 16:48:06Z huan.song $
 * @package slib
 * @since 1.0
 */
abstract class BaseService
{
	/**
	 * @var instance of tdo\Db
	 */
	protected $_db = null;

	/**
	 * @var instance of slib\Language
	 */
	protected $_language = null;

	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param slib\BaseDb $db
	 * @param slib\Language $language
	 */
	public function __construct(BaseDb $db, Language $language)
	{
		$this->_db = $db;
		$this->_language = $language;
	}

	/**
	 * 获取数据库操作类
	 * @return instance of tdo\Db
	 */
	public function getDb()
	{
		return $this->_db;
	}

	/**
	 * 获取语言国际化管理类
	 * @return instance of slib\Language
	 */
	public function getLanguage()
	{
		return $this->_language;
	}

	/**
	 * 通过键名获取语言内容
	 * @param string $string
	 * @param boolean $jsSafe
	 * @param boolean $interpretBackSlashes
	 * @return string
	 */
	public function _($string, $jsSafe = false, $interpretBackSlashes = true)
	{
		return $this->getLanguage()->_($string, $jsSafe, $interpretBackSlashes);
	}
}
