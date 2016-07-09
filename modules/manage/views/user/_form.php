<?php

use app\models\User;
use app\modules\core\extensions\HuActiveForm;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $form HuActiveForm
 * @var $model User
 */
?>

<div class="sys-user-form">

    <?php $form = HuActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?php
    if ($model->isNewRecord) {
        echo $form->field($model, 'password')->passwordInput(['maxlength' => true]);
    };
    ?>

    <?= $form->field($model, 'status')->dropDownList(User::$status_map) ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-12">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php HuActiveForm::end(); ?>

</div>
