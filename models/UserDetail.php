<?php

namespace app\models;

use app\models\base\UserDetailBase;
use Yii;
use yii\behaviors\TimestampBehavior;

class UserDetail extends UserDetailBase
{
    const GENDER_SECRECY = '0';
    const GENDER_MAN = '1';
    const GENDER_WOMAN = '2';
    public static $gender_array = [
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
     * 详细注释在Music这个Model里面了
     * @see Music::behaviors()
     *
     * @return array
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

    public function rules()
    {
        return array_merge(parent::rules(), [
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
            'avatar_file' => '头像',
        ]);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}
