<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/11
 * Time: 12:13
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\core\extensions;

use yii\captcha\CaptchaValidator;

class HuCaptchaValidator extends CaptchaValidator
{
    public $captchaAction = '/core/default/captcha';
}