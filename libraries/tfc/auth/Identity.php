<?php
/**
 * Trotri Foundation Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tfc\auth;

use tfc\ap\UserIdentity;

/**
 * Identity class file
 * 用户身份管理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Identity.php 1 2014-09-03 01:08:06Z huan.song $
 * @package tfc.auth
 * @since 1.0
 */
class Identity
{
    /**
     * @var array 用户角色名
     */
    protected static $_roleNames = array();

    /**
     * @var array 用户拥有权限的项目名
     */
    protected static $_appNames = array();

    /**
     * @var instance of tfc\auth\Authoriz
     */
    protected static $_authoriz = null;

    /**
     * 判断用户是否已登录
     * @return boolean
     */
    public static function isLogin()
    {
        return UserIdentity::isLogin();
    }

    /**
     * 获取用户ID
     * @return integer
     */
    public static function getUserId()
    {
        return UserIdentity::getId();
    }

    /**
     * 设置用户ID
     * @param integer $id
     * @return void
     */
    public static function setUserId($id)
    {
        UserIdentity::setId($id);
    }

    /**
     * 获取登录名
     * @return string
     */
    public static function getLoginName()
    {
        return UserIdentity::getName();
    }

    /**
     * 设置登录名
     * @param string $name
     * @return void
     */
    public static function setLoginName($name)
    {
        UserIdentity::setName($name);
    }

    /**
     * 获取用户昵称
     * @return string
     */
    public static function getNickName()
    {
        return UserIdentity::getNick();
    }

    /**
     * 设置用户昵称
     * @param string $nick
     * @return void
     */
    public static function setNickName($name)
    {
        UserIdentity::setNick($name);
    }

    /**
     * 获取用户角色名
     * @return array
     */
    public static function getRoleNames()
    {
        return self::$_roleNames;
    }

    /**
     * 设置用户角色名
     * @param array $roleNames
     * @return void
     */
    public static function setRoleNames($names)
    {
        $names = (array) $names;

        $temp = array();
        foreach ($names as $name) {
            if (($name = trim($name)) !== '') {
                $temp[] = $name;
            }
        }

        self::$_roleNames = array_unique($temp);
    }

    /**
     * 获取用户拥有权限的项目名
     * @return array
     */
    public static function getAppNames()
    {
        return self::$_appNames;
    }

    /**
     * 设置用户拥有权限的项目名
     * @param array $names
     * @return void
     */
    public static function setAppNames($names)
    {
        $names = (array) $names;

        $temp = array();
        foreach ($names as $name) {
            if (($name = trim($name)) !== '') {
                $temp[] = $name;
            }
        }

        self::$_appNames = array_unique($temp);
    }

    /**
     * 获取用户身份授权类
     * @return tfc\auth\Authoriz
     */
    public static function getAuthoriz()
    {
        if (self::$_authoriz === null) {
            self::$_authoriz = new Authoriz();
        }

        return self::$_authoriz;
    }

    /**
     * 设置用户身份授权类
     * @param tfc\auth\Authoriz $authoriz
     * @return void
     */
    public static function setAuthoriz(Authoriz $authoriz)
    {
        self::$_authoriz = $authoriz;
    }

    /**
     * 设置所有的值
     * @param integer $userId
     * @param string $loginName
     * @param string $nickName
     * @param array $roleNames
     * @param array $appNames
     * @param tfc\auth\Authoriz $authoriz
     * @return void
     */
    public static function setAll($userId, $loginName, $nickName, $roleNames, $appNames, Authoriz $authoriz)
    {
        $this->setUserId($userId);
        $this->setLoginName($loginName);
        $this->setNickName($nickName);
        $this->setRoleNames($roleNames);
        $this->setAppNames($appNames);
        $this->setAuthoriz($authoriz);
    }
}
