<?php

use app\models\Article;
use yii\db\Migration;

class m161228_043323_modify_created_by_column_from_article_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn(Article::tableName(), 'created_by', $this->integer(10)->unsigned()->comment('作者'));
    }

    public function safeDown()
    {
        $this->alterColumn(Article::tableName(), 'created_by', $this->integer(10)->notNull()->unsigned()->comment('作者'));
    }
}
