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
            [['verifyCode'], 'string', 'length' => 4],
            [['verifyCode'], HuCaptchaValidator::className()],
            ['rememberMe', 'boolean'],

            /**
             * 以上方法在前端不提交就可以验证了，
             * 以下自定验证方法在提交后才进行验证，建议放在最后，
             * 如果用ajax想提交一次获得一条错误提示的话，那就可以考虑布置一下所有规则的顺序，但感觉没人会用ajax这么做
             */

            ['password', 'validatePassword'],
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

            //TODO auth_key是cookie自动登录用的字段，主动登录后更新，可以踹掉其他端的，但是要其他端下一次打开浏览器才能生效，研究发现要把cookie里的session_id删掉才行，以后再研究能不能马上把用户踢掉
            $user->generateAuthKey();
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
            $this->_user = User::find()->where(['username' => $this->username, 'status' => User::status_enable])->one();
        }
        return $this->_user;
    }
}
