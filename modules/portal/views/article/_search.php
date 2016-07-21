<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\models\search\ArticleSearch
 * @var $form yii\widgets\ActiveForm
 * @var $sort yii\data\Sort
 */
?>

<div class="article-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'title')->textInput()->label($sort->link('title')) ?>

    <?= $form->field($model, 'content')->textInput()->label($sort->link('content')) ?>

    <?= $form->field($model, 'user.username')->textInput()->label($sort->link('user.username')) ?>

    <?= $form->field($model, 'published_at')->widget(DateRangePicker::className(), [
        'convertFormat' => true,
        'readonly' => true,
        'pluginOptions' => [
            'separator' => ' - ',
            'format' => 'Y/m/d H:i',
            'timePicker' => true,
            'timePicker12Hour' => false,
            'timePickerIncrement' => 1,
        ],
    ])->label($sort->link('published_at')) ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
