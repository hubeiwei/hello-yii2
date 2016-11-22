<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property string $id
 * @property string $key
 * @property string $value
 * @property string $status
 * @property string $description
 * @property string $tag
 * @property string $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class SettingBase extends \app\common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['value', 'status'], 'string'],
            [['updated_by', 'created_at', 'updated_at'], 'integer'],
            [['key', 'tag'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 200],
            [['key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => '键',
            'value' => '值',
            'status' => '状态',
            'description' => '描述',
            'tag' => '标记',
            'updated_by' => '最后操作者',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
