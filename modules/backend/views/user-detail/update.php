<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $username string
 * @var $id int
 * @var $model app\modules\user\models\UserDetailForm
 */

$this->title = '用户资料: ' . $username;
$this->params['breadcrumbs'][] = ['label' => '用户资料', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $username, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="user-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('@app/modules/user/views/setting/_user-detail-form', [
        'model' => $model,
    ]) ?>
    
</div>
