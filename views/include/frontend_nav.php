<?php

use app\common\helpers\UserHelper;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/**
 * @var $this \yii\web\View
 */

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
