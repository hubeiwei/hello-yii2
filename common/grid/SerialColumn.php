<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/11/8
 * Time: 15:08
 */

namespace app\common\grid;

use kartik\grid\SerialColumn as KartikSerialColumn;

/**
 * 不想td换行才有了这个类
 */
class SerialColumn extends KartikSerialColumn
{
    public $noWrap = true;
}
