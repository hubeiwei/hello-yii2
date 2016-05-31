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
     *
     * @return array
     *
     * @see Music::behaviors()
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                //只有修改时间
                'attributes' => [
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            /**
             * 用户信息因为日期的问题所以都用UserDetailForm来验证前端的内容了
             * 邮箱规则也顺便写在那些类里了
             * 所以这里不弄什么规则了
             * @see app\modules\user\models\RegisterForm
             * @see app\modules\user\models\UserDetailForm
             */
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
