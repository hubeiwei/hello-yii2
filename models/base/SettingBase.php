<?php

namespace app\models\base;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property integer $status
 * @property string $description
 * @property string $tag
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class SettingBase extends \hubeiwei\yii2tools\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['value'], 'string'],
            [['status', 'updated_by', 'created_at', 'updated_at'], 'integer'],
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
