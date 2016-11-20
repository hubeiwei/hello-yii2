<?php
namespace app\modules\user\controllers\base;

use app\modules\core\extensions\MasterController;

class ModuleController extends MasterController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = '@app/views/layouts/user_form';
    }
}
