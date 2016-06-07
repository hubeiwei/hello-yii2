<?php

namespace app\models;

use app\models\base\SettingBase;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Setting extends SettingBase
{
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
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
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
            'creater.username' => '创建者',
            'updater.username' => '最后操作者',
        ]);
    }

    public function getCreater()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }
}
