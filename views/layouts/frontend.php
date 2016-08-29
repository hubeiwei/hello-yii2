<?php

use app\modules\core\helpers\UserHelper;
use kartik\growl\Growl;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

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
                    'label' => '个人资料',
                    'url' => ['/user/default/detail'],
                ],
                [
                    'label' => '我的文章',
                    'url' => ['/frontend/article/my-article'],
                ],
                [
                    'label' => '我的音乐',
                    'url' => ['/frontend/music/my-music'],
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

    //获取成功消息提示
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
    //获取消息提示
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
    //获取错误消息提示
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

    echo $content;
    ?>
</div>
<?php $this->endContent(); ?>
