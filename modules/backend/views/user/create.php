<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\models\User
 */

$this->title = '添加用户';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
