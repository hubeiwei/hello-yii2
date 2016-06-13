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
use yii\web\UploadedFile;

class FileHelper
{
    /**
     * 配置项，其他代码没事就不动了
     */
    const MUSIC_PATH = 'file/music/';
    const MUSIC_EXTENSION = 'mp3';
    const MUSIC_SIZE = 20971520;

    /**
     * 生成文件名，统一在这获取文件名，以后想换个取名字的方式，就改这里
     *
     * @param string $extension 默认空，以后想同时获得扩展名的时候直接在这里传就好了
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
     * 获取音乐文件扩展名
     * 感觉其实没必要弄这个方法，好像就是为了拼接而已
     *
     * @param string $dot 弄这个只是为了方便拼接"."
     * @return string
     */
    public static function getMusicExtension($dot = '')
    {
        return $dot . self::MUSIC_EXTENSION;
    }

    /**
     * 获取音乐文件路径
     *
     * @param string $basePath 弄了这个只是为了方便拼接路径
     * @return string
     */
    public static function getMusicPath($basePath = '')
    {
        return $basePath . self::MUSIC_PATH;
    }

    /**
     * 获取音乐文件完整路径
     *
     * @param string $fileName 音乐文件名
     * @return string
     */
    public static function getMusicFullPath($fileName)
    {
        return Yii::$app->basePath . self::getMusicPath('/web/') . $fileName . self::getMusicExtension('.');
    }

    /**
     * 获取音乐路径url
     * 
     * @return string
     */
    public static function getMusicPathUrl()
    {
        return Url::to('@web' . self::getMusicPath('/'), true);
    }

    /**
     * 获取音乐完整url
     * 
     * @param string $fileName 文件名 
     * @return string
     */
    public static function getMusicFullUrl($fileName)
    {
        return self::getMusicPathUrl() . $fileName . self::getMusicExtension('.');
    }
}