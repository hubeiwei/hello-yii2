<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\modules\core\helpers\UserHelper;
use kartik\growl\Growl;
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
                        'url' => ['/logout'],
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
            echo Growl::widget([
                'type' => Growl::TYPE_SUCCESS,
                'icon' => 'glyphicon glyphicon-ok-sign',
                'body' => Yii::$app->session->getFlash('success'),
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'center',
                    ]
                ]
            ]);
        }
        if (Yii::$app->session->hasFlash('info')) {
            echo Growl::widget([
                'type' => Growl::TYPE_INFO,
                'icon' => 'glyphicon glyphicon-info-sign',
                'body' => Yii::$app->session->getFlash('info'),
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'center',
                    ]
                ]
            ]);
        }
        if (Yii::$app->session->hasFlash('error')) {
            echo Growl::widget([
                'type' => Growl::TYPE_DANGER,
                'icon' => 'glyphicon glyphicon-remove-sign',
                'body' => Yii::$app->session->getFlash('error'),
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'center',
                    ]
                ]
            ]);
        }
        ?>

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="panel panel-default">
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
