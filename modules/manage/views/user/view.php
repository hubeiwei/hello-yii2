<?php

use app\models\User;
use app\modules\core\helpers\EasyHelper;
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
        <?= Html::a('修改', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->user_id], [
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
            'user_id',
            'username',
            'password',
            'passkey',
            [
                'attribute' => 'status',
                'value' => User::$status_map[$model->status],
            ],
            [
                'attribute' => 'type',
                'value' => User::$type_map[$model->type],
            ],
            'auth_key',
            'access_token',
            [
                'attribute' => 'created_at',
                'value' => EasyHelper::timestampToDate($model->created_at),
            ],
            [
                'attribute' => 'updated_at',
                'value' => EasyHelper::timestampToDate($model->updated_at),
            ],
            [
                'attribute' => 'last_login',
                'value' => EasyHelper::timestampToDate($model->last_login),
            ],
            'last_ip',
        ],
    ]) ?>

</div>
