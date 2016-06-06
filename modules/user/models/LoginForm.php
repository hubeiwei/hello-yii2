<?php

namespace app\modules\user\models;

use Yii;
use app\models\User;
use app\modules\core\extensions\HuCaptchaValidator;
use app\modules\core\helpers\EasyHelper;
use yii\base\Exception;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $rememberMe = false;

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
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'verifyCode'], 'required'],
            ['username', 'string', 'max' => 20],
            ['password', 'string', 'min' => 8, 'max' => 20],
            ['password', 'validatePassword'],
            [['verifyCode'], 'string', 'length' => 4],
            [['verifyCode'], HuCaptchaValidator::className()],
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
            if (!$user || !$user->validatePassword($this->password)) {
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

            $user->last_login = time();
            $user->last_ip = EasyHelper::getRealIP();

            if ($user->save()) {
                return Yii::$app->user->login($user, $this->rememberMe ? 60 * 60 * 24 * 7 : 0);
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()->where(['username' => $this->username, 'status' => User::STATUS_ENABLE])->limit(1)->one();
        }
        return $this->_user;
    }
}
