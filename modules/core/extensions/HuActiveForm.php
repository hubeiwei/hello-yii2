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

class HuActiveForm extends ActiveForm
{
    public $options = [
        'class' => 'form-horizontal col-md-8',
    ];

    public $fieldConfig = [
        'template' => '{label}<div class="col-md-5">{input}{error}</div>',
        'labelOptions' => ['class' => 'col-md-2 control-label'],
    ];
}