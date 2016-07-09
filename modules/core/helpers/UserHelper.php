<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/28
 * Time: 9:56
 * To change this template use File | Setting | File Templates.
 */

namespace app\modules\core\helpers;

use app\models\User;
use Yii;

/**
 * Class UserHelper
 * @package app\modules\core\helpers
 *
 * @property $user
 * @property $userInstance
 * @property $userId
 * @property $userName
 */
class UserHelper
{
    /**
     * 获取用户实例，默认返回当前登录的用户实例
     *
     * @param int|string $userId
     * @return User|null
     */
    public static function getUserInstance($userId = 0)
    {
        if ($userId == 0) {
            return Yii::$app->user->identity;
        } else {
            return User::find()->where(['user_id' => $userId])->limit(1)->one();
        }
    }

    /**
     * 判断当前访客是否已登录
     *
     * @return bool 访客未登录返回true，已登录返回false
     */
    public static function userIsGuest()
    {
        return Yii::$app->user->isGuest;
    }

    /**
     * 判断当前访客是否是管理员
     *
     * 统一封装在这有利于以后改动设计时不需要对项目进行很大改动
     *
     * @return bool
     */
    public static function userIsAdmin()
    {
        return Yii::$app->user->can('SuperAdmin');
    }

    /**
     * 获取用户ID，默认返回当前登录的用户ID
     *
     * @param string|null $userName
     * @return bool|int|string
     */
    public static function getUserId($userName = null)
    {
        if ($userName) {
            return User::find()->select(['user_id'])->where(['username' => $userName])->limit(1)->scalar();
        } else {
            return Yii::$app->user->id;
        }
    }

    /**
     * 获取用户名，默认返回当前登录用户的用户名
     *
     * @param int $userId
     * @param null $default
     * @param string $zero_name
     * @return bool|null|string
     */
    public static function getUserName($userId = -1, $default = null, $zero_name = 'System')
    {
        if ($userId == -1 && !self::userIsGuest()) {
            return self::getUserInstance()->username;
        } else if ($userId == 0) {
            return $zero_name;
        } else {
            $username = User::find()->select(['username'])->where(['user_id' => $userId])->limit(1)->scalar();
            if ($username) {
                return $username;
            }
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
        if ($allowAdmin && self::userIsAdmin()) {
            return true;
        }
        return self::getUserId() == $userId;
    }
}
