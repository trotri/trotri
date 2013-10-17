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

use tfc\ap\ErrorException;

/**
 * Conf class file
 * 获取配置类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Conf.php 1 2013-04-05 15:21:06Z huan.song $
 * @package tfc.saf
 * @since 1.0
 */
class Conf
{
    /**
     * @var array 用于寄存项目的配置
     */
    protected static $_appConf = null;

    /**
     * @var array 用于寄存数据库的配置
     */
    protected static $_dbConf = null;

    /**
     * @var array 用于寄存Ral的配置
     */
    protected static $_ralConf = null;

    /**
     * @var array 用于寄存缓存的配置
     */
    protected static $_cacheConf = null;

    /**
     * 通过配置名获取项目的配置
     * @param string $name
     * @param string $parentName
     * @param string $grandName
     * @throws ErrorException 如果指定的配置名不存在，抛出异常
     * @return mixed
     */
    public static function getAppConf($name, $parentName = null, $grandName  = null)
    {
        if (self::$_appConf === null) {
            $file = DIR_CONF_APP . DS . 'main.php';
            self::$_appConf = self::getConf($file);
        }

        if ($parentName === null) {
            if (isset(self::$_appConf[$name])) {
                return self::$_appConf[$name];
            }

            throw new ErrorException(sprintf(
                'Conf no app conf is registered for name "%s", conf "%s".', $name, var_export(self::$_appConf, true)
            ));
        }

        if ($grandName === null) {
            if (isset(self::$_appConf[$parentName][$name])) {
                return self::$_appConf[$parentName][$name];
            }

            throw new ErrorException(sprintf(
                'Conf no app conf is registered for name "%s.%s", conf "%s".', $parentName, $name, var_export(self::$_appConf, true)
            ));
        }

        if (isset(self::$_appConf[$grandName][$parentName][$name])) {
            return self::$_appConf[$grandName][$parentName][$name];
        }

        throw new ErrorException(sprintf(
            'Conf no app conf is registered for name "%s.%s.%s", conf "%s".', $grandName, $parentName, $name, var_export(self::$_appConf, true)
        ));
    }

    /**
     * 通过配置名获取数据库的配置
     * @param string $name
     * @return array
     * @throws ErrorException 如果指定的配置名不存在，抛出异常
     */
    public static function getDbConf($name)
    {
        if (self::$_dbConf === null) {
            $file = DIR_CONF_DB . DS . 'cluster.php';
            self::$_dbConf = self::getConf($file);
        }

        if (isset(self::$_dbConf[$name])) {
            return self::$_dbConf[$name];
        }

        throw new ErrorException(sprintf(
            'Conf no db conf is registered for name "%s".', $name
        ));
    }

    /**
     * 通过配置名获取Ral的配置
     * @param string $name
     * @return array
     * @throws ErrorException 如果指定的配置名不存在，抛出异常
     */
    public static function getRalConf($name)
    {
        if (self::$_ralConf === null) {
            $file = DIR_CONF_DB . DS . 'cluster.php';
            self::$_ralConf = self::getConf($file);
        }

        if (isset(self::$_ralConf[$name])) {
            return self::$_ralConf[$name];
        }

        throw new ErrorException(sprintf(
            'Conf no ral conf is registered for name "%s".', $name
        ));
    }

    /**
     * 通过配置名获取缓存的配置
     * @param string $name
     * @return array
     * @throws ErrorException 如果指定的配置名不存在，抛出异常
     */
    public static function getCacheConf($name)
    {
        if (self::$_cacheConf === null) {
            $file = DIR_CONF_CACHE . DS . 'cluster.php';
            self::$_cacheConf = self::getConf($file);
        }

        if (isset(self::$_cacheConf[$name])) {
            return self::$_cacheConf[$name];
        }

        throw new ErrorException(sprintf(
            'Conf no cache conf is registered for name "%s".', $name
        ));
    }

    /**
     * 通过配置文件路径获取配置数据
     * @param string $file
     * @return array
     * @throws ErrorException 如果指定的配置文件不存在，抛出异常
     * @throws ErrorException 如果配置文件返回值不是数组，抛出异常
     */
    public static function getConf($file)
    {
        if (!is_file($file)) {
            throw new ErrorException(sprintf(
                'Conf file "%s" is not a valid file.', $file
            ));
        }

        $config = require_once $file;
        if (is_array($config)) {
            return $config;
        }

        throw new ErrorException(sprintf(
            'Conf file "%s" must return array only, config "%s".', $file, $config
        ));
    }
}
