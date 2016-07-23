<?php

namespace app\models;

use Yii;
use app\models\base\UserBase;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

class User extends UserBase implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
    public static $status_array = [
        self::STATUS_INACTIVE,
        self::STATUS_ACTIVE,
    ];
    public static $status_map = [
        self::STATUS_INACTIVE => '禁用',
        self::STATUS_ACTIVE => '启用',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->encryptPassword();
            }
            $this->generateAuthKey();
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['password_hash', 'string', 'min' => 8],
            ['status', 'in', 'range' => self::$status_array],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), [
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
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
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
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
        if ($this->status == self::STATUS_ACTIVE) {
            return $this->getAuthKey() === $authKey;
        }
        return false;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function encryptPassword()
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
    }

    /**
     * TODO 主动登录后更新auth_key可以踢掉其他端的，但是要其他端下一次打开浏览器才生效，研究发现要把cookie里的session_id删掉才能做到立即踢掉，以后再研究能不能马上把用户踢掉
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
