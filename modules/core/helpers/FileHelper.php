<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/25
 * Time: 1:02
 * To change this template use File | Setting | File Templates.
 */

namespace app\modules\core\helpers;

use Yii;
use yii\helpers\Url;

class FileHelper
{
    /**
     * 配置项，下面的方法没事就不用改了
     */
    const MUSIC_PATH = 'file/music/';
    const MUSIC_EXTENSION = 'mp3';
    const MUSIC_SIZE = 20971520;

    /**
     * 生成文件名，统一在这获取文件名，以后想换个取名字的方式，就改这里
     *
     * @param string $extension 默认空，以后想同时获得扩展名的时候直接在这里传就好了，不用加"."
     * @return string
     */
    public static function generateFileName($extension = '')
    {
        $filename = UserHelper::getUserId() . '_' . Yii::$app->security->generateRandomString(20);
        if ($extension) {
            $filename .= '.' . $extension;
        }
        return $filename;
    }

    /**
     * 获取音乐目录的完整磁盘路径
     * 这样做的目的是让项目搭载在任何目录和系统下都能上传文件
     *
     * @param string $fileName 音乐文件名
     * @return string
     */
    public static function getMusicFullPath($fileName)
    {
        return Yii::$app->basePath . '/web/' . self::MUSIC_PATH . $fileName . '.' . self::MUSIC_EXTENSION;
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
        return self::getMusicPathUrl() . $fileName . '.' . self::MUSIC_EXTENSION;
    }
}
