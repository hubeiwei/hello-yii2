<?php

use app\models\Article;
use Faker\Factory;
use yii\db\Migration;

class m160728_084313_generate_article extends Migration
{
    public function safeUp()
    {
        $time = time();
        $faker = Factory::create();

        $articles = [];
        for ($i = 0; $i < 50; $i++) {
            $articles[] = [
                'title' => $faker->text(mt_rand(10, 20)),
                'created_by' => mt_rand(1, 2),
                'published_at' => mt_rand(strtotime('-1 day'), strtotime('+6 hour')),
                'content' => $faker->text(mt_rand(100, 6000)),
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
    }

    public function safeDown()
    {
        $this->truncateTable(Article::tableName());
    }
}
