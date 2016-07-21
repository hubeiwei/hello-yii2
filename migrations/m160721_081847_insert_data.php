<?php

use app\models\Article;
use app\models\User;
use app\models\UserDetail;
use Faker\Factory;
use yii\db\Migration;

class m160721_081847_insert_data extends Migration
{
    public function up()
    {
        $time = time();
        $faker = Factory::create();

        $this->batchInsert(User::tableName(), [
            'username',
            'auth_key',
            'password_hash',
            'email',
            'created_at',
            'updated_at',
        ], [
            [
                'hu',
                Yii::$app->security->generateRandomString(),
                '$2y$13$GseYzG9z1Q87wVsGJ9DdleP/QHSPoPbAdLr3y4D8gDCFq2BRuIYQu',
                $faker->email,
                $time,
                $time,
            ],
            [
                'test',
                Yii::$app->security->generateRandomString(),
                '$2y$13$bkTA/HShzVF8P2uZDRZgbe5jPftXwO3xIJnF5gjph63xtFKs9bEpS',
                $faker->email,
                $time,
                $time,
            ],
        ]);

        $this->batchInsert(UserDetail::tableName(), ['user_id', 'updated_at'], [[1, $time], [2, $time]]);

        $articles = [];
        for ($i = 0; $i < 50; $i++) {
            $articles[] = [
                'title' => $faker->text(rand(10, 20)),
                'created_by' => mt_rand(1, 2),
                'published_at' => mt_rand(strtotime('-1 day'), strtotime('+6 hour')),
                'content' => $faker->text(rand(500, 2000)),
                'type' => Article::TYPE_MARKDOWN,
                'created_at' => $time,
                'updated_at' => $time,
            ];
        }
        $this->batchInsert(Article::tableName(), [
            'title',
            'created_by',
            'published_at',
            'content',
            'type',
            'created_at',
            'updated_at'
        ], $articles);

        //rbac相关
        $this->batchInsert('auth_item', ['name', 'type', 'created_at', 'updated_at'], [
            ['/*', 2, $time, $time],
            ['/admin/*', 2, $time, $time],
            ['/admin/default/index', 2, $time, $time],
            ['/gii/*', 2, $time, $time],
            ['/gii/default/index', 2, $time, $time],
            ['/manage/article/*', 2, $time, $time],
            ['/manage/article/index', 2, $time, $time],
            ['/manage/default/*', 2, $time, $time],
            ['/manage/default/index', 2, $time, $time],
            ['/manage/music/*', 2, $time, $time],
            ['/manage/music/index', 2, $time, $time],
            ['/manage/setting/*', 2, $time, $time],
            ['/manage/setting/index', 2, $time, $time],
            ['/manage/user-detail/*', 2, $time, $time],
            ['/manage/user-detail/index', 2, $time, $time],
            ['/manage/user/*', 2, $time, $time],
            ['/manage/user/index', 2, $time, $time],
        ]);

        $this->batchInsert('auth_item', ['name', 'type', 'description', 'created_at', 'updated_at'], [
            ['Guest', 1, '访客', $time, $time],
            ['SuperAdmin', 1, '超管', $time, $time],
        ]);

        $this->insert('auth_item_child', [
            'parent' => 'SuperAdmin',
            'child' => '/*',
        ]);

        $this->insert('auth_assignment', [
            'item_name' => 'SuperAdmin',
            'user_id' => '1',
            'created_at' => $time,
        ]);

        $this->batchInsert('menu', ['name', 'parent', 'route', 'order'], [
            ['首页', null, '/manage/default/index', 1],
            ['前台', null, null, 2],
            ['文章管理', 2, '/manage/article/index', 1],
            ['音乐管理', 2, '/manage/article/index', 2],
            ['用户', null, null, 3],
            ['用户管理', 5, '/manage/user/index', 1],
            ['用户资料', 5, '/manage/user-detail/index', 2],
            ['系统', null, null, 4],
            ['网站配置', 8, '/manage/setting/index', 1],
            ['权限管理', 8, '/admin/default/index', 2],
            ['代码生成', 8, '/gii/default/index', 3],
        ]);
    }

    public function down()
    {
        $this->truncateTable(Article::tableName());
        $this->truncateTable(UserDetail::tableName());
        $this->truncateTable(User::tableName());

        //rbac相关
        $this->truncateTable('menu');
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
