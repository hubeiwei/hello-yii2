<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/17
 * Time: 14:32
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\frontend\models;

use app\common\captcha\CaptchaValidator;
use app\models\Music;
use yii\base\Model;

class MusicValidator extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /** @var \yii\web\UploadedFile */
    public $music_file;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'music_file' => '文件',
            'verifyCode' => '验证码',
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $baseAttributes = ['music_file', 'verifyCode'];
        $scenarios = array_merge(parent::scenarios(), [
            self::SCENARIO_CREATE => $baseAttributes,
            self::SCENARIO_UPDATE => $baseAttributes,
        ]);

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['music_file', 'required', 'on' => self::SCENARIO_CREATE],
            ['music_file', 'file',
                'extensions' => ['mp3'],
                'checkExtensionByMimeType' => false,
                'maxSize' => Music::MUSIC_SIZE,
            ],
            ['verifyCode', 'required'],
            ['verifyCode', 'string', 'length' => 4],
            ['verifyCode', CaptchaValidator::className()],
        ];
    }
}
