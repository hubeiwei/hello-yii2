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
use yii\db\Transaction;

class EasyHelper
{
    /**
     * 设置消息提示，获取消息的代码在两个布局文件里
     *
     * @param $value
     * @param string $key
     */
    public static function setMessage($value, $key = 'info')
    {
        Yii::$app->session->setFlash($key, $value);
    }

    /**
     * 设置成功消息
     *
     * @param $value
     */
    public static function setSuccessMsg($value)
    {
        self::setMessage($value, 'success');
    }

    /**
     * 设置错误消息
     *
     * @param $value
     */
    public static function setErrorMsg($value)
    {
        self::setMessage($value, 'error');
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
     * 时间戳转日期
     *
     * @param int $timestamp 时间戳
     * @param string $format 默认Y-m-d H:i:s
     * @return string|null 时间戳为空时就不显示"1970..."了
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
     * 字符串拼接
     *
     * For example:
     *
     * ```php
     * $string = 'A:{0},B:{1},C:{2}';
     * return EasyHelper:stringFormat($string, 'a', 'b', 'c');//A:a,B:b,C:c
     * ```
     *
     * @return string
     */
    public static function stringFormat()
    {
        $args = func_get_args();
        if (count($args) == 0) {
            return null;
        }
        if (count($args) == 1) {
            return $args[0];
        }
        $str = array_shift($args);
        $str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = ' . var_export($args, true) . '; return isset($args[$match[1]]) ? $args[$match[1]] : null;'), $str);
        return $str;
    }

    /**
     * 开启事务
     *
     * 该方法只是为了让不同数据库的component开启事务时都能让IDE提示代码
     *
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
