<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/11/8
 * Time: 15:08
 */

namespace app\common\grid;

use kartik\grid\SerialColumn as KartikSerialColumn;

class SerialColumn extends KartikSerialColumn
{
    public $noWrap = true;
}
