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

    public $template = '{input}{image}';

    public $options = [
        'class' => 'form-control',
        'maxlength' => 4,
    ];
}