<?php

namespace app\models\Base;

/**
 * This is the model class for table "article".
 *
 * @property string $id
 * @property string $title
 * @property string $created_by
 * @property string $published_at
 * @property string $content
 * @property string $visible
 * @property string $type
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class ArticleBase extends \hubeiwei\yii2tools\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'published_at', 'content', 'type'], 'required'],
            [['created_by', 'published_at', 'created_at', 'updated_at'], 'integer'],
            [['content', 'visible', 'type', 'status'], 'string'],
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
