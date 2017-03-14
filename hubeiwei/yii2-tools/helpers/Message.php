<?php

namespace hubeiwei\yii2tools\helpers;

use Yii;
use yii\bootstrap\Widget;

/**
 * 封装该类主要是为了定义一些常量以及固定的方法以方便后期管理
 *
 * ```php
 * use hubeiwei\yii2tools\helpers\Message;
 *
 * \Yii::$app->session->setFlash(Message::TYPE_INFO, 'message');
 * Message::setSuccessMsg('success');
 * Message::setErrorMsg(['error1', 'error2']);
 * ```
 *
 * 以下两个 widget 支持批量输出所有而且数据类型为数组的消息
 * @see \hubeiwei\yii2tools\widgets\Alert
 * @see \hubeiwei\yii2tools\widgets\Growl
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
     * @param string $type
     */
    public static function setMessage($message, $type = self::TYPE_INFO)
    {
        Yii::$app->getSession()->setFlash($type, $message);
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
