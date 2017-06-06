<?php

namespace app\modules\user\models;

use app\common\captcha\CaptchaValidator;
use app\common\extensions\StrengthValidator;
use app\models\User;
use app\models\UserDetail;
use hubeiwei\yii2tools\helpers\Helper;
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
            [['username', 'email'], 'filter', 'filter' => 'trim'],
            [['username', 'email'], 'unique', 'targetClass' => User::className()],
            ['username', 'string', 'max' => 20],
            ['password', StrengthValidator::className()],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', CaptchaValidator::className()],
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

    public function register()
    {
        if (!$this->validate()) {
            return null;
        }

        $flow = true;
        $transaction = Helper::beginTransaction();
        try {
            $user = new User();
            $user->username = $this->username;
            $user->setPassword($this->password);
            $user->email = $this->email;
            $user->generateAuthKey();
            $flow = $user->save();

            if ($flow) {
                $user_detail = new UserDetail();
                $user_detail->user_id = $user->id;
                $flow = $user_detail->save();
            }

            if ($flow) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }

        return $flow;
    }
}
