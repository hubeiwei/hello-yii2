<?php

use app\models\User;
use app\models\UserDetail;
use Faker\Factory;
use yii\db\Migration;

class m160728_084255_create_users extends Migration
{
    public function safeUp()
    {
        $time = time();
        $faker = Factory::create();

        echo '    > create admin ...';
        $microtime = microtime(true);
        $adminUser = new User();
        $adminUser->username = 'admin';
        $adminUser->password_hash = 'asdf1234';
        $adminUser->email = $faker->email;
        if (!$adminUser->save(false)) {
            throw new \ErrorException('创建管理员用户失败');
        }
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $microtime) . "s)\n";

        echo '    > create user ...';
        $microtime = microtime(true);
        $testUser = new User();
        $testUser->username = 'test';
        $testUser->password_hash = 'asdf1234';
        $testUser->email = $faker->email;
        if (!$testUser->save(false)) {
            throw new \ErrorException('创建普通用户失败');
        }
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $microtime) . "s)\n";

        $this->batchInsert(UserDetail::tableName(), ['user_id', 'updated_at'], [
            [$adminUser->id, $time],
            [$testUser->id, $time]
        ]);

        $this->insert('auth_assignment', [
            'item_name' => 'admin',
            'user_id' => $adminUser->id,
            'created_at' => $time,
        ]);
    }

    public function safeDown()
    {
        $this->delete('auth_assignment');
        $this->truncateTable(UserDetail::tableName());
        $this->truncateTable(User::tableName());
    }
}
