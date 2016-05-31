<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/9
 * Time: 18:24
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\user\models;

use app\modules\core\extensions\HuCaptchaValidator;
use app\modules\core\extensions\HuStrengthValidator;
use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $email;
    public $verifyCode;

    /**
     * 声明往数据库查询的表名
     *
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat', 'email', 'verifyCode'], 'required'],
            ['username', 'string', 'max' => 20],
            ['password', HuStrengthValidator::className()],

            /**
             * 直接写['attribute', 'compare']会自动去对比attribute_repeat这个属性的值
             * 如果attribute的值与attribute_repeat不相等，错误是在attribute这里提示
             * 这不合理，错误提示应该出现在attribute_repeat
             * 以下是让某attribute与另一个attribute对比的规则
             */
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],

            ['email', 'email'],
            ['email', 'string', 'max' => 100],

            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', HuCaptchaValidator::className()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'password_repeat' => '确认密码',
            'email' => '邮箱',
            'verifyCode' => '验证码',
        ];
    }
}