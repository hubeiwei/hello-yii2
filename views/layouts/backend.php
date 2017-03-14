<?php

use app\common\helpers\UserHelper;
use hubeiwei\yii2tools\widgets\Alert;
use hubeiwei\yii2tools\widgets\CssBlock;
use mdm\admin\components\MenuHelper;
use yii\widgets\Breadcrumbs;

/**
 * @var $this \yii\web\View
 * @var $content string
 */

$menu = MenuHelper::getAssignedMenu(UserHelper::getUserId());
?>

<?php CssBlock::begin(); ?>
<style>
    .container {
        width: 100%;
    }
</style>
<?php CssBlock::end(); ?>

<?php
$this->beginContent('@app/views/layouts/master.php');
?>

<?= $this->render('@app/views/layouts/backend_nav.php', [
    'menu' => $menu,
]) ?>

<div class="container">
    <div class="row">
        <div class="col-md-3 col-lg-2 hidden-sm hidden-xs">
            <?= $this->render('@app/views/layouts/backend_menu.php', [
                'menu' => $menu,
            ]) ?>
        </div>
        <div class="col-md-9 col-lg-10">
            <?= Breadcrumbs::widget([
                'homeLink' => [
                    'label' => '首页',
                    'url' => ['/backend'],
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <?= Alert::widget() ?>

            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
