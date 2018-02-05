<?php

namespace app\common\captcha;

use yii\captcha\Captcha as YiiCaptcha;

/**
 * 因为很多地方都用到验证码，
 * 不能每个验证码都把那么多值配一遍，很难看也很难维护，
 * 所以继承一份来改写是最好的方法
 */
class Captcha extends YiiCaptcha
{
    public $captchaAction = '/site/captcha';

    public $imageOptions = [
        'alt' => '验证码',
    ];

    public $template = '<div class="row"><div class="col-xs-4">{input}</div><div class="col-xs-8">{image}</div></div>';

    public $options = [
        'class' => 'form-control',
        'maxlength' => 4,
    ];
}
