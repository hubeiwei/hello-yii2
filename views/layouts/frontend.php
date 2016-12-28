<?php

use app\common\helpers\UserHelper;
use app\common\widgets\CssBlock;
use app\common\widgets\Growl;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/**
 * @var $this \yii\web\View
 * @var $content string
 */
?>

<?php CssBlock::begin(); ?>
<style>
    html, body {
        background-color: #f1f1f1;
    }
</style>
<?php CssBlock::end(); ?>

<?php
$this->beginContent('@app/views/layouts/master.php');

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => [
        ['label' => '文章', 'url' => ['/frontend/article/index']],
        ['label' => '音乐', 'url' => ['/frontend/music/index']],
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        [
            'label' => '后台管理',
            'url' => ['/backend'],
            'visible' => UserHelper::isAdmin(),
        ],
        [
            'label' => '登录',
            'url' => Yii::$app->user->loginUrl,
            'visible' => Yii::$app->user->isGuest,
        ],
        [
            'label' => '注册',
            'url' => ['/register'],
            'visible' => Yii::$app->user->isGuest,
        ],
        [
            'label' => UserHelper::getUserName(),
            'visible' => !Yii::$app->user->isGuest,
            'items' => [
                [
                    'label' => '个人中心',
                    'url' => ['/user/home'],
                ],
                '<li class="divider"></li>',
                [
                    'label' => '登出',
                    'url' => ['/logout'],
                    'linkOptions' => [
                        'data' => [
                            'confirm' => '确定要登出吗？',
                            'method' => 'post',
                        ],
                    ],
                ],
            ],
        ],
    ],
]);

NavBar::end();
?>
<div class="container">
    <?php
    echo Breadcrumbs::widget([
        'options' => [
            'class' => 'breadcrumb',
            'style' => [
                'background-color' => 'white',
            ],
        ],
        'homeLink' => false,
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);

    echo Growl::widget();

    echo $content;
    ?>
</div>
<?php $this->endContent(); ?>
