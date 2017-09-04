<?php

namespace app\common\helpers;

use Yii;

class UserHelper
{
    /**
     * @var yii\db\ActiveRecord|string 用户类，实例或类名
     */
    public $userClass;

    /**
     * @var string 用户表主键
     */
    public $userIdField = 'id';

    /**
     * @var string 用户名字段
     */
    public $usernameField = 'username';

    /**
     * @return self
     */
    public static function get()
    {
        return Yii::$container->get('UserHelper');
    }

    /**
     * 获取用户实例，默认返回当前登录的用户实例
     *
     * @param int|string $userId
     * @return yii\db\ActiveRecord|null
     */
    public static function getUserInstance($userId = 0)
    {
        if ($userId == 0) {
            return Yii::$app->getUser()->getIdentity();
        } else {
            $userHelper = self::get();
            return call_user_func([$userHelper->userClass, 'find'])
                ->where([$userHelper->userIdField => $userId])
                ->limit(1)
                ->one();
        }
    }

    /**
     * 判断当前访客是否是管理员
     *
     * 统一封装在这有利于以后改动设计时不需要对项目进行很大改动
     *
     * @return bool
     */
    public static function isAdmin()
    {
        return Yii::$app->getUser()->can('admin');
    }

    /**
     * 获取用户ID，默认返回当前登录的用户ID
     *
     * @param string|null $userName
     * @return false|int|null|string
     */
    public static function getUserId($userName = null)
    {
        if ($userName) {
            $userHelper = self::get();
            return call_user_func([$userHelper->userClass, 'find'])
                ->select([$userHelper->userIdField])
                ->where([$userHelper->usernameField => $userName])
                ->limit(1)
                ->scalar();
        } else {
            return Yii::$app->getUser()->getId();
        }
    }

    /**
     * 获取用户名，默认返回当前登录用户的用户名
     *
     * @param int $userId
     * @param string|null $default
     * @return bool|null|string
     */
    public static function getUserName($userId = null, $default = null)
    {
        $userHelper = self::get();
        if ($userId == null && !Yii::$app->user->isGuest) {
            return self::getUserInstance()->{$userHelper->usernameField};
        } else {
            $username = call_user_func([$userHelper->userClass, 'find'])
                ->select([$userHelper->usernameField])
                ->where([$userHelper->userIdField => $userId])
                ->limit(1)
                ->scalar();
            return $username;
        }
        return $default;
    }

    /**
     * 是否属于当前登录的用户，在一些修改和删除的按钮以及控制器上会用到
     *
     * @param $userId
     * @param bool $allowAdmin 是否允许管理员
     * @return bool
     */
    public static function isBelongToUser($userId, $allowAdmin = true)
    {
        if ($allowAdmin && self::isAdmin()) {
            return true;
        }
        return self::getUserId() == $userId;
    }
}
