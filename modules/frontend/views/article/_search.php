<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $sort yii\data\Sort
 * @var $title string
 * @var $content string
 * @var $username string
 * @var $published_at string
 */
?>

<div class="article-search">

    <?= Html::beginForm(['index'], 'get') ?>

    <div class="form-group">
        <?= Html::label($sort->link('title', ['label' => '标题']), 'title') ?>
        <?= Html::textInput('title', $title, ['id' => 'title', 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::label($sort->link('content', ['label' => '内容']), 'content') ?>
        <?= Html::textInput('content', $content, ['id' => 'content', 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::label($sort->link('username', ['label' => '用户名']), 'username') ?>
        <?= Html::textInput('username', $username, ['id' => 'username', 'class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::label($sort->link('published_at', ['label' => '发布时间']), 'published_at') ?>
        <?= DateRangePicker::widget([
            'id' => 'published_at',
            'name' => 'published_at',
            'value' => $published_at,
            'convertFormat' => true,
            'pluginOptions' => [
                'locale' => [
                    'separator' => ' - ',
                    'format' => 'Y/m/d H:i:s',
                ],
                'showDropdowns' => true,
                'timePicker' => true,
                'timePicker24Hour' => true,
                'timePickerIncrement' => 1,
                'timePickerSeconds' => true,
            ],
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?= Html::endForm() ?>

</div>
