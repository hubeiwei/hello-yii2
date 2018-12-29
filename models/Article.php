<?php

namespace app\models;

use app\models\base\ArticleBase;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Markdown;

class Article extends ArticleBase
{
    const TYPE_HTML = 0;
    const TYPE_MARKDOWN = 1;

    /**
     * @param int $value
     * @return array|string|null
     */
    public static function typeMap($value = -1)
    {
        $map = [
            self::TYPE_HTML => 'Html',
            self::TYPE_MARKDOWN => 'Markdown',
        ];
        if ($value == -1) {
            return $map;
        }
        return ArrayHelper::getValue($map, $value);
    }

    const VISIBLE_NO = 0;
    const VISIBLE_YES = 1;

    /**
     * @param int $value
     * @return array|string|null
     */
    public static function visibleMap($value = -1)
    {
        $map = [
            self::VISIBLE_YES => '显示',
            self::VISIBLE_NO => '隐藏',
        ];
        if ($value == -1) {
            return $map;
        }
        return ArrayHelper::getValue($map, $value);
    }

    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;

    /**
     * @param int $value
     * @return array|string|null
     */
    public static function statusMap($value = -1)
    {
        $map = [
            self::STATUS_ENABLE => '启用',
            self::STATUS_DISABLE => '禁用',
        ];
        if ($value == -1) {
            return $map;
        }
        return ArrayHelper::getValue($map, $value);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_by'],
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
            ['type', 'in', 'range' => array_keys(self::typeMap())],
            ['visible', 'in', 'range' => array_keys(self::visibleMap())],
            ['status', 'in', 'range' => array_keys(self::statusMap())],
        ]);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * 解析文章
     *
     * @return string
     */
    public function processArticle()
    {
        $content = '<article class="article-body">';
        if ($this->type == self::TYPE_MARKDOWN) {
            $content .= Markdown::process($this->content, 'gfm');
        } else if ($this->type == self::TYPE_HTML) {
            $content .= $this->content;
        }
        $content .= '</article>';
        return $content;
    }
}
