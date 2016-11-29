<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/11/8
 * Time: 14:37
 */

namespace app\common\grid;

use kartik\grid\ActionColumn as KartikActionColumn;

/**
 * 不想td换行才有了这个类
 */
class ActionColumn extends KartikActionColumn
{
    public $noWrap = true;
}
