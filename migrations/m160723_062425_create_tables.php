<?php

use app\models\Article;
use app\models\Music;
use app\models\Setting;
use app\models\UserDetail;
use yii\db\Migration;

class m160723_062425_create_tables extends Migration
{
    public function safeUp()
    {
        $tableInnoDBOptions = 'ENGINE=InnoDB CHARACTER SET utf8';
        $tableMyISAMOptions = 'ENGINE=MyISAM CHARACTER SET utf8';

        $this->createTable(UserDetail::tableName(), [
            'id' => $this->primaryKey(10)->unsigned(),
            'user_id' => $this->integer(10)->notNull()->unique()->unsigned()->comment('用户ID'),
            'avatar_file' => $this->string(100)->defaultValue(null)->comment('头像文件'),
            'gender' => 'enum(\'0\',\'1\',\'2\') DEFAULT \'0\' COMMENT \'性别\'',
            'birthday' => $this->integer(11)->unsigned()->comment('生日'),
            'phone' => $this->string(11)->unique()->comment('电话'),
            'resume' => $this->string(100)->comment('简介'),
            'updated_at' => $this->integer(11)->unsigned()->comment('修改时间'),
        ], $tableInnoDBOptions);

        $this->createTable(Article::tableName(), [
            'id' => $this->primaryKey(10)->unsigned(),
            'title' => $this->string(20)->notNull()->comment('标题'),
            'created_by' => $this->integer(10)->notNull()->unsigned()->comment('作者'),
            'published_at' => $this->integer(11)->notNull()->unsigned()->comment('发布时间'),
            'content' => $this->text()->notNull()->comment('内容'),
            'visible' => 'enum(\'Y\',\'N\') DEFAULT \'Y\' COMMENT \'可见性\'',
            'type' => 'enum(\'H\',\'M\') NOT NULL COMMENT \'文章类型\'',
            'status' => 'enum(\'Y\',\'N\') DEFAULT \'Y\' COMMENT \'状态\'',
            'created_at' => $this->integer(11)->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer(11)->unsigned()->comment('修改时间'),
        ], $tableInnoDBOptions);

        $this->createTable(Music::tableName(), [
            'id' => $this->primaryKey(10)->unsigned(),
            'track_title' => $this->string(50)->notNull()->comment('标题'),
            'music_file' => $this->string(100)->notNull()->comment('音乐文件'),
            'user_id' => $this->integer(10)->unsigned()->comment('用户ID'),
            'visible' => 'enum(\'Y\',\'N\') DEFAULT \'Y\' COMMENT \'可见性\'',
            'status' => 'enum(\'Y\',\'N\') DEFAULT \'Y\' COMMENT \'状态\'',
            'created_at' => $this->integer(11)->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer(11)->unsigned()->comment('修改时间'),
        ], $tableInnoDBOptions);

        $this->createTable(Setting::tableName(), [
            'id' => $this->primaryKey(10)->unsigned(),
            'key' => $this->string(20)->notNull()->unique()->comment('键'),
            'value' => $this->text()->notNull()->comment('值'),
            'status' => 'enum(\'Y\',\'N\') DEFAULT \'Y\' COMMENT \'状态\'',
            'description' => $this->string(200)->comment('描述'),
            'tag' => $this->string(20)->comment('标记'),
            'created_by' => $this->integer(10)->unsigned()->comment('创建者'),
            'updated_by' => $this->integer(10)->unsigned()->comment('最后操作者'),
            'created_at' => $this->integer(11)->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer(11)->unsigned()->comment('修改时间'),
        ], $tableMyISAMOptions . ' COMMENT=\'网站配置\'');
    }

    public function safeDown()
    {
        $this->dropTable(UserDetail::tableName());
        $this->dropTable(Article::tableName());
        $this->dropTable(Music::tableName());
        $this->dropTable(Setting::tableName());
    }
}
