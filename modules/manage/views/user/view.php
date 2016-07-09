<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model app\models\User
 */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-user-view">

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
            'username',
            'password',
            'passkey',
            [
                'attribute' => 'status',
                'value' => User::$status_map[$model->status],
            ],
            'auth_key',
            'access_token',
            'created_at:dateTime',
            'updated_at:dateTime',
            'last_login:dateTime',
            'last_ip',
        ],
    ]) ?>

</div>
