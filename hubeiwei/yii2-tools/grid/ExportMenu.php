<?php

namespace hubeiwei\yii2tools\grid;

use kartik\export\ExportMenu as KartikExportMenu;

/**
 * 虽然在 RenderHelper 有根据业务来封装，但为了有时候能单独使用 ExportMenu，在这里进行部分配置
 * @see \hubeiwei\yii2tools\helpers\RenderHelper::gridView()
 * @see \hubeiwei\yii2tools\helpers\RenderHelper::dynaGrid()
 */
class ExportMenu extends KartikExportMenu
{
    public $exportFormView = '@vendor/kartik-v/yii2-export/views/_form';

    public $exportColumnsView = '@vendor/kartik-v/yii2-export/views/_columns';

    public $afterSaveView = '@vendor/kartik-v/yii2-export/views/_view';

//    public $batchSize = 500;

    /**
     * 打算在这里弄个导出时临时修改内存的，还没开始用
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
