<?php

namespace hubeiwei\yii2tools\grid;

use kartik\grid\GridView as KartikGridView;

/**
 * 继承 \kartik\grid\GridView 只是为了方便加代码，以及配置一些单独使用时的配置
 * 在 RenderHelper 封装的代码是根据业务来进行的
 * @see \hubeiwei\yii2tools\helpers\RenderHelper::gridView()
 */
class GridView extends KartikGridView
{
    public $pager = [
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
    ];

    public $dataColumnClass = '\hubeiwei\yii2tools\grid\DataColumn';

    public $resizableColumns = false;

    public $responsiveWrap = false;

    public $hover = true;

    public $export = false;
}
