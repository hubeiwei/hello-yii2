<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_by
 * @property integer $published_at
 * @property string $content
 * @property integer $visible
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class ArticleBase extends \hubeiwei\yii2tools\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'published_at', 'content', 'type'], 'required'],
            [['created_by', 'published_at', 'visible', 'type', 'status', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'created_by' => '作者',
            'published_at' => '发布时间',
            'content' => '内容',
            'visible' => '可见性',
            'type' => '文章类型',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
