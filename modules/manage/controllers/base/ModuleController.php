<?php
namespace app\modules\manage\controllers\base;

use app\modules\core\extensions\MasterController;

class ModuleController extends MasterController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = 'main';
    }
}
