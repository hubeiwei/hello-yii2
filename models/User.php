<?php

namespace app\models;

use app\models\base\UserBase;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class User extends UserBase implements IdentityInterface
{
    /** @var int second */
    const PASSWORD_RESET_TOKEN_EXPIRE = 600;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
    public static $status_list = [
        self::STATUS_INACTIVE,
        self::STATUS_ACTIVE,
    ];

    /**
     * @param int $value
     * @return array|string|null
     */
    public static function statusMap($value = -1)
    {
        $map = [
            self::STATUS_ACTIVE => '启用',
            self::STATUS_INACTIVE => '禁用',
        ];
        if ($value == -1) {
            return $map;
        }
        return ArrayHelper::getValue($map, $value);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['password_hash', 'string', 'min' => 8],
            ['status', 'in', 'range' => self::$status_list],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'username' => '用户名',
            'password_reset_token' => '密码重置口令',
            'email' => '邮箱',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ]);
    }

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
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function encryptPassword()
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
    }

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
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return ($timestamp + self::PASSWORD_RESET_TOKEN_EXPIRE) >= time();
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

    public function getDetail()
    {
        return $this->hasOne(UserDetail::className(), ['user_id' => 'id']);
    }

    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['created_by' => 'id']);
    }

    public function getMusics()
    {
        return $this->hasMany(Music::className(), ['user_id' => 'id']);
    }
}
