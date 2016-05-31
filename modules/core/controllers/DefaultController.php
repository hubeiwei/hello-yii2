<?php

namespace app\modules\core\controllers;

use app\modules\core\controllers\base\ModuleController;
use app\modules\core\extensions\HuCaptchaAction;
use yii\web\ErrorAction;

class DefaultController extends ModuleController
{
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::className(),
            ],
            'captcha' => [
                'class' => HuCaptchaAction::className(),
            ],
        ];
    }
}
