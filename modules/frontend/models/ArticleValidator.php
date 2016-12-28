<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/6/8
 * Time: 2:18
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\frontend\models;

use app\common\captcha\CaptchaValidator;
use yii\base\Model;
use yii\validators\DateValidator;

class ArticleValidator extends Model
{
    public $published_at;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'published_at' => '发布时间',
            'verifyCode' => '验证码',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['published_at'], 'required'],
            ['published_at', 'date', 'type' => DateValidator::TYPE_DATETIME, 'format' => 'php:Y-m-d H:i'],
            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', CaptchaValidator::className()],
        ];
    }
}
