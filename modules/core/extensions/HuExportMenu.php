<?php
namespace app\modules\core\extensions;

use kartik\export\ExportMenu;
use Yii;

/**
 * 需要依赖kartik-v/yii2-export
 * @link https://github.com/kartik-v/yii2-export
 */
class HuExportMenu extends ExportMenu
{
    public $exportFormView = '@vendor/kartik-v/yii2-export/views/_form';

    public $exportColumnsView = '@vendor/kartik-v/yii2-export/views/_columns';

    public $afterSaveView = '@vendor/kartik-v/yii2-export/views/_view';

//    public $batchSize = 500;

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
