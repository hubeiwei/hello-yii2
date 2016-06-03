<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/29
 * Time: 15:06
 * To change this template use File | Settings | File Templates.
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class ManageAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $js = [
    ];
    public $css = [
        'css/site.css',
        'css/manage.css',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}