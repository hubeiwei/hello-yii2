<?php

namespace app\modules\portal\models;

use app\modules\core\helpers\FileHelper;

class MusicUploadForm extends MusicFormBase
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['music_file', 'required'],

            /**
             * 注释掉的这个扩展名验证总是不准，写了一个方法来判断
             * @see MusicFormBase::verifyExtension()
             */
            ['music_file', 'file', 'skipOnEmpty' => false, 'maxSize' => FileHelper::MUSIC_SIZE/*, 'extensions' => ['mp3', ]*/],
        ]);
    }
}
