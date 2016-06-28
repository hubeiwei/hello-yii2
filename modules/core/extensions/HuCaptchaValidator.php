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

/**
 * 因为很多地方用到验证码，
 * 不能每个验证码都把那么多值配一遍，很难看也很难维护，
 * 所以继承一份来改写是最好的方法
 */
class HuCaptchaValidator extends CaptchaValidator
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
     * @var string 在控制器上配置的验证码action
     */
    public $captchaAction = '/core/default/captcha';
}