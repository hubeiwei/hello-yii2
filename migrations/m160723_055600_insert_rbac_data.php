<?php

use yii\db\Migration;

class m160723_055600_insert_rbac_data extends Migration
{
    public function up()
    {
        $time = time();

        $this->batchInsert('auth_item', ['name', 'type', 'created_at', 'updated_at'], [
            ['/*', 2, $time, $time],
            ['/admin/*', 2, $time, $time],
            ['/admin/assignment/*', 2, $time, $time],
            ['/admin/assignment/index', 2, $time, $time],
            ['/admin/menu/*', 2, $time, $time],
            ['/admin/menu/index', 2, $time, $time],
            ['/admin/permission/*', 2, $time, $time],
            ['/admin/permission/index', 2, $time, $time],
            ['/admin/role/*', 2, $time, $time],
            ['/admin/role/index', 2, $time, $time],
            ['/admin/route/*', 2, $time, $time],
            ['/admin/route/index', 2, $time, $time],
            ['/admin/rule/*', 2, $time, $time],
            ['/admin/rule/index', 2, $time, $time],
            ['/gii/*', 2, $time, $time],
            ['/gii/default/index', 2, $time, $time],
            ['/backend/article/*', 2, $time, $time],
            ['/backend/article/index', 2, $time, $time],
            ['/backend/default/*', 2, $time, $time],
            ['/backend/default/index', 2, $time, $time],
            ['/backend/music/*', 2, $time, $time],
            ['/backend/music/index', 2, $time, $time],
            ['/backend/setting/*', 2, $time, $time],
            ['/backend/setting/index', 2, $time, $time],
            ['/backend/user-detail/*', 2, $time, $time],
            ['/backend/user-detail/index', 2, $time, $time],
            ['/backend/user/*', 2, $time, $time],
            ['/backend/user/index', 2, $time, $time],
        ]);

        $this->batchInsert('auth_item', ['name', 'type', 'description', 'created_at', 'updated_at'], [
            ['Guest', 1, '访客', $time, $time],
            ['SuperAdmin', 1, '超管', $time, $time],
        ]);

        $this->insert('auth_item_child', [
            'parent' => 'SuperAdmin',
            'child' => '/*',
        ]);

        $this->batchInsert('menu', ['name', 'parent', 'route', 'order'], [
            ['首页', null, '/backend/default/index', 1],
            ['前台', null, null, 2],
            ['文章管理', 2, '/backend/article/index', 1],
            ['音乐管理', 2, '/backend/music/index', 2],
            ['用户', null, null, 3],
            ['用户管理', 5, '/backend/user/index', 1],
            ['用户资料', 5, '/backend/user-detail/index', 2],
            ['权限管理', null, null, 4],
            ['分配', 8, '/admin/assignment/index', 1],
            ['角色列表', 8, '/admin/role/index', 2],
            ['权限列表', 8, '/admin/permission/index', 3],
            ['规则列表', 8, '/admin/rule/index', 4],
            ['菜单列表', 8, '/admin/menu/index', 5],
            ['路由列表', 8, '/admin/route/index', 6],
            ['系统', null, null, 5],
            ['网站配置', 15, '/backend/setting/index', 1],
            ['代码生成', 15, '/gii/default/index', 2],
        ]);
    }

    public function down()
    {
        $this->truncateTable('menu');
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
