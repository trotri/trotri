<?php
/**
 * Trotri Foundation Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv;

use tfc\ap\Ap;
use tfc\util\Language;
use tfc\saf;

/**
 * Text class file
 * 当前业务的语言国际化管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Text.php 1 2013-04-05 01:38:06Z huan.song $
 * @package srv
 * @since 1.0
 */
class Text extends saf\Text
{
    /**
     * 设置国际化管理类
     * @param tfc\util\Language $language
     * @return void
     */
    public static function setLanguage(Language $language = null)
    {
        if ($language === null) {
            $type = Ap::getLanguageType();
            $baseDir = DIR_SRV_LANGUAGES;
            $language = Language::getInstance($type, $baseDir);
        }

        self::$_language = $language;
    }
}
