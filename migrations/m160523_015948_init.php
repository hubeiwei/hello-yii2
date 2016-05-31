<?php

use app\models\Music;
use app\models\Setting;
use app\models\User;
use app\models\UserDetail;
use yii\db\Migration;

class m160523_015948_init extends Migration
{
    public function up()
    {
        $tableInnoDBOptions = 'ENGINE=InnoDB CHARACTER SET utf8';
        $tableMyISAMOptions = 'ENGINE=MyISAM CHARACTER SET utf8';

        $this->createTable(User::tableName(), [
            'user_id' => $this->primaryKey(10)->unsigned(),
            'username' => $this->string(20)->notNull()->unique()->comment('用户名'),
            'password' => $this->string(255)->notNull()->comment('密码'),
            'passkey' => $this->char(6)->notNull(),
            'type' => 'enum(\'Member\',\'Admin\') NOT NULL DEFAULT \'Member\' COMMENT \'用户类型\'',
            'status' => 'enum(\'Y\',\'N\') DEFAULT \'Y\' COMMENT \'状态\'',
            'auth_key' => $this->char(64)->notNull()->unique(),
            'access_token' => $this->char(64)->notNull()->unique(),
            'created_at' => $this->integer(11)->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer(11)->unsigned()->comment('修改时间'),
            'last_login' => $this->integer(11)->unsigned()->comment('最后登录时间'),
            'last_ip' => $this->char(15)->comment('最后登录IP'),
        ], $tableInnoDBOptions);

        $user = new User();
        $attributes = $user->attributes();
        unset($attributes[0]);//user_id
        unset($attributes[5]);//status
        unset($attributes[10]);//last_login
        unset($attributes[11]);//last_ip
        $this->batchInsert($user::tableName(), $attributes, [
            [
                'hu',
                '$2y$13$/pWZHbHrDBHQfp99VO7qvuoID7C.REZOfIkqOaDGhNurHrdna.l6G',
                'PGWY7_',
                'Admin',
                Yii::$app->security->generateRandomString(64),
                Yii::$app->security->generateRandomString(64),
                time(),
                time(),
            ],
            [
                'test',
                '$2y$13$jokKL4zwtjY8Rtw0uKjWdOS1O7ast2e9rosNw1/1Dq2NJJ3C9mPT.',
                'ML-ncP',
                'Member',
                Yii::$app->security->generateRandomString(64),
                Yii::$app->security->generateRandomString(64),
                time(),
                time(),
            ],
        ]);

        $this->createTable(UserDetail::tableName(), [
            'id' => $this->primaryKey(10)->unsigned(),
            'user_id' => $this->integer(10)->notNull()->unique()->unsigned()->comment('用户ID'),
            'avatar_file' => $this->string(100)->defaultValue(null)->comment('头像文件'),
            'gender' => 'enum(\'0\',\'1\',\'2\') DEFAULT \'0\' COMMENT \'性别\'',
            'birthday' => $this->integer(11)->unsigned()->comment('生日'),
            'email' => $this->string(100)->unique()->comment('邮箱'),
            'phone' => $this->string(11)->unique()->comment('电话'),
            'resume' => $this->string(100)->comment('简介'),
            'security_question' => $this->string(30)->comment('密保问题'),
            'security_answer' => $this->string(64)->comment('密保答案'),
            'updated_at' => $this->integer(11)->unsigned()->comment('修改时间'),
        ], $tableInnoDBOptions);

        $this->batchInsert(UserDetail::tableName(), ['user_id', 'updated_at'], [[1, time()], [2, time()]]);

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

        $this->batchInsert(Music::tableName(), ['track_title', 'music_file', 'user_id', 'created_at', 'updated_at'], [
            ['いのちの名前 ~ジブリ・メドレー~', '34b372ac9769060', 1, time(), time()],
        ]);

        $this->createTable(Setting::tableName(), [
            'id' => $this->primaryKey(10)->unsigned(),
            'name' => $this->string(50)->notNull()->comment('名称'),
            'key' => $this->string(20)->notNull()->unique()->comment('键'),
            'value' => $this->text()->notNull()->comment('值'),
            'status' => 'enum(\'Y\',\'N\') DEFAULT \'Y\' COMMENT \'状态\'',
            'description' => $this->string(200)->comment('描述'),
            'tag' => $this->string(20)->comment('标记'),
            'user_id' => $this->integer(10)->unsigned()->comment('用户ID'),
            'last_operater' => $this->integer(10)->unsigned()->comment('最后操作人'),
            'created_at' => $this->integer(11)->unsigned()->comment('创建时间'),
            'updated_at' => $this->integer(11)->unsigned()->comment('修改时间'),
        ], $tableMyISAMOptions . ' COMMENT=\'网站配置\'');

        //以下是插入rbac相关的数据
        $this->batchInsert('auth_item', ['name', 'type', 'created_at', 'updated_at'], [
            ['/*', 2, time(), time()],
            ['/admin/*', 2, time(), time()],
            ['/admin/default/index', 2, time(), time()],
            ['/gii/*', 2, time(), time()],
            ['/gii/default/index', 2, time(), time()],
            ['/manage/default/*', 2, time(), time()],
            ['/manage/default/index', 2, time(), time()],
            ['/manage/setting/*', 2, time(), time()],
            ['/manage/setting/index', 2, time(), time()],
            ['/manage/user-detail/*', 2, time(), time()],
            ['/manage/user-detail/index', 2, time(), time()],
            ['/manage/user/*', 2, time(), time()],
            ['/manage/user/index', 2, time(), time()],
        ]);

        $this->batchInsert('auth_item', ['name', 'type', 'description', 'created_at', 'updated_at'], [
            ['Guest', 1, '访客', time(), time()],
            ['SuperAdmin', 1, '超管', time(), time()],
        ]);

        $this->insert('auth_item_child', ['parent' => 'SuperAdmin', 'child' => '/*']);

        $this->insert('auth_assignment', [
            'item_name' => 'SuperAdmin',
            'user_id' => '1',
            'created_at' => time(),
        ]);

        $this->batchInsert('menu', ['name', 'parent', 'route', 'order'], [
            ['首页', null, '/manage/default/index', 1],
            ['用户', null, null, 2],
            ['用户管理', 2, '/manage/user/index', 1],
            ['用户资料', 2, '/manage/user-detail/index', 2],
            ['系统', null, null, 3],
            ['网站配置', 5, '/manage/setting/index', 1],
            ['权限管理', 5, '/admin/default/index', 2],
            ['代码生成', 5, '/gii/default/index', 3],
        ]);
    }

    public function down()
    {
        $this->dropTable(User::tableName());
        $this->dropTable(UserDetail::tableName());
        $this->dropTable(Music::tableName());
        $this->dropTable(Setting::tableName());

        //其实都可以用truncateTable的，但是auth_item这个表居然不能用，反正没有自增id，用delete就好
        $this->delete('menu');
        $this->delete('auth_assignment');
        $this->delete('auth_item_child');
        $this->delete('auth_item');
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
