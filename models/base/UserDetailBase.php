<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "user_detail".
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property string $avatar_file 头像文件
 * @property int $gender 性别
 * @property int $birthday 生日
 * @property string $phone 电话
 * @property string $resume 简介
 * @property int $updated_at 修改时间
 */
class UserDetailBase extends \hubeiwei\yii2tools\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'gender', 'birthday', 'updated_at'], 'integer'],
            [['avatar_file', 'resume'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 11],
            [['user_id'], 'unique'],
            [['phone'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
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
