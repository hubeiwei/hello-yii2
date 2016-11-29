<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/11/23
 * Time: 13:53
 */

namespace app\common\widgets;

use kartik\select2\Select2 as KartikSelect2;
use yii\helpers\ArrayHelper;

/**
 * 为了DynaGrid的默认过滤器而继承的，dropDownList不支持选中
 */
class Select2 extends KartikSelect2
{
    public $isFilter = true;

    public function run()
    {
        if ($this->isFilter) {
            $this->data = ArrayHelper::merge(
                ['' => '全部'],
                $this->data
            );
        }
        parent::run();
    }
}
