<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "music".
 *
 * @property int $id
 * @property string $track_title 标题
 * @property string $music_file 音乐文件
 * @property int $user_id 用户ID
 * @property int $visible 可见性
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 */
class MusicBase extends \hubeiwei\yii2tools\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'music';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['track_title', 'music_file'], 'required'],
            [['user_id', 'visible', 'status', 'created_at', 'updated_at'], 'integer'],
            [['track_title'], 'string', 'max' => 50],
            [['music_file'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'track_title' => '标题',
            'music_file' => '音乐文件',
            'user_id' => '用户ID',
            'visible' => '可见性',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
