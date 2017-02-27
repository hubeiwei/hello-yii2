<?php

/**
 * @var $this yii\web\View
 * @var $content string
 */

use app\common\helpers\UserHelper;
use app\common\widgets\JsBlock;
use yii\widgets\Menu;
use yii\widgets\Pjax;

?>
<?php $this->beginContent('@app/views/layouts/frontend.php') ?>
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= UserHelper::getUserName() ?>
                </h3>
            </div>
            <div class="panel-body">
                <?= Menu::widget([
                    'options' => [
                        'class' => 'nav nav-pills nav-stacked pjax_menu'
                    ],
                    'items' => [
                        ['label' => '个人资料', 'url' => ['/user/home/detail']],
                        ['label' => '我的文章', 'url' => ['/frontend/article/my-article']],
                        ['label' => '我的音乐', 'url' => ['/frontend/music/my-music']],
                    ],
                    'itemOptions' => [
                        'class' => 'pjax_link',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= $this->title ?>
                </h3>
            </div>
            <div class="panel-body content">
                <?php
                Pjax::begin([
                    'linkSelector' => '.pjax_link a',
                ]);
                echo $content;
                Pjax::end();
                ?>
            </div>
        </div>
    </div>
</div>
<?php JsBlock::begin(); ?>
<script>
    $(".pjax_menu .pjax_link").on("click",function () {
        $(".pjax_menu .pjax_link").removeClass('active');
        $(this).addClass('active');
    });
</script>
<?php JsBlock::end(); ?>
<?php $this->endContent(); ?>
