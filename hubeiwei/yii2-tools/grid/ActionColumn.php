<?php

namespace hubeiwei\yii2tools\grid;

use kartik\grid\ActionColumn as KartikActionColumn;

/**
 * 不想 td 换行才有了这个类
 */
class ActionColumn extends KartikActionColumn
{
    public $noWrap = true;
}
