<?php

use app\models\Setting;
use app\modules\core\extensions\HuActiveForm;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model Setting
 * @var $form HuActiveForm
 */
?>

<div class="setting-form">

    <?php $form = HuActiveForm::begin(); ?>

    <?= $form->field($model, 'key')->textInput([
        'autofocus' => true,
        'maxlength' => true,
    ]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    <?= $form->field($model, 'tag')->textInput(['maxlength' => true, 'placeholder' => '这里声明用在哪个类或场景']) ?>

    <?= $form->field($model, 'status')->dropDownList(Setting::$status_map) ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-12">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php HuActiveForm::end(); ?>

</div>
