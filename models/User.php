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
     * 详细注释在Music这个Model里面了
     * @see Music::behaviors()
     *
     * @return array
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->passkey = Yii::$app->security->generateRandomString(6);
                $this->access_token = Yii::$app->security->generateRandomString(64);
                $this->hashPassword();
            }

            /**
             * auth_key字段是自动登录时，取cookie记录的值往数据库查找对应用户来实现的，
             * 所以强烈建议这个字段的值必须是为唯一的。
             * 根据目前项目内的情况，无论添加还是修改（包括登录）都要更新auth_key，
             * 例如，超管把用户禁用了，自动登录的用户是不会受影响的。
             *
             * TODO 主动登录后更新可以踢掉其他端的，但是要其他端下一次打开浏览器才生效，研究发现要把cookie里的session_id删掉才能做到立即踢掉，以后再研究能不能马上把用户踢掉
             */
            $this->auth_key = Yii::$app->security->generateRandomString(64);
            return true;
        }
        return false;
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var self $user */
        $user = self::find()->where(['access_token' => $token, 'status' => self::STATUS_ENABLE])->limit(1)->one();
        if ($user->access_token === $token) {
            return $user;
        }
        return null;
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

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
