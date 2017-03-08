<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/4/1
 * Time: 23:28
 * To change this template use File | Setting | File Templates.
 */

namespace app\common\extensions;

use yii\db\ActiveRecord as YiiActiveRecord;

class ActiveRecord extends YiiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * 清空表
     * @return int
     */
    public static function truncateTable()
    {
        return static::getDb()
            ->createCommand()
            ->truncateTable(static::tableName())
            ->execute();
    }

    /**
     * 获取第一条错误
     * @return string
     */
    public function getFirstErrorString()
    {
        if ($this->hasErrors()) {
            return array_values($this->getErrors())[0][0];
        }
        return '';
    }
}
