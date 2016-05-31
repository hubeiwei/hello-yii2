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
     * 生成文件名，统一在这生成文件名，以后想换个取名字的方式，就改这里
     *
     * @param string $extension 预留参数，默认空，以后想生成扩展名的时候直接在这里传就好了
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
     *
     * @param string $dot 有需要可以加上'.'
     * @return string
     */
    public static function getMusicExtension($dot = '')
    {
        return $dot . self::MUSIC_EXTENSION;
    }

    /**
     * 获取音乐文件路径
     *
     * @param string $basePath
     * @return string
     */
    public static function getMusicPath($basePath = '')
    {
        return $basePath . self::MUSIC_PATH;
    }

    /**
     * 生成音乐文件完整路径，包括磁盘路径
     *
     * @param string $fileName 文件名
     * @return string
     */
    public static function getMusicFullPath($fileName)
    {
        return Yii::$app->basePath . self::getMusicPath('/web/') . $fileName . self::getMusicExtension('.');
    }

    /**
     * @return string 生成音乐路径的url
     */
    public static function getMusicPathUrl()
    {
        return Url::to('@web' . FileHelper::getMusicPath('/'), true);
    }

    public static function getMusicFullUrl($fileName)
    {
        return self::getMusicPathUrl() . $fileName . self::getMusicExtension('.');
    }
}