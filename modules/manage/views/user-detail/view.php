<?php

use app\models\UserDetail;
use app\modules\core\helpers\EasyHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model app\models\UserDetail
 */

$this->title = '用户资料：' . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => '用户资料', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->user->username;
?>
<div class="user-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'user.username',
            'avatar_file',
            [
                'attribute' => 'gender',
                'value' => UserDetail::$gender_map[$model->gender],
            ],
            [
                'attribute' => 'birthday',
                'value' => EasyHelper::timestampToDate($model->birthday, 'Y年m月d日'),
            ],
            'email:email',
            'phone',
            'resume',
            'security_question',
            'security_answer',
            [
                'attribute' => 'updated_at',
                'value' => EasyHelper::timestampToDate($model->updated_at),
            ],
        ],
    ]) ?>

</div>
