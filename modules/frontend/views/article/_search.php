<?php

use hubeiwei\yii2tools\widgets\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $searchModel app\models\search\ArticleSearch
 * @var $sort yii\data\Sort
 */
?>

<div class="article-search">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
    ]); ?>

    <?= $form->field($searchModel, 'title')->textInput()
        ->label($sort->link('title', ['label' => '标题'])) ?>

    <?= $form->field($searchModel, 'content')->textInput()
        ->label($sort->link('content', ['label' => '内容'])) ?>

    <?= $form->field($searchModel, 'username')->textInput()
        ->label($sort->link('username', ['label' => '用户名'])) ?>

    <?= $form->field($searchModel, 'published_at')
        ->widget(DateRangePicker::className(), [
            'pluginOptions' => [
                'locale' => [
                    'format' => 'Y/m/d H:i',
                ],
            ],
        ])
        ->label($sort->link('published_at', ['label' => '发布时间'])) ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
