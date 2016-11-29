<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/29
 * Time: 0:08
 * To change this template use File | Settings | File Templates.
 */

namespace app\common\grid;

use kartik\grid\GridView as KartikGridView;

/**
 * 继承\kartik\grid\GridView只是为了方便加代码，以及配置一些单独使用时的配置
 * 在RenderHelper封装的代码是根据业务来进行的
 * @see \app\common\helpers\RenderHelper::gridView()
 */
class GridView extends KartikGridView
{
    public $pager = [
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
    ];

    public $dataColumnClass = '\app\common\grid\DataColumn';

    public $resizableColumns = false;

    public $responsiveWrap = false;

    public $hover = true;

    public $export = false;
}
