<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $user_id
 * @property string $username
 * @property string $password
 * @property string $passkey
 * @property string $status
 * @property string $auth_key
 * @property string $access_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $last_login
 * @property string $last_ip
 */
class UserBase extends \app\modules\core\extensions\HuActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'passkey', 'auth_key', 'access_token'], 'required'],
            [['created_at', 'updated_at', 'last_login'], 'integer'],
            [['username'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 255],
            [['passkey'], 'string', 'max' => 6],
            [['auth_key', 'access_token'], 'string', 'max' => 64],
            [['last_ip'], 'string', 'max' => 15],
            [['username'], 'unique'],
            [['auth_key'], 'unique'],
            [['access_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => '用户名',
            'password' => '密码',
            'passkey' => 'Passkey',
            'status' => '状态',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'last_login' => '最后登录时间',
            'last_ip' => '最后登录IP',
        ];
    }
}
