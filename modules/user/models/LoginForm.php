<?php

namespace app\modules\user\models;

use app\common\captcha\CaptchaValidator;
use app\common\helpers\UserHelper;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $rememberMe = false;

    public $validatePasswordMethod = 'validatePassword';
    public $loginSecond = 7 * 24 * 60 * 60;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'verifyCode' => '验证码',
            'rememberMe' => '记住我',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'verifyCode'], 'required'],
            ['username', 'string', 'max' => 20],
            ['password', 'string', 'min' => 8, 'max' => 20],
            ['password', 'validatePassword'],
            [['verifyCode'], 'string', 'length' => 4],
            [['verifyCode'], CaptchaValidator::className()],
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !call_user_func([$user, $this->validatePasswordMethod], $this->password)) {
                $this->addError($attribute, '用户名或密码错误');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            return Yii::$app->user->login($user, $this->rememberMe ? $this->loginSecond : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return yii\web\IdentityInterface|yii\db\ActiveRecord|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $userHelper = UserHelper::get();
            $this->_user = call_user_func([$userHelper->userClass, 'find'])
                ->where([$userHelper->usernameField => $this->username])
                ->limit(1)
                ->one();
        }
        return $this->_user;
    }
}
