<?php

namespace hubeiwei\yii2tools\grid;

use kartik\grid\DataColumn as KartikDataColumn;

/**
 * 不想 td 换行才有了这个类
 * 另外如果是用 css 控制 td 居中，那么 Select2 的文字也会被居中，所以在这里配置了居中
 */
class DataColumn extends KartikDataColumn
{
    public $hAlign = GridView::ALIGN_CENTER;

    public $vAlign = GridView::ALIGN_MIDDLE;

    public $noWrap = true;
}
