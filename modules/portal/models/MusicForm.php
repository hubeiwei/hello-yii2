<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/17
 * Time: 14:32
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\portal\models;

use app\models\Music;
use app\modules\core\extensions\HuCaptchaValidator;
use app\modules\core\helpers\FileHelper;
use yii\base\Model;

class MusicForm extends Model
{
    public $track_title;
    /** @var \yii\web\UploadedFile */
    public $music_file;
    public $visible;
    public $status = Music::STATUS_ENABLE;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'track_title' => '标题',
            'music_file' => '文件',
            'visible' => '可见性',
            'status' => '状态',
            'verifyCode' => '验证码',
        ];
    }

    public function scenarios()
    {
        return [
            'create' => ['track_title', 'music_file', 'visible', 'status', 'verifyCode'],
            'update' => ['track_title', 'music_file', 'visible', 'status', 'verifyCode'],
        ];
    }

    public function rules()
    {
        return [
            ['music_file', 'required', 'on' => 'create'],
            ['music_file', 'file', 'maxSize' => FileHelper::MUSIC_SIZE],
            ['music_file', 'verifyExtension'],//自带的格式验证经常不准，另外写了一个
            [['track_title', 'verifyCode'], 'required'],
            ['track_title', 'string', 'max' => 50],
            ['visible', 'in', 'range' => Music::$visible_array],
            ['status', 'in', 'range' => Music::$status_array],
            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', HuCaptchaValidator::className()],
        ];
    }

    public function verifyExtension($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $extension = FileHelper::MUSIC_EXTENSION;
            if ($this->music_file->extension != $extension) {
                $this->addError($attribute, '扩展名不是' . $extension);
            }
        }
    }
}