<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/10/30
 * Time: 0:28
 */

namespace app\modules\core\helpers;

use Yii;
use yii\bootstrap\Widget;

/**
 * 封装该类主要是为了定义一些常量以及固定的方法以方便后期管理
 *
 * ```php
 * use app\modules\core\helpers\Message;
 *
 * \Yii::$app->session->setFlash(Message::TYPE_INFO, 'message');
 * Message::setSuccessMsg('success');
 * Message::setErrorMsg(['error1', 'error2']);
 * ```
 *
 * 以下两个类支持批量输出所有类型以及数据类型为数组的消息
 * @see \app\modules\core\widget\Alert
 * @see \app\modules\core\widget\Growl
 */
class Message extends Widget
{
    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_ERROR = 'error';
    const TYPE_DANGER = 'danger';
    const TYPE_WARNING = 'warning';

    /**
     * @param string|array $message
     * @param string $key
     */
    public static function setMessage($message, $key = self::TYPE_INFO)
    {
        Yii::$app->session->setFlash($key, $message);
    }

    public static function setSuccessMsg($message)
    {
        self::setMessage($message, self::TYPE_SUCCESS);
    }

    public static function setErrorMsg($message)
    {
        self::setMessage($message, self::TYPE_ERROR);
    }

    public static function setDangerMsg($message)
    {
        self::setMessage($message, self::TYPE_DANGER);
    }

    public static function setWarningMsg($message)
    {
        self::setMessage($message, self::TYPE_WARNING);
    }
}
