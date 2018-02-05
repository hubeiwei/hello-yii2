<?php

namespace app\modules\user\models;

use app\common\captcha\CaptchaValidator;
use yii\base\Model;

class UserDetailValidator extends Model
{
    public $birthday;
    public $verifyCode;

    public function rules()
    {
        return [
            ['birthday', 'date', 'format' => 'php:Y-m-d'],
            ['verifyCode', 'required'],
            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', CaptchaValidator::className()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'birthday' => '生日',
            'verifyCode' => '验证码',
        ];
    }
}
