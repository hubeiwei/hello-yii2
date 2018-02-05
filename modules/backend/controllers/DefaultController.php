<?php

namespace app\modules\backend\controllers;

use app\modules\backend\controllers\base\ModuleController;

/**
 * Default controller for the `backend` module
 */
class DefaultController extends ModuleController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
