<?php

namespace app\models;

use Yii;
use app\models\base\UserBase;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

class User extends UserBase implements IdentityInterface
{
    const COMMON_KEY = 'LaoHu';

    const TYPE_MEMBER = 'Member';
    const TYPE_ADMIN = 'Admin';
    public static $type_array = [
        self::TYPE_MEMBER,
        self::TYPE_ADMIN,
    ];
    public static $type_map = [
        self::TYPE_MEMBER => '用户',
        self::TYPE_ADMIN => '管理员',
    ];

    const STATUS_DISABLE = 'N';
    const STATUS_ENABLE = 'Y';
    public static $status_array = [
        self::STATUS_DISABLE,
        self::STATUS_ENABLE,
    ];
    public static $status_map = [
        self::STATUS_DISABLE => '禁用',
        self::STATUS_ENABLE => '启用',
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['password', 'string', 'min' => 8],
            ['type', 'in', 'range' => self::$type_array],
            ['status', 'in', 'range' => self::$status_array],
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
            'user_id' => 'ID',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->passkey = Yii::$app->security->generateRandomString(6);
                $this->access_token = Yii::$app->security->generateRandomString(64);
                $this->hashPassword();
            }

            /**
             * TODO 主动登录后更新auth_key可以踢掉其他端的，但是要其他端下一次打开浏览器才生效，研究发现要把cookie里的session_id删掉才能做到立即踢掉，以后再研究能不能马上把用户踢掉
             */
            $this->auth_key = Yii::$app->security->generateRandomString(64);
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
        /** @var self $user */
        $user = self::find()->where(['access_token' => $token, 'status' => self::STATUS_ENABLE])->limit(1)->one();
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
        if($this->status == self::STATUS_ENABLE) {
            return $this->auth_key === $authKey;
        }
        return false;
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

    public function hashPassword()
    {
        $password = $this->encryptPassword($this->password);
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

}
