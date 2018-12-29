<?php

use app\models\Article;
use app\models\Music;
use app\models\User;
use app\models\UserDetail;
use yii\db\Migration;

class m160723_062425_create_tables extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->alterColumn(User::tableName(), 'username', $this->string(32)->notNull()->unique()->comment('用户名'));
        $this->alterColumn(User::tableName(), 'email', $this->string()->notNull()->unique()->comment('邮箱'));
        $this->alterColumn(User::tableName(), 'status', $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE)->comment('状态'));
        $this->alterColumn(User::tableName(), 'created_at', $this->integer()->unsigned()->comment('创建时间'));
        $this->alterColumn(User::tableName(), 'updated_at', $this->integer()->unsigned()->comment('修改时间'));
        $this->addCommentOnTable(User::tableName(), '用户');

        $this->createTable(UserDetail::tableName(), [
            'id' => $this->primaryKey(10)->unsigned(),
            'user_id' => $this->integer(10)->notNull()->unique()->unsigned()->comment('用户ID'),
            'avatar_file' => $this->string(100)->defaultValue(null)->comment('头像文件'),
            'gender' => $this->smallInteger()->notNull()->defaultValue(UserDetail::GENDER_SECRECY)->comment('性别'),
            'birthday' => $this->integer(11)->unsigned()->comment('生日'),
            'phone' => $this->string(11)->unique()->comment('电话'),
            'resume' => $this->string(100)->comment('简介'),
            'updated_at' => $this->integer(11)->unsigned()->comment('修改时间'),
        ], $tableOptions . " COMMENT='用户资料'");

        $this->createTable(Article::tableName(), [
            'id' => $this->primaryKey(10)->unsigned(),
            'title' => $this->string(20)->notNull()->comment('标题'),
            'created_by' => $this->integer(10)->unsigned()->comment('作者'),
            'published_at' => $this->integer(11)->notNull()->unsigned()->comment('发布时间'),
            'content' => $this->text()->notNull()->comment('内容'),
            'visible' => $this->smallInteger()->notNull()->defaultValue(Article::VISIBLE_YES)->comment('可见性'),
            'type' => $this->smallInteger()->notNull()->comment('文章类型'),
            'status' => $this->smallInteger()->notNull()->defaultValue(Article::STATUS_ENABLE)->comment('状态'),
            'created_at' => $this->integer(11)->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer(11)->unsigned()->comment('修改时间'),
        ], $tableOptions . " COMMENT='文章'");

        $this->createTable(Music::tableName(), [
            'id' => $this->primaryKey(10)->unsigned(),
            'track_title' => $this->string(50)->notNull()->comment('标题'),
            'music_file' => $this->string(100)->notNull()->comment('音乐文件'),
            'user_id' => $this->integer(10)->unsigned()->comment('用户ID'),
            'visible' => $this->smallInteger()->notNull()->defaultValue(Music::VISIBLE_YES)->comment('可见性'),
            'status' => $this->smallInteger()->notNull()->defaultValue(Music::STATUS_ENABLE)->comment('状态'),
            'created_at' => $this->integer(11)->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer(11)->unsigned()->comment('修改时间'),
        ], $tableOptions . " COMMENT='音乐'");
    }

    public function safeDown()
    {
        $this->alterColumn(User::tableName(), 'username', $this->string(32)->notNull());
        $this->alterColumn(User::tableName(), 'email', $this->string()->notNull());
        $this->alterColumn(User::tableName(), 'status', $this->smallInteger()->notNull()->defaultValue(10));
        $this->alterColumn(User::tableName(), 'created_at', $this->integer()->notNull());
        $this->alterColumn(User::tableName(), 'updated_at', $this->integer()->notNull());
        $this->dropCommentFromTable(User::tableName());
        $this->dropTable(UserDetail::tableName());
        $this->dropTable(Article::tableName());
        $this->dropTable(Music::tableName());
    }
}
