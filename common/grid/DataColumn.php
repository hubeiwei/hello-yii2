<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/11/8
 * Time: 13:36
 */

namespace app\common\grid;

use kartik\grid\DataColumn as KartikDataColumn;

class DataColumn extends KartikDataColumn
{
    public $hAlign = GridView::ALIGN_CENTER;

    public $vAlign = GridView::ALIGN_MIDDLE;

    public $noWrap = true;
}
