<?php

namespace hubeiwei\yii2tools\widgets;

use kartik\select2\Select2 as KartikSelect2;
use yii\helpers\ArrayHelper;

/**
 * 为了 DynaGrid 的默认过滤器功能而继承的，
 * 因为 \yii\helpers\Html::dropDownList() 不支持选中
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
