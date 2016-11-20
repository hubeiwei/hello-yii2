<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/11/8
 * Time: 15:08
 */

namespace app\modules\core\grid;

use kartik\grid\SerialColumn as KartikSerialColumn;

class SerialColumn extends KartikSerialColumn
{
    public $noWrap = true;
}
