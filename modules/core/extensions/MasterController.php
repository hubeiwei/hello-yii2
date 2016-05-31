<?php

namespace app\modules\core\extensions;

//use app\models\LogRequest;
//use app\models\Setting;
//use app\modules\core\helpers\DHelper;
use yii\web\Controller;

class MasterController extends Controller
{

    public function init()
    {
        parent::init();
//        $this->maintenance();
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

//    private function maintenance()
//    {
//        $maintenance_mod = Setting::cacheGet('maintenance_mod');
//        if ($maintenance_mod == 'true') {
//            if (!strstr($this->route, 'core/maintenance') && !strstr($this->route, 'cake/') && !strstr($this->route, 'api/')) {
//                $this->redirect('/core/maintenance');
//                return \Yii::$app->end();
//            }
//        }
//    }

}