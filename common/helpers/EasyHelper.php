<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/1
 * Time: 22:23
 * To change this template use File | Setting | File Templates.
 */

namespace app\common\helpers;

use Yii;
use yii\db\Transaction;

class EasyHelper
{
    public static function getGlobal($key)
    {
        $global = Yii::$app->params['global_variable'];
        if (isset($global[$key])) {
            return $global[$key];
        }
        return null;
    }

    public static function setGlobal($key, $value)
    {
        Yii::$app->params['global_variable'][$key] = $value;
    }

    public static function getRealIP()
    {
        $ip = '';
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            if (isset($ip[0])) {
                $ip = $ip[0];
            }
        } else if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if (!empty($_SERVER['REMOTE_ADDR']))
            $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }

    /**
     * 开启事务
     *
     * 该方法只是为了让不同数据库的 component 开启事务时都能让 IDE 提示代码
     *
     * @param \yii\db\Connection $db
     * @param string $isolationLevel
     * @return Transaction
     */
    public static function beginTransaction($db = null, $isolationLevel = Transaction::SERIALIZABLE)
    {
        if ($db === null) {
            $db = Yii::$app->getDb();
        }
        return $db->beginTransaction($isolationLevel);
    }

    /**
     * @param $value
     * @return string|array
     */
    public static function unifyLimiter($value)
    {
        return str_replace([' ', '　', '，', '、', '
'], ',', $value);// 不要取消换行！那是newline
    }
}
