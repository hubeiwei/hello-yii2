<?php

namespace app\modules\user\models;

use app\common\captcha\CaptchaValidator;
use app\models\User;
use app\modules\core\extensions\StrengthValidator;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPassword extends Model
{
    public $password;
    public $password_repeat;
    public $verifyCode;
    /**
     * @var User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  string $token
     * @param  array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('密码重置口令不能为空');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('错误的密码重置口令');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password', StrengthValidator::className(), 'hasUser' => false],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', CaptchaValidator::className()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '新密码',
            'password_repeat' => '确认密码',
            'verifyCode' => '验证码',
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->password_hash = $this->password;
        $user->encryptPassword();
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
