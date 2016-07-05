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

    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat', 'email', 'verifyCode'], 'required'],
            ['username', 'string', 'max' => 20],
            ['password', HuStrengthValidator::className()],
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
