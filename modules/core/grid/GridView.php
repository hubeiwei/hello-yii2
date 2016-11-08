<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/29
 * Time: 0:08
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\core\grid;

use kartik\grid\GridView as KartikGridView;

/**
 * 已经封装在RenderHelper了，
 * 但有特别需求时还是可以单独使用该类
 * @see \app\modules\core\helpers\RenderHelper::gridView()
 */
class GridView extends KartikGridView
{
    public $pager = [
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
    ];

    public $resizableColumns = false;

    public $responsiveWrap = false;

    public $hover = true;

    public $export = false;
}
