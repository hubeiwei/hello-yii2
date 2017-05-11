<?php

use app\models\Setting;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model app\models\Setting
 */

$this->title = $model->key;
$this->params['breadcrumbs'][] = ['label' => '网站配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除该数据吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'key',
            'value',
            [
                'attribute' => 'status',
                'value' => Setting::statusMap($model->status),
            ],
            'description',
            'tag',
            'user.username',
            'created_at:dateTime',
            'updated_at:dateTime',
        ],
    ]) ?>

</div>
