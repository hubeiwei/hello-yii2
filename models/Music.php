<?php

namespace app\models;

use app\models\base\MusicBase;
use app\modules\core\helpers\UserHelper;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

class Music extends MusicBase
{
    const MUSIC_PATH = 'file/music/';
    const MUSIC_EXTENSION = ['mp3'];
    const MUSIC_SIZE = 20971520;

    const VISIBLE_YES = 'Y';
    const VISIBLE_NO = 'N';
    public static $visible_array = [
        self::VISIBLE_YES,
        self::VISIBLE_NO,
    ];
    public static $visible_map = [
        self::VISIBLE_YES => '显示',
        self::VISIBLE_NO => '隐藏',
    ];

    const STATUS_DISABLE = 'N';
    const STATUS_ENABLE = 'Y';
    public static $status_array = [
        self::STATUS_ENABLE,
        self::STATUS_DISABLE,
    ];
    public static $status_map = [
        self::STATUS_ENABLE => '启用',
        self::STATUS_DISABLE => '禁用',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'user_id',
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
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'user.username',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'user.username' => '上传者',
        ]);
    }

    /**
     * @param $file \yii\web\UploadedFile
     * @return bool
     */
    public function uploadMusic($file)
    {
        $this->music_file = Yii::$app->security->generateRandomString(20) . '_' . UserHelper::getUserId() . '.' . $file->extension;
        return $file->saveAs($this->getMusicFullPath($this->music_file));
    }

    public function deleteMusic()
    {
        unlink($this->getMusicFullPath($this->music_file));
    }


    /**
     * 获取音乐目录的完整磁盘路径
     * 这样做的目的是让项目搭载在任何目录和系统下都能上传文件
     *
     * @param $filename
     * @return string
     */
    public static function getMusicFullPath($filename)
    {
        return Yii::getAlias('@webroot/' . self::MUSIC_PATH . $filename);
    }

    /**
     * 获取音乐目录的url
     *
     * @return string
     */
    public static function getMusicPathUrl()
    {
        return Url::to('@web/' . self::MUSIC_PATH, true);
    }

    /**
     * 获取音乐文件的完整url
     *
     * @param string $fileName 文件名
     * @return string
     */
    public static function getMusicFullUrl($fileName)
    {
        return self::getMusicPathUrl() . $fileName;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
