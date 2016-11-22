<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/11
 * Time: 12:13
 * To change this template use File | Settings | File Templates.
 */

namespace app\common\captcha;

use yii\captcha\CaptchaValidator as YiiCaptchaValidator;

class CaptchaValidator extends YiiCaptchaValidator
{
    /**
     * @var boolean 是否忽略空
     */
    public $skipOnEmpty = false;

    /**
     * @var boolean 是否区分大小写
     */
    public $caseSensitive = false;
    
    /**
     * @var string
     */
    public $captchaAction = '/site/captcha';
}
