<?php

namespace app\models;

use Yii;
use app\models\base\UserBase;
use yii\behaviors\TimestampBehavior;

class User extends UserBase implements \yii\web\IdentityInterface
{
    const COMMON_KEY = 'LaoHu';

    const type_member = 'Member';
    const type_admin = 'Admin';
    public static $type_array = [
        self::type_member,
        self::type_admin,
    ];
    public static $type_map = [
        self::type_member => '用户',
        self::type_admin => '管理员',
    ];

    const status_disable = 'N';
    const status_enable = 'Y';
    public static $status_array = [
        self::status_disable,
        self::status_enable,
    ];
    public static $status_map = [
        self::status_disable => '禁用',
        self::status_enable => '启用',
    ];

    /**
     * 详细注释在Music这个Model里面了
     *
     * @return array
     *
     * @see Music::behaviors()
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['password', 'string', 'min' => 8],
            ['type', 'in', 'range' => self::$type_array],
            ['status', 'in', 'range' => self::$status_array],
        ]);
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'user_id' => 'ID',
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::findOne(['access_token' => $token]);
        if ($user->access_token === $token) {
            return $user;
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function generatePasskey($length = 6)
    {
        $this->passkey = Yii::$app->security->generateRandomString($length);
    }

    public function generateAuthKey($length = 64)
    {
        $this->auth_key = Yii::$app->security->generateRandomString($length);
    }

    public function generateAccessToken($length = 64)
    {
        $this->access_token = Yii::$app->security->generateRandomString($length);
    }

    public function generateKey($password = '')
    {
        if (empty($password)) {
            $password = $this->password;
        }
        $this->generatePasskey();
        $this->generateAuthKey();
        $this->generateAccessToken();
        $this->hashPassword($password);
    }

    public function encryptPassword($password)
    {
        $password = md5($password) . md5(self::COMMON_KEY . $this->passkey);
        return $password;
    }
    
    public function validatePassword($password)
    {
        $password = $this->encryptPassword($password);
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function hashPassword($password = '')
    {
        if (empty($password)) {
            $password = $this->password;
        }
        $password = $this->encryptPassword($password);
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

}
