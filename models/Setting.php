<?php

namespace app\models;

use app\models\base\SettingBase;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Setting extends SettingBase
{
    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;
    public static $status_list = [
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
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'updated_by',
                    self::EVENT_BEFORE_UPDATE => 'updated_by',
                ],
            ],
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['status', 'in', 'range' => self::$status_list],
        ]);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by'])->from(['user' => User::tableName()]);
    }
}
