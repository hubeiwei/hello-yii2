<?php

use app\common\helpers\UserHelper;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/**
 * @var $this yii\web\View
 * @var $menu array
 */

NavBar::begin([
    'brandLabel' => Yii::$app->name . '后台',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => $menu,
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => '返回前台', 'url' => ['/frontend']],
        [
            'label' => '登出(' . UserHelper::getUserName() . ')',
            'url' => ['/logout'],
            'linkOptions' => [
                'data' => [
                    'confirm' => '确定要登出吗？',
                    'method' => 'post',
                ],
            ],
        ],
    ],
]);

NavBar::end();
