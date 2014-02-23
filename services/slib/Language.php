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

use tfc\util;

/**
 * Language class file
 * 业务层：语言国际化管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Language.php 1 2013-03-29 16:48:06Z huan.song $
 * @package slib
 * @since 1.0
 */
class Language extends util\Language
{
    /**
     * 单例模式：获取本类的实例
     * @param string $type
     * @return instance of slib\Language
     */
    public static function getInstance($type)
    {
    	$baseDir = DIR_SERVICES . DS . 'slangs';
        return parent::getInstance($type, $baseDir);
    }
}
