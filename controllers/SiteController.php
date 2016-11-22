<?php

namespace app\controllers;

use app\common\captcha\CaptchaAction;
use yii\web\Controller;
use yii\web\ErrorAction;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::className(),
            ],
            'captcha' => [
                'class' => CaptchaAction::className(),
            ],
        ];
    }
}
