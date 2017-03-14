<?php

namespace app\models\base;

/**
 * This is the model class for table "user_detail".
 *
 * @property string $id
 * @property string $user_id
 * @property string $avatar_file
 * @property string $gender
 * @property string $birthday
 * @property string $phone
 * @property string $resume
 * @property string $updated_at
 */
class UserDetailBase extends \hubeiwei\yii2tools\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'birthday', 'updated_at'], 'integer'],
            [['gender'], 'string'],
            [['avatar_file', 'resume'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 11],
            [['user_id'], 'unique'],
            [['phone'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'avatar_file' => '头像文件',
            'gender' => '性别',
            'birthday' => '生日',
            'phone' => '电话',
            'resume' => '简介',
            'updated_at' => '修改时间',
        ];
    }
}
