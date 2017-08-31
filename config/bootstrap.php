<?php

Yii::$container->set('UserHelper', [
    'class' => 'app\common\helpers\UserHelper',
    'userClass' => 'app\models\User',
]);
