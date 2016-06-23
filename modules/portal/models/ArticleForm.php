<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/6/8
 * Time: 2:18
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\portal\models;

use app\models\Article;
use app\modules\core\extensions\HuCaptchaValidator;
use yii\base\Model;
use yii\validators\DateValidator;

class ArticleForm extends Model
{
    public $title;
    public $content;
    public $published_at;
    public $visible;
    public $type;
    public $verifyCode;

    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'content' => '内容',
            'published_at' => '发布时间',
            'visible' => '可见性',
            'verifyCode' => '验证码',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'content', 'type', 'published_at'], 'required'],
            ['title', 'string', 'max' => 20],
            ['content', 'string'],
            ['published_at', 'date', 'type' => DateValidator::TYPE_DATETIME, 'format' => 'php:Y-m-d H:i'],
            ['visible', 'in', 'range' => Article::$visible_array],
            ['type', 'in', 'range' => Article::$type_array],
            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', HuCaptchaValidator::className()],
        ];
    }
}