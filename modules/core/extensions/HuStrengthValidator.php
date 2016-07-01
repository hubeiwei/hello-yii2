<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/11
 * Time: 13:03
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\core\extensions;

use kartik\password\StrengthValidator;

/**
 * 目前只用到一个密码验证，
 * 但为了方便改属性以及不让控制器的代码过多，
 * 就继承了一份来改写，同时也能加上中文注释
 * 
 * 需要依赖kartik-v/yii2-password
 * @link https://github.com/kartik-v/yii2-password
 */
class HuStrengthValidator extends StrengthValidator
{
    /**
     * @var bool 是否允许密码里有用户名，默认true不允许，默认用户名字段为username，如果不是请修改下面的配置
     */
    public $hasUser = true;

    /**
     * @var string 用户名字段
     */
    public $userAttribute = 'username';

    /**
     * @var bool 是否允许密码里有email
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
     * @var bool 允许空格
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
