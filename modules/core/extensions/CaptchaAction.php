<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/1
 * Time: 17:27
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\core\extensions;

use yii\captcha\CaptchaAction as YiiCaptchaAction;

/**
 * 虽然验证码action只配了一个，
 * 但为了方便改属性以及不让控制器的代码过多，
 * 就继承了一份来改写，同时也能加上中文注释
 */
class CaptchaAction extends YiiCaptchaAction
{
    /**
     * @var int 相同验证码的显示次数
     */
    public $testLimit = 3;

    /**
     * @var int
     */
    public $width = 100;

    /**
     * @var int
     */
    public $height = 50;

    /**
     * @var int
     */
    public $padding = 2;

    /**
     * @var int 背景色
     */
    public $backColor = 0xFFFFFF;

    /**
     * @var int 前景色
     */
    public $foreColor = 0x2040A0;

    /**
     * @var bool 图片背景透明
     */
    public $transparent = false;

    /**
     * @var int 生成验证码的最小长度
     */
    public $minLength = 4;

    /**
     * @var int 生成验证码的最大长度
     */
    public $maxLength = 4;

    /**
     * @var int 字符间距
     */
    public $offset = -2;

    /**
     * @var string 字体文件
     */
    public $fontFile = '@yii/captcha/SpicyRice.ttf';
}
