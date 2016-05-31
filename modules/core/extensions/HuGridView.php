<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/29
 * Time: 0:08
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\core\extensions;

use kartik\grid\GridView;

class HuGridView extends GridView
{
    public $resizableColumns = false;

    public $responsiveWrap = false;

    public $hover = true;
}