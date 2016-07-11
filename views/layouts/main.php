<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\modules\core\helpers\UserHelper;
use kartik\alert\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'LaoHu Yii2',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => '文章', 'url' => ['/portal/article/index']],
            ['label' => '音乐', 'url' => ['/portal/music/index']],
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                'label' => '后台管理',
                'url' => ['/manage'],
                'visible' => UserHelper::userIsAdmin(),
            ],
            [
                'label' => '登录',
                'url' => ['/user/default/login'],
                'visible' => UserHelper::userIsGuest(),
            ],
            [
                'label' => '注册',
                'url' => ['/user/default/register'],
                'visible' => UserHelper::userIsGuest(),
            ],
            [
                'label' => UserHelper::getUserName(),
                'visible' => !UserHelper::userIsGuest(),
                'items' => [
                    [
                        'label' => '个人资料',
                        'url' => ['/user/default/detail'],
                    ],
                    [
                        'label' => '我的文章',
                        'url' => ['/portal/article/my-article'],
                    ],
                    [
                        'label' => '我的音乐',
                        'url' => ['/portal/music/my-music'],
                    ],
                    '<li class="divider"></li>',
                    [
                        'label' => '登出',
                        'url' => ['/user/default/logout'],
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

        if (Yii::$app->session->hasFlash('success')) {
            echo Alert::widget([
                'type' => Alert::TYPE_SUCCESS,
                'body' => Yii::$app->session->getFlash('success'),
                'delay' => 10000,
            ]);
        }
        if (Yii::$app->session->hasFlash('info')) {
            echo Alert::widget([
                'body' => Yii::$app->session->getFlash('info'),
                'delay' => 10000,
            ]);
        }
        if (Yii::$app->session->hasFlash('error')) {
            echo Alert::widget([
                'type' => Alert::TYPE_DANGER,
                'body' => Yii::$app->session->getFlash('error'),
                'delay' => 10000,
            ]);
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading media">
                <h1 class="media-heading"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; LaoHu Yii2 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
