<?php

use app\models\Setting;
use yii\db\Migration;

class m161012_021822_drop_setting_created_by_column extends Migration
{
    public function up()
    {
        $this->dropColumn(Setting::tableName(), 'created_by');
    }

    public function down()
    {
        $this->addColumn(Setting::tableName(), 'created_by', $this->integer(10)->unsigned()->comment('创建者')->after('tag'));
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
