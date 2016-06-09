<?php

use app\models\UserDetail;
use app\modules\core\extensions\HuActiveForm;
use app\modules\core\extensions\HuCaptcha;
use kartik\date\DatePicker;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\UserDetailForm
 */

$this->title = '个人资料';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="user-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('user_detail_form', [
        'model' => $model,
    ]) ?>

</div>
