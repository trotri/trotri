<?php
/**
 * Trotri Foundation Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tfc\util;

use tfc\ap\ErrorException;

/**
 * Language class file
 * 国际化处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Language.php 1 2013-03-29 16:48:06Z huan.song $
 * @package tfc.util
 * @since 1.0
 */
class Language
{
	/**
	 * @var string 当没有指定语言类型时默认的语言类型
	 */
	const DEFAULT_TYPE = 'en-GB';

	/**
	 * @var string 语言类型
	 */
	protected $_type = self::DEFAULT_TYPE;

	protected $_baseDir = '';

	

	public function getBaseDir()
	{
		return $this->_baseDir;
	}

	public function setBaseDir($baseDir)
	{
		if (!is_dir($baseDir)) {
            throw new ErrorException(sprintf(
                'Language base dir "%s" is not a valid directory.', $baseDir
            ));
        }

        $this->_baseDir = $baseDir;
	}

	public function getType()
	{
		return $this->_type;
	}

	public function setType($value)
	{
		if (($value = trim($value)) !== '') {
			$this->_type = $value;
		}

		return $this;
	}
}
