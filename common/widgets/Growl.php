<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/10/30
 * Time: 9:45
 */

namespace app\common\widgets;

use app\common\helpers\Message;
use kartik\growl\Growl as KartikGrowl;
use Yii;
use yii\bootstrap\Widget;

/**
 * 输出消息用，建议放在layout里
 * ```php
 * <?= app\common\widgets\Growl::widget() ?>
 * ```
 *
 * 设置消息请看Message类
 * @see Message
 */
class Growl extends Widget
{
    /**
     * @var array
     */
    public $typeMap = [
        Message::TYPE_INFO => KartikGrowl::TYPE_INFO,
        Message::TYPE_SUCCESS => KartikGrowl::TYPE_SUCCESS,
        Message::TYPE_ERROR => KartikGrowl::TYPE_DANGER,
        Message::TYPE_DANGER => KartikGrowl::TYPE_DANGER,
        Message::TYPE_WARNING => KartikGrowl::TYPE_WARNING,
    ];

    /**
     * @var array
     */
    public $iconMap = [
        Message::TYPE_INFO => 'glyphicon glyphicon-info-sign',
        Message::TYPE_SUCCESS => 'glyphicon glyphicon-ok-sign',
        Message::TYPE_ERROR => 'glyphicon glyphicon-remove-sign',
        Message::TYPE_DANGER => 'glyphicon glyphicon-remove-sign',
        Message::TYPE_WARNING => 'glyphicon glyphicon-exclamation-sign',
    ];

    /**
     * @var string
     */
    private $_message = '';

    public function init()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        foreach ($flashes as $type => $data) {
            if (isset($this->typeMap[$type])) {
                $data = (array)$data;
                foreach ($data as $i => $message) {
                    $this->_message .= KartikGrowl::widget([
                        'type' => $this->typeMap[$type],
                        'icon' => $this->iconMap[$type],
                        'body' => $message,
                        'pluginOptions' => [
                            'showProgressbar' => true,
                            'placement' => [
                                'from' => 'top',
                                'align' => 'center',
                            ]
                        ]
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
