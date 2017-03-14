<?php

namespace hubeiwei\yii2tools\grid;

use kartik\grid\SerialColumn as KartikSerialColumn;

/**
 * 不想 td 换行才有了这个类
 */
class SerialColumn extends KartikSerialColumn
{
    public $noWrap = true;
}
