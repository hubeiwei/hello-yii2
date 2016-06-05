<?php

namespace app\models;

use app\models\base\UserDetailBase;
use Yii;
use yii\behaviors\TimestampBehavior;

class UserDetail extends UserDetailBase
{
    const gender_secrecy = '0';
    const gender_man = '1';
    const gender_woman = '2';
    public static $gender_array = [
        self::gender_secrecy,
        self::gender_man,
        self::gender_woman,
    ];
    public static $gender_map = [
        self::gender_secrecy => '保密',
        self::gender_man => '男',
        self::gender_woman => '女',
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
