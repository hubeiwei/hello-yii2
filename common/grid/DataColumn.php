<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/11/8
 * Time: 13:36
 */

namespace app\common\grid;

use kartik\grid\DataColumn as KartikDataColumn;

/**
 * 不想td换行才有了这个类
 * 另外如果是用css控制td居中，那么Select2的文字也会被居中，所以在这里配置了居中
 */
class DataColumn extends KartikDataColumn
{
    public $hAlign = GridView::ALIGN_CENTER;

    public $vAlign = GridView::ALIGN_MIDDLE;

    public $noWrap = true;
}
