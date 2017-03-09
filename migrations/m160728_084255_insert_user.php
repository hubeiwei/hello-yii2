<?php

use app\models\User;
use app\models\UserDetail;
use Faker\Factory;
use yii\db\Migration;

class m160728_084255_insert_user extends Migration
{
    public function safeUp()
    {
        $time = time();
        $faker = Factory::create();

        $user = new User();
        $user->password_hash = 'asdf1234';
        $user->encryptPassword();

        $this->batchInsert(
            User::tableName(),
            [
                'username',
                'auth_key',
                'password_hash',
                'email',
                'created_at',
                'updated_at',
            ],
            [
                [
                    'admin',
                    Yii::$app->security->generateRandomString(),
                    $user->password_hash,
                    $faker->email,
                    $time,
                    $time,
                ],
                [
                    'test',
                    Yii::$app->security->generateRandomString(),
                    $user->password_hash,
                    $faker->email,
                    $time,
                    $time,
                ],
            ]
        );

        $this->batchInsert(UserDetail::tableName(), ['user_id', 'updated_at'], [[1, $time], [2, $time]]);

        $this->insert('auth_assignment', [
            'item_name' => 'SuperAdmin',
            'user_id' => 1,
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
