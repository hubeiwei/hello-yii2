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

class MusicFormBase extends Model
{
    public $track_title;
    /** @var \yii\web\UploadedFile */
    public $music_file;
    public $visible;
    public $status = Music::STATUS_ENABLE;//非管理员提交的时候没有值也能插入数据库，导致前台调用数组报错，要设置个默认值
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

    public function rules()
    {
        return [
            [['track_title', 'verifyCode'], 'required'],
            ['track_title', 'string', 'max' => 50],
            ['visible', 'in', 'range' => Music::$visible_array],
            ['status', 'in', 'range' => Music::$status_array],
            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', HuCaptchaValidator::className()],

            /**
             * 以上方法在前端不提交就可以验证了，
             * 以下自定验证方法在提交后才进行验证，建议放在最后。
             *
             * 另外如果用ajax想提交一次获得一条错误提示的话，那就可以考虑布置一下所有规则的顺序，
             * 但我感觉有了这么好的表单验证，我不会这么做。
             */
            
            ['music_file', 'verifyExtension'],
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