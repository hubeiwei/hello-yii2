<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/20
 * Time: 23:56
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\core\extensions;

use yii\widgets\ActiveForm;

/**
 * 为了统一控制表单的宽度，
 * 不能每个表单都把那么多值配一遍，很难看也很难维护，
 * 所以继承一份来改写是最好的方法，
 * 当然这并不是所有地方都要用到。
 */
class HuActiveForm extends ActiveForm
{
    public $options = [
        'class' => 'form-horizontal',
    ];

    public $fieldConfig = [
        'template' => '{label}<div class="col-md-5">{input}</div><div class="col-md-5">{error}</div>',
        'labelOptions' => ['class' => 'col-md-2 control-label'],
    ];
}
