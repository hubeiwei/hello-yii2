<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "music".
 *
 * @property string $id
 * @property string $track_title
 * @property string $music_file
 * @property string $user_id
 * @property string $visible
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class MusicBase extends \app\modules\core\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'music';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['track_title', 'music_file'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['visible', 'status'], 'string'],
            [['track_title'], 'string', 'max' => 50],
            [['music_file'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
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
