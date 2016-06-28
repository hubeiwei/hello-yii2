<?php
namespace app\modules\core\extensions\HuExportMenu;

use kartik\export\ExportMenu;
use Yii;

/**
 * 需要依赖kartik-v/yii2-export
 * @link https://github.com/kartik-v/yii2-export
 */
class HuExportMenu extends ExportMenu
{
    /**
     * 打算在这里弄个导出时临时修改内存的，还在建设中
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
//        if ($this->_triggerDownload) {
//            $memory = Setting::cacheGet('php_memory');
//            ini_set('memory_limit', $memory);
//            $time = Setting::cacheGet('php_execute_time');
//            set_time_limit($time);
//        }
        parent::run();
    }
}