<?php

namespace app\modules\portal\models;

use app\modules\core\helpers\FileHelper;

class MusicUpdateForm extends MusicFormBase
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'music_file' => '新文件（可不选）',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['music_file', 'file', 'skipOnEmpty' => true, 'maxSize' => FileHelper::MUSIC_SIZE],
        ]);
    }
}
