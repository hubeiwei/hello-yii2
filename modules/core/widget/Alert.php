<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\core\widget;

use app\modules\core\helpers\Message;
use yii\bootstrap\Alert as YiiAlert;
use Yii;
use yii\bootstrap\Widget;

class Alert extends Widget
{
    public $typeMap = [
        Message::TYPE_INFO => 'alert-info',
        Message::TYPE_SUCCESS => 'alert-success',
        Message::TYPE_ERROR => 'alert-danger',
        Message::TYPE_DANGER => 'alert-danger',
        Message::TYPE_WARNING => 'alert-warning'
    ];

    private $_message = '';

    public function init()
    {
        parent::init();

        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        foreach ($flashes as $type => $data) {
            if (isset($this->typeMap[$type])) {
                $data = (array)$data;
                foreach ($data as $i => $message) {
                    $this->_message .= YiiAlert::widget([
                        'body' => $message,
                        'options' => ['class' => $this->typeMap[$type]],
                    ]);
                }
                $session->removeFlash($type);
            }
        }
    }

    public function run()
    {
        return $this->_message;
    }
}
