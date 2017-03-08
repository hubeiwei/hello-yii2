<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/10/30
 * Time: 9:43
 */

namespace app\common\widgets;

use app\common\helpers\Message;
use Yii;
use yii\bootstrap\Alert as YiiAlert;
use yii\bootstrap\Widget;

/**
 * 输出消息用，建议放在layout里
 * ```php
 * <?= app\common\widgets\Alert::widget() ?>
 * ```
 *
 * 设置消息请看Message类
 * @see Message
 */
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

        $session = Yii::$app->getSession();
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
