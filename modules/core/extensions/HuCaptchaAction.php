<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/1
 * Time: 17:27
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\core\extensions;

use yii\captcha\CaptchaAction;

class HuCaptchaAction extends CaptchaAction
{
//    public $testLimit = 3;

//    public $width = 120;

//    public $height = 50;

//    public $padding = 2;

//    public $backColor = 0xFFFFFF;

//    public $foreColor = 0x2040A0;

//    public $transparent = false;

    /**
     * @var int 生成验证码的最小长度
     */
    public $minLength = 4;

    /**
     * @var int 生成验证码的最大长度
     */
    public $maxLength = 4;

//    public $offset = -2;

//    public $fontFile = '@yii/captcha/SpicyRice.ttf';
}
