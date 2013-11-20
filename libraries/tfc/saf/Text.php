<?php
/**
 * Trotri Foundation Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tfc\saf;

use tfc\util\Language;

/**
 * Text class file
 * 当前项目的语言国际化管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Text.php 1 2013-04-05 01:38:06Z huan.song $
 * @package tfc.saf
 * @since 1.0
 */
class Text
{
    /**
     * @var instance of tfc\util\Language
     */
    protected static $_language = null;

    /**
     * 通过键名获取语言内容
     * @param string $string
     * @param boolean $jsSafe
     * @param boolean $interpretBackSlashes
     * @return string
     */
    public static function _($string, $jsSafe = false, $interpretBackSlashes = true)
    {
        return self::getLanguage()->_($string, $jsSafe, $interpretBackSlashes);
    }

    /**
     * 获取国际化管理类
     * @return tfc\util\Language
     */
    public static function getLanguage()
    {
        if (self::$_language === null) {
            self::setLanguage();
        }

        return self::$_language;
    }

    /**
     * 设置国际化管理类
     * @param tfc\util\Language $language
     * @return void
     */
    public static function setLanguage(Language $language = null)
    {
        if ($language === null) {
            $type = Cfg::getApp('language');
            $baseDir = DIR_APP_LANGUAGES;
            $language = Language::getInstance($type, $baseDir);
        }

        self::$_language = $language;
    }
}
