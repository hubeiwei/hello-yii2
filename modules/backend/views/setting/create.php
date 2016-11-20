<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\models\Setting
 */

$this->title = '添加配置';
$this->params['breadcrumbs'][] = ['label' => '网站配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
