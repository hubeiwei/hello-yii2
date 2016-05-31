<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/1
 * Time: 22:23
 * To change this template use File | Setting | File Templates.
 */

namespace app\modules\core\helpers;

use Yii;
use app\models\User;
use yii\db\Transaction;

class EasyHelper
{
    public static function hasMessage($key)
    {
        return Yii::$app->session->hasFlash($key);
    }

    public static function getMessage($key)
    {
        return Yii::$app->session->getFlash($key);
    }

    public static function setMessage($key, $value)
    {
        Yii::$app->session->setFlash($key, $value);
    }

    public static function setSuccessMsg($value, $key = 'success')
    {
        self::setMessage($key, $value);
    }

    public static function setErrorMsg($value, $key = 'error')
    {
        self::setMessage($key, $value);
    }

    public static function setSession($key, $value)
    {
        return Yii::$app->session[$key] = $value;
    }

    public static function getSession($key)
    {
        return Yii::$app->session[$key];
    }

    public static function getCache($key)
    {
        return Yii::$app->cache->get($key);
    }

    public static function setCache($key, $value, $expiration, $dependency = null)
    {
        return Yii::$app->cache->set($key, $value, $expiration, $dependency);
    }

    public static function getGlobal($key)
    {
        $global = Yii::$app->params['global_variable'];
        if (isset($global[$key])) {
            return $global[$key];
        }
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
     * 时间戳转日期
     *
     * @param int $timestamp 时间戳
     * @param string $format 默认Y-m-d H:i:s
     * @return mixed
     */
    public static function timestampToDate($timestamp = -1, $format = 'Y-m-d H:i:s')
    {
        if (!$timestamp) {
            return null;
        }
        if ($timestamp == -1) {
            return date($format, time());
        } else {
            return date($format, $timestamp);
        }
    }

    /**
     * ```php
     * return EasyHelper:stringFormat('{0}{1}', '1', '2');//12
     * ```
     */
    public static function stringFormat()
    {
        $args = func_get_args();
        if (count($args) == 0) {
            return;
        }
        if (count($args) == 1) {
            return $args[0];
        }
        $str = array_shift($args);
        $str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = ' . var_export($args, true) . '; return isset($args[$match[1]]) ? $args[$match[1]] : null;'), $str);
        return $str;
    }

    /**
     * @param string $db
     * @param string $isolationLevel
     * @return \yii\db\Transaction
     */
    public static function beginTransaction($db = 'db', $isolationLevel = Transaction::SERIALIZABLE)
    {
        return Yii::$app->$db->beginTransaction($isolationLevel);
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function unifyLimiter($value)
    {
        return str_replace(array(' ', '　', '，', '、', '
'), ',', $value); //不要取消换行! 那是newline
    }
}