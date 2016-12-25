<?php

namespace app\models;

use app\models\base\UserDetailBase;
use yii\behaviors\TimestampBehavior;

class UserDetail extends UserDetailBase
{
    const GENDER_SECRECY = '0';
    const GENDER_MAN = '1';
    const GENDER_WOMAN = '2';
    public static $gender_list = [
        self::GENDER_SECRECY,
        self::GENDER_MAN,
        self::GENDER_WOMAN,
    ];
    public static $gender_map = [
        self::GENDER_SECRECY => '保密',
        self::GENDER_MAN => '男',
        self::GENDER_WOMAN => '女',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'updated_at',
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['gender', 'in', 'range' => self::$gender_list],
            ['phone', 'match', 'pattern' => '/^1[34578]\d{9}$/'],
        ]);
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            // 挖了个大坑，值为空字符串时无法通过唯一约束
            if (empty($this->phone)) {
                $this->phone = null;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'avatar_file' => '头像',
        ]);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
