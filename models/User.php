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
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
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

    /**
     * 验证密码
     *
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * 加密密码
     *
     * @param $password
     * @return string
     */
    public function encryptPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 设置密码
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = $this->encryptPassword($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function refreshAuthKey()
    {
        $this->generateAuthKey();
        return $this->save();
    }

    /**
     * 根据用户名查找
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
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
