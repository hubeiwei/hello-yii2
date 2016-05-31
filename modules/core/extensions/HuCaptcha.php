<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/1
 * Time: 21:40
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\core\extensions;

use yii\captcha\Captcha;

/**
 * Class HuCaptcha
 * @package app\modules\core\extensions
 * 
 * @see Captcha
 */
class HuCaptcha extends Captcha
{
    public $captchaAction = '/core/default/captcha';

    public $imageOptions = ['alt' => '验证码'];

    public $template = '<div class="col-md-6" style="padding-left: 0">{input}</div><div class="col-md-6">{image}</div>';

    public $options = [
        'class' => 'form-control',
        'maxlength' => 4,
    ];
}