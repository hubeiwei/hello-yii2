<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/28
 * Time: 9:56
 * To change this template use File | Setting | File Templates.
 */

namespace app\modules\core\helpers;

use Yii;
use app\models\User;

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
    public static $questions = [
        '我的名字',
        '我妈妈的名字',
        '我爸爸的名字',
        '我的生日',
        '我的电话',
        '我喜欢的动物',
    ];

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
     * @param int $userId
     * @return bool
     */
    public static function userIsAdmin($userId = 0)
    {
        return Yii::$app->user->can('SuperAdmin');
//        if ($userId == 0 && !self::userIsGuest()) {
//            return self::getUserInstance()->type == User::type_admin;
//        } else if ($userId > 0) {
//            return User::find()->select(['type'])->where(['user_id' => $userId])->limit(1)->scalar() == User::type_admin;
//        } else {
//            return false;
//        }
    }

    /**
     * 获取用户ID，默认返回当前登录的用户ID
     *
     * @param null $userName
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
            $username = User::find()->select(['username'])->where(['user_id' => $userId])->scalar();
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
