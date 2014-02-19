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
     * @var string 当前语种
     */
    protected static $_languageType = null;

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
     * 解析当前语种的ini语言包
     * @param string $fileName
     * @return array
     */
    public static function parse($fileName)
    {
        $fileName = self::getLanguage()->getType() . '.' . $fileName . '.ini';
        return self::getLanguage()->parse($fileName);
    }

    /**
     * 获取解析过的所有语言串
     * @return array
     */
    public static function getStrings()
    {
        return self::getLanguage()->getStrings();
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
            $type = self::getLanguageType();
            $baseDir = DIR_APP_LANGUAGES;
            $language = Language::getInstance($type, $baseDir);
        }

        self::$_language = $language;
    }

    /**
     * 获取当前语种
     * @return string
     */
    public static function getLanguageType()
    {
        if (self::$_languageType === null) {
            $type = Cfg::getApp('language');
            self::setLanguageType($type);
        }

        return self::$_languageType;
    }

    /**
     * 设置当前语种
     * @param string $type
     * @return void
     */
    public static function setLanguageType($type = null)
    {
        if ($type !== null) {
            self::$_languageType = trim($type);
        }
    }
}
