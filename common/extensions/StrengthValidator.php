<?php

namespace app\common\extensions;

use kartik\password\StrengthValidator as KartikStrengthValidator;

/**
 * 目前只用到一个密码验证，
 * 但为了方便改属性以及不让控制器的代码过多，
 * 就继承了一份来改写，同时也能加上中文注释
 * 
 * 需要依赖kartik-v/yii2-password
 * @link https://github.com/kartik-v/yii2-password
 */
class StrengthValidator extends KartikStrengthValidator
{
    /**
     * @var bool 允许密码里有用户名，true为不允许
     * @see $userAttribute
     */
    public $hasUser = true;

    /**
     * @var string 用户名字段
     */
    public $userAttribute = 'username';

    /**
     * @var bool 允许密码里有email，true为不允许
     */
    public $hasEmail = true;

    /**
     * @var int 最小长度
     */
    public $min = 8;

    /**
     * @var int 最大长度
     */
    public $max = 20;

    /**
     * @var bool 允许空格，true为允许
     */
    public $allowSpaces = false;

    /**
     * @var int 至少有多少个小写字母
     */
    public $lower = 1;

    /**
     * @var int 至少有多少个大写字母
     */
    public $upper = 0;

    /**
     * @var int 至少有多少个数字
     */
    public $digit = 1;

    /**
     * @var int 至少有多少个特殊符号
     */
    public $special = 0;
}
