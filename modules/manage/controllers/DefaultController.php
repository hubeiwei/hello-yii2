<?php
namespace app\modules\manage\controllers;

use app\modules\manage\controllers\base\ModuleController;

/**
 * Default controller for the `manage` module
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
