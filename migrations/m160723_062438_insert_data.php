<?php

use app\models\Article;
use app\models\User;
use app\models\UserDetail;
use Faker\Factory;
use yii\db\Migration;

class m160723_062438_insert_data extends Migration
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
                'content' => $faker->text(rand(1000, 3000)),
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

        $this->insert('auth_assignment', [
            'item_name' => 'SuperAdmin',
            'user_id' => 1,
            'created_at' => $time,
        ]);
    }

    public function down()
    {
        $this->truncateTable(Article::tableName());
        $this->truncateTable(UserDetail::tableName());
        $this->truncateTable(User::tableName());

        $this->delete('auth_assignment');
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
