<?php

use app\models\Setting;
use yii\db\Migration;

class m161012_021822_drop_created_by_columns_from_setting_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn(Setting::tableName(), 'created_by');
    }

    public function safeDown()
    {
        $this->addColumn(Setting::tableName(), 'created_by', $this->integer(10)->unsigned()->comment('创建者')->after('tag'));
    }
}
